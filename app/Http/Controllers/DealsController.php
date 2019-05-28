<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\emailnotify;
use App\SubCategory;
use App\Category;
use App\Country;
use App\City;
use App\Deal;
use App\Ticket;
use Auth;
use Carbon\Carbon;

use App;
class DealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        date_default_timezone_set('Africa/Cairo');
    }
    public function index()
    {
        $lang = App::getlocale();
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $dt = Carbon::now();
        // $date = $dt->toDateString();
         $date  = date('Y-m-d', strtotime($dt));
        $title = 'deals';
        $allcategories = Category::all();
        $categories = array_pluck($allcategories,'name_ar', 'id');
        $allsubcategories = SubCategory::all();
        $subcategories = array_pluck($allsubcategories,'name_ar', 'id');
        $allcountries = Country::all();
        $countries = array_pluck($allcountries,'name_ar', 'id');
        $allcities = City::all();
        $cities = array_pluck($allcities,'name_ar', 'id');
        $deals = Deal::whereDate('expiry_date','>',$date)->orWhere('expiry_date','')->orWhere('expiry_date',null)->orderBy('id', 'DESC')->get();
        // return $deals ; 
        return view('deals.index',compact('deals','categories','cities','subcategories','countries','title','lang'));
        
    }
    public function nowdeals()
    {
        $lang = App::getlocale();
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        $time  = date('H:i:s', strtotime($dt));
        //  return $date ;
        $title = 'nowdeals';
        $allcategories = Category::all();
        $categories = array_pluck($allcategories,'name_ar', 'id');
        $allsubcategories = SubCategory::all();
        $subcategories = array_pluck($allsubcategories,'name_ar', 'id');
        $allcountries = Country::all();
        $countries = array_pluck($allcountries,'name_ar', 'id');
        $allcities = City::all();
        $cities = array_pluck($allcities,'name_ar', 'id');
        $deals = Deal::whereDate('expiry_date','=',$date)->whereTime('expiry_time','>=',$time)->orderBy('id', 'DESC')->get();
        // return $deals ; 
        return view('deals.now',compact('deals','categories','cities','subcategories','countries','title','lang'));
        
    }
    
    public function last()
    {
        $lang = App::getlocale();
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $dt = Carbon::now();
        // $date = $dt->toDateString();
        $date  = date('Y-m-d', strtotime($dt));
        $time  = date('H:i:s', strtotime($dt));
        $title = 'last_deals';
        $allcategories = Category::all();
        $categories = array_pluck($allcategories,'name_ar', 'id');
        $allsubcategories = SubCategory::all();
        $subcategories = array_pluck($allsubcategories,'name_ar', 'id');
        $allcountries = Country::all();
        $countries = array_pluck($allcountries,'name_ar', 'id');
        $deals = Deal::whereDate('expiry_date','<',$date)->orwhereDate('expiry_date','=',$date)->whereTime('expiry_time','<',$time)->orderBy('id', 'DESC')->get();
        // return $deals ; 
        return view('deals.last',compact('deals','categories','subcategories','countries','title','lang'));
        
    }

    public function tickets($id)
    {
        $lang = App::getlocale();
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $dt = Carbon::now();
        $date = $dt->toDateString();
        
        $tickets = Ticket::where('deal_id',$id)->orderBy('id', 'DESC')->get();

        $deal = Deal::where('id',$id)->first();
        $expiry_date = date('Y-m-d H:i:s', strtotime($deal->expiry_date) );
        $dt = Carbon::now();
        $time = $dt->format('H:i:s');
        $date = $dt->toDateString();
        $date2 = date('Y-m-d H:i:s', strtotime($dt));
        if($date2 > $expiry_date){
            $title = 'last_deals';
        }
        else{
            $title = 'deals';
        }
        if($date2 >= $expiry_date){
            foreach($tickets as $ticket){
                $ticket->status = '0';
                $ticket->save();
            }
            
            $ticket = Ticket::where('deal_id',$id)->orderBy('points','desc')->first();
            if($ticket){
                
                $ticket->status = '1';
                $ticket->save();
            }
            
        }
        $tickets = Ticket::where('deal_id',$id)->orderBy('id', 'DESC')->get();
        return view('deals.tickets',compact('tickets','title','lang'));
        
    }


    public function store(Request $request)
    {
        // return $request ;
        if($request->id ){
            $rules =
            [
                'title_ar'  =>'required|max:190',           
                'title_en'  =>'required|max:190',              
                'original_price'  =>'required',           
                'initial_price'  =>'required',           
                'points'  =>'required',           
                'tender_cost'  =>'required',           
                'tender_edit_cost'  =>'required',           
                'tender_coupon'  =>'required',           
                'disc_ar'  =>'required',           
                'disc_en'  =>'required',           
                'info_ar'  =>'required',           
                'info_en'  =>'required',           
                'category_id'  =>'required',           
                'subcategory_id'  =>'required',           
                'country_id'  =>'required',   
                'city_id'  =>'required',                   
                'participants_no'  =>'required',     
                // 'expiry_time'  =>'required',     
                'status'  =>'required'   ,   
                // 'image'  =>'required'   , 
            ];
            
        }     
    
        else{
            $rules =
            [
                'title_ar'  =>'required|max:190',           
                'title_en'  =>'required|max:190',              
                'original_price'  =>'required',           
                'initial_price'  =>'required',           
                'points'  =>'required',           
                'tender_cost'  =>'required',           
                'tender_edit_cost'  =>'required',           
                'tender_coupon'  =>'required',           
                'disc_ar'  =>'required',           
                'disc_en'  =>'required',           
                'info_ar'  =>'required',           
                'info_en'  =>'required',           
                'category_id'  =>'required',           
                'subcategory_id'  =>'required',           
                'country_id'  =>'required',           
                'city_id'  =>'required',           
                'participants_no'  =>'required',      
                // 'expiry_time'  =>'required',     
                'status'  =>'required'   ,   
                'image'  =>'required'   ,   
            ];
        }
        
        
         $validator = \Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             return \Response::json(array('errors' => $validator->getMessageBag()->toArray()));
         }
      
        // return $request ;
         if($request->id ){
            $deal = Deal::find( $request->id );
            
            if ($request->hasFile('image')) {

                $imageName =  $deal->image; 
                \File::delete(public_path(). '/img/' . $imageName);
            }
            
         }
         else{
            $deal = new Deal ;

         }

         $deal->title_ar            = $request->title_ar ;
         $deal->title_en            = $request->title_en ;
         $deal->original_price      = $request->original_price ;
         $deal->initial_price       = $request->initial_price ;
         $deal->points              = $request->points ;
         $deal->participants_no     = $request->participants_no ;
         $deal->tender_cost         = $request->tender_cost ;
         $deal->tender_edit_cost    = $request->tender_edit_cost ;
         $deal->tender_coupon       = $request->tender_coupon ;
         $deal->disc_ar             = $request->disc_ar ;
         $deal->disc_en             = $request->disc_en ;
         $deal->info_ar             = $request->info_ar ;
         $deal->info_en             = $request->info_en ;
         $deal->category_id         = $request->category_id ;
         $deal->sub_id              = $request->subcategory_id ;
         $deal->expiry_date         = $request->expiry_date ;
         $deal->expiry_time         = $request->expiry_time ;
         $deal->country_id          = $request->country_id ;
         $deal->city_id             = $request->city_id ;
         $deal->status              = $request->status ;
         $deal->save();

       if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/img');
            $image->move($destinationPath, $name);
            $deal->image   = $name;  
        }
        $imagess = [] ;
        $i = 0; 
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach($images as $image){
                // return $image ;
                $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
                $destinationPath = public_path('/img');
                $image->move($destinationPath, $name);
                $imagess[$i] = $name;   
                $i++;
            }
            $deal->images   = json_encode($imagess);  
        }

        $deal->save();
        $deal = Deal::where('id',$deal->id)->first();
        $expiry_date = date('d-m-Y', strtotime($deal->expiry_date) );
        // return $deal ;
        return response()->json([
            'deal'=>$deal,
            'expiry_date'=>$expiry_date
        ]);

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

      
    }


    public function destroy($id)
    {
       
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $id = deal::find( $id );
        $imageName =  $id->image; 
        \File::delete(public_path(). '/img/' . $imageName);
        $id ->delete();

        session()->flash('alert-danger', trans('admin.record_deleted'));   
        return response()->json($id);
        // return view('admin.index',compact('admins','title'));
    }

    public function deleteall(Request $request)
    {
        
        
        if($request->ids){
            foreach($request->ids as $id){
                $id = deal::find($id);
                $imageName =  $id->image; 
                \File::delete(public_path(). '/img/' . $imageName);
            }
            $ids = deal::whereIn('id',$request->ids)->delete();
        }
        return response()->json($request->ids);
        session()->flash('alert-danger', trans('admin.record_selected_deleted'));
        return redirect()->route('subcategories');
      
    }
}
