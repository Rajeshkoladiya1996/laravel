<?php

namespace App\Helper;
use Auth;
use App\Models\User;
use App\Models\Level;
use App\Models\LevelPoint;
use App\Models\LevelDetail;
use App\Models\UserLevelDetail;
use App\Models\UserLoginLog;
use Illuminate\Support\Facades\Log;

class BaseFunction {

	public static function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }

        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );

        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            dd($ipdat);
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        if($ip=='::1'){
            $output = array(
                "city"           => 'Surat',
                "state"          => 'Gujarat',
                "country"        => 'India',
                "country_code"   => 'IN',
                "continent"      => 'Asia',
                "continent_code" => 'AS'
            );
        }
        return $output;
    }

    public static function liveStreamList($offset,$size)
    {
        $curl = curl_init();
        $url="http://bklive.stream:5080/WebRTCAppEE/rest/v2/broadcasts/list/".$offset."/".$size;
        curl_setopt_array($curl, array(
          CURLOPT_PORT => "5080",
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"          
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          // echo "cURL Error #:" . $err;
           return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$err],500);
        } else {
            return $response;
        }
    }


    public static function agoraliveStreamList()
    {
        $curl = curl_init();
        $url="https://api.agora.io/dev/v1/channel/e5574359857246129815648c6b279095";
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         
          CURLOPT_HTTPHEADER => array(
             'Authorization: Basic NDRkZTNmYTA1OTNjNGViNjk0YWVhYzFiM2FhNGQxZDI6NzdhNGU2YmNkMDYyNDZiNWI1ODgyMGU2YjI2YTc2NDg=',
            'Content-Type: application/json'
          ),
          CURLOPT_CUSTOMREQUEST => "GET"          
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          // echo "cURL Error #:" . $err;
           return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$err],500);
        } else {
            return $response;
        }
    }

    public static function agoraliveStreamListUserDetail($stream_id)
    {
        $curl = curl_init();
        $url="https://api.agora.io/dev/v1/channel/user/e5574359857246129815648c6b279095/".$stream_id;
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_HTTPHEADER => array(
             'Authorization: Basic NDRkZTNmYTA1OTNjNGViNjk0YWVhYzFiM2FhNGQxZDI6NzdhNGU2YmNkMDYyNDZiNWI1ODgyMGU2YjI2YTc2NDg=',
            'Content-Type: application/json'
          ),
          CURLOPT_CUSTOMREQUEST => "GET"          
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
          // echo "cURL Error #:" . $err;
           return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$err],500);
        } else {
            return $response;
        }

    }
    public static function sendNotification($user,$title,$body){

        $serverkey = 'AAAAkd8gF4s:APA91bF2ZSaZ9IiefryIS1LrR9nguuGXYxZQ87D2VDNkXVHYbZVSGf7yPJqy6682PCOoPrlr1_qgrXd51OkxIHwaYnGoeWVOxJ_RxQyPBjSx047q1yVcabrhZg2AcOTnhW0hue_o8l_k';

        define( 'API_ACCESS_KEY' ,$serverkey);

        if($user->device_type == 0){
             $fcmFields = array(
                'registration_ids' =>array($user->device_token),
                'priority' => 'high',
                'data' =>array('message' => $body,'title' => $title,'sound' => "default","type"=>"normal"));
        }else{
            $fcmFields = array ('registration_ids' =>array($user->device_token),
                'notification' =>array('title' => $title,'body' => $body,'sound' => "default","type"=>"normal"));
        }

        $headers = array(
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        \Log::info($result);
        return 1;
    }

    public static function curlCallApi($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_PORT => "5080",
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"          
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          // echo "cURL Error #:" . $err;
           return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$err],500);
        } else {
            return $response;
        }
    }

    public static function curlCallSSlApi($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_PORT => "5443",
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"          
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          // echo "cURL Error #:" . $err;
           return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$err],500);
        } else {
            return $response;
        }
    }

    public static function levelIncrease($userdetail,$user_id,$level_point_id)
    {
        $level=Level::where('id',$userdetail->level_id)->first();
        $levelNext=Level::where('id','>',$userdetail->level_id)->first();

        $cur_date = date("Y-m-d");

        $levelPoint = LevelPoint::where('id',$level_point_id)->first();

        $userleveldetail = UserLevelDetail::where('user_id',$user_id)
        									->where('level_detail_id',$levelPoint->id)
        									->where('date',$cur_date)
        									->first();

        
        if ($userleveldetail == "") {
            Log::info("First Time");
            $data = new UserLevelDetail;
            $data->user_id = $user_id;
            $data->level_detail_id = $levelPoint->id;
            $data->point = $levelPoint->points;
            $data->per_day = 1;
            $data->date = $cur_date;
            if($data->save()){	
                $point = $userdetail->total_point + $levelPoint->points;
                User::where('id',$user_id)->update(['total_point'=>$point]);
                if($point >= $level->total_point){
                    if($levelNext!=""){
                        User::where('id',$user_id)->update(['level_id'=>$levelNext->id,'total_point'=>0]);
                    }
                }
            }
        }else{
            Log::info("Second Time");
            Log::info($userleveldetail->id);
            $data = new UserLevelDetail;
            $data->exists = true;
            $data->id = $userleveldetail->id;
            if($userleveldetail->per_day != $levelPoint->per_day){
                $data->per_day = $userleveldetail->per_day + 1;
                $point = $userdetail->total_point + $levelPoint->points;
                User::where('id',$user_id)->update(['total_point'=>$point]);
                if($point >= $level->total_point){
                    if($levelNext!=""){
                        User::where('id',$user_id)->update(['level_id'=>$levelNext->id,'total_point'=>0]);
                    }
                }
            }
            $data->save();
            
        }
    }
    // loginLogs
    public static function loginLogs($user_id,$ip_address,$type,$device_type)
    {
        $userlog = new UserLoginLog;
        $userlog->user_id=$user_id;
        $userlog->ip_address=($ip_address!='')? $ip_address : '0.0.0.0';
        $userlog->type=$type;
        $userlog->date=date("Y-m-d h:i:s");
        $userlog->device_type=$device_type;
        $userlog->save();
    } 
}