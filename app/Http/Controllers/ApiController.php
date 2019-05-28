<?php
use Illuminate\Support\Facades\Hash;
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\User;
use App\SubCategory;
use App\Category;
use App\Deal;
use App\City;
use App\ContactUs;
use App\Doc ; 
use App\Term;
use App\Country;
use App\Advertisement ;
use App\PasswordReset ; 
use App\Package ; 
use App\Favorite ; 
use App\Award ; 
use App\Ticket ; 
use App\Charge ; 
use App\Address ; 
use App\Interest ; 
use App\UserInterest ; 
use App\Contact;

use DateTime;
use Carbon\Carbon;
use App\Notifications\Notifications;
use App\Notifications\SendMessages;
use Validator;
use Notification;
use StreamLab\StreamLabProvider\Facades\StreamLabFacades;
use App\Notifications\verify_code;

class ApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
 
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set('Africa/Cairo');
        $this->middleware('guest')->except('logout');
    }
//////////////////////////////////////////////
// Advertisement function by Antonious hosny
    public function Advertisements(Request $request){ 
        $advertisements  = Advertisement::where('status','active')->orderBy('id', 'desc')->get();
            if(sizeof($advertisements) > 0){
                $advertisementss =[];
                $i = 0 ;

                foreach($advertisements as $advertisement){
                    if($advertisement){
                        $advertisementss[$i]['link'] = $advertisement->link;
                        $advertisementss[$i]['time'] = $advertisement->time;
                        if($advertisement->image != null){
                            $advertisementss[$i]['image']   = asset('img/').'/'. $advertisement->image;
                        }
                        else{
                            $advertisementss[$i]['image']   = null;
                        }
                        $i ++ ;
                       
                    }
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null,
                    'message' => trans('api.fetch'),
                    'data' => $advertisementss
                ]);
            }
            else
            {
                $errors=  trans('api.notfound');
                // $errors[] = trans('api.fail_login');
                return response()->json([
                    'success' => 'failed',
                    'errors' => $errors,
                    'message' => trans('api.notfound'),
                    'data' => null,

                ]);
            }


    }
//////////////////////////////////////////////
// Advertisement function by Antonious hosny
    public function Countries(Request $request){ 
        $lang = $request->header('lang');
        if($lang == 'ar'){
            $Countries  = Country::where('id','<>','1')->where('status','active')->orderBy('name_ar', 'asc')->get();
        }else{
            $Countries  = Country::where('id','<>','1')->where('status','active')->orderBy('name_en', 'asc')->get();
        } 
            if(sizeof($Countries) > 0){
                $Countriess =[];
                $i = 0 ;

                foreach($Countries as $Country){
                    if($Country){
                        $Countriess[$i]['country_id']   = $Country->id;

                        if($Country->image != null){
                            $Countriess[$i]['country_image']   = asset('img/').'/'. $Country->image;
                        }
                        else{
                            $Countriess[$i]['country_image']   = null;
                        }
                        if($lang == 'ar'){
                            $Countriess[$i]['country_name']   = $Country->name_ar;
                        }else{
                            $Countriess[$i]['country_name']   =  $Country->name_en;
                        }
                        $i ++ ;
                    
                    }
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null,
                    'message' => trans('api.fetch'),
                    'data' => $Countriess
                ]);
            }
            else
            {
                $errors=  trans('api.notfound');
                // $errors[] = trans('api.fail_login');
                return response()->json([
                    'success' => 'failed',
                    'errors' => $errors,
                    'message' => trans('api.notfound'),
                    'data' => null,

                ]);
            }


    }
////////////////////////////////////////////// 
// Advertisement function by Antonious hosny
    public function Cities(Request $request){ 
        $lang = $request->header('lang');
        if($lang == 'ar'){
            $Cities  = City::where('id','<>','1')->where('status','active')->where('country_id',$request->country_id)->orderBy('name_ar', 'asc')->get();
        }else{
            $Cities  = City::where('id','<>','1')->where('status','active')->where('country_id',$request->country_id)->orderBy('name_en', 'asc')->get();
        }
            if(sizeof($Cities) > 0){
                $Citiess =[];
                $i = 0 ;

                foreach($Cities as $City){
                    if($City){
                        $Citiess[$i]['city_id']   = $City->id;

                        // if($City->image != null){
                        //     $Citiess[$i]['city_image']   = asset('img/').'/'. $City->image;
                        // }
                        // else{
                        //     $Citiess[$i]['city_image']   = null;
                        // }
                        if($lang == 'ar'){
                            $Citiess[$i]['city_name']   = $City->name_ar;
                        }else{
                            $Citiess[$i]['city_name']   =  $City->name_en;
                        }
                        $i ++ ;
                    
                    }
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null,
                    'message' => trans('api.fetch'),
                    'data' => $Citiess
                ]);
            }
            else
            {
                $errors=  trans('api.notfound');
                // $errors[] = trans('api.fail_login');
                return response()->json([
                    'success' => 'failed',
                    'errors' => $errors,
                    'message' => trans('api.notfound'),
                    'data' => null,

                ]);
            }

    }
//////////////////////////////////////////////

// login function by Antonious hosny
    public function login(Request $request){
        // return $request;
        // print time();
        $lang = $request->header('lang');
        // $this->validateLogin($request);
        $rules=array(
                    
            "mobile"=>"required",
            "password"=>"required",
            "device_token"=>"required",
            "device_type" => "required"  //1for ios , 0 for android  
        );
   
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
 
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    // 'field' => $field,
                    'message' => $message
                ];
            }
            return response()->json([
                'success' => 'failed',
                'errors'=>$transformed,
                'message' => trans('api.failed_login'),
                'data' => null,

            ]);
        }
        $user = User::where('mobile',$request->mobile)->orWhere('user_name',$request->mobile)->first();

        if(!$user){

            $errors =  trans('api.mobile_notfound');
            return response()->json([
                'success' => 'failed',
                'errors' => $errors ,
                'message' => trans('api.mobile_notfound'),
                'data' => null,

            ]);
        }
        else{
            if (\Hash::check( $request->password,$user->password)) {
                if($user->status == 'not_active'){
                    return response()->json([
                        'success' => 'failed',
                        'errors' => trans('api.allowed'),
                        'message' => trans('api.allowed'),
                        'data' => null,
                    ]);
                }
                $user->generateToken();
                $user->device_token = $request->device_token ;
                $user->type = $request->device_type ;
                $user->save();
                $user =  User::where('id',$user->id)->with('country')->with('city')->first();
                if($user){
                    $users = [] ;
                    $users['id'] = $user->id ;
                    $users['name'] = $user->name ;
                    $users['email'] = $user->email ;
                    $users['user_name'] = $user->user_name ;
                    $users['mobile'] = $user->mobile ;
                    if($user->country){
                        
                        if($lang == 'ar'){
                            
                            $users['country_id'] = $user->country->id ;
                            $users['country_name']   = $user->country->name_ar;
                        }else{
                            $users['country_id'] = $user->country->id ;
                            $users['country_name']   = $user->country->name_en;
                        }
                    }else{
                        $users['country_id'] = null ;
                        $users['country_name']   =  null;
                    }
                    if($user->city){
                        
                        if($lang == 'ar'){
                            $users['city_id'] = $user->city->id ;
                            $users['city_name']   = $user->city->name_ar;
                        }else{
                            $users['city_id'] = $user->city->id ;
                            $users['city_name']   = $user->city->name_en;
                        }
                    }else{
                        $users['city_id'] = null ;
                        $users['city_name']   =  null;
                    }
                    $users['job'] = $user->job ;
                    $users['gender'] = $user->gender ;
                    if($user->points){
                        $users['points'] = $user->points ;
                    }else{
                        $users['points'] = 0 ;
                    }
                    if($user->coupons){
                        $users['coupons'] = $user->coupons ;
                    }else{
                        $users['coupons'] = 0 ;
                    }
                    $users['remember_token'] = $user->remember_token ;
                    
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null,
                    'message' => trans('api.login'),
                    'data' => $users
                ]);
            }
            else
            {
                $errors=  trans('api.password_failed');
                // $errors[] = trans('api.fail_login');
                return response()->json([
                    'success' => 'failed',
                    'errors' => $errors,
                    'message' => trans('api.password_failed'),
                    'data' => null,

                ]);
            }
                
            
        }

    }
//////////////////////////////////////////////
// register function by Antonious hosny
    public function Register(Request $request) {
        // return $request;
        $lang = $request->header('lang');
        // $this->validateLogin($request);
        $rules=array(   
            "name"=>"required|min:3",
            "user_name"=>"required|unique:users,user_name",
            "email"=>"required|unique:users,email",
            "mobile"=>"required|unique:users,mobile",
            "password"=>"required|min:3",
            "country"=>"required",
            "city"=>"required",
            "job"=>"required",
            "gender"=>"required",
            "birth_date"=>"required",
            // "role" => "required"     // client ,user
        );
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
 
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            return response()->json([
                'success' => 'failed',
                'errors'  => $transformed,
                'message' => trans('api.failed_registered'),
                'data'    => null ,
            ]);
        }

            $user = new User;

            $password            = \Hash::make($request->password);
            $user->password      = $password ;
            $user->name          = $request->name ;
            $user->email         = $request->email ;
            $user->mobile        = $request->mobile ;
            $user->user_name        = $request->user_name ;
            $user->country_id        = $request->country ;
            $user->city_id        = $request->city ;
            $user->job        = $request->job ;
            $user->gender        = $request->gender ;
            $user->birth_date        = $request->birth_date ;
            $user->status        = 'not_active';
            $user->role          = 'user';
            $user->save();
            $user->generateToken();

            $msg = " مستخدم جديد " ;
            $type = "user";
            $title =" مستخدم جديد " ;
            $admins = User::where('role', 'admin')->get(); 
            if(sizeof($admins) > 0){
                foreach($admins as $admin){
                    $admin->notify(new Notifications($msg,$type ));
                }
                $device_token = $admin->device_token ;
                if($device_token){
                    $this->notification($device_token,$title,$msg);
                }
            }
            $token = rand(100000,999999);
            $PasswordReset = PasswordReset::where('email',$user->email)->first();
            if(!$PasswordReset){
                $PasswordReset = new PasswordReset ;
            }
            $PasswordReset->email = $user->email ;
            $PasswordReset->token = $token ;
            $PasswordReset->save();
            User::find($user->id)->notify(new verify_code($token));
            $user =  User::where('id',$user->id)->with('country')->with('city')->first();
            if($user){
                $users = [] ;
                $users['id'] = $user->id ;
                $users['name'] = $user->name ;
                $users['email'] = $user->email ;
                $users['user_name'] = $user->user_name ;
                $users['mobile'] = $user->mobile ;
                if($lang == 'ar'){
                    $users['country_id'] = $user->country->id ;
                    $users['country_name']   = $user->country->name_ar;
                }else{
                    $users['country_id'] = $user->country->id ;
                    $users['country_name']   = $user->country->name_en;
                }
                if($lang == 'ar'){
                    $users['city_id'] = $user->city->id ;
                    $users['city_name']   = $user->city->name_ar;
                }else{
                    $users['city_id'] = $user->city->id ;
                    $users['city_name']   = $user->city->name_en;
                }
                $users['job'] = $user->job ;
                $users['gender'] = $user->gender ;
                $users['remember_token'] = $user->remember_token ;
                
            }
            return response()->json([
                'success' => 'success',
                'errors'=> null ,
                'message' => trans('api.success_registered'),
                'data' => $users ,
            ]);
        
    }
//////////////////////////////////////////////
// editprofile function by Antonious hosny
    public function editprofile(Request $request){
        // return $request ;
        $lang = $request->header('lang');
        $token = $request->token;
        if($token == ''){
            $errors[] = [
                'message' => trans('api.logged_out')
            ]; 
            return response()->json([
                'success' => 'failed',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'user' => null,

            ]);
        }  
        $user = User::where('remember_token',$token)->first();
        if($user){      
            $rules=array(  
                "name"=>"min:3",
                // 'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                // "mobile"=>"digits:10",
                "password" => "min:6",
                "email"=> 'email'
            );
            $user = User::where('id',$user->id)->first();
            if($request->mobile){
                if( $request->mobile != $user->mobile){
                    $rules['mobile'] = 'unique:users,mobile';
                }
            }
            if($request->email){
                if($request->email != $user->email){
                    $rules['email'] = 'email|unique:users,email';
                }
            }
            //check the validator true or not
            $validator  = \Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                $messages = $validator->messages();
                $transformed = [];

                foreach ($messages->all() as $field => $message) {
                    $transformed[] = [
                        // 'field' => $field,
                        'message' => $message
                    ];
                }
                return response()->json([
                    'success' => 'failed',
                    'errors'=>$transformed,
                    'message' => trans('api.failed'),
                    'user' =>  null ,
                ]);
            }

            if($request->password){
                $password = \Hash::make($request->password);
                $user->password = $password ;
            }
            if($request->name){
                $user->name          = $request->name ;
            }
            if($request->email){
                $user->email         = $request->email ;
            }
            if($request->mobile){
                $user->mobile        = $request->mobile ;
            }
            if($request->address){
                $user->address           = $request->address ;
            }
            if($request->lat){
                $user->lat           = $request->lat ;
            }
            if($request->lng){
                $user->lng           = $request->lng ;
            }
            if($request->national_id){
                $user->national_id           = $request->national_id ;
            }
            if($request->disc){
                $user->disc           = $request->disc ;
            }
            if ($request->profile_pic){
                $image = $request->input('profile_pic'); // image base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(10). time().'.'.'png';
                \File::put(public_path(). '/img/' . $imageName, base64_decode($image));
                $user->image = $imageName;
            }
            $user->save();
            return response()->json([
                'success' => 'success',
                'errors'=> null ,
                'message' => trans('api.save'),
                'user' => $user ,
            ]);
        }
        else{
            $errors[] = [
                'message' => trans('api.logged_out')
            ]; 
            return response()->json([
                'success' => 'failed',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'user' => null,

            ]);

        }

    }
///////////////////////////////////////////////////
// logout function by Antonious hosny
    public function logout(Request $request){
        $token = $request->token;
        if($token == ''){
        }
        // $token = $request->header('access_token');
        $user = User::where('remember_token',$token)->first();
        if ($user) {
            $user->remember_token = null;
            $user->device_token = null;
            $user->save();
            return response()->json([
                'success' => 'success',
                'errors' => null,
                "message"=>trans('api.logout'),
                ]);
        }else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logout'),
                "message"=>trans('api.logout'),
                ]);
        }

    }
//////////////////////////////////////////////////
// forget_password function by Antonious hosny
    public function forget_password(Request $request){
        $rules['email'] = 'required';
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];

            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    // 'field' => $field,
                    'message' => $message
                ];
            }
            return response()->json([
                'success' => 'failed',
                'errors'=>$transformed,
                'message' => trans('api.failed'), 
                'user' =>  null ,
            ]);
        }
        $email = $request->email;
        $user = User::where('email',$email)->first();

        if($user){

            $token = rand(100000,999999);
            $PasswordReset = PasswordReset::where('email',$user->email)->first();
            if(!$PasswordReset){
                $PasswordReset = new PasswordReset ;
            }
            $PasswordReset->email = $user->email ;
            $PasswordReset->token = $token ;
            $PasswordReset->save();
            User::find($user->id)->notify(new verify_code($token));
            return response()->json([
                'success' => 'success',
                'errors'  => null,
                "message"=>trans('api.send_token'),
                ]);

        }
        $error = trans('api.user_notfound');
        return response()->json([
            'success' => 'failed',
            'errors'  =>  $error,
            "message"=>trans('api.user_notfound'),

            ]);
        
    }
//////////////////////////////////////////////////
// verify_code function by Antonious hosny
    public function verify_code(Request $request){
        $code = $request->code;
        if($code){
            $PasswordReset = PasswordReset::where('token',$code)->first();
            // return $PasswordReset ;
            if ($PasswordReset) {
                $user = User::where('email',$PasswordReset->email)->first();
                if($user){
                    $user->status = 'active' ;
                    $user->save();
                }
                return response()->json([
                    'success' => 'success',
                    'errors'  => null,
                    "message"=>trans('api.success_code'),
                    'code' => $code 

                ]);
            }
            else{
                $error = trans('api.incorrect_code');
                return response()->json([
                    'success' => 'failed',
                    'errors'  =>  $error,
                    "message"=>trans('api.incorrect_code'),
                    'code' => null
                ]);
            }
            
        }
        $error = trans('api.code_requird');
        return response()->json([
            'success' => 'failed',
            'errors'  =>  $error,
            "message"=>trans('api.code_requird'),
            'code' => null
        ]);
        
    }
///////////////////////////////////////////////////
// reset_password function by Antonious hosny
    public function reset_password(Request $request){
        $code = $request->code;
        if($code){
            $PasswordReset = PasswordReset::where('token',$code)->first();
            if($PasswordReset){
                $user = User::where('email',$PasswordReset->email)->first();
            }
            
            else{
                $error = trans('api.code_notfound');
                return response()->json([
                    'success' => 'failed',
                    'errors'  => $error,
                    "message"=>trans('api.code_notfound'),

                ]);
            }
            if ($user) {
                if($request->password){
                    $password = \Hash::make($request->password);
                    $user->password = $password ;
                    // $user->generateToken();
                    $user->save();
                    
                    return response()->json([
                        'success' => 'success',
                        'errors'  => null,
                        "message"=>trans('api.passwordsucces')
                    ]);
                }
                else{
                    $error = trans('api.password_requird');
                    return response()->json([
                        'success' => 'failed',
                        'errors'  => $error,
                        "message"=>trans('api.password_requird'),
                
                    ]);
                }
            
                // User::find($user->id)->notify(new verify_code($user->verify_code ));
                // return $user;
                
            }
            $error = trans('api.code_notfound');
            return response()->json([
                'success' => 'failed',
                'errors'  => $error,
                "message"=>trans('api.code_notfound'),
                

            ]);
        }
        $error = trans('api.code_required');
        return response()->json([
            'success' => 'failed',
            'errors'  => $error,
            "message"=>trans('api.code_required'),
        

        ]);
        
    }
//////////////////////////////////////////////////
/////////////////////////////////////////////////
// request_home function by Antonious hosny
    public function homePage(Request $request){
       $this->CloseDeal();
       
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $lang = $request->header('lang');
            $dt = Carbon::now();
            $date2 = date('Y-m-d', strtotime($dt));
            $time2 = $dt->format('H:i:s');
            $date  = date('Y-m-d', strtotime($dt));
            // return $date ;
            $time  = date('H:i:s', strtotime($dt));
            $advertisements  = Advertisement::where('status','active')->orderBy('id', 'desc')->get();
            $advertisementss =[];
            $i = 0 ;
            if(sizeof($advertisements) > 0){
                foreach($advertisements as $advertisement){
                    $advertisementss[$i]['link'] = $advertisement->link;
                    $advertisementss[$i]['time'] = $advertisement->time;
                    if($advertisement->image != null){
                        $advertisementss[$i]['image']   = asset('img/').'/'. $advertisement->image;
                    }
                    else{
                        $advertisementss[$i]['image']   = null;
                    }
                    $i ++ ;
                }
            }
            $user = User::where('remember_token',$token)->first();
            // return $user;
            $now_Deals = Deal::whereDate('expiry_date',$date)->whereTime('expiry_time','>=',$time)->where('status','active')->orderBy('id', 'desc')->limit(10)->get();
            
            // return $now_Deals ;
            $count_now_Deals = 0 ;
            $coming_Deals = Deal::whereDate('expiry_date','>',$date)->orWhere('expiry_date','')->orWhere('expiry_date',null)->where('status','active')->orderBy('id', 'desc')->limit(10)->get();
            $count_coming_Deals = 0 ;
            $pervios_Deals = Deal::whereDate('expiry_date','<',$date)->orwhereDate('expiry_date','=',$date)->whereTime('expiry_time','<',$time)->where('status','active')->orderBy('id', 'desc')->limit(10)->get();
            $count_pervios_Deals = 0 ;
            // return $pervios_Deals ;
            $now_Dealss = [] ;
            $coming_Dealss = [] ;
            $pervios_Dealss = [] ;
            $my_Dealss = [] ;
            $i = 0;
            $x = 0;
            $y = 0;
            if(sizeof($now_Deals) > 0 ){
                foreach($now_Deals as $Deal){
                    if($Deal->country_id == '1' ||$Deal->country_id == $user->country_id && $Deal->city_id == '1' ||$Deal->city_id == $user->city_id) {
                        $datedeal = strtotime($Deal->expiry_date);
                        // return asset('img/').'/'. $image->image;
                        $now_Dealss[$i]['Deal_id'] = $Deal->id ;    
                        if($lang == 'ar'){
                            $now_Dealss[$i]['title'] = $Deal->title_ar ; 
                            $now_Dealss[$i]['disc'] = $Deal->disc_ar ; 
                            $now_Dealss[$i]['info'] = $Deal->info_ar ; 
                        }else{
                            $now_Dealss[$i]['title'] = $Deal->title_en ; 
                            $now_Dealss[$i]['disc'] = $Deal->disc_en ; 
                            $now_Dealss[$i]['info'] = $Deal->info_en ; 
                        }
                        if($Deal->image){
                            $now_Dealss[$i]['image'] = asset('img/').'/'. $Deal->image;
                        }else{
                            $now_Dealss[$i]['image'] = null ;
                        }
                        
                        $now_Dealss[$i]['original_price'] = $Deal->original_price ; 
                        $now_Dealss[$i]['initial_price'] = $Deal->initial_price ; 
                        $now_Dealss[$i]['points'] = $Deal->points ; 
                        $now_Dealss[$i]['tickets'] = $Deal->tickets ; 
                        $now_Dealss[$i]['tender_cost'] = $Deal->tender_cost ; 
                        $now_Dealss[$i]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                        $now_Dealss[$i]['tender_coupon'] = $Deal->tender_coupon ; 
                        $now_Dealss[$i]['expiry_date'] = $Deal->expiry_date .' '.$Deal->expiry_time;  

                        $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($favorite){
                            $now_Dealss[$i]['is_favorite'] = 'true' ;
                        }else{
                            $now_Dealss[$i]['is_favorite'] = 'false' ;
                        }
                        $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($ticket){
                            $now_Dealss[$i]['my_ticket_points'] = $ticket->points ;
                        }else{
                            $now_Dealss[$i]['my_ticket_points'] = null ;
                        }
                        
                        $imagess = []; 
                        if( $Deal->images){
                            $images = json_decode($Deal->images);
                            if(gettype($images)== 'array' && sizeof($images) > 0){
                                $n = 0 ;
                                foreach($images as $img){
                                    $imagess[$n] = asset('img/').'/'. $img;
                                    $n++;
                                }
                            }
                        }
                        $now_Dealss[$i]['images'] = $imagess ;
                        $i ++ ; 
                        $count_now_Deals ++ ;
                    }
                    
                }
            }
            if(sizeof($coming_Deals) > 0 ){
                foreach($coming_Deals as $Deal){
                    if($Deal->country_id == '1' ||$Deal->country_id == $user->country_id && $Deal->city_id == '1' ||$Deal->city_id == $user->city_id) {
                        // return asset('img/').'/'. $image->image;
                        $coming_Dealss[$x]['Deal_id'] = $Deal->id ;    
                        if($lang == 'ar'){
                            $coming_Dealss[$x]['title'] = $Deal->title_ar ; 
                            $coming_Dealss[$x]['disc'] = $Deal->disc_ar ; 
                            $coming_Dealss[$x]['info'] = $Deal->info_ar ; 
                        }else{
                            $coming_Dealss[$x]['title'] = $Deal->title_en ; 
                            $coming_Dealss[$x]['disc'] = $Deal->disc_en ; 
                            $coming_Dealss[$x]['info'] = $Deal->info_en ; 
                        }
                        if($Deal->image){
                            $coming_Dealss[$x]['image'] = asset('img/').'/'. $Deal->image;
                        }else{
                            $coming_Dealss[$x]['image'] = null ;
                        }
                        
                        $coming_Dealss[$x]['original_price'] = $Deal->original_price ; 
                        $coming_Dealss[$x]['initial_price'] = $Deal->initial_price ; 
                        $coming_Dealss[$x]['points'] = $Deal->points ; 
                        $coming_Dealss[$x]['tickets'] = $Deal->tickets ; 
                        $coming_Dealss[$x]['tender_cost'] = $Deal->tender_cost ; 
                        $coming_Dealss[$x]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                        $coming_Dealss[$x]['tender_coupon'] = $Deal->tender_coupon ; 
                        $coming_Dealss[$x]['expiry_date'] = $Deal->expiry_date .' '.$Deal->expiry_time; 
                        $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($favorite){
                            $coming_Dealss[$x]['is_favorite'] = 'true' ;
                        }else{
                            $coming_Dealss[$x]['is_favorite'] = 'false' ;
                        }
                        $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($ticket){
                            $coming_Dealss[$x]['my_ticket_points'] = $ticket->points ;
                        }else{
                            $coming_Dealss[$x]['my_ticket_points'] = null ;
                        }
                        $imagess = []; 
                        if( $Deal->images){
                            $images = json_decode($Deal->images);
                            if(gettype($images)== 'array' && sizeof($images) > 0){
                                $n = 0 ;
                                foreach($images as $img){
                                    $imagess[$n] = asset('img/').'/'. $img;
                                    $n++;
                                }
                            }
                        }
                        $coming_Dealss[$x]['images'] = $imagess ;
                        $x ++ ; 
                        $count_coming_Deals ++ ;
                    }
                }
            }
            if(sizeof($pervios_Deals) > 0 ){
                foreach($pervios_Deals as $Deal){
                    if($Deal->country_id == '1' || $Deal->country_id == $user->country_id && $Deal->city_id == '1' ||$Deal->city_id == $user->city_id) {
                        $Deal->is_open = '0' ;
                        $Deal->save();
                        // return asset('img/').'/'. $image->image;
                        $pervios_Dealss[$y]['Deal_id'] = $Deal->id ;    
                        if($lang == 'ar'){
                            $pervios_Dealss[$y]['title'] = $Deal->title_ar ; 
                            $pervios_Dealss[$y]['disc'] = $Deal->disc_ar ; 
                            $pervios_Dealss[$y]['info'] = $Deal->info_ar ; 
                        }else{
                            $pervios_Dealss[$y]['title'] = $Deal->title_en ; 
                            $pervios_Dealss[$y]['disc'] = $Deal->disc_en ; 
                            $pervios_Dealss[$y]['info'] = $Deal->info_en ; 
                        }
                        if($Deal->image){
                            $pervios_Dealss[$y]['image'] = asset('img/').'/'. $Deal->image;
                        }else{
                            $pervios_Dealss[$y]['image'] = null ;
                        }
                        
                        $pervios_Dealss[$y]['original_price'] = $Deal->original_price ; 
                        $pervios_Dealss[$y]['initial_price'] = $Deal->initial_price ; 
                        $pervios_Dealss[$y]['points'] = $Deal->points ; 
                        $pervios_Dealss[$y]['tickets'] = $Deal->tickets ; 
                        $pervios_Dealss[$y]['tender_cost'] = $Deal->tender_cost ; 
                        $pervios_Dealss[$y]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                        $pervios_Dealss[$y]['tender_coupon'] = $Deal->tender_coupon ; 
                        $pervios_Dealss[$y]['expiry_date'] = $Deal->expiry_date .' '.$Deal->expiry_time; 
                        $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($favorite){
                            $pervios_Dealss[$y]['is_favorite'] = 'true' ;
                        }else{
                            $pervios_Dealss[$y]['is_favorite'] = 'false' ;
                        }
                        $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($ticket){
                            $pervios_Dealss[$y]['my_ticket_points'] = $ticket->points ;
                        }else{
                            $pervios_Dealss[$y]['my_ticket_points'] = null ;
                        }
                        $imagess = []; 
                        if( $Deal->images){
                            $images = json_decode($Deal->images);
                            if(gettype($images)== 'array' && sizeof($images) > 0){
                                $n = 0 ;
                                foreach($images as $img){
                                    $imagess[$n] = asset('img/').'/'. $img;
                                    $n++;
                                }
                            }
                        }
                        $pervios_Dealss[$y]['images'] = $imagess ;
                        $y ++ ; 
                        $count_pervios_Deals ++ ;
                    }
                }
            }
            $tickets = Ticket::where('user_id',$user->id)->get();
            $i = 0 ;
            foreach($tickets as $ticket){

                $Deal = Deal::where('id',$ticket->deal_id)->first();  
                if($Deal){

                    $my_Dealss[$i]['Deal_id'] = $Deal->id ;    
                    if($lang == 'ar'){
                        $my_Dealss[$i]['title'] = $Deal->title_ar ; 
                        $my_Dealss[$i]['disc'] = $Deal->disc_ar ; 
                        $my_Dealss[$i]['info'] = $Deal->info_ar ; 
                    }else{
                        $my_Dealss[$i]['title'] = $Deal->title_en ; 
                        $my_Dealss[$i]['disc'] = $Deal->disc_en ; 
                        $my_Dealss[$i]['info'] = $Deal->info_en ; 
                    }
                    if($Deal->image){
                        $my_Dealss[$i]['image'] = asset('img/').'/'. $Deal->image;
                    }else{
                        $my_Dealss[$i]['image'] = null ;
                    }
                    
                    $my_Dealss[$i]['original_price'] = $Deal->original_price ; 
                    $my_Dealss[$i]['initial_price'] = $Deal->initial_price ; 
                    $my_Dealss[$i]['points'] = $Deal->points ; 
                    $my_Dealss[$i]['tickets'] = $Deal->tickets ; 
                    $my_Dealss[$i]['tender_cost'] = $Deal->tender_cost ; 
                    $my_Dealss[$i]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                    $my_Dealss[$i]['tender_coupon'] = $Deal->tender_coupon ; 
                    $my_Dealss[$i]['expiry_date'] = $Deal->expiry_date .' '.$Deal->expiry_time;  
                    // return $Deal->images ;
                    $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                    if($favorite){
                        $my_Dealss[$i]['is_favorite'] = 'true' ;
                    }else{
                        $my_Dealss[$i]['is_favorite'] = 'false' ;
                    }
                    $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                    if($ticket){
                        $my_Dealss[$i]['my_ticket_points'] = $ticket->points ;
                    }else{
                        $my_Dealss[$i]['my_ticket_points'] = null ;
                    }
                    if($ticket->status == '1'){
                        $my_Dealss[$i]['ticket_status'] = 'winner';
                    }else{
                        $my_Dealss[$i]['ticket_status'] = '0' ;
                    }
                    $i++ ;
                }
            }
            return response()->json([
                'success' => 'success',
                'errors' => null ,
                'message' => trans('api.fetch'),
                'data' => [
                    'now_Deals' => $now_Dealss,
                    'pervious_Deals' => $pervios_Dealss ,
                    'coming_Deals'         => $coming_Dealss ,
                    'my_Deals'         => $my_Dealss,
                    'advertisements'   => $advertisementss,
                    'count_now_Deals' => $count_now_Deals,
                    'count_coming_Deals' => $count_coming_Deals,
                    'count_pervious_Deals' => $count_pervios_Deals,
    
                    ],
    
            ]);
            
        }else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logout'),
                "message"=>trans('api.logout'),
                ]);
        }


    }
//////////////////////////////////////////////////
// NowDeals function by Antonious hosny
    public function NowDeals(Request $request){
        $token = $request->token;
        if($request->skip && $request->skip > 0 ){
            $skip = $request->skip.'0' ;
        }else{
            $skip = 0 ;
        }
        $lang = $request->header('lang');
        $dt = Carbon::now();
        $date2 = date('Y-m-d', strtotime($dt));
        $time2 = $dt->format('H:i:s');
        $date  = date('Y-m-d', strtotime($dt));
        $time  = date('H:i:s', strtotime($dt));
        if($token){
            $user = User::where('remember_token',$token)->first();
            // return $user;
            $now_Deals = Deal::whereDate('expiry_date','=',$date)->whereTime('expiry_time','>=',$time)->where('status','active')->orderBy('id', 'desc')->limit(10)->get();
            $count_now_Deals = 0 ;
            $now_Dealss = [] ;
            $i =0 ;
            if(sizeof($now_Deals) > 0 ){
                foreach($now_Deals as $Deal){
                      if($Deal->country_id == '1' ||$Deal->country_id == $user->country_id && $Deal->city_id == '1' ||$Deal->city_id == $user->city_id) {
                        $datedeal = strtotime($Deal->expiry_date);
                        $timedeal = date('H:i:s', $datedeal);
                        // return asset('img/').'/'. $image->image;
                        $now_Dealss[$i]['Deal_id'] = $Deal->id ;    
                        if($lang == 'ar'){
                            $now_Dealss[$i]['title'] = $Deal->title_ar ; 
                            $now_Dealss[$i]['disc'] = $Deal->disc_ar ; 
                            $now_Dealss[$i]['info'] = $Deal->info_ar ; 
                        }else{
                            $now_Dealss[$i]['title'] = $Deal->title_en ; 
                            $now_Dealss[$i]['disc'] = $Deal->disc_en ; 
                            $now_Dealss[$i]['info'] = $Deal->info_en ; 
                        }
                        if($Deal->image){
                            $now_Dealss[$i]['image'] = asset('img/').'/'. $Deal->image;
                        }else{
                            $now_Dealss[$i]['image'] = null ;
                        }
                        
                        $now_Dealss[$i]['original_price'] = $Deal->original_price ; 
                        $now_Dealss[$i]['initial_price'] = $Deal->initial_price ; 
                        $now_Dealss[$i]['points'] = $Deal->points ; 
                        $now_Dealss[$i]['tickets'] = $Deal->tickets ; 
                        $now_Dealss[$i]['tender_cost'] = $Deal->tender_cost ; 
                        $now_Dealss[$i]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                        $now_Dealss[$i]['tender_coupon'] = $Deal->tender_coupon ; 
                        $now_Dealss[$i]['expiry_date'] = $Deal->expiry_date .' '.$Deal->expiry_time;  
                        $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($favorite){
                            $now_Dealss[$i]['is_favorite'] = 'true' ;
                        }else{
                            $now_Dealss[$i]['is_favorite'] = 'false' ;
                        }
                        $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($ticket){
                            $now_Dealss[$i]['my_ticket_points'] = $ticket->points ;
                        }else{
                            $now_Dealss[$i]['my_ticket_points'] = null ;
                        }
                        if( $Deal->images){
                            $images = json_decode($Deal->images);
                            if(gettype($images)== 'array' && sizeof($images) > 0){
                                $imagess = []; 
                                $n = 0 ;
                                foreach($images as $img){
                                    $imagess[$n] = asset('img/').'/'. $img;
                                    $n++;
                                }
                            $now_Dealss[$i]['images'] = $imagess ;
                            }
                        }
                        $i ++ ; 
                        $count_now_Deals ++ ;
                    }
                    
                }
            }
            return response()->json([
                'success' => 'success',
                'errors' => null ,
                'message' => trans('api.fetch'),
                'data' => [
                    'now_Deals' => $now_Dealss,
                    'count_now_Deals' => $count_now_Deals,
                    ],

            ]);
            
        }else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logout'),
                "message"=>trans('api.logout'),
                ]);
        }


    }
//////////////////////////////////////////////////
// ComingDeals function by Antonious hosny
    public function ComingDeals(Request $request){
        $token = $request->token;
        if($request->skip && $request->skip > 0 ){
            $skip = $request->skip.'0' ;
        }else{
            $skip = 0 ;
        }
        $lang = $request->header('lang');
        $dt = Carbon::now();
  
        $date  = date('Y-m-d', strtotime($dt));
        $time  = date('H:i:s', strtotime($dt));
        if($token){

            $user = User::where('remember_token',$token)->first();

            $coming_Deals = Deal::whereDate('expiry_date','>',$date)->orWhere('expiry_date','')->orWhere('expiry_date',null)->where('status','active')->orderBy('id', 'desc')->limit(10)->get();
            $count_coming_Deals = 0 ;
            
            $coming_Dealss = [] ;
            $x = 0;
           if(sizeof($coming_Deals) > 0 ){
                foreach($coming_Deals as $Deal){
                    // return asset('img/').'/'. $image->image;
                    $coming_Dealss[$x]['Deal_id'] = $Deal->id ;    
                    if($lang == 'ar'){
                        $coming_Dealss[$x]['title'] = $Deal->title_ar ; 
                        $coming_Dealss[$x]['disc'] = $Deal->disc_ar ; 
                        $coming_Dealss[$x]['info'] = $Deal->info_ar ; 
                    }else{
                        $coming_Dealss[$x]['title'] = $Deal->title_en ; 
                        $coming_Dealss[$x]['disc'] = $Deal->disc_en ; 
                        $coming_Dealss[$x]['info'] = $Deal->info_en ; 
                    }
                    if($Deal->image){
                        $coming_Dealss[$x]['image'] = asset('img/').'/'. $Deal->image;
                    }else{
                        $coming_Dealss[$x]['image'] = null ;
                    }
                    
                    $coming_Dealss[$x]['original_price'] = $Deal->original_price ; 
                    $coming_Dealss[$x]['initial_price'] = $Deal->initial_price ; 
                    $coming_Dealss[$x]['points'] = $Deal->points ; 
                    $coming_Dealss[$x]['tickets'] = $Deal->tickets ; 
                    $coming_Dealss[$x]['tender_cost'] = $Deal->tender_cost ; 
                    $coming_Dealss[$x]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                    $coming_Dealss[$x]['tender_coupon'] = $Deal->tender_coupon ; 
                    $coming_Dealss[$x]['expiry_date'] = $Deal->expiry_date .' '.$Deal->expiry_time;  
                    $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                    if($favorite){
                        $coming_Dealss[$x]['is_favorite'] = 'true' ;
                    }else{
                        $coming_Dealss[$x]['is_favorite'] = 'false' ;
                    }
                    $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                    if($ticket){
                        $coming_Dealss[$x]['my_ticket_points'] = $ticket->points ;
                    }else{
                        $coming_Dealss[$x]['my_ticket_points'] = null ;
                    }
                    if( $Deal->images){
                        $images = json_decode($Deal->images);
                        if(gettype($images)== 'array' && sizeof($images) > 0){
                            $imagess = []; 
                            $n = 0 ;
                            foreach($images as $img){
                                $imagess[$n] = asset('img/').'/'. $img;
                                $n++;
                            }
                           $coming_Dealss[$x]['images'] = $imagess ;
                        }
                    }
                    $x ++ ; 
                    $count_coming_Deals ++ ;
                }
            }
            
            return response()->json([
                'success' => 'success',
                'errors' => null ,
                'message' => trans('api.fetch'),
                'data' => [
                    'coming_Deals'         => $coming_Dealss ,
                    'count_coming_Deals' => $count_coming_Deals,

                    ],

            ]);
            
        }else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logout'),
                "message"=>trans('api.logout'),
                ]);
        }


    }
//////////////////////////////////////////////////
// PreviousDeals function by Antonious hosny
    public function PreviousDeals(Request $request){
        $token = $request->token;
        if($request->skip && $request->skip > 0 ){
            $skip = $request->skip.'0' ;
        }else{
            $skip = 0 ;
        }
        $lang = $request->header('lang');
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        $time  = date('H:i:s', strtotime($dt));
        if($token){
            
            $user = User::where('remember_token',$token)->first();
            $now_Deals = Deal::whereDate('expiry_date','=',$date)->whereTime('expiry_time','>=',$time)->where('status','active')->orderBy('id', 'desc')->limit(10)->get();
            $pervios_Deals = Deal::whereDate('expiry_date','<',$date)->orwhereDate('expiry_date','=',$date)->whereTime('expiry_time','<',$time)->orderBy('id', 'desc')->limit(10)->get();
            $count_pervios_Deals = 0 ;
            // return $pervios_Deals ;
            $pervios_Dealss = [] ;
            $y = 0;
          
            if(sizeof($pervios_Deals) > 0 ){
                foreach($pervios_Deals as $Deal){
                    if($Deal->country_id == '1' ||$Deal->country_id == $user->country_id && $Deal->city_id == '1' ||$Deal->city_id == $user->city_id) {
                        $Deal->is_open = '0' ;
                        $Deal->save();
                        // return asset('img/').'/'. $image->image;
                        $pervios_Dealss[$y]['Deal_id'] = $Deal->id ;    
                        if($lang == 'ar'){
                            $pervios_Dealss[$y]['title'] = $Deal->title_ar ; 
                            $pervios_Dealss[$y]['disc'] = $Deal->disc_ar ; 
                            $pervios_Dealss[$y]['info'] = $Deal->info_ar ; 
                        }else{
                            $pervios_Dealss[$y]['title'] = $Deal->title_en ; 
                            $pervios_Dealss[$y]['disc'] = $Deal->disc_en ; 
                            $pervios_Dealss[$y]['info'] = $Deal->info_en ; 
                        }
                        if($Deal->image){
                            $pervios_Dealss[$y]['image'] = asset('img/').'/'. $Deal->image;
                        }else{
                            $pervios_Dealss[$y]['image'] = null ;
                        }
                        
                        $pervios_Dealss[$y]['original_price'] = $Deal->original_price ; 
                        $pervios_Dealss[$y]['initial_price'] = $Deal->initial_price ; 
                        $pervios_Dealss[$y]['points'] = $Deal->points ; 
                        $pervios_Dealss[$y]['tickets'] = $Deal->tickets ; 
                        $pervios_Dealss[$y]['tender_cost'] = $Deal->tender_cost ; 
                        $pervios_Dealss[$y]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                        $pervios_Dealss[$y]['tender_coupon'] = $Deal->tender_coupon ; 
                        $pervios_Dealss[$y]['expiry_date'] = date('d-m-Y H:i:s', strtotime($Deal->expiry_date) );  ; 
                        $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($favorite){
                            $pervios_Dealss[$y]['is_favorite'] = 'true' ;
                        }else{
                            $pervios_Dealss[$y]['is_favorite'] = 'false' ;
                        }
                        $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($ticket){
                            $pervios_Dealss[$y]['my_ticket_points'] = $ticket->points ;
                        }else{
                            $pervios_Dealss[$y]['my_ticket_points'] = null ;
                        }
                        if( $Deal->images){
                            $images = json_decode($Deal->images);
                            if(gettype($images)== 'array' && sizeof($images) > 0){
                                $imagess = []; 
                                $n = 0 ;
                                foreach($images as $img){
                                    $imagess[$n] = asset('img/').'/'. $img;
                                    $n++;
                                }
                            $pervios_Dealss[$y]['images'] = $imagess ;
                            }
                        }
                        $y ++ ; 
                        $count_pervios_Deals ++ ;
                    }
                }
            }
            
            return response()->json([
                'success' => 'success',
                'errors' => null ,
                'message' => trans('api.fetch'),
                'data' => [
                    'pervious_Deals' => $pervios_Dealss ,
                    'count_pervious_Deals' => $count_pervios_Deals,
                    ],

            ]);
            
        }else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logout'),
                "message"=>trans('api.logout'),
                ]);
        }


    }
///////////////////////////////////////////////////
// Categorys function by Antonious hosny
    public function Categorys(Request $request){
        $lang = $request->header('lang');
        $Categorys = Category::where('status','active')->get();
        if(sizeof($Categorys) > 0 ){
            $i = 0;
            foreach($Categorys as $Category){
                $Categoryss[$i]['id'] = $Category->id ; 
                if($lang == 'ar'){
                    $Categoryss[$i]['name'] = $Category->name_ar ; 
                    $Categoryss[$i]['disc'] = $Category->disc_ar ; 

                }else{
                    $Categoryss[$i]['name'] = $Category->name_en ; 
                    $Categoryss[$i]['disc'] = $Category->disc_en ; 
                }
                if($Category->image){
                    $Categoryss[$i]['image'] = asset('img/').'/'. $Category->image;
                }else{
                    $Categoryss[$i]['image'] = null ;
                }
                $i ++ ; 
            }
        }
        else{
            $Categoryss = [];
        }
        return response()->json([
            'success' => 'success',
            'errors' => null ,
            'message' => trans('api.fetch'),
            'data' => $Categoryss,

        ]);
            
        
   
    }   
///////////////////////////////////////////////////
// SubCategorys function by Antonious hosny
    public function SubCategorys(Request $request){
            $lang = $request->header('lang');
            $rules=array(
                'category_id'      =>'required',
            );
            $validator  = Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return response()->json([
                    'success' => 'failed',
                    'errors'=> 'رقم القسم مطلوب',
                    'message' =>'رقم القسم مطلوب',
                    'data' =>  null ,
                ]);
            }
            $SubCategorys = SubCategory::where('category_id',$request->category_id)->where('status','active')->get();
            if(sizeof($SubCategorys) > 0 ){
                $SubCategoryss = []; 
                $i = 0 ;
                foreach($SubCategorys as $SubCategory){
                    $SubCategoryss[$i]['id']        = $SubCategory->id ;   
                    if($lang == 'ar'){
                        $SubCategoryss[$i]['name'] = $SubCategory->name_ar ; 
                        $SubCategoryss[$i]['disc'] = $SubCategory->disc_ar ; 
    
                    }else{
                        $SubCategoryss[$i]['name'] = $SubCategory->name_en ; 
                        $SubCategoryss[$i]['disc'] = $SubCategory->disc_en ; 
                    }
                    if($SubCategory->image){
                        $SubCategoryss[$i]['image']   = asset('img/').'/'. $SubCategory->image;
                    }
                    else{
                        $SubCategoryss[$i]['image']   = null;
                    }

                    $i ++ ; 
                }
       
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.fetch'),
                    'data' => $SubCategoryss ,
                ]);
            }
            else{
                return response()->json([
                    'success' => 'failed',
                    'errors' => 'لا يوجد اقسام',
                    'message' => 'لا يوجد اقسام ',
                    'data' => null 

                ]);
            }
        // }
        // else{
        //     $errors = trans('api.logged_out');
        //     return response()->json([
        //         'success' => 'logged',
        //         'errors' => $errors ,
        //         'message' => trans('api.logged_out'),
        //         'data' => null,
        //     ]);
        // }
            
    }   
///////////////////////////////////////////////////
// SubCategoryDeals function by Antonious hosny
    public function SubCategoryDeals(Request $request){
        $token = $request->token;
        if($request->skip && $request->skip > 0 ){
            $skip = $request->skip.'0' ;
        }else{
            $skip = 0 ;
        }
        $lang = $request->header('lang');
        $dt = Carbon::now();
        // $date = $dt->toDateString();
        $date  = date('Y-m-d H:i:s', strtotime($dt));
        if($token){
            
            $user = User::where('remember_token',$token)->first();
            $Deals = Deal::where('sub_id','<',$request->subcategory_id)->where('status','active')->orderBy('id', 'desc')->skip($skip)->limit(10)->get();
            $count_pervios_Deals = Deal::where('sub_id','<',$request->subcategory_id)->where('status','active')->orderBy('id', 'desc')->count('id');
            // return $pervios_Deals ;
            $Dealss = [] ;

            if(sizeof($Deals) > 0 ){
                $i = 0;
                foreach($Deals as $Deal){
                    // return asset('img/').'/'. $image->image;
                    $Dealss[$i]['Deal_id'] = $Deal->id ;    
                    if($lang == 'ar'){
                        $Dealss[$i]['title'] = $Deal->title_ar ; 
                        $Dealss[$i]['disc'] = $Deal->disc_ar ; 
                        $Dealss[$i]['info'] = $Deal->info_ar ; 
                    }else{
                        $Dealss[$i]['title'] = $Deal->title_en ; 
                        $Dealss[$i]['disc'] = $Deal->disc_en ; 
                        $Dealss[$i]['info'] = $Deal->info_en ; 
                    }
                    if($Deal->image){
                        $Dealss[$i]['image'] = asset('img/').'/'. $Deal->image;
                    }else{
                        $Dealss[$i]['image'] = null ;
                    }
                    
                    $Dealss[$i]['original_price'] = $Deal->original_price ; 
                    $Dealss[$i]['initial_price'] = $Deal->initial_price ; 
                    $Dealss[$i]['points'] = $Deal->points ; 
                    $Dealss[$i]['tickets'] = $Deal->tickets ; 
                    $Dealss[$i]['tender_cost'] = $Deal->tender_cost ; 
                    $Dealss[$i]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                    $Dealss[$i]['tender_coupon'] = $Deal->tender_coupon ; 
                    $Dealss[$i]['expiry_date'] = $Deal->expiry_date .' '.$Deal->expiry_time;   
                    $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                    if($favorite){
                        $Dealss[$i]['is_favorite'] = 'true' ;
                    }else{
                        $Dealss[$i]['is_favorite'] = 'false' ;
                    }
                    $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                    if($ticket){
                        $Dealss[$i]['my_ticket_points'] = $ticket->points ;
                    }else{
                        $Dealss[$i]['my_ticket_points'] = null ;
                    }
                    
                    $i ++ ; 
                }
            }
            
            return response()->json([
                'success' => 'success',
                'errors' => null ,
                'message' => trans('api.fetch'),
                'data' => [
                    'Dealss' => $Dealss ,
                    'count_Deals' => $count_pervios_Deals,
                    ],

            ]);
            
        }else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logout'),
                "message"=>trans('api.logout'),
                ]);
        }


    }
///////////////////////////////////////////////////
// DealDetails function by Antonious hosny
    public function DealDetails(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        $dt = Carbon::now();
        $time = $dt->format('H:i:s');
        // $date = $dt->toDateString();
        $date  = date('Y-m-d H:i:s', strtotime($dt));
        if($user){
            $lang = $request->header('lang');
            $rules=array(
                'Deal_id'      =>'required',
            );

            $validator  = Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                $messages = 'رقم الصفقة مطلوب';
                return response()->json([
                    'success' => 'failed',
                    'errors'=> $messages,
                    'message' => $messages,
                    'data' =>  null ,
                ]);
            }
            $Deal = Deal::where('id',$request->Deal_id)->where('status','active')->first();  
            // return $request->Deal_id ;
            $now_Dealss = null;
            if($Deal){

                $now_Dealss['Deal_id'] = $Deal->id ;    
                if($lang == 'ar'){
                    $now_Dealss['title'] = $Deal->title_ar ; 
                    $now_Dealss['disc'] = $Deal->disc_ar ; 
                    $now_Dealss['info'] = $Deal->info_ar ; 
                }else{
                    $now_Dealss['title'] = $Deal->title_en ; 
                    $now_Dealss['disc'] = $Deal->disc_en ; 
                    $now_Dealss['info'] = $Deal->info_en ; 
                }
                if($Deal->image){
                    $now_Dealss['image'] = asset('img/').'/'. $Deal->image;
                }else{
                    $now_Dealss['image'] = null ;
                }
                $imagess = []; 
                if( $Deal->images){
                    $images = json_decode($Deal->images);
                    if(gettype($images)== 'array' && sizeof($images) > 0){
                        $n = 0 ;
                        foreach($images as $img){
                            $imagess[$n] = asset('img/').'/'. $img;
                            $n++;
                        }
                    }
                }
                $now_Dealss['images'] = $imagess ;
                $now_Dealss['original_price'] = $Deal->original_price ; 
                $now_Dealss['initial_price'] = $Deal->initial_price ; 
                $now_Dealss['points'] = $Deal->points ; 
                $now_Dealss['participants_no'] = $Deal->participants_no ; 
                $now_Dealss['tickets'] = $Deal->tickets ; 
                $now_Dealss['tender_cost'] = $Deal->tender_cost ; 
                $now_Dealss['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                $now_Dealss['tender_coupon'] = $Deal->tender_coupon ; 
                $now_Dealss['expiry_date'] = $Deal->expiry_date.' '.$Deal->expiry_time  ; 
                // return $Deal->images ;
                $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                    if($favorite){
                        $now_Dealss['is_favorite'] = 'true' ;
                    }else{
                        $now_Dealss['is_favorite'] = 'false' ;
                    }
              
                $now_Dealss['my_ticket_points'] =  null;
                
                $dt = Carbon::now();

                $date  = date('Y-m-d', strtotime($dt));
                $time  = date('H:i:s', strtotime($dt));
                // $date = $dt->toDateString();
                
                // $date2 = date('Y-m-d H:i:s', strtotime($dt));
                $ticketss = Ticket::where('deal_id',$Deal->id)->get();
                if(sizeof($ticketss) > 0){

                    $expiry_date = date('Y-m-d H:i:s', strtotime($Deal->expiry_date) );
                    if($Deal->expiry_date < $date || $Deal->expiry_date == $date && $Deal->expiry_time <= $time || $Deal->is_open == '0'){
                        $Deal->is_open = '0' ;
                        $Deal->save();
                        foreach($ticketss as $ticket){
                            $ticket->status = '0';
                            $ticket->save();
                        }
                        $ticket = Ticket::where('deal_id',$Deal->id)->orderBy('points','desc')->first();
                        if($ticket){
                            
                            $ticket->status = '1';
                            $ticket->save();
                        }
                        $now_Dealss['winner_name'] = $ticket->name ;
                        $now_Dealss['winner_id'] = $ticket->user_id ;
                        $tickets = Ticket::where('deal_id',$Deal->id)->skip(1)->limit(5)->orderBy('points','desc')->get();
                        // return $tickets ;
                        $five_second_users  = [];
                        $n= 0;
                        if(sizeof($tickets) > 0){
                            
                            foreach( $tickets as $ticket){
                                $five_second_users[$n]['user_name'] = $ticket->name ;
                                $five_second_users[$n]['user_id'] = $ticket->user_id ;
                                $n++;
                            }
                        }
                        $now_Dealss['five_second_users'] = $five_second_users ;
                    }
                    else{
                        $ticket = Ticket::where('deal_id',$Deal->id)->where('user_id',$user->id)->first();
                        if($ticket){
                            $now_Dealss['my_ticket_points'] = $ticket->points ;
                        }
                        $now_Dealss['winner_name'] = null ;
                        $now_Dealss['winner_id'] = null ;
                        $now_Dealss['five_second_users'] = null ;
                    }
                }
            }
            return response()->json([
                'success' => 'success',
                'errors' => null ,
                'message' => trans('api.fetch'),
                'data' =>[
                    'DealDetails' => $now_Dealss ,
                ] 

            ]);
        }
        else{
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        } 
    }   
/////////////////////////////////////////////////////
// Packages function by Antonious hosny
    public function Packages(Request $request){
        $lang = $request->header('lang');
        $Packages = Package::where('status','active')->get();
        if(sizeof($Packages) > 0 ){
            $i = 0;
            foreach($Packages as $Package){
                $Packagess[$i]['id'] = $Package->id ; 
                if($lang == 'ar'){
                    $Packagess[$i]['title'] = $Package->title_ar ; 
                }else{
                    $Packagess[$i]['title'] = $Package->title_en ;      
                }
                $Packagess[$i]['cost'] = $Package->cost ;      
                $Packagess[$i]['points'] = $Package->points ;      
                $Packagess[$i]['coupons'] = $Package->coupons ;      
                
                $i ++ ; 
            }
        }
        else{
            $Packagess = [];
        }
        return response()->json([
            'success' => 'success',
            'errors' => null ,
            'message' => trans('api.fetch'),
            'data' => $Packagess,

        ]);
            
        

    }   
//////////////////////////////////////////////////////
// Charge function by Antonious hosny
    public function Charge(Request $request){
        $token = $request->token;
        if($token){
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $rules=array(
                    'package_id'      =>'required',
                );
                $validator  = Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    return response()->json([
                        'success' => 'failed',
                        'errors'=> 'رقم القسم مطلوب',
                        'message' =>'رقم القسم مطلوب',
                        'data' =>  null ,
                    ]);
                }

                $Package = Package::where('id',$request->package_id)->first();
                if($Package){
                   $charge = new Charge ; 
                   $charge->user_name = $user->name ;
                   $charge->package = $Package->title_ar ;
                   $charge->points = $Package->points ;
                   $charge->package_id = $Package->id ;
                   $charge->user_id = $user->id ;
                   $charge->save() ;
                   $user->points +=  $Package->points ;
                   $user->coupons +=  $Package->coupons ;
                   $user->save();
                    return response()->json([
                        'success' => 'success',
                        'errors' => null ,
                        'message' => trans('api.save'),
                        'data' => $charge ,
                    ]);
                }
                else{
                    return response()->json([
                        'success' => 'failed',
                        'errors' => 'لا توجد باقة',
                        'message' => 'لا توجد باقة',
                        'data' => null 
    
                    ]);
                }
            }
            else{
                $errors = trans('api.logged_out');
                return response()->json([
                    'success' => 'logged',
                    'errors' => $errors ,
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// AddTicket function by Antonious hosny
    public function AddTicket(Request $request){
        $token = $request->token;
        $dt = Carbon::now();
        $time = date('H:i:s', strtotime($dt));
        $date  = date('Y-m-d', strtotime($dt));
        // $date = $dt->toDateString();
        if($token){
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $rules=array(
                    'deal_id'      =>'required',
                    'points'      =>'required',
                );
                $validator  = \Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    $messages = $validator->messages();
                    $transformed = [];
        
                    foreach ($messages->all() as $field => $message) {
                        $transformed[] = [
                            'message' => $message
                        ];
                    }
                    return response()->json([
                        'success' => 'failed',
                        'errors'  => $transformed,
                        'message' => trans('api.validation_error'),
                        'data'    => null ,
                    ]);
                }

                $deal = Deal::where('id',$request->deal_id)->first();
                if($deal){
                    if($deal->is_open == 0){
                        return response()->json([
                            'success' => 'failed',
                            'errors'=> trans('api.deal_closed'),
                            'message' => trans('api.deal_closed'),
                            'data' =>  null ,
                        ]);
                    }
                    if($deal->expiry_date < $date){
                        return response()->json([
                            'success' => 'failed',
                            'errors'=> trans('api.date_not_valid'),
                            'message' => trans('api.date_not_valid'),
                            'data' =>  null ,
                        ]);
                    }
                    else{
                        if($deal->expiry_date == $date && $time > $deal->expiry_time){
                            return response()->json([
                                'success' => 'failed',
                                'errors'=> trans('api.time_not_valid'),
                                'message' => trans('api.time_not_valid'),
                                'data' =>  null ,
                            ]);
                        }
                        $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$deal->id)->first();
                        if($ticket){
                            if($user->points >= $deal->tender_edit_cost){
                                $user->points -=  $deal->tender_edit_cost ;
                                $user->save();
                                $ticket->points = $request->points ;
                                $ticket->save();
                                
                            }else{
                                return response()->json([
                                    'success' => 'failed',
                                    'errors'=> trans('api.you_dont_have_enouph_points'),
                                    'message' => trans('api.you_dont_have_enouph_points'),
                                    'data' =>  null ,
                                ]);
                            }
                        }else{
                            if($user->points >= $deal->tender_cost){
                                
                                if( $deal->tickets < $deal->participants_no){

                                    $user->points -=  $deal->tender_cost ;
                                    $user->coupons += $deal->tender_coupon ;
                                    $user->save();
                                    $ticket = new  Ticket ;
                                    $ticket->name = $user->name ;
                                    $ticket->user_id = $user->id ;
                                    $ticket->deal_id = $deal->id ;
                                    $ticket->points = $request->points ;
                                    $ticket->save();
                                    $deal->tickets += 1 ;
                                    $deal->save();
                                    if($deal->tickets == $deal->participants_no){
                                        $deal->participants_date = $date ;

                                        // $deal->is_open = '0' ;
                                        $deal->save();
                                        // return ($deal->participants_date - $date );
                                    }
                                }else{
                                    $later = new DateTime($deal->participants_date);
                                    $earlier = new DateTime($date);
                                    $diff = $later->diff($earlier)->format("%a");
                                    // return $deal->participants_date . ' '. $date.' '.$diff ;
                                    return response()->json([
                                        'success' => 'failed',
                                        'errors'=> trans('api.participants_number_comleted'),
                                        'message' => trans('api.participants_number_comleted'),
                                        'data' =>  null ,
                                    ]);
                                }

                            }else{
                                return response()->json([
                                    'success' => 'failed',
                                    'errors'=> trans('api.you_dont_have_enouph_points'),
                                    'message' => trans('api.you_dont_have_enouph_points'),
                                    'data' =>  null ,
                                ]);
                            }
                        }
                        return response()->json([
                            'success' => 'success',
                            'errors' => null ,
                            'message' => trans('api.save'),
                            'data' => $ticket ,
                        ]);
                       
                    }
                    
                }
                else{
                    return response()->json([
                        'success' => 'failed',
                        'errors' => 'لا توجد صفقة',
                        'message' => 'لا توجد صفقة',
                        'data' => null 

                    ]);
                }
            }
            else{
                $errors = trans('api.logged_out');
                return response()->json([
                    'success' => 'logged',
                    'errors' => $errors ,
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// Favorite function by Antonious hosny
    public function Favorite(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $dt = Carbon::now();
            $time = $dt->format('H:i:s');
            $date = $dt->toDateString();
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $rules=array(
                    'deal_id'      =>'required',
                );
                $validator  = \Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    $messages = $validator->messages();
                    $transformed = [];
        
                    foreach ($messages->all() as $field => $message) {
                        $transformed[] = [
                            'message' => $message
                        ];
                    }
                    return response()->json([
                        'success' => 'failed',
                        'errors'  => $transformed,
                        'message' => trans('api.validation_error'),
                        'data'    => null ,
                    ]);
                }

                $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$request->deal_id)->first();
                if($favorite){
                   $favorite->delete();
                   
                }
                else{
                    $favorite = new Favorite;
                    $favorite->user_id = $user->id ;
                    $favorite->deal_id = $request->deal_id ;
                    $favorite->save();
                   
                }
                $Deal = Deal::where('id',$request->deal_id)->where('status','active')->first();  
                $now_Dealss = null;
                if($Deal){

                    $now_Dealss['Deal_id'] = $Deal->id ;    
                    if($lang == 'ar'){
                        $now_Dealss['title'] = $Deal->title_ar ; 
                        $now_Dealss['disc'] = $Deal->disc_ar ; 
                        $now_Dealss['info'] = $Deal->info_ar ; 
                    }else{
                        $now_Dealss['title'] = $Deal->title_en ; 
                        $now_Dealss['disc'] = $Deal->disc_en ; 
                        $now_Dealss['info'] = $Deal->info_en ; 
                    }
                    if($Deal->image){
                        $now_Dealss['image'] = asset('img/').'/'. $Deal->image;
                    }else{
                        $now_Dealss['image'] = null ;
                    }
                    
                    $now_Dealss['original_price'] = $Deal->original_price ; 
                    $now_Dealss['initial_price'] = $Deal->initial_price ; 
                    $now_Dealss['points'] = $Deal->points ; 
                    $now_Dealss['tickets'] = $Deal->tickets ; 
                    $now_Dealss['tender_cost'] = $Deal->tender_cost ; 
                    $now_Dealss['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                    $now_Dealss['tender_coupon'] = $Deal->tender_coupon ; 
                    $now_Dealss['expiry_date'] = date('d-m-Y H:i:s', strtotime($Deal->expiry_date) );   
                    // return $Deal->images ;
                    $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($favorite){
                            $now_Dealss['is_favorite'] = 'true' ;
                        }else{
                            $now_Dealss['is_favorite'] = 'false' ;
                        }
                    $images = json_decode($Deal->images) ;
                    // return $images ;
                    $deal_images  = [] ;
                    $i =0 ;
                    if(sizeof($images) > 0){
                        foreach($images as $image){
                            if($image){
                                $deal_images[$i]['image'] = asset('img/').'/'. $image;
                            }else{
                                $deal_images[$i]['image'] = null ;
                            }
                            $i++ ;
                        }
                    }
                    $now_Dealss['deal_images'] = $deal_images ;
                    
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.save'),
                    'data' => $now_Dealss ,
                ]);
            }
            else{
                $errors = trans('api.logged_out');
                return response()->json([
                    'success' => 'logged',
                    'errors' => $errors ,
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// AddAddress function by Antonious hosny
    public function AddAddress(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $rules=array(
                    'title'      =>'required',
                    'disc'      =>'required',
                    'city_id'      =>'required',
                    'country_id'      =>'required',
                    'zip_code'      =>'required',
                    'mobile'      =>'required',
                );
                $validator  = \Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    $messages = $validator->messages();
                    $transformed = [];
        
                    foreach ($messages->all() as $field => $message) {
                        $transformed[] = [
                            'message' => $message
                        ];
                    }
                    return response()->json([
                        'success' => 'failed',
                        'errors'  => $transformed,
                        'message' => trans('api.validation_error'),
                        'data'    => null ,
                    ]);
                }
                if($request->address_id){
                    $address = Address::find($request->address_id);
                }
                else{
                    $address = new Address;
                }
                $address->user_id = $user->id ;
                $address->city_id = $request->city_id ;
                $address->country_id = $request->country_id ;
                $address->mobile = $request->mobile ;
                $address->zip_code = $request->zip_code ;
                $address->title = $request->title ;
                $address->disc = $request->disc ;
                $address->save();
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.save'),
                    'data' => $address ,
                ]);
            }
            else{
                $errors = trans('api.logged_out');
                return response()->json([
                    'success' => 'logged',
                    'errors' => $errors ,
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// MyAddress function by Antonious hosny
    public function MyAddress(Request $request){
        $token = $request->token;
        $lang = $request->header('lang');
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $user = User::where('remember_token',$token)->first();
            if($user){

                
                $addresses = Address::where('user_id',$user->id)->with('city')->with('country')->get();
                // return  $addresses ;
                $addresss = [];
                $i = 0;
                if(sizeof($addresses)> 0){

                    foreach($addresses as $address){
                        $addresss[$i]['title'] = $address->title ;
                        $addresss[$i]['disc'] = $address->disc ;
                        $addresss[$i]['zip_code'] = $address->zip_code ;
                        $addresss[$i]['city_id'] = $address->city_id ;
                        if($address->city){
                            if($lang == 'ar'){
                                $addresss[$i]['city'] = $address->city->name_ar ;
                            }else{
                                $addresss[$i]['city'] = $address->city->name_en ;
                            }
                        }else{
                            $addresss[$i]['city'] = '';
                        }
                        $addresss[$i]['country_id'] = $address->country_id ;
                        if($address->country){
                            if($lang == 'ar'){
                                $addresss[$i]['country'] = $address->country->name_ar ;
                            }else{
                                $addresss[$i]['country'] = $address->country->name_en ;
                            }
                        }
                        else{
                            $addresss[$i]['country'] = '';
                        }
                        $i ++ ;

                    }
                }
               
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.fetch'),
                    'data' => $addresss ,
                ]);
            }
            else{
                $errors = trans('api.logged_out');
                return response()->json([
                    'success' => 'logged',
                    'errors' => $errors ,
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// DeleteAddress function by Antonious hosny
    public function DeleteAddress(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $rules=array(
                    'address_id'      =>'required',
                );
                $validator  = \Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    $messages = $validator->messages();
                    $transformed = [];
        
                    foreach ($messages->all() as $field => $message) {
                        $transformed[] = [
                            'message' => $message
                        ];
                    }
                    return response()->json([
                        'success' => 'failed',
                        'errors'  => $transformed,
                        'message' => trans('api.validation_error'),
                        'data'    => null ,
                    ]);
                }
                if($request->address_id){
                    $address = Address::find($request->address_id);
                    $address->delete();
                   
                }
               
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.success'),
                    'data' => null ,
                ]);
            }
            else{
                $errors = trans('api.logged_out');
                return response()->json([
                    'success' => 'logged',
                    'errors' => $errors ,
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// MyFavorite function by Antonious hosny
    public function MyFavorite(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $favorites = Favorite::where('user_id',$user->id)->get();
                $now_Dealss = null;
                $i = 0 ;
                foreach($favorites as $favorite){

                    $Deal = Deal::where('id',$favorite->deal_id)->where('status','active')->first();  
                    // return $Deal ;
                    if($Deal){
    
                        $now_Dealss[$i]['Deal_id'] = $Deal->id ;    
                        if($lang == 'ar'){
                            $now_Dealss[$i]['title'] = $Deal->title_ar ; 
                            $now_Dealss[$i]['disc'] = $Deal->disc_ar ; 
                            $now_Dealss[$i]['info'] = $Deal->info_ar ; 
                        }else{
                            $now_Dealss[$i]['title'] = $Deal->title_en ; 
                            $now_Dealss[$i]['disc'] = $Deal->disc_en ; 
                            $now_Dealss[$i]['info'] = $Deal->info_en ; 
                        }
                        if($Deal->image){
                            $now_Dealss[$i]['image'] = asset('img/').'/'. $Deal->image;
                        }else{
                            $now_Dealss[$i]['image'] = null ;
                        }
                        
                        $now_Dealss[$i]['original_price'] = $Deal->original_price ; 
                        $now_Dealss[$i]['initial_price'] = $Deal->initial_price ; 
                        $now_Dealss[$i]['points'] = $Deal->points ; 
                        $now_Dealss[$i]['tickets'] = $Deal->tickets ; 
                        $now_Dealss[$i]['tender_cost'] = $Deal->tender_cost ; 
                        $now_Dealss[$i]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                        $now_Dealss[$i]['tender_coupon'] = $Deal->tender_coupon ; 
                        if($Deal->expiry_date){
                            $now_Dealss[$i]['expiry_date'] = $Deal->expiry_date .' '.$Deal->expiry_time;   
                        }else{
                            $now_Dealss[$i]['expiry_date'] = null ;
                        }
                        // return $Deal->images ;
                        $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($favorite){
                            $now_Dealss[$i]['is_favorite'] = 'true' ;
                        }else{
                            $now_Dealss[$i]['is_favorite'] = 'false' ;
                        }
                       
                        $i++ ;
                    }
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.fetch'),
                    'data' => $now_Dealss ,
                ]);
            }
            else{
                $errors = trans('api.logged_out');
                return response()->json([
                    'success' => 'logged',
                    'errors' => $errors ,
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// MyDeals function by Antonious hosny
    public function MyDeals(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $tickets = Ticket::where('user_id',$user->id)->get();
                $now_Dealss = null;
                $i = 0 ;
                foreach($tickets as $ticket){

                    $Deal = Deal::where('id',$ticket->deal_id)->first();  
                    if($Deal){

                        $now_Dealss[$i]['Deal_id'] = $Deal->id ;    
                        if($lang == 'ar'){
                            $now_Dealss[$i]['title'] = $Deal->title_ar ; 
                            $now_Dealss[$i]['disc'] = $Deal->disc_ar ; 
                            $now_Dealss[$i]['info'] = $Deal->info_ar ; 
                        }else{
                            $now_Dealss[$i]['title'] = $Deal->title_en ; 
                            $now_Dealss[$i]['disc'] = $Deal->disc_en ; 
                            $now_Dealss[$i]['info'] = $Deal->info_en ; 
                        }
                        if($Deal->image){
                            $now_Dealss[$i]['image'] = asset('img/').'/'. $Deal->image;
                        }else{
                            $now_Dealss[$i]['image'] = null ;
                        } 
                        if($Deal->status == '1'){
                            $now_Dealss[$i]['status'] = 'winner';
                        }else{
                            $now_Dealss[$i]['status'] = '0' ;
                        } 
                        $now_Dealss[$i]['original_price'] = $Deal->original_price ; 
                        $now_Dealss[$i]['initial_price'] = $Deal->initial_price ; 
                        $now_Dealss[$i]['points'] = $Deal->points ; 
                        $now_Dealss[$i]['tickets'] = $Deal->tickets ; 
                        $now_Dealss[$i]['tender_cost'] = $Deal->tender_cost ; 
                        $now_Dealss[$i]['tender_edit_cost'] = $Deal->tender_edit_cost ; 
                        $now_Dealss[$i]['tender_coupon'] = $Deal->tender_coupon ; 
                        $now_Dealss[$i]['expiry_date'] = date('d-m-Y H:i:s', strtotime($Deal->expiry_date) );   
                        // return $Deal->images ;
                        $favorite = Favorite::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($favorite){
                            $now_Dealss[$i]['is_favorite'] = 'true' ;
                        }else{
                            $now_Dealss[$i]['is_favorite'] = 'false' ;
                        }
                        $ticket = Ticket::where('user_id',$user->id)->where('deal_id',$Deal->id)->first();
                        if($ticket){
                            $now_Dealss[$i]['my_ticket_points'] = $ticket->points ;
                        }else{
                            $now_Dealss[$i]['my_ticket_points'] = null ;
                        }
                        $i++ ;
                    }
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.fetch'),
                    'data' => $now_Dealss ,
                ]);
            }
            else{
                $errors = trans('api.logged_out');
                return response()->json([
                    'success' => 'logged',
                    'errors' => $errors ,
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// ContactUs function by Antonious hosny
    public function ContactUs(Request $request){

        $rules=array(   
            "message"=>"required",
            "title"=>"required",
            "email"=>"required|email",
            "name"=>"required",
        );

        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];

            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            return response()->json([
                'success' => 'failed',
                'errors'  => $transformed,
                'message' => trans('api.failed'),
                'user'    => null ,
            ]);
        }
        else{
            $contact = new ContactUs ;

            $contact->name = $request->name ;
            $contact->email = $request->email ;
            $contact->title = $request->title ;
            $contact->message = $request->message ;
            $contact->status = 'new' ;
            $contact->save();

            return response()->json([
                'success' => 'success',
                'errors' => null ,
                'message' => trans('api.save'),
                'data' => [
                    "contact" => $contact,
                    ],
            ]);
        }
        

    }
/////////////////////////////////////////////////////
// Terms and Conditions function by Antonious hosny
    public function TermsConditions(Request $request){
        $lang = $request->header('lang');
        $docs = Doc::where('type','terms')->where('status','active')->get();
        $docss =[] ;
        $i = 0 ;
        if(sizeof($docs)> 0){
            foreach($docs as $doc){
                $docss[$i]['id'] = $doc->id ; 
                if($lang == 'ar'){
                    $docss[$i]['title'] = $doc->title_ar ; 
                    $docss[$i]['disc'] = $doc->disc_ar ; 
                }else{
                    $docss[$i]['title'] = $doc->title_en ;      
                    $docss[$i]['disc'] = $doc->disc_en ;      
                }    
                
                $i ++ ; 
            }
        }
        return response()->json([
            'success' => 'success',
            'errors' => null ,
            'message' => trans('api.fetch'),
            'data' =>  $docss,
                
        ]);
    

    }
///////////////////////////////////////////////////
// Policy function by Antonious hosny
    public function Policy(Request $request){
        $lang = $request->header('lang');
        $docs = Doc::where('type','policy')->where('status','active')->get();
        $docss =[] ;
        $i = 0 ;
        if(sizeof($docs)> 0){
            foreach($docs as $doc){
                $docss[$i]['id'] = $doc->id ; 
                if($lang == 'ar'){
                    $docss[$i]['title'] = $doc->title_ar ; 
                    $docss[$i]['disc'] = $doc->disc_ar ; 
                }else{
                    $docss[$i]['title'] = $doc->title_en ;      
                    $docss[$i]['disc'] = $doc->disc_en ;      
                }    
                
                $i ++ ; 
            }
        }
        return response()->json([
            'success' => 'success',
            'errors' => null ,
            'message' => trans('api.fetch'),
            'data' =>  $docss,
                
        ]);


    }
    ///////////////////////////////////////////////////
// AboutUs function by Antonious hosny
    public function AboutUs(Request $request){
        $lang = $request->header('lang');
        $docs = Doc::where('type','about')->where('status','active')->get();
        $docss =[] ;
        $i = 0 ;
        $contacts= Contact::first();
        if(sizeof($docs)> 0){
            foreach($docs as $doc){
                $docss[$i]['id'] = $doc->id ; 
                if($lang == 'ar'){
                    $docss[$i]['title'] = $doc->title_ar ; 
                    $docss[$i]['disc'] = $doc->disc_ar ; 
                }else{
                    $docss[$i]['title'] = $doc->title_en ;      
                    $docss[$i]['disc'] = $doc->disc_en ;      
                }    
                
                $i ++ ; 
            }
        }
        return response()->json([
            'success' => 'success',
            'errors' => null ,
            'message' => trans('api.fetch'),
            'data' =>  $docss,
            'contacts'=> $contacts
                
        ]);


    }
///////////////////////////////////////////////////
// ChargesHistory function by Antonious hosny
    public function ChargesHistory(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $charges = Charge::where('user_id',$user->id)->get();
                $chargess = [];
                $i = 0 ;
                foreach($charges as $charge){

                    $package = Package::where('id',$charge->package_id)->first();  
                    if($package){

                        if($lang == 'ar'){
                            $chargess[$i]['title'] = $package->title_ar ; 
                        }else{
                            $chargess[$i]['title'] = $package->title_en ;  
                        }
                        
                    }else{
                        $chargess[$i]['title'] = $charge->package ; 
                    }
                    $chargess[$i]['points'] = $charge->points ; 
                    $chargess[$i]['created_at'] = $charge->created_at->format('Y-m-d') ; 
                    $i++ ;
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.fetch'),
                    'data' => $chargess ,
                ]);
            }
            else{
                return response()->json([
                    'success' => 'logged',
                    'errors' =>trans('api.logged_out'),
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logged_out'),
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// Awards function by Antonious hosny
    public function Awards(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $dt = Carbon::now();
                $date  = date('Y-m-d H:i:s', strtotime($dt));
                // $time  = date('H:i:s', strtotime($dt));
                $awards = Award::whereDate('expiry_date','>=',$date)->where('status','active')->get();
                $awardss = [];
                $i = 0 ;
                foreach($awards as $award){
                    if($lang == 'ar'){
                        $awardss[$i]['title'] = $award->title_ar ; 
                    }else{
                        $awardss[$i]['title'] = $award->title_en ;  
                    }
                    $awardss[$i]['coupons'] = $award->coupons ; 
                    $awardss[$i]['images'] = asset('img/').'/'.$award->image ; 
                    $awardss[$i]['expiry_date'] = date('Y-m-d H:i:s', strtotime($award->expiry_date) )  ; 
                    $i++ ;
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.fetch'),
                    'data' => $awardss ,
                ]);
            }
            else{
                return response()->json([
                    'success' => 'logged',
                    'errors' =>trans('api.logged_out'),
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logged_out'),
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
//////////////////////////////////////////////////////
// Interests function by Antonious hosny
    public function Interests(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $user = User::where('remember_token',$token)->first();
            if($user){

                $lang = $request->header('lang');
                $interests = Interest::where('status','active')->get();
                $interestss = [];
                $i = 0 ;
                foreach($interests as $interest){

                    $interestss[$i]['id'] = $interest->id ; 
                    if($lang == 'ar'){
                        $interestss[$i]['title'] = $interest->title_ar ; 
                    }else{
                        $interestss[$i]['title'] = $interest->title_en ;  
                    }
                    $interestss[$i]['images'] = asset('img/').'/'.$interest->image ; 
                    $user_interest = USerInterest::where('user_id',$user->id)->where('interest_id',$interest->id)->first();
                    if($user_interest){
                        $interestss[$i]['is_interest'] = 'yes'; 
                    }else{
                        $interestss[$i]['is_interest'] = 'no' ;  
                    }
                    $i++ ;
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.fetch'),
                    'data' => $interestss ,
                ]);
            }
            else{
                return response()->json([
                    'success' => 'logged',
                    'errors' =>trans('api.logged_out'),
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logged_out'),
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
///////////////////////////////////////////////////////
// SaveInterests function by Antonious hosny
    public function SaveInterests(Request $request){
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // return $user ;
        if($user){
            $user = User::where('remember_token',$token)->first();
            if($user){
                $rules=array(
                    'interests'      =>'required',
                );
                $validator  = \Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    $messages = $validator->messages();
                    $transformed = [];
        
                    foreach ($messages->all() as $field => $message) {
                        $transformed[] = [
                            'message' => $message
                        ];
                    }
                    return response()->json([
                        'success' => 'failed',
                        'errors'  => $transformed,
                        'message' => trans('api.validation_error'),
                        'data'    => null ,
                    ]);
                }
                $lang = $request->header('lang');

                if($request->interests){
                    if(gettype($request->interests) == 'array'){
                        $interests = $request->interests ;
                        // return $interests ;
                    }else{
                        $interests = json_decode($request->interests) ;
                        // return $interests ;
                    }
                    $ids = UserInterest::where('user_id',$user->id)->delete();

                    foreach($interests as $interest){
                        $interest = Interest::find($interest) ;
                        if($interest){
                            $interestt = new UserInterest ;
                            $interestt->user_id = $user->id ;
                            $interestt->interest_id = $interest->id ;
                            $interestt->save();
                        }
                    }
                }
                $interests = Interest::where('status','active')->get();
                $interestss = [];
                $i = 0 ;
                foreach($interests as $interest){

                    $interestss[$i]['id'] = $interest->id ; 
                    if($lang == 'ar'){
                        $interestss[$i]['title'] = $interest->title_ar ; 
                    }else{
                        $interestss[$i]['title'] = $interest->title_en ;  
                    }
                    $interestss[$i]['images'] = asset('img/').'/'.$interest->image ; 
                    $user_interest = USerInterest::where('user_id',$user->id)->where('interest_id',$interest->id)->first();
                    if($user_interest){
                        $interestss[$i]['is_interest'] = 'yes'; 
                    }else{
                        $interestss[$i]['is_interest'] = 'no' ;  
                    }
                    $i++ ;
                }
                return response()->json([
                    'success' => 'success',
                    'errors' => null ,
                    'message' => trans('api.save'),
                    'data' => $interestss ,
                ]);
            }
            else{
                return response()->json([
                    'success' => 'logged',
                    'errors' =>trans('api.logged_out'),
                    'message' => trans('api.logged_out'),
                    'data' => null,
                ]);
            }
        }
        else{
            return response()->json([
                'success' => 'logged',
                'errors' => trans('api.logged_out'),
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        
    } 
////////////////////////////////////////////////////////
// send_notification function by Antonious hosny
    public function send_notification(Request $request){

        $token = $request->token;
        if($token == ''){
            $errors[] = [
                'message' => trans('api.logged_out')
            ]; 
            return response()->json([
                'success' => 'failed',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();

        if($user){
            $user_id    = $request->user_id;
            $msg        = $request->message;

            if($user_id){
                // return $child_id;

                $User2 = User::find($user_id);
                
                if($User2){
                        if($msg){
                            $type = "message";
                            $User2->notify(new Notifications($msg,$user,$type ));
                        }
                        return response()->json([
                            'success' => 'success',
                            'errors' => null ,
                            'message' => trans('api.save'),
                            'data' => $msg
                        ]);
                }else{
                    $error = trans('api.user_notfound');
                    return response()->json([
                        'success' => 'failed',
                        'errors' =>$error ,
                        'message' => trans('api.user_notfound'),
                        'data' =>null,
                    ]);
                }
                

            }  
            else{
                $error = trans('api.user_id_notfound');
                return response()->json([
                    'success' => 'failed',
                    'errors' =>$error ,
                    'message' => trans('api.user_id_notfound'),
                    'data' =>null,
                ]);
            }  

        }
        else{
            $errors[] = [
                'message' => trans('api.logged_out')
            ]; 
            return response()->json([
                'success' => 'failed',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'data' => null,
            ]);
        }

    }
////////////////////////////////////////////////////////
// count_notification function by Antonious hosny
    public function count_notification(Request $request){
        
        date_default_timezone_set('Africa/Cairo');
        $token = $request->token;
        // return $token ;
        if($token == ''){
            $errors =  trans('api.logged_out');
            
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'count' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // $user->notify(new Notifications());
        // return $user ;
        if($user){
            $count = count($user->unreadnotifications) ;
            // return $count ;
            return response()->json([
                'success' => 'success',
                'errors' => null ,
                'message' => trans('api.fetch'),
                'count' => $count ,
            ]);
        }
        else{
            $errors[] = [
                'message' => trans('api.logged_out')
            ]; 
            return response()->json([
                'success' => 'logged',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'count' => null,
            ]);
        }

    }
/////////////////////////////////////////////////////////
// get_notification function by Antonious hosny
    public function get_notification(Request $request){
        date_default_timezone_set('Africa/Cairo');
        $token = $request->token;
        if($token == ''){
            $errors = trans('api.logged_out');
        
            return response()->json([
                'success' => 'failed',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'notifications' => null,
            ]);
        }
        $user = User::where('remember_token',$token)->first();
        // $user->notify(new Notifications());
        // return $user ;
        if($user){
            $notifications = $user->notifications->take(25)  ;
            foreach($user->unreadnotifications as $note){
                $note->markAsRead();
            }
            // return $count ;
    
            return response()->json([
                'success' => 'success',
                'errors' => null ,
                'message' => trans('api.fetch'),
                'notifications' => $notifications ,
            ]);
        }
        else{
            $errors = trans('api.logged_out');
        
            return response()->json([
                'success' => 'failed',
                'errors' => $errors ,
                'message' => trans('api.logged_out'),
                'notifications' => null,
            ]);
        }

    }
/////////////////////////////////////////////////////////

// for test send_notifications
    public function send_notifications(Request $request){
        // $request->device_id;
            $rules=array(
                        'device_id'          => 'required',
                    );
                        $Messages = [
                    ];
                    //check the validator true or not
                    $validator  = Validator::make($request->all(),$rules,$Messages);
        $device_id = $request->device_id;
        // $msg = "you have message from backend";
        // $title = "test";
         
            $msg_ar = 'تم تاكيد استلام الطلب ' ;
            $msg_en = 'Your order has been Receipt confirmed';
        
        $msg =  [
            'msg_ar' => $msg_ar ,
            'msg_en' => $msg_en ,
        ];
        $title = [
            'title_ar' => 'تم تحديث حالة طلبك' ,  
            'title_en' => 'Your order status has been updated' ,   
        ];
        $this->notification($device_id,$title,$msg);
        
        return response()->json([
            'message' => 'done'
        ]);

    }
////////////////////////////////////////////////////////
// for test send_notifications
    public function webnotifications(Request $request){
        // $request->device_id;
            $rules=array(
                        'device_id'          => 'required',
                    );
            $Messages = [
                    ];
                    //check the validator true or not
        $validator  = Validator::make($request->all(),$rules,$Messages);
        $device_id = $request->device_id;
        // $msg = "you have message from backend";
        // $title = "test";
        
        $msg =  [
            'msg_ar' => 'لديك طلب جديد من '   ,
            'msg_en' => 'you have new order from '  ,
        ] ;

        $title = [
        'title_ar' => 'طلب جديد' ,  
        'title_en' => 'New Order' ,   
        ];
        $type = "order" ;
        $this->webnotification($device_id,$title,$msg, $type);
        
        return response()->json([
            'message' => 'done'
        ]);

    }

////////////////////////////////////////////////////////
   
}
