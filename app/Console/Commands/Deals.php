<?php

namespace App\Console\Commands;
use App\Deal ;
use App\Ticket ;
use App\User ;
use App\Notifications\Notifications;
use Notification;
use Illuminate\Console\Command;
use Carbon\Carbon;
class Deals extends Command   
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deal:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function notification($device_id ,$title,$msg,$id="0")
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
    public function webnotification($device_id ,$title,$msg,$type)
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
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $deals = Deal::all();
        foreach($deals as $deal){
        $dt = Carbon::now();

        $date  = date('Y-m-d', strtotime($dt));
        $time  = date('H:i:s', strtotime($dt));
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
        // $deal->expiry_time  = '19:01';
    
        $this->info('success');
    }
}
