<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\Models\Gift;
use App\Models\UserGemsDetail;

class GiftController extends Controller
{
    public function giftList(Request $request)
    {
        
    	if (! $users = JWTAuth::parseToken()->authenticate()) {
    	    return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
    	}

    	$giftList=Gift::where('status','1')->where('type','image')->select('*',\DB::raw("CONCAT('".url('/storage/app/public/uploads/gift/')."/', image) AS image"))->get();

    	foreach ($giftList as $value) {
    		$total_gift=UserGemsDetail::where('gift_id',$value->id)
                        ->where('user_id',$users->id)
                        ->where('status','1')
                        ->select(\DB::raw('sum(qty) - sum(spend_qty) as total_gift'))->get()[0]->total_gift;

    		$value->giftpurches=($total_gift==null)? 0 : intval($total_gift) ;
    		$value->giftspurchase=($total_gift==null)? 0 : intval($total_gift);    	
    	}

    	return response()->json(['ResponseCode'=>1,'ResponseText'=>'Gift lList successfully','ResponseData'=>$giftList],200); 
    }
}
