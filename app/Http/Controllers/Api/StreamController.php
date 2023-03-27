<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserBlock;
use App\Models\UserGemsDetail;
use App\Models\UserGemsGiftsDetail;
use App\Models\UserWalletRequest;
use App\Models\TopupRate;
use App\Models\UserWalletDetail;
use App\Models\UserSpendGemsDetail;
use App\Models\WithdrawRate;
use App\Models\Config;
use JWTAuth;
use Validator;

class StreamController extends Controller
{
    // userBlock
    public function userBlock(Request $request)
    {
    	$validate = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
    	if($validate->fails())
		{
		  	return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
		}
		if (! $users = JWTAuth::parseToken()->authenticate()) {
		      return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
		}
		
		if($users->id==$request->user_id){
			return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>['Invalid user id']]],499);
		}
		$check=UserBlock::where('from_id',$users->id)->where('to_id',$request->user_id)->first();
		if($check==""){		
	    	$block =new UserBlock;
	    	$block->from_id=$users->id;
			$block->to_id=$request->user_id;
			$block->save();
			return response()->json(['ResponseCode'=>1,'ResponseText'=>'User block successfully'],200);
		}else{
			return response()->json(['ResponseCode'=>1,'ResponseText'=>'User already blocked'],200);
		}

    }

    // userUnblock
    public function userUnblock(Request $request)
    {
    	$validate = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
    	if($validate->fails())
		{
		  	return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
		}
		if (! $users = JWTAuth::parseToken()->authenticate()) {
		      return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
		}
		$loginuser=compact('users');
		if($loginuser['users']->id==$request->user_id){
			return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>['Invalid user id']]],499);
		}
		$check=UserBlock::where('from_id',$loginuser['users']->id)->where('to_id',$request->user_id)->first();
		if($check!=""){		
	    	UserBlock::where('from_id',$loginuser['users']->id)->where('to_id',$request->user_id)->delete();
			return response()->json(['ResponseCode'=>1,'ResponseText'=>'User unblock successfully'],200);
		}else{
			return response()->json(['ResponseCode'=>1,'ResponseText'=>'User not block'],200);
		}
    }

    // myBlockList
    public function myBlockList(Request $request)
    {
    	if (! $users = JWTAuth::parseToken()->authenticate()) {
    	      return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
    	}
    	$loginuser=compact('users');
    	$data=UserBlock::with('user')->where('from_id',$loginuser['users']->id)->get();
    	return response()->json(['ResponseCode'=>1,'ResponseText'=>'User block list','ResponseData'=>$data],200);
    }

    // giftPurches
    public function giftPurches(Request $request)
    {
    	$validate = Validator::make($request->all(), [
            'gift_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
        ]);
    	if($validate->fails())
		{
		  	return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
		}

		if (! $users = JWTAuth::parseToken()->authenticate()) {
    	    return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
    	}

    	$loginuser=compact('users');
    	$userData=User::where('id',$loginuser['users']->id)->first();
    	if($userData->total_gems!=0){
    		
    		$total_gems=$request->price * $request->qty;
    		$total_gems_all=$userData->total_gems;
    		if($total_gems <= $userData->total_gems){

    			$userGemsDetail = new UserGemsDetail;
    			$userGemsDetail->gift_id=$request->gift_id;
                $userGemsDetail->user_id=$loginuser['users']->id;
    			$userGemsDetail->gems=$request->price;
                $userGemsDetail->qty=$request->qty;
                $userGemsDetail->save();

    			$data['total_gems']=$userData->total_gems - $total_gems;
    			User::where('id',$loginuser['users']->id)->update($data);
    			
    			return response()->json(['ResponseCode'=>1,'ResponseText'=>'Gifts purchased successfully'], 200);
    		}else{
    			return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'You do not have enough salmon coin to buy this gift. Please top up."']], 499);
    		}
    	}else{
    		return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'Your account is empty!']], 499);
    	}
    }

    // walletRequest
    public function walletRequest(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required',
            'amount' => 'required',
        ]);


        if($validate->fails()){
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }

        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }
        $userData=User::where('id',$users->id)->first();
       

        if(!preg_match("/^[0-9]+$/", $request->amount)) {
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>['Amount is invalid!']]],499);
        }
        if($request->amount < 0){
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>['Amount request is min 1 allow!']]],499);   
        }
        if($request->amount > 1000000){
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>['Amount request is max 999999 allow!']]],499);  
        }
        $checkrequest=UserWalletDetail::where('type',$request->type)->where('user_id',$users->id)->where('status',0)->count();
        if($checkrequest!=0){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'Your request already in progress!'], 200);
        }

        // 1. cash to salmon coin / 2. gold coin to cash  


        if($request->type==1){
           $topuprate = TopupRate::where('from_price','<=',intval($request->amount))->where('to_price','>=',intval($request->amount))->first();
            if($topuprate == ""){
                return response()->json(['ResponseCode'=>'0','ResponseText'=>'Minimum amount should be 100.','ResponseData'=>['errors'=>['Minimum amount should be 100.']]],499);
            }
        }
        
        $userwalletdetail = new UserWalletDetail;
        $userwalletdetail->user_id=$request->user_id;
        $userwalletdetail->create_by=$users->id;
        $userwalletdetail->status=0;
        if($request->type==1){
            // consider amount as Cash ( amount = Cash )
            $userwalletdetail->type =1;
            $topuprate = TopupRate::where('from_price','<=',intval($request->amount))->where('to_price','>=',intval($request->amount))->first();
            $userwalletdetail->amount = $request->amount;
            $userwalletdetail->diamond_amount = $topuprate->rate;
            $userwalletdetail->gems_amount = $request->amount * $topuprate->rate;
              
        }
        else if($request->type == 2){
            // gold coin to cash  (amount == gold coin)
            if($request->amount <= $userData->earned_gems){            
                $userwalletdetail->type = 2; 
                $withdrawrate = WithdrawRate::where('id',1)->first();
                $topuprate = TopupRate::where('from_price','<=',intval($request->amount))->where('to_price','>=',intval($request->amount))->first();
                $amountcash = ($request->amount * (1 - $withdrawrate->bk_commission) ) / $withdrawrate->rate;
                $userwalletdetail->amount = $amountcash;
                $userwalletdetail->diamond_amount = $withdrawrate->rate;
                $userwalletdetail->gems_amount = $request->amount;

            }else{
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'You do not have enough salmon coins'], 200);
            }
        }
        $userwalletdetail->save();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Wallet request send successfully'], 200);
    }

    // myCoinListing
    public function myCoinListing(Request $request)
    {
        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $coinList=UserSpendGemsDetail::whereHas('gift_detail')->with('gift_detail')->where('to_id',$users->id)->orderBy('id','desc')->get();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Coin history list','ResponseData'=>$coinList],200);
    }

    // mySpendCoinListing
    public function mySpendCoinListing(Request $request)
    {
        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $coinList=UserSpendGemsDetail::whereHas('gift_detail')->with('gift_detail')->where('from_id',$users->id)->orderBy('id','desc')->get();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Coin spend history list','ResponseData'=>$coinList],200);
    }

    // myPurchaseCoinListing
    public function myPurchaseCoinListing(Request $request)
    {
        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $coinList=UserGemsDetail::with('gems_detail')->where('user_id',$users->id)->orderBy('id','desc')->get();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Coin purchase history list','ResponseData'=>$coinList],200);
    }

    // gemsHistory
    public function gemsHistory(Request $request)
    {
        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $coinList=UserWalletDetail::where('user_id',$users->id)->where('type',1)->orderBy('id','desc')->get();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Coin purchase history list','ResponseData'=>$coinList],200);
    }

    // salmonHistory
    public function salmonHistory(Request $request)
    {
        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $coinList=UserWalletDetail::where('user_id',$users->id)->where('type',3)->orderBy('id','desc')->get();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Salmon coins history list','ResponseData'=>$coinList],200);
    }

    // cashHistory
    public function cashHistory(Request $request)
    {
        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $coinList=UserWalletDetail::where('user_id',$users->id)->where('type',2)->orderBy('id','desc')->get();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Cash history list','ResponseData'=>$coinList],200);
    }

}
