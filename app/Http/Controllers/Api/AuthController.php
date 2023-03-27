<?php

namespace App\Http\Controllers\Api;

use Auth;
use Hash;
use JWTAuth;
use Validator;
use App\Models\User;
use App\Models\Level;
use App\Models\UserProfile;
use Twilio\Rest\Client;
use App\Models\LevelPoint;
use App\Models\LevelDetail;
use App\Helper\BaseFunction;
use App\Models\UserFollower;
use App\Models\UserLoginLog;
use Illuminate\Http\Request;
use App\Models\UserFavourite;
use App\Models\UserLevelDetail;
use App\Models\EventParticipant;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;




class AuthController extends Controller
{


	public function __construct()
	{
		$this->middleware('jwt.verify', ['except' => ['login', 'register', 'forgotPassword', 'resetPassword', 'otpVerify']]);
	}

	/**
	 * Get a JWT via given credentials.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(Request $request)
	{

		$validate = Validator::make($request->all(), [
			'device_token' => 'required',
			'device_type' => 'required',
			'login_type' => 'required',
		]);

		if ($validate->fails()) {
			return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
		}
		$level = Level::orderBy('id', 'ASC')->get()->first();
		try {
			$data['email'] = (@$request->email) ? $request->email : NULL;
			if (isset($request->phone)) {
				if ($request->phone == "" || $request->phone == "null" || $request->phone == null) {
					$data['phone'] = NULL;
				} else {
					$data['phone'] = $request->phone;
				}
			}


			// $data['phone']=(@$request->phone) ? $request->phone != "" || $request->phone != "null" ? $request->phone : NULL : NULL;
			// $data['username']=(@$request->username)? $request->username : Null;
			$data['first'] = (@$request->username) ? $request->username : NULL;
			$data['device_token'] = $request->device_token;
			$data['user_type'] = "0";
			$data['stream_id'] = 'Bk_' . rand(1, 50) . rand(10, 100) . rand(10, 10000);
			$data['profile_pic'] = (@$request->social_pic) ? $request->social_pic : 'default.png';
			$data['social_pic'] = (@$request->social_pic) ? $request->social_pic : 'default.png';
			$data['device_type'] = ($request->device_type == "android" || $request->device_type == "Android") ? 0 : 1;
			$data['county_code'] = (@$request->county_code) ? $request->county_code : '';
			$data['level_id'] = $level->id;
			if ($request->login_type == "phone" || $request->login_type == "email") {
				$emailvalidate = Validator::make($request->all(), [
					'username' => 'required',
					'password' => 'required|min:8|max:12',
				]);

				if ($emailvalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
				}
				if (preg_match("/^[0-9]+$/", $request->username)) {
					$login['phone'] = $request->username;
				} else {
					$login['username'] = $request->username;
				}
				$updatedate['logindate'] = date("Y-m-d h:i:s");
				User::where($login)->update($updatedate);

				$login['password'] = $request->password;
				return $this->checkLogin($login, $request->all());
			} else if ($request->login_type == "google") {
				$googlevalidate = Validator::make($request->all(), [
					'google_id' => 'required',
				]);
				if ($googlevalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $googlevalidate->errors()->all()]], 499);
				}
				$login['google_id'] = $request->google_id;
				$checkgoogle = User::where($login)->count();

				if ($checkgoogle != 0) {
					$updatedate['logindate'] = date("Y-m-d h:i:s");
					User::where($login)->update($updatedate);

					$login['password'] = 'g-' . $request->google_id;
					return $this->checkLogin($login, $request->all());
				} else {
					$emailvalidate = Validator::make($request->all(), [
						'email' => 'email|unique:users'
					]);
					if ($emailvalidate->fails()) {
						return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
					}
					$data['google_id'] = $request->google_id;
					$data['login_type'] = "google";
					$data['password'] = Hash::make('g-' . $request->google_id);

					$user = User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first());
					$login['password'] = 'g-' . $request->google_id;
					return $this->checkLogin($login, $request->all());

					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Registration with google successfully'], 200);
				}
			} else if ($request->login_type == "facebook") {
				$facebookvalidate = Validator::make($request->all(), [
					'facebook_id' => 'required',
				]);
				if ($facebookvalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $facebookvalidate->errors()->all()]], 499);
				}
				$login['facebook_id'] = $request->facebook_id;
				$checkfacebook = User::where($login)->first();
				if ($checkfacebook != '') {
					$updatedate['logindate'] = date("Y-m-d h:i:s");
					User::where($login)->update($updatedate);

					$login['password'] = 'f-' . $request->facebook_id;
					return $this->checkLogin($login, $request->all());
				} else {
					if (isset($request->email) || $request->email != '') {
						$emailvalidate = Validator::make($request->all(), [
							'email' => 'email|unique:users'
						]);
						if ($emailvalidate->fails()) {
							return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
						}
					}
					$data['facebook_id'] = $request->facebook_id;
					$data['login_type'] = "facebook";
					$data['password'] = Hash::make('f-' . $request->facebook_id);

					$user = User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first());
					$login['password'] = 'f-' . $request->facebook_id;
					return $this->checkLogin($login, $request->all());
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Registration with facebook successfully'], 200);
				}
			} else if ($request->login_type == "apple") {
				$applevalidate = Validator::make($request->all(), [
					'apple_id' => 'required',
				]);
				if ($applevalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $applevalidate->errors()->all()]], 499);
				}
				$login['apple_id'] = $request->apple_id;
				$checkfacebook = User::where($login)->first();
				if ($checkfacebook != '') {
					$updatedate['logindate'] = date("Y-m-d h:i:s");
					User::where($login)->update($updatedate);

					$login['password'] = 'a-' . $request->apple_id;
					return $this->checkLogin($login, $request->all());
				} else {
					$emailvalidate = Validator::make($request->all(), [
						'email' => 'email|unique:users'
					]);
					if ($emailvalidate->fails()) {
						return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
					}
					$data['apple_id'] = $request->apple_id;
					$data['login_type'] = "apple";
					$data['password'] = Hash::make('a-' . $request->apple_id);
					$user = User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first());
					$login['password'] = 'a-' . $request->apple_id;
					return $this->checkLogin($login, $request->all());
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Login with apple successfully'], 200);
				}
			} else if ($request->login_type == "line") {
				$applevalidate = Validator::make($request->all(), [
					'line_id' => 'required',
				]);
				if ($applevalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $applevalidate->errors()->all()]], 499);
				}
				$login['line_id'] = $request->line_id;
				$checkline = User::where($login)->first();
				if ($checkline != '') {
					$updatedate['logindate'] = date("Y-m-d h:i:s");
					User::where($login)->update($updatedate);

					$login['password'] = 'li-' . $request->line_id;
					return $this->checkLogin($login, $request->all());
				} else {
					$emailvalidate = Validator::make($request->all(), [
						'email' => 'email|unique:users'
					]);
					if ($emailvalidate->fails()) {
						return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
					}
					$data['line_id'] = $request->line_id;
					$data['login_type'] = "line";
					$data['password'] = Hash::make('li-' . $request->line_id);
					$user = User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first());
					$login['password'] = 'li-' . $request->line_id;
					return $this->checkLogin($login, $request->all());
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Login with line successfully'], 200);
				}
			} else {
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Invalid login type'], 401);
			}
		} catch (JWTException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could not create token'], 500);
		}
	}

	/**
	 * Register a User.
	 * 
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function register(Request $request)
	{
		$validate = Validator::make($request->all(), [
			'device_token' => 'required',
			'device_type' => 'required',
			'login_type' => 'required',
			'is_accept_terms' => 'required'
		]);

		if ($validate->fails()) {
			return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
		}
		$level = Level::orderBy('id', 'ASC')->get()->first();
		try {
			$data['email'] = (@$request->email) ? $request->email : NULL;
			if (isset($request->phone)) {
				if ($request->phone == "" || $request->phone == "null" || $request->phone == null) {
					$data['phone'] = NULL;
				} else {
					$data['phone'] = $request->phone;
				}
			}
			// $data['username']=(@$request->username)? $request->username : Null;
			$data['first'] = (@$request->username) ? $request->username : NULL;
			$data['device_token'] = $request->device_token;
			$data['user_type'] = "0";
			$data['stream_id'] = 'Bk_' . rand(1, 50) . rand(10, 100) . rand(10, 10000);
			$data['profile_pic'] = (@$request->social_pic) ? $request->social_pic : 'default.png';
			$data['social_pic'] = (@$request->social_pic) ? $request->social_pic : 'default.png';
			$data['device_type'] = ($request->device_type == "android" || $request->device_type == "Android") ? 0 : 1;
			$data['county_code'] = (@$request->county_code) ? $request->county_code : '';
			$data['phone_code'] = (isset($request->phone_code)) ? $request->phone_code : NULL;
			$data['level_id'] = $level->id;
			if ($request->login_type == "email" || $request->login_type == "phone") {
				$validatecheck = [
					'username' => 'required|string|between:2,100|unique:users',
					'phone' => 'required|min:6|max:15|unique:users',
					'password' => 'required|min:8|max:12',
					'email' => 'email|unique:users'
				];
				if (isset($request->email) && $request->email != '') {
					$validatecheck['email'] = 'email|unique:users';
				}
				$emailvalidate = Validator::make($request->all(), $validatecheck);

				if ($emailvalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
				}
				$data['username'] = (@$request->username) ? $request->username : '';
				$data['login_type'] = "email";
				$data['password'] = Hash::make($request->password);
				$user = User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first());
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Registration Successfully'], 200);
			} else if ($request->login_type == "google") {
				$googlevalidate = Validator::make($request->all(), [
					'google_id' => 'required',
				]);
				if ($googlevalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $googlevalidate->errors()->all()]], 499);
				}
				$login['google_id'] = $request->google_id;
				$checkgoogle = User::where($login)->first();
				if ($checkgoogle != '') {
					$updatedate['logindate'] = date("Y-m-d h:i:s");
					User::where($login)->update($updatedate);

					$login['password'] = 'g-' . $request->google_id;
					return $this->checkLogin($login, $request->all());
				} else {
					$emailvalidate = Validator::make($request->all(), [
						'email' => 'email|unique:users'
					]);
					if ($emailvalidate->fails()) {
						return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
					}
					$data['google_id'] = $request->google_id;
					$data['login_type'] = "google";
					$data['password'] = Hash::make('g-' . $request->google_id);

					$user = User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first());
					$login['password'] = 'g-' . $request->google_id;
					return $this->checkLogin($login, $request->all());
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Registration with google successfully'], 200);
				}
			} else if ($request->login_type == "facebook") {
				$facebookvalidate = Validator::make($request->all(), [
					'facebook_id' => 'required',
				]);
				if ($facebookvalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $facebookvalidate->errors()->all()]], 499);
				}
				$login['facebook_id'] = $request->facebook_id;
				$checkfacebook = User::where($login)->first();
				if ($checkfacebook != '') {
					$updatedate['logindate'] = date("Y-m-d h:i:s");
					User::where($login)->update($updatedate);

					$login['password'] = 'f-' . $request->facebook_id;
					return $this->checkLogin($login, $request->all());
				} else {
					if (isset($request->email) || $request->email != '') {
						$emailvalidate = Validator::make($request->all(), [
							'email' => 'email|unique:users'
						]);
						if ($emailvalidate->fails()) {
							return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
						}
					}
					$data['facebook_id'] = $request->facebook_id;
					$data['login_type'] = "facebook";
					$data['password'] = Hash::make('f-' . $request->facebook_id);

					$user = User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first());
					$login['password'] = 'f-' . $request->facebook_id;
					return $this->checkLogin($login, $request->all());
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Registration with facebook successfully'], 200);
				}
			} else if ($request->login_type == "apple") {
				$applevalidate = Validator::make($request->all(), [
					'apple_id' => 'required',
				]);
				if ($applevalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $applevalidate->errors()->all()]], 499);
				}
				$login['apple_id'] = $request->apple_id;
				$checkfacebook = User::where($login)->first();
				if ($checkfacebook != '') {
					$updatedate['logindate'] = date("Y-m-d h:i:s");
					User::where($login)->update($updatedate);

					$login['password'] = 'a-' . $request->apple_id;
					return $this->checkLogin($login, $request->all());
				} else {
					$emailvalidate = Validator::make($request->all(), [
						'email' => 'email|unique:users'
					]);
					if ($emailvalidate->fails()) {
						return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
					}
					$data['apple_id'] = $request->apple_id;
					$data['login_type'] = "apple";
					$data['password'] = Hash::make('a-' . $request->apple_id);

					$user = User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first());
					$login['password'] = 'a-' . $request->apple_id;
					return $this->checkLogin($login, $request->all());
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Registration with apple successfully'], 200);
				}
			} else if ($request->login_type == "line") {
				$applevalidate = Validator::make($request->all(), [
					'line_id' => 'required',
				]);
				if ($applevalidate->fails()) {
					return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $applevalidate->errors()->all()]], 499);
				}
				$login['line_id'] = $request->line_id;
				$checkline = User::where($login)->first();
				if ($checkline != '') {
					$updatedate['logindate'] = date("Y-m-d h:i:s");
					User::where($login)->update($updatedate);

					$login['password'] = 'li-' . $request->line_id;
					return $this->checkLogin($login, $request->all());
				} else {
					$emailvalidate = Validator::make($request->all(), [
						'email' => 'email|unique:users'
					]);
					if ($emailvalidate->fails()) {
						return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $emailvalidate->errors()->all()]], 499);
					}
					$data['line_id'] = $request->line_id;
					$data['login_type'] = "line";
					$data['password'] = Hash::make('li-' . $request->line_id);
					$user = User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first());
					$login['password'] = 'li-' . $request->line_id;
					return $this->checkLogin($login, $request->all());
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Login with line successfully'], 200);
				}
			} else {
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Invalid login type'], 401);
			}
		} catch (JWTException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could_not_create_token'], 500);
		}
	}

	/**
	 * Log the user out (Invalidate the token).
	 * logout function
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout(Request $request)
	{
		try {
			$validate = Validator::make($request->all(), [
				'ip_address' => 'required',
				'device_type' => 'required',
			]);

			if ($validate->fails()) {
				return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
			}

			if (!$user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 401);
			}
			$data = compact('user');
			$this->loginLogs($data['user']->id, $request->ip_address, 'logout', $request->device_type);
			JWTAuth::invalidate(JWTAuth::getToken());
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'logout Successfully']);
		} catch (JWTException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could_not_create_token'], 500);
		}
	}

	// login with normal, google, facebook, apple common function
	public function checkLogin($login, $request)
	{

		try {

			if (!$token = JWTAuth::attempt($login)) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Unauthorized', 'ResponseData' => ['errors' => 'Invalid user login']], 401);
			}

			if (JWTAuth::user()->hasRole('user')) {
				if (JWTAuth::user()->is_active == 0) {
					return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Unauthorized', 'ResponseData' => ['errors' => 'User account deactive by admin']], 401);
				}

				$data = compact('token');
				$data['token_type'] = 'bearer';
				$data['user'] = JWTAuth::user();
				$data['user']->followers = 0;
				$data['user']->following = 0;
				$data['user']->total_gems = 0;
				$updatedate['device_token'] = $request['device_token'];
				$updatedate['device_type'] = ($request['device_type'] == "android" || $request['device_type'] == "Android") ? 0 : 1;
				$updatedate['device_id'] = (isset($request['device_id'])) ? $request['device_id'] : '';
				// $updatedate['logindate']=date("Y-m-d h:i:s");
				$updatedate['county_code'] = (isset($request['county_code'])) ? $request['county_code'] : '';
				$updatedate['phone_code'] = (isset($request['phone_code'])) ? $request['phone_code'] : NULL;
				User::where('id', $data['user']->id)->update($updatedate);
				if (!filter_var($data['user']->profile_pic, FILTER_VALIDATE_URL)) {
					if ($data['user']->profile_pic != "") {
						$data['user']->profile_pic = URL('/storage/app/public/uploads/users/' . $data['user']->profile_pic);
					} else {
						$data['user']->profile_pic = URL('/storage/app/public/uploads/users/default.png');
					}
				}

				$this->loginLogs($data['user']->id, $request['ip_address'], 'login', $request['device_type']);
				$this->checkInApp($data['user']->id);
				// $data['daily_login_point']=UserLevelDetail::with('level_point')->where('user_id',$data['user']->id)->where('level_detail_id',6)->get();
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Login successfully', 'ResponseData' => $data], 200);
			} else {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Unauthorized', 'ResponseData' => ['errors' => 'Invalid user login']], 401);
			}
		} catch (JWTException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could_not_create_token'], 500);
		}
	}

	// user profile details get function
	public function profile()
	{
		try {
			if (!$user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 401);
			}

			$userdata = User::where('id', $user->id)->select('users.*', \DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', users.profile_pic)) AS profile_pic"))->first();
			$userdata->profile_images = UserProfile::where('user_id', $user->id)->select('*', \DB::raw("IF(image LIKE '%https://%' , image , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', image)) AS image"))->get();
			$userdata->followers = UserFollower::where('to_id', $user->id)->count();
			$userdata->following = UserFollower::where('from_id', $user->id)->count();
			$userdata->favourite = UserFavourite::where('from_id', $user->id)->count();
			$userdata->level = Level::where('id', $userdata->level_id)->first();
			$eventParticipant = EventParticipant::where('user_id',$user->id)->first();
			$userdata->is_event_rank = 0;
			if($eventParticipant!=''){
				if($eventParticipant->event_counts >= 50){
					$userdata->is_event_rank = 3;
				}else if($eventParticipant->event_counts >= 40 && $eventParticipant->event_counts < 50 ){
					$userdata->is_event_rank = 2;
				}else if ($eventParticipant->event_counts >= 30 && $eventParticipant->event_counts < 40){
					$userdata->is_event_rank = 1;
				}else{
					$userdata->is_event_rank = 0;
				}
			}
			
			$userdata->level->level = (isset(explode('-', $userdata->level->slug)[1])) ? explode('-', $userdata->level->slug)[1] : 0;
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User profile detail', 'ResponseData' => $userdata]);
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'token_expired']], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'token_invalid']], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'token_absent']], $e->getStatusCode());
		}
	}

	//change password function
	public function changePassword(Request $request)
	{
		try {
			if (!$user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 401);
			}


			$validate = Validator::make($request->all(), [
				'old_password' => 'required|min:8|max:12',
				'new_password' => 'required|min:8|max:12',
				'confirm_password' => 'required|min:8|max:12'
			]);

			if ($validate->fails()) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
			}
			if ($request->old_password == $request->new_password) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'new password should not be same as old password']], 499);
			}

			if ($request->confirm_password != $request->new_password) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'Password and confim password does not match']], 499);
			}

			$userdata = User::findOrFail($user->id);
			if (Hash::check($request->old_password, $userdata->password)) {
				User::where('id', $user->id)->update(['password' => Hash::make($request->new_password)]);
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User password update successfully'], 200);
			} else {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'The old password does not match our records.']], 499);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'token_expired']], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'token_invalid']], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'token_absent']], $e->getStatusCode());
		}
	}

	// forgot password function
	public function forgotPassword(Request $request)
	{
		$validate = Validator::make($request->all(), [
			'username' => 'required',
			'phone_code' => 'required',
		]);

		if ($validate->fails()) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
		}
		$sid = config('services.twilio.sid');
		$token  = config('services.twilio.token');
		$twilio = new Client($sid, $token);

		if (preg_match("/^[0-9]+$/", $request->username)) {
			$data['phone'] = $request->username;
		} else {
			$data['username'] = $request->username;
		}
		$userdata = User::where($data)->first();
		if ($userdata) {
			if ($userdata->login_type == "email") {
				$phone = $request->phone_code . $userdata->phone;
				$verification = $twilio->verify->v2->services(env('TWILIO_SERVICE_SID'))->verifications->create($phone, "sms");
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'OTP send to your contact no'], 200);
			} else {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'User acount login with social', 'ResponseData' => ['errors' => 'User acount login with social']], 401);
			}
		} else {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'User name not exists!', 'ResponseData' => ['errors' => 'User name not exists']], 401);
		}
	}

	// otpVerify function
	public function otpVerify(Request $request)
	{
		$validate = Validator::make($request->all(), [
			'username' => 'required',
			'phone_code' => 'required',
			'otp' => 'required',
		]);

		if ($validate->fails()) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
		}
		$sid = config('services.twilio.sid');
		$token  = config('services.twilio.token');
		$twilio = new Client($sid, $token);

		if (preg_match("/^[0-9]+$/", $request->username)) {
			$data['phone'] = $request->username;
		} else {
			$data['username'] = $request->username;
		}
		try {
			$userdata = User::where($data)->where('login_type', 'email')->first();
			if ($userdata) {
				$phone = $request->phone_code . $userdata->phone;
				$verification_check = $twilio->verify->v2->services(env('TWILIO_SERVICE_SID'))->verificationChecks->create($request->otp, array("to" => $phone));
				if ($verification_check->status == 'approved') {
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Otp Verify successfully'], 200);
				} else {
					return response()->json(['ResponseCode' => 0,  'ResponseText' => 'Invalid OTP', 'ResponseData' => ['errors' => 'Otp does not match']], 499);
				}
			} else {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'User name not exists!', 'ResponseData' => ['errors' => 'User name not exists']], 499);
			}
		} catch (\Exception $e) {
			$message = $e->getMessage();
			return response()->json([
				'ResponseCode' => 0,
				'ResponseText' => 'Something went wrong Try to resend OTP',
				// 'ResponseData' => [ 'errors' => $message ]
			], 500);
		}
	}

	//reset password function
	public function resetPassword(Request $request)
	{
		$validate = Validator::make($request->all(), [
			'username' => 'required',
			'new_password' => 'required|min:8|max:12',
			'confirm_password' => 'required|min:8|max:12'
		]);

		if ($validate->fails()) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
		}

		if ($request->confirm_password != $request->new_password) {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'Password and confim password does not match']], 499);
		}

		if (preg_match("/^[0-9]+$/", $request->username)) {
			$data['phone'] = $request->username;
		} else {
			$data['username'] = $request->username;
		}

		$userdata = User::where($data)->first();
		if ($userdata) {
			User::where('id', $userdata->id)->update(['password' => Hash::make($request->new_password)]);
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User password update successfully'], 200);
		} else {
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'User name not exists!', 'ResponseData' => ['errors' => 'User name not exists']], 404);
		}
	}

	// user login logs function
	public function loginLogs($user_id, $ip_address, $type, $device_type)
	{
		$userlog = new UserLoginLog;
		$userlog->user_id = $user_id;
		$userlog->ip_address = ($ip_address != '') ? $ip_address : '0.0.0.0';
		$userlog->type = $type;
		$userlog->date = date("Y-m-d h:i:s");
		$userlog->device_type = $device_type;
		$userlog->save();
	}

	// check in app function
	public function checkInApp($user_id)
	{
		$userdetail = User::where('id', $user_id)->first();
		if ($userdetail->level_id != "") {
			BaseFunction::levelIncrease($userdetail, $user_id, 6);
		}
	}
}
