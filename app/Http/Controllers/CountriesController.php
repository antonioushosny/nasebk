<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\emailnotify;
use App\City;
use App\Country;
use Auth;
use App;
class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
     
    }
    public function index()
    {
        $lang = App::getlocale();
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $title = 'countries';
        $countries = Country::where('id','<>','1')->orderBy('id', 'DESC')->get();
        // return $admins ; 
        return view('countries.index',compact('countries','title','lang'));

    }

    public function store(Request $request)
    {
        
        if($request->id ){
            $rules =
            [
                'name_ar'  =>'required|max:190',           
                'name_en'  =>'required|max:190',           
                // 'image'  =>'required',            
                'status'  =>'required',   
            ];
            
        }     
    
        else{
            $rules =
            [
                'name_ar'  =>'required|max:190',           
                'name_en'  =>'required|max:190',              
                'image'  =>'required',            
                'status'  =>'required'      
            ];
        }
        
        
         $validator = \Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             return \Response::json(array('errors' => $validator->getMessageBag()->toArray()));
         }
      
        // return $request ;
         if($request->id ){
            $country = Country::find( $request->id );
            
            if ($request->hasFile('image')) {

                $imageName =  $country->image; 
                \File::delete(public_path(). '/img/' . $imageName);
            }
            
         }
         else{
            $country = new Country ;

         }

         $country->name_ar          = $request->name_ar ;
         $country->name_en         = $request->name_en ;
         $country->status        = $request->status ;
         $country->save();
       if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/img');
            $image->move($destinationPath, $name);
            $country->image   = $name;  
        }

        $country->save();

        return response()->json($country);

    }
    public function cities(Request $request, $id) {
        // return $id ;
        if ($request->ajax()) {
            return response()->json([
                'cities' => City::where('country_id', $id)->orWhere('country_id','1')->get()
            ]);
        }
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
        $id = Country::find( $id );
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
                $id = Country::find($id);
                $imageName =  $id->image; 
                \File::delete(public_path(). '/img/' . $imageName);
            }
            $ids = Country::whereIn('id',$request->ids)->delete();
        }
        return response()->json($request->ids);
        session()->flash('alert-danger', trans('admin.record_selected_deleted'));
        return redirect()->route('countries');
      
    }
}
