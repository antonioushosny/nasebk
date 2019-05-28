<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use App\Ticket ;
use App\Deal;
use DateTime;
use Carbon\Carbon;
use App\Notifications\Notifications;
use Notification;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     // function send notification by Antonious Hosny for hala company 
    protected function notification($device_id ,$title,$msg,$id="0")
    {
        $path_to_fcm='https://fcm.googleapis.com/fcm/send';

        $server_key="AAAAS3O293Q:APA91bG45V-lR8HAaG3J7OVbX_Pu3gbriOlwo9g1SOV2XeRt6Lr6pTZH9qLRvmtbMCcLTQVmm3Pn-Ci-s-LLG4_TMEbv4IFtzDarXnC2Czm3z38yeK9pmx2pjiJlUVayE6l8aJIbQKuM";

        $key = $device_id;

        $message = $msg;
        $title = $title ;
        $headers = array('Authorization:key=' .$server_key,'Content-Type:application/json');
        $user = User::where('device_token', $device_id)->first();
        if($user->type == '1'){
                 $fields = array("to" => $key, "notification"=>  array( "text"=>$message ,"id"=>$id,
                    "title"=>$title,
                    "is_background"=>false,
                    "payload"=>array("my-data-item"=>"my-data-value"),
                    "timestamp"=>date('Y-m-d G:i:s'),
                    'sound' => 'default', 'badge' =>'1'
                   
                    ), "priority" => "high",
                  "data"=>  array( "message"=>$message ,
                                            // "id"=>$id,
                                            "notification_type"=>$title,
                                            "is_background"=>false,
                                            "payload"=>array("my-data-item"=>"my-data-value"),
                                            "timestamp"=>date('Y-m-d G:i:s')
                                            )
                    );
        
        }
        else{
             $fields = array("to" => $key,
            "data"=>  array( "message"=>$message ,
                                // "id"=>$id,
                                "notification_type"=>$title,
                                "is_background"=>false,
                                "payload"=>array("my-data-item"=>"my-data-value"),
                                "timestamp"=>date('Y-m-d G:i:s')
                                )
        );
        }
   
       

       $payload =json_encode($fields);

       $curl_session =curl_init();

       curl_setopt($curl_session,CURLOPT_URL, $path_to_fcm);

       curl_setopt($curl_session,CURLOPT_POST, true);

       curl_setopt($curl_session,CURLOPT_HTTPHEADER, $headers);

       curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);

       curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER, false);

       curl_setopt($curl_session,CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);

       curl_setopt($curl_session,CURLOPT_POSTFIELDS, $payload);

       $result=curl_exec($curl_session);

       curl_close($curl_session);

            //   dd($result) ;
    }
    // end send notification 
    protected function webnotification($device_id ,$title,$msg,$type)
    {
        date_default_timezone_set('Africa/Cairo');
        $path_to_fcm='https://fcm.googleapis.com/fcm/send';

        $server_key="AAAAS3O293Q:APA91bG45V-lR8HAaG3J7OVbX_Pu3gbriOlwo9g1SOV2XeRt6Lr6pTZH9qLRvmtbMCcLTQVmm3Pn-Ci-s-LLG4_TMEbv4IFtzDarXnC2Czm3z38yeK9pmx2pjiJlUVayE6l8aJIbQKuM";

        $key = $device_id; 
        $message = $msg;
        $title = $title ;
        $headers = array('Authorization:key=' .$server_key,'Content-Type:application/json');

        $fields =array('to'=>$key,
            'notification' => array("title" => $title,
            "body" => $type  ,
            "click_action"=>"fresh/public/home",
            "sound"=>"default",
            "icon"=>"fresh/public/fresh_fruit.png" ), 'data' => array('type' => $type ,"title" => $title,
            "message" => $message  ),

        );
        // dd($fields);
       $payload =json_encode($fields);

       $curl_session =curl_init();

       curl_setopt($curl_session,CURLOPT_URL, $path_to_fcm);

       curl_setopt($curl_session,CURLOPT_POST, true);

       curl_setopt($curl_session,CURLOPT_HTTPHEADER, $headers);

       curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);

       curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER, false);

       curl_setopt($curl_session,CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);

       curl_setopt($curl_session,CURLOPT_POSTFIELDS, $payload);

       $result=curl_exec($curl_session);

       curl_close($curl_session);

            //   dd($result) ;
    }

    protected function CloseDeal(){
        $deals = Deal::all();
        foreach($deals as $deal){
        $dt = Carbon::now();

        $date  = date('Y-m-d', strtotime($dt));
        $time  = date('H:i:s', strtotime($dt));
        $later = new DateTime($deal->participants_date);
        $earlier = new DateTime($date);
        $diff = $later->diff($earlier)->format("%a");
        // return $diff ;
        if($diff >= 5){
            $deal->is_open = '0' ;
            $deal->save();
        }
        if($deal->expiry_date < $date || $deal->expiry_date == $date && $deal->expiry_time <= $time || $deal->is_open == '0'){
            $ticketss = Ticket::where('deal_id',$deal->id)->get();
                if(sizeof($ticketss) > 0){
                    $deal->is_open = '0' ;
                    $deal->save();
                    foreach($ticketss as $ticket){
                        $ticket->status = '0';
                        $ticket->save();
                    }
                    $ticket = Ticket::where('deal_id',$deal->id)->orderBy('points','desc')->first();
                    if($ticket){
                        $ticket->status = '1';
                        $ticket->save();
                        if($deal->notify == '0'){
                            $user =User::find($ticket->user_id ) ;
                            
                            $title = 'Congratulations' ;
                            $msg = 'مبروك لقد فزت بصفقة ال'  . $deal->title_ar ;
                            $type = 'deal' ;
                            if($user->device_token){
                                $this->notification($user->device_token,$title,$msg,$deal->id);
                            }
                            $user->notify(new Notifications($msg,$user,$type ));
                            $admins = User::where('role','admin')->orderBy('id', 'DESC')->get();
                            
                            $msg = 'لقد فاز '.$user->name.'بصفقة '  . $deal->title_ar ;
                            foreach($admins as $admin){
                                $admin->notify(new Notifications($msg,$admin,$type ));
                                $device_token = $admin->device_token;
                                if($device_token){
                                    $this->webnotification($device_token,$title,$msg,$type);
                                }
                            }
                            $deal->notify = '1' ;
                            $deal->save();
                        }
                        
                    }
                    
                }
                
            }
        }
    }
        

    // end send notification 
    public function AllSeen(){
        foreach(auth()->user()->unreadNotifications as $note){
            $note->markAsRead();
        }
    }

    protected function GetDistance($lat1, $lat2, $long1, $long2, $unit) {
            // $lat1 = 24.7509789;
            // $long1 = 46.6798639;
            // $lat2 = 24.771487;       
            // $long2 = 46.7173513;
          $unit = 'k';
          $theta = $long1 - $long2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);
          if ($unit == "K") {
            //   return ($miles * 1.609344) . ' km';
              return ($miles * 1.609344);
          } 
          else if ($unit == "M") {
            return ($miles * 1.609344 * 1000) . ' m';
        }else if ($unit == "N") {
              return ($miles * 0.8684) . ' nm';
          } else {
              return $miles . ' mi';
          }
      }
  
      protected function GetDrivingDistanceKM($lat1, $lat2, $long1, $long2, $unit = "M") {
            //  $lat1 = 24.7509789;
            //  $long1 = 46.6798639;
            //  $lat2 = 24.771487;
            //  $long2 = 46.7173513;
            //  $unit = 'k';
          $theta = $long1 - $long2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);
          if ($unit == "K") {
           $distanceKm = $miles * 1.609344;
           $distanceMeter = $distanceKm * 1000;
              return $distanceKm; 
          } else if ($unit == "N") {
              return ($miles * 0.8684) . ' nm';
          } 
         else if ($unit == "M") {
             return ($miles * 1.609344 * 1000);
        }else {
              return $miles . ' mi';
          }
      }
}

