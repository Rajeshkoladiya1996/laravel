<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'Api'],function (){

	// v2 login
	Route::group(['namespace'=>'V2','prefix'=>'v2'],function(){
		Route::post('/login','AuthController@login');
		Route::post('/otp-verify','AuthController@otpVerify');
		Route::post('/resend-otp','AuthController@reSendOTP');
		Route::get('/app-check','AppSettingsController@checkApp');

		//event participants
		Route::group(['prefix'=>'event-participant'],function(){
			Route::post('/','EventParticipantController@registerPartisipant');
		});

		
	});



	// V1 api
	Route::post('register','AuthController@register');
	Route::post('login','AuthController@login');
	Route::post('forgot','AuthController@forgotPassword');
	Route::post('otpVerify','AuthController@otpVerify');
	Route::post('reset','AuthController@resetPassword');

	// topSuppotersList
	Route::get('top-suppoters-list/{live_stream_id}','UserController@topSuppotersList');
	Route::get('battle-top-suppoters-list/{battel_live_stream_id}/{user_id}','UserController@topBattelSuppotersList');
	Route::post('/test-api','VideoController@testApiAntMedia');
	Route::post('/test-api-ssl','VideoController@testApisslAntMedia');
	Route::group(['middleware' => ['jwt.verify']], function() {

		//logout route
		Route::post('logout','AuthController@logout');
		
		Route::post('change/password','AuthController@changePassword');
		Route::get('profile','AuthController@profile');
		Route::post('profile/update','UserController@updateProfile');
		// send request for admin route 
		Route::post('send-request-for-live','UserController@requestForLive');
		Route::post('check-send-request-status','UserController@getStreamStatus');

		// category wise user list
		Route::post('category/user-list','VideoController@userCategorywise');
		
		Route::get('/notifications-list','UserController@notificationList');
		//user route
		Route::group(['prefix' => 'user'], function () {
			Route::get('/list','UserController@userList');
			Route::post('/privacyUpdate','UserController@userPrivacyUpdate');
			Route::post('/detail','UserController@userDetails');
			Route::post('/activity','UserController@userActivity');
			//followe api
			Route::post('/follow','UserController@followerRequest');
			Route::post('/unfollow','UserController@unfollowerRequest');
			Route::get('/myFollower','UserController@myFollowerList');
			Route::get('/myFollowing','UserController@myFollowingList');
			//favourite api
			Route::get('/favouriteList','UserController@favouriteList');
			Route::post('/favourite','UserController@favourite');
			Route::post('/unfavourite','UserController@unfavourite');
			Route::post('/search','VideoController@searchUser');
			Route::post('/other-following-list','UserController@otherFollowingList');
			Route::post('/other-follower-list','UserController@otherFollowerList');
		});

		// user block request
		Route::post('user-block','StreamController@userBlock');
		Route::post('user-unblock','StreamController@userUnblock');
		Route::get('user-block-list','StreamController@myBlockList');
		
		// followe and favourut live user route
		Route::get('/followerLiveList','VideoController@followerLiveList');

		// gift api
		Route::get('/giftList','GiftController@giftList');
		Route::post('/gift/purches','StreamController@giftPurches');
		Route::post('/wallet-request','StreamController@walletRequest');

		//streamer api	
		Route::post('totalViewer','VideoController@videoTotalView');
		Route::post('liveStreamList','VideoController@liveStreamList');
		
		// level api
		Route::get('all-level-list','LevelController@allLeveList');
		Route::get('user-level-list','LevelController@userLeveList');
		Route::get('level-point-list','LevelController@levelPointList');
		Route::get('new-user-level-list','LevelController@newuserLeveList');
		
		// Reward api
		Route::post('collect-reward','RewardController@collectReward');
		Route::post('collect-progress','RewardController@collectProgress');
		Route::get('all-reward-list','RewardController@allRewardList');

		// // level-increase
		// Route::post('level-increase','LevelController@chatLevelIncrease');

		// Get viewerListInStream
		Route::post('viewer-list-stream','VideoController@viewerListInStream');
		Route::get('my-coin-list','StreamController@myCoinListing');
		Route::get('my-spend-coin-list','StreamController@mySpendCoinListing');
		Route::get('my-purchase-coin-list','StreamController@myPurchaseCoinListing');
		Route::get('gems-history','StreamController@gemsHistory');
		Route::get('salmon-history','StreamController@salmonHistory');
		Route::get('cash-history','StreamController@cashHistory');
		
		// events
		Route::get('event-list','EventController@eventList');
		Route::post('event-list','EventController@eventList');
		Route::post('event-detail','EventController@eventDetail');

		// create Battle Room
		Route::post('create-battle','BattleController@create');
		Route::post('change-battle-status','BattleController@changeStatus');
		Route::get('live-battle-list','BattleController@livebattleList');
		Route::post('battle-viewer-list','BattleController@battleviewer');
		Route::post('user-following','BattleController@userfollwing');

		Route::post('user-live-stream-report','LivestreamReportController@liveStreamReport');

		// packageList
		Route::get('package-list','PackageController@packageList');
		Route::post('purchase-package','PackageController@purchasePackage');

		// V2 
		Route::group(['namespace'=>'V2','prefix'=>'v2'],function(){
			
			//streamer api
			Route::post('liveStreamList','VideoController@liveStreamList');
			Route::post('liveStreamList2','VideoController@liveStreamList2');

			// profile update
			Route::get('profile','UserController@profile');
			Route::post('profile/update','UserController@updateProfile');
			Route::post('profile-image/delete','UserController@destroyImage');
			Route::get('live-user-list','UserController@liveUserList');
			Route::post('recommended-user-list','VideoController@recommendedUserList');
			
			//user
			Route::group(['prefix' => 'user'], function () {
				Route::get('/myFollower','UserController@myFollowerList');
				Route::get('/myFollowing','UserController@myFollowingList');	
				Route::post('/detail','UserController@userDetails');
				Route::get('/most-search','UserController@mostSearchUserList');
				Route::post('/profile/image-update','UserController@updateProfileImage');
			});
			
			// gift
			Route::get('/giftList','GiftController@giftList');

			//award
			Route::group(['prefix'=>'award'],function(){
				Route::post('/user-list','AwardController@userRewards');
				Route::post('/broadcaster-list','AwardController@broadcasterRewards');
			});

			

		});
		
	});

	// level-increase
	Route::post('level-increase','LevelController@chatLevelIncrease');


	// Route::post('liveStreamList','VideoController@liveStreamList');

	// alphabeats list
	Route::get('alphabeats-list','UserController@getAlphabeats');

});