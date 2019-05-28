@extends('layouts.index')

 @section('content')
    <section class="content-header">
        <h1>
            {{trans('admin.nowdeals')}}
        <small>{{trans('admin.Control_panel')}}</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> {{trans('admin.home')}}</a></li>
          <li class="active"><a href="{{ route('nowdeals') }}">{{trans('admin.nowdeals')}}</a></li>
        </ol>
    </section>
  
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'success'] as $msg)
          @if(Session::has('alert-' . $msg))
          @section('script')
                <script>
                    toastr.success('{{ Session::get('alert-' . $msg) }}', '{{trans('admin.Success_Alert')}}', {timeOut: 5000});
                </script>
            @endsection
          <!--<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>-->
          @endif
        @endforeach
    </div>

    <!-- Main content -->
     <?php $msg = trans('admin.confirm_delete') ; ?> 
      {!! Form::open(['route'=>['dealsdeleteall'],'method'=>'post','autocomplete'=>'off', 'id'=>'dealss_form' ])!!}
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="panel panel-green">
                  <div class="panel-heading">
                    <section class="content-header" style=" !important;">
                        <div class="row" style="display:flex;">
                            <div class="col-md-8" >
                                <span style="font-size:2em ;"><i class="fa fa-cog"></i> {{trans('admin.nowdeals')}}</span>

                            </div>
                            <div class=" col-md-4">
                                <a href="#" class="add-modal btn btn-primary"><i class="fa fa-plus" ></i> {{trans('admin.add_deal')}}</a>  

                                <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-trash" ></i> {{trans('admin.deleteall')}} </button>

                            </div>
                        </div>
                    </section>
                  </div>
                  <div class="panel-body">
                    <div class="box-body table-responsive">
                      <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                          <tr>
                            
                            <th><input type="checkbox" class="checkbox icheck" id="check-all" /></th>
                            
                            <th>{{trans('admin.title_ar')}}</th>
                            <th>{{trans('admin.original_price')}}</th>
                            <th>{{trans('admin.initial_price')}}</th>
                            <th>{{trans('admin.points')}}</th>
                            <th>{{trans('admin.tickets')}}</th>
                            <th>{{trans('admin.expiry_date')}}</th>
                            <th>{{trans('admin.image')}}</th>
                            <th>{{trans('admin.status')}}</th>
                            <th>{{trans('admin.actions')}}</th>
                          </tr>
                        </thead>

                        <tbody id="adminstable">
                            @foreach ($deals as $data)
                              <tr class="item{{$data->id}}">
                               
                                <td><input type="checkbox" name="ids[]" value={{$data->id}} class="check icheck"></td>
                                <td>{{ $data->title_ar }}</td>
                                <td>{{ $data->original_price }}</td>
                                <td>{{ $data->initial_price }}</td>
                                <td>{{ $data->points }}</td>
                                <td>{{ $data->tickets }}</td>
                                @if($data->expiry_date)
                                <td>{{ date('d-m-Y', strtotime($data->expiry_date))}} </td>
                                @else 
                                <td> Soon </td>
                                @endif                                @if($data->image)
                                <td><img src="{{asset('img/').'/'.$data->image }}" width="50px" height="50px"></td>
                                @else 
                                <td><img src="{{asset('images/default.png') }}" width="50px" height="50px"></td>
                                @endif
                                @if($data->status == 'active')
                                  <td style="text-align:center"><span  class="badge">{{ trans('admin.active')}}</span></td> 
                                @elseif($data->status == 'not_active')
                                  <td style="text-align:center"><span  class="badge">{{ trans('admin.not_active')}}</span></td> 
                                @else 
                                    <td> </td>
                                @endif
                                
                                <td>

                                <a href="#" class="edit-modal btn btn-success btn-round " title="{{trans('admin.edit')}}" data-id="{{$data->id}}" data-data="{{$data}}">
                                    <span class="glyphicon glyphicon-edit"></span> 
                                </a> 

                                <a href="#" class=" delete-modal btn btn-danger btn-round" title="{{trans('admin.delete')}}" data-id="{{$data->id}}" >
                                   <span class="glyphicon glyphicon-trash"></span>
                                </a>  
                                
                                <a href="{{route('tickets',$data->id)}}" class=" profile-modal btn btn-warning btn-round" title="{{trans('admin.tickets')}}" data-data="{{$data}}" >
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                 </a>

                            </td>
              
                              </tr>
                           
                              @endforeach
                        </tbody>
                      </table>
                    
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
        <!-- /.row -->
    </section>

    {{-- <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="panel panel-green">
                  <div class="panel-heading">
                    <section class="content-header" style=" !important;">
                        <div class="row" style="display:flex;">
                            <div class="col-md-8" >
                                <span style="font-size:2em ;"><i class="fa fa-cog"></i> {{trans('admin.deals')}}</span>

                            </div>
                            <div class=" col-md-4">
                                <a href="#" class="add-modal btn btn-primary"><i class="fa fa-plus" ></i> {{trans('admin.add_deal')}}</a>  

                                <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-trash" ></i> {{trans('admin.deleteall')}} </button>

                            </div>
                        </div>
                    </section>
                  </div>
                  <div class="panel-body">
                    <div class="box-body table-responsive">
                      <table id="example" class="table table-bordered table-striped table-hover">
                        <thead>
                          <tr>
                            
                            <th><input type="checkbox" class="checkbox icheck" id="check-all2" /></th>
                            
                            <th>{{trans('admin.title_ar')}}</th>
                            <th>{{trans('admin.original_price')}}</th>
                            <th>{{trans('admin.initial_price')}}</th>
                            <th>{{trans('admin.points')}}</th>
                            <th>{{trans('admin.tickets')}}</th>
                            <th>{{trans('admin.expiry_date')}}</th>
                            <th>{{trans('admin.image')}}</th>
                            <th>{{trans('admin.status')}}</th>
                            <th>{{trans('admin.actions')}}</th>
                          </tr>
                        </thead>

                        <tbody id="adminstable">
                            @foreach ($deals as $data)
                              <tr class="item{{$data->id}}">
                               
                                <td><input type="checkbox" name="ids[]" value={{$data->id}} class="check2 icheck"></td>
                                <td>{{ $data->title_ar }}</td>
                                <td>{{ $data->original_price }}</td>
                                <td>{{ $data->initial_price }}</td>
                                <td>{{ $data->points }}</td>
                                <td>{{ $data->tickets }}</td>
                                <td>{{ date('d-m-Y H:i:s', strtotime($data->expiry_date))}} </td>
                                @if($data->image)
                                <td><img src="{{asset('img/').'/'.$data->image }}" width="50px" height="50px"></td>
                                @else 
                                <td><img src="{{asset('images/default.png') }}" width="50px" height="50px"></td>
                                @endif
                                @if($data->status == 'active')
                                  <td style="text-align:center"><span  class="badge">{{ trans('admin.active')}}</span></td> 
                                @elseif($data->status == 'not_active')
                                  <td style="text-align:center"><span  class="badge">{{ trans('admin.not_active')}}</span></td> 
                                @else 
                                    <td> </td>
                                @endif
                                
                                <td>

                                <a href="#" class="edit-modal btn btn-success btn-round " title="{{trans('admin.edit')}}" data-id="{{$data->id}}" data-data="{{$data}}">
                                    <span class="glyphicon glyphicon-edit"></span> 
                                </a> 

                                <a href="#" class=" delete-modal btn btn-danger btn-round" title="{{trans('admin.delete')}}" data-id="{{$data->id}}" >
                                   <span class="glyphicon glyphicon-trash"></span>
                                </a>                                

                            </td>
              
                              </tr>
                           
                              @endforeach
                        </tbody>
                      </table>
                    
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
        <!-- /.row -->
    </section> --}}
</form>
        <div id="fade"></div>
        <div id="modal" style="z-index:30000">
            <img id="loader" src="{{asset('images/loading.gif')}}" />
        </div>
        <!--modal for add -->
        <div id="addModal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="  width: 85%; ">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="panel-group">
                            
                         {!! Form::open(['route'=>['storedeal'],'method'=>'post','autocomplete'=>'off','role'=>'form','id'=>'formadddeals'])!!}
 
                            <div class="panel panel-green">
                                <div class="panel-heading " style="text-align: center"> 
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4>{{trans('admin.add_deal')}}</h4>
                                </div>
                                <div class="panel-body">

                                    <div class="row"  style="display:flex;">

                                        {{--  for  title_ar   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('title_ar',trans('admin.title_ar')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('title_ar','',['class'=>'form-control','id' => 'title_ar_field','placeholder' => trans('admin.placeholder_title_ar')]) !!}
                                                    </span>
                                                    <span style="color: red " class="title_ar text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  title_en   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('title_en',trans('admin.title_en')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('title_en','',['class'=>'form-control','id' => 'title_en_field','placeholder' => trans('admin.placeholder_title_en')]) !!}
                                                    </span>
                                                    <span style="color: red " class="title_en text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  	original_price   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('original_price',trans('admin.original_price')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('original_price','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'original_price_field','placeholder' => trans('admin.placeholder_original_price')]) !!}
                                                    </span>
                                                    <span style="color: red " class="original_price text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  initial_price   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('initial_price',trans('admin.initial_price')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('initial_price','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'initial_price_field','placeholder' => trans('admin.placeholder_initial_price')]) !!}
                                                    </span>
                                                    <span style="color: red " class="initial_price text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  points   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('points',trans('admin.points')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('points','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'points_field','placeholder' => trans('admin.placeholder_points')]) !!}
                                                    </span>
                                                    <span style="color: red " class="points text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  tender_cost   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('tender_cost',trans('admin.tender_cost')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('tender_cost','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'tender_cost_field','placeholder' => trans('admin.placeholder_tender_cost')]) !!}
                                                    </span>
                                                    <span style="color: red " class="tender_cost text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  tender_edit_cost   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('tender_edit_cost',trans('admin.tender_edit_cost')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('tender_edit_cost','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'tender_edit_cost_field','placeholder' => trans('admin.placeholder_tender_edit_cost')]) !!}
                                                    </span>
                                                    <span style="color: red " class="tender_edit_cost text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  	tender_coupon   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('tender_coupon',trans('admin.tender_coupon')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('tender_coupon','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'tender_coupon_field','placeholder' => trans('admin.placeholder_tender_coupon')]) !!}
                                                    </span>
                                                    <span style="color: red " class="tender_coupon text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  disc_ar   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('disc_ar',trans('admin.disc_ar')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::textarea('disc_ar','',['class'=>'form-control','id' => 'disc_ar_field','rows'=>'4','placeholder' => trans('admin.placeholder_disc_ar')]) !!}
                                                    </span>
                                                    <span style="color: red " class="disc_ar text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  disc_en   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('disc_en',trans('admin.disc_en')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::textarea('disc_en','',['class'=>'form-control','id' => 'disc_en_field','rows'=>'4','placeholder' => trans('admin.placeholder_disc_en')]) !!}
                                                    </span>
                                                    <span style="color: red " class="disc_en text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  info_ar   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('info_ar',trans('admin.info_ar')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::textarea('info_ar','',['class'=>'form-control','id' => 'info_ar_field','rows'=>'4','placeholder' => trans('admin.placeholder_info_ar')]) !!}
                                                    </span>
                                                    <span style="color: red " class="info_ar text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  info_en   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('info_en',trans('admin.info_en')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::textarea('info_en','',['class'=>'form-control','id' => 'info_en_field','rows'=>'4','placeholder' => trans('admin.placeholder_info_en')]) !!}
                                                    </span>
                                                    <span style="color: red " class="info_en text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">
                                        {{--  for category_id   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('category_id',trans('admin.category_id')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('category_id',$categories
                                                            ,'',['class'=>'form-control' ,'id' => 'category_id_field' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="category_id text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for subcategory_id   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('subcategory_id',trans('admin.subcategory_id')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('subcategory_id',[]
                                                            ,'',['class'=>'form-control' ,'id' => 'subcategory_id_field' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="subcategory_id text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for country_id   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('country_id',trans('admin.country_id')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('country_id',$countries
                                                            ,'',['class'=>'form-control' ,'id' => 'country_id_field' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="country_id text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                        {{--  for city_id   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('city_id',trans('admin.city_id')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('city_id',[]
                                                            ,'',['class'=>'form-control' ,'id' => 'city_id_field' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="city_id text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">
                                        {{--  for  	expiry_date   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> 
                                                        {!!Form::label('expiry_date',trans('admin.expiry_date')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {{--  <input type="datetime-local" name="expiry_date" class="form-control" id="expiry_date_field" placeholder="{{trans('admin.placeholder_expiry_date')}}">  --}}
                                                        {!! Form::date('expiry_date','',['class'=>'form-control','id' => 'expiry_date_field','placeholder' => trans('admin.placeholder_expiry_date')]) !!}
                                                    </span>
                                                    <span style="color: red " class="expiry_date text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  	expiry_time   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> 
                                                        {!!Form::label('expiry_time',trans('admin.expiry_time')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        
                                                        {!! Form::time('expiry_time','',['class'=>'form-control','id' => 'expiry_time_field','placeholder' => trans('admin.placeholder_expiry_time')]) !!}
                                                    </span>
                                                    <span style="color: red " class="expiry_time text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">   
                                        {{--  for status   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('status',trans('admin.status')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('status',['active'=>trans('admin.active'),'not_active'=>trans('admin.not_active')]
                                                            ,'',['class'=>'form-control' ,'id' => 'status_field' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="status text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        {{--  for  participants_no   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('participants_no',trans('admin.participants_no')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('participants_no','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'participants_no_field','placeholder' => trans('admin.placeholder_participants_no')]) !!}
                                                    </span>
                                                    <span style="color: red " class="participants_no text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">
                                        {{--  for image  --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                            <div class="col-xs-3">
                                                <span style="color: black "> 
                                                    {!! Form::label('image',trans('admin.image')) !!}
                                                </span>
                                            </div>
                                            <div class="col-xs-9">
                                                <div class="form-group  row" style="display:flex;">
                                                    <div style="position:relative; ">
                                                        <a class='btn btn-primary' href='javascript:;' >
                                                            {{trans('admin.Choose_File')}}
                    
                                                            {!! Form::file('image',['class'=>'form-control','id' => 'image_field', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimage");' ]) !!}
                                                        </a>
                                                        &nbsp;
                                                        <div class='label label-primary' id="upload-file-success" ></div>
                                                        <span style="color: red " class="image text-center hidden"></span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <img id="changeimage" src="#" width="100%" height="100%" alt=" {{trans('admin.image')}}" />
                                            </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row"  style="display:flex;">   
                                        <fieldset>
                                            <legend>{{ trans('admin.images') }}:</legend>
                                                <div class= "col-md-1 col-xs-6"> </div>
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_field', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimagess1");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimagess1" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_field', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimagess2");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimagess2" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" /   >
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_field', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimagess3");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimagess3" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_field', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimagess4");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimagess4" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_field', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimagess5");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimagess5" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-1 col-xs-6"> </div>
                                        </fieldset>
                                                                                
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-primary add" >
                                        <span class='glyphicon glyphicon-check'></span> {{trans('admin.add')}}
                                    </button>
                                        {!! Form::close()!!}
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                        <span class='glyphicon glyphicon-remove'></span> {{trans('admin.Close')}} 
                                    </button>
                                    
                                </div>
                            </div>
                        </div>           
                    </div>
                </div>
            </div>
        </div>
    
        <!--modal for delete -->
        <div id="deleteModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        {{--  <h4 class="modal-title"></h4>  --}}
                         <div class="panel-heading " style="text-align: center"> <h4>{{trans('admin.delete_deal')}}</h4>
                        </div>  
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">{{trans('admin.confirm_delete')}}</h3>
                        <br />
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="hidden" class="form-control" id="id_delete" disabled>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                                <span id="" class='glyphicon glyphicon-trash'></span> {{trans('admin.delete')}} 
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span>  {{trans('admin.Close')}} 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--modal for deleteall -->
        <div id="deleteallModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        {{--  <h4 class="modal-title"></h4>  --}}
                         <div class="panel-heading " style="text-align: center"> <h4>{{trans('admin.delete_deal')}}</h4>
                        </div>  
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">{{trans('admin.notselected_delete')}}</h3>
                        <br />
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span> {{trans('admin.Close')}} 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--modal for edit -->
        <div id="editModal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="  width: 85%; ">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="panel-group">
                            
                            {!! Form::open(['route'=>['editdeal'],'method'=>'post','autocomplete'=>'off','role'=>'form','id'=>'formeditdeals'])!!}
                            {!! Form::hidden('id','',['class'=>'form-control foridedit','id' => 'id_edit']) !!}
                            <div class="panel panel-green">
                                <div class="panel-heading " style="text-align: center"> 
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4>{{trans('admin.edit_deal')}}</h4>
                                </div>
                                <div class="panel-body">

                                    <div class="row"  style="display:flex;">

                                        {{--  for  title_ar   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('title_ar',trans('admin.title_ar')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('title_ar','',['class'=>'form-control','id' => 'title_ar_edit','placeholder' => trans('admin.placeholder_title_ar')]) !!}
                                                    </span>
                                                    <span style="color: red " class="title_ar1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  title_en   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('title_en',trans('admin.title_en')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('title_en','',['class'=>'form-control','id' => 'title_en_edit','placeholder' => trans('admin.placeholder_title_en')]) !!}
                                                    </span>
                                                    <span style="color: red " class="title_en1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  	original_price   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('original_price',trans('admin.original_price')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('original_price','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'original_price_edit','placeholder' => trans('admin.placeholder_original_price')]) !!}
                                                    </span>
                                                    <span style="color: red " class="original_price1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  initial_price   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('initial_price',trans('admin.initial_price')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('initial_price','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'initial_price_edit','placeholder' => trans('admin.placeholder_initial_price')]) !!}
                                                    </span>
                                                    <span style="color: red " class="initial_price1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  points   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('points',trans('admin.points')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('points','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'points_edit','placeholder' => trans('admin.placeholder_points')]) !!}
                                                    </span>
                                                    <span style="color: red " class="points1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  tender_cost   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('tender_cost',trans('admin.tender_cost')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('tender_cost','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'tender_cost_edit','placeholder' => trans('admin.placeholder_tender_cost')]) !!}
                                                    </span>
                                                    <span style="color: red " class="tender_cost1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  tender_edit_cost   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('tender_edit_cost',trans('admin.tender_edit_cost')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('tender_edit_cost','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'tender_edit_cost_edit','placeholder' => trans('admin.placeholder_tender_edit_cost')]) !!}
                                                    </span>
                                                    <span style="color: red " class="tender_edit_cost1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  	tender_coupon   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('tender_coupon',trans('admin.tender_coupon')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('tender_coupon','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'tender_coupon_edit','placeholder' => trans('admin.placeholder_tender_coupon')]) !!}
                                                    </span>
                                                    <span style="color: red " class="tender_coupon1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  disc_ar   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('disc_ar',trans('admin.disc_ar')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::textarea('disc_ar','',['class'=>'form-control','id' => 'disc_ar_edit','rows'=>'4','placeholder' => trans('admin.placeholder_disc_ar')]) !!}
                                                    </span>
                                                    <span style="color: red " class="disc_ar1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  disc_en   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('disc_en',trans('admin.disc_en')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::textarea('disc_en','',['class'=>'form-control','id' => 'disc_en_edit','rows'=>'4','placeholder' => trans('admin.placeholder_disc_en')]) !!}
                                                    </span>
                                                    <span style="color: red " class="disc_en1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for  info_ar   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('info_ar',trans('admin.info_ar')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::textarea('info_ar','',['class'=>'form-control','id' => 'info_ar_edit','rows'=>'4','placeholder' => trans('admin.placeholder_info_ar')]) !!}
                                                    </span>
                                                    <span style="color: red " class="info_ar1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  info_en   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('info_en',trans('admin.info_en')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::textarea('info_en','',['class'=>'form-control','id' => 'info_en_edit','rows'=>'4','placeholder' => trans('admin.placeholder_info_en')]) !!}
                                                    </span>
                                                    <span style="color: red " class="info_en1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">
                                        {{--  for category_id   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('category_id',trans('admin.category_id')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('category_id',$categories
                                                            ,'',['class'=>'form-control' ,'id' => 'category_id_edit' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="category_id1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for subcategory_id   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('subcategory_id',trans('admin.subcategory_id')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('subcategory_id',[]
                                                            ,'',['class'=>'form-control' ,'id' => 'subcategory_id_edit' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="subcategory_id1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="row"  style="display:flex;">

                                        {{--  for country_id   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('country_id',trans('admin.country_id')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('country_id',$countries
                                                            ,'',['class'=>'form-control' ,'id' => 'country_id_edit' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="country_id1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div> 
                                        {{--  for city_id   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('city_id',trans('admin.city_id')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('city_id',[]
                                                            ,'',['class'=>'form-control' ,'id' => 'city_id_edit' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="city_id1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;">
                                        {{--  for  	expiry_date   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> 
                                                        {!!Form::label('expiry_date',trans('admin.expiry_date')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        <input type="date" name="expiry_date" class="form-control" id="expiry_date_edit" placeholder="{{trans('admin.placeholder_expiry_date')}}">
                                                       
                                                    </span>
                                                    <span style="color: red " class="expiry_date1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        {{--  for  	expiry_time   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> 
                                                        {!!Form::label('expiry_time',trans('admin.expiry_time')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        
                                                        {!! Form::time('expiry_time','',['class'=>'form-control','id' => 'expiry_time_edit','placeholder' => trans('admin.placeholder_expiry_time')]) !!}
                                                    </span>
                                                    <span style="color: red " class="expiry_time1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row"  style="display:flex;">   
                                        {{--  for status   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!! Form::label('status',trans('admin.status')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::select('status',['active'=>trans('admin.active'),'not_active'=>trans('admin.not_active')]
                                                            ,'',['class'=>'form-control' ,'id' => 'status_edit' ,'placeholder' =>trans('admin.choose')]) !!}
                                                    </span>
                                                    <span style="color: red " class="status1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        {{--  for  participants_no   --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('participants_no',trans('admin.participants_no')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('participants_no','',['class'=>'form-control','onkeypress'=>'isNumber(event); ','id' => 'participants_no_edit','placeholder' => trans('admin.placeholder_participants_no')]) !!}
                                                    </span>
                                                    <span style="color: red " class="participants_no1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="display:flex;"> 
                                        {{--  for image  --}}
                                        <div class= "col-md-6 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                            <div class="col-xs-3">
                                                <span style="color: black "> 
                                                    {!! Form::label('image',trans('admin.image')) !!}
                                                </span>
                                            </div>
                                            <div class="col-xs-9">
                                                <div class="form-group  row" style="display:flex;">
                                                    <div style="position:relative; ">
                                                        <a class='btn btn-primary' href='javascript:;' >
                                                            {{trans('admin.Choose_File')}}
                    
                                                            {!! Form::file('image',['class'=>'form-control','id' => 'image_edit', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimage1");' ]) !!}
                                                        </a>
                                                        &nbsp;
                                                        <div class='label label-primary' id="upload-file-success" ></div>
                                                        <span style="color: red " class="image1 text-center hidden"></span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <img id="changeimage1" src="#" width="100%" height="100%" alt=" {{trans('admin.image')}}" />
                                            </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row"  style="display:flex;">   
                                        <fieldset>
                                            <legend>{{ trans('admin.images') }}:</legend>
                                                <div class= "col-md-1 col-xs-6"> </div>
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_edit', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimages1");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimages1" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_edit', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimages2");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimages2" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" /   >
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_edit', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimages3");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimages3" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_edit', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimages4");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimages4" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-2 col-xs-6">
                                                    <div class="form-group  row" style="display:flex;">
                                                        
                                                        <div class="col-xs-3">
                                                            <div class="form-group  row" style="display:flex;">
                                                                <div style="position:relative; ">
                                                                    <a class='btn btn-primary' href='javascript:;' >
                                                                        +
                                                                        {!! Form::file('images[]',['class'=>'form-control ','id' => 'images_edit', 'accept'=>'image/x-png,image/gif,image/jpeg' ,'style'=>'position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;','size'=> '40' ,'onchange' => 'readURL(this,"changeimages5");' ]) !!}
                                                                    </a>
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9" >
                                                            <img id="changeimages5" src="#" width="100%" height="100%" alt=" {{trans('admin.images')}}" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class= "col-md-1 col-xs-6"> </div>
                                        </fieldset>
                                                                                
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-primary edit " >
                                        <span class='glyphicon glyphicon-check'></span> {{trans('admin.edit')}}
                                    </button>

                                        {!! Form::close()!!}
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                        <span class='glyphicon glyphicon-remove'></span> {{trans('admin.Close')}} 
                                    </button>
                                    
                                </div>
                            </div>
                        </div>           
                    </div>
                </div>
            </div>
        </div>
   
@endsection 
@section('style')
    <style>
        fieldset { 
            display: block;
            margin-left: 2px;
            margin-right: 2px;
            padding-top: 0.35em;
            padding-bottom: 0.625em;
            padding-left: 0.75em;
            padding-right: 0.75em;
            width:100% ;
            border: 2px groove (internal value);
            }
    </style>  
  
@endsection

@section('script1')

  <script>
        function openModal() {
            document.getElementById('modal').style.display = 'block';
            document.getElementById('fade').style.display = 'block';
        }
    
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('fade').style.display = 'none';
        }
      jQuery(function($){
        $(document).on('click', '.delete-modal', function() {
 
          $('.modal-title').text('{{trans('admin.delete')}}');
          $('#id_delete').val($(this).data('id'));
          $('#deleteModal').modal('show');
          id = $('#id_delete').val();
        });

        $(document).on('click', '.edit-modal', function() {
            data = $(this).data('data');
            imag = "{{asset('images/addimage.png')}}" ;
            
            $('#changeimages1').attr('src', imag); 
            $('#changeimages2').attr('src', imag); 
            $('#changeimages3').attr('src', imag); 
            $('#changeimages4').attr('src', imag); 
            $('#changeimages5').attr('src', imag); 
            images = JSON.parse(data.images) ;
            console.log(images);
            n = 5 ;
            var i;
            for (i = 0; i < images.length; i++) {
                img = "{{asset('img/')}}" +'/'+ images[i] ;
                $('#changeimages'+n).attr('src', img); 
                  n--;
            } 
  
            console.log(images);
            if(data.image){
                image = "{{asset('img/')}}" +'/'+ data.image ;
            }
            else{
                image = "{{asset('images/addimage.png')}}" ;
            }
            
            $('.modal-title').text('{{trans('admin.edit')}}');
            $('#id_edit').val($(this).data('id'));
            $('#title_ar_edit').val(data.title_ar);
            $('#title_en_edit').val(data.title_en);
            $('#original_price_edit').val(data.original_price);
            $('#initial_price_edit').val(data.initial_price);
            $('#points_edit').val(data.points);
            $('#participants_no_edit').val(data.participants_no);
            $('#tender_cost_edit').val(data.tender_cost);
            $('#tender_edit_cost_edit').val(data.tender_edit_cost);
            $('#tender_coupon_edit').val(data.tender_coupon);
            $('#disc_ar_edit').val(data.disc_ar);
            $('#disc_en_edit').val(data.disc_en);
            $('#info_ar_edit').val(data.info_ar);
            $('#info_en_edit').val(data.info_en);
            $('#category_id_edit').val(data.category_id);
            $('#subcategory_id_edit').empty();
            category_id = $('#category_id_edit').val();
            
            $.ajax({
                type: 'GET',
                url: "<?php echo url('/')?>/categories/"+category_id+"/subcategories",
                success: data => {
                    if(data.subcategories.length <= 0){
                        alert('لا يوجد اقسام فرعيه لهذا القسم');
                    }
                    data.subcategories.forEach(subcategory =>
                        $('#subcategory_id_edit').append(`<option value="${subcategory.id}">${subcategory.name_ar}</option>`)
                    )
                }
            }) 
            {{--  console.log(data.expiry_date) ;  --}}
            $('#subcategory_id_edit').val(data.subcategory_id);
            $('#country_id_edit').val(data.country_id);
            $('#city_id_edit').empty();
            country_id = $('#country_id_edit').val();
            $.ajax({
                type: 'GET',
                url: "<?php echo url('/')?>/countries/"+country_id+"/cities",
                success: data => {
                    data.cities.forEach(city =>
                        $('#city_id_edit').append(`<option value="${city.id}">${city.name_ar}</option>`)
                    )
                }
            })
            $('#city_id_edit').val(data.city_id);
            $('#expiry_date_edit').val(data.expiry_date);
            $('#expiry_time_edit').val(data.expiry_time);
            $('#changeimage1').attr('src', image);
            $('#status_edit').val(data.status);
            id = $('#id_edit').val();
            {{-- console.log(data.expiry_date); --}}
            $('.title_ar1').addClass('hidden');
            $('.title_en1').addClass('hidden');
            $('.original_price1').addClass('hidden');
            $('.initial_price1').addClass('hidden');
            $('.points1').addClass('hidden');
            $('.tender_cost1').addClass('hidden');
            $('.tender_edit_cost1').addClass('hidden');
            $('.tender_coupon1').addClass('hidden');
            $('.disc_ar1').addClass('hidden');
            $('.disc_en1').addClass('hidden');
            $('.info_ar1').addClass('hidden');
            $('.info_en1').addClass('hidden');
            $('.category_id1').addClass('hidden');
            $('.subcategory_id1').addClass('hidden');
            $('.country_id1').addClass('hidden');
            $('.expiry_date1').addClass('hidden');
            $('.expiry_time1').addClass('hidden');
            $('.image1').addClass('hidden');
            $('.status1').addClass('hidden');
            $('.participants_no1').addClass('hidden');
            $('#editModal').modal('show');
        });
        
        $(document).on('click', '.add-modal', function() {
            $('.modal-title').text('{{trans('admin.add')}}');
            imag = "{{asset('images/addimage.png')}}" ;
            
            $('#changeimagess1').attr('src', imag); 
            $('#changeimagess2').attr('src', imag); 
            $('#changeimagess3').attr('src', imag); 
            $('#changeimagess4').attr('src', imag); 
            $('#changeimagess5').attr('src', imag); 
            image = "{{asset('images/addimage.png')}}"  ;
            $('#formadddeals')[0].reset();
            $('#changeimage').attr('src', image );
            $('.title_ar').addClass('hidden');
            $('.title_en').addClass('hidden');
            $('.original_price').addClass('hidden');
            $('.initial_price').addClass('hidden');
            $('.points').addClass('hidden');
            $('.tender_cost').addClass('hidden');
            $('.tender_edit_cost').addClass('hidden');
            $('.tender_coupon').addClass('hidden');
            $('.disc_ar').addClass('hidden');
            $('.disc_en').addClass('hidden');
            $('.info_ar').addClass('hidden');
            $('.info_en').addClass('hidden');
            $('.category_id').addClass('hidden');
            $('.subcategory_id').addClass('hidden');
            $('.country_id').addClass('hidden');
            $('.expiry_date').addClass('hidden');
            $('.expiry_time').addClass('hidden');
            $('.image').addClass('hidden');
            $('.status').addClass('hidden');
            $('.participants_no').addClass('hidden');
            $('#addModal').modal('show');

        });

        // this for delete record or delete mor than one
        $('.modal-footer').on('click', '.delete', function() {
            var choices = [];
            checkboxes = document.getElementsByName('ids[]');
            for (var i=0;i<checkboxes.length;i++){
                if ( checkboxes[i].checked ) {
                choices.push(checkboxes[i].value);
                }
            }
            if(choices.length >= 1){
                var form = $(this);
                openModal();
                $.ajax({
                    type: 'POST',
                    url: '{{ URL::route("dealsdeleteall") }}',
                    data:  new FormData($("#dealss_form")[0]),
                    processData: false,
                      contentType: false,
                    
                    success: function(data) {

                        if ((data.errors)) {
                            closeModal()
                           toastr.error('{{trans('admin.Validation_error')}}', '{{trans('admin.Error_Alert')}}', {timeOut: 5000});
                        } else {
                            closeModal()
                            toastr.success('{{trans('admin.successfully_deleted')}}', '{{trans('admin.Success_Alert')}}', {timeOut: 5000});
                            location.reload()
                            for (var i=0;i<data.length;i++){
                                $('.item' + data[i]).remove();
                                {{--  console.log(data[i]) ;   --}}
                            }
   
                        }
                    },
                });
            }
            else{
                 openModal();
                $.ajax({
                    type: 'GET',
                    url: "<?php echo url('/')?>/deals/delete/" + id,
                    data: {
                        '_token': $('input[name=_token]').val(),
                    },
                    success: function(data) {
                        closeModal()
                        toastr.success('{{trans('admin.successfully_deleted')}}', '{{trans('admin.Success_Alert')}}', {timeOut: 5000});
                        $('.item' + data['id']).remove();
                    }
                });
            }
          
          

        });

        //this for deleteall 
        $('#dealss_form').submit(function(e){
            e.preventDefault();
            var choices = [];
            checkboxes = document.getElementsByName('ids[]');
            for (var i=0;i<checkboxes.length;i++){
                if ( checkboxes[i].checked ) {
                    choices.push(checkboxes[i].value);
                }
            }
            if(choices.length >= 1){
                $('.modal-title').text('{{trans('admin.delete')}}');
                $('#id_delete').val($(this).data('id'));
                $('#deleteModal').modal('show');
            }
            else{
                $('#deleteallModal').modal('show');
                
            }
                
        });
        //this for add new record
        $("#formadddeals").submit(function(e){
           {{--  $('#addModal').modal('hide');  --}}
           $('.add').disabled =true;
          e.preventDefault();
          var form = $(this);
           openModal();
          $.ajax({
              type: 'POST',
              url: '{{ URL::route("storedeal") }}',
              data:  new FormData($("#formadddeals")[0]),
              processData: false,
                contentType: false,
              
              success: function(data) {
                    $('.title_ar').addClass('hidden');
                    $('.title_en').addClass('hidden');
                    $('.original_price').addClass('hidden');
                    $('.initial_price').addClass('hidden');
                    $('.points').addClass('hidden');
                    $('.tender_cost').addClass('hidden');
                    $('.tender_edit_cost').addClass('hidden');
                    $('.tender_coupon').addClass('hidden');
                    $('.disc_ar').addClass('hidden');
                    $('.disc_en').addClass('hidden');
                    $('.info_ar').addClass('hidden');
                    $('.info_en').addClass('hidden');
                    $('.category_id').addClass('hidden');
                    $('.subcategory_id').addClass('hidden');
                    $('.country_id').addClass('hidden');
                    $('.expiry_date').addClass('hidden');
                    $('.expiry_time').addClass('hidden');
                    $('.image').addClass('hidden');
                    $('.status').addClass('hidden');
                    $('.participants_no').addClass('hidden');
                  if ((data.errors)) {
                        {{--  $('#addModal').modal('show');  --}}
                        closeModal();
                        $('.add').disabled =false;
                        {{--  console.log(data.errors);                      --}}
                        toastr.error('{{trans('admin.Validation_error')}}', '{{trans('admin.Error_Alert')}}', {timeOut: 5000});
          
                        if (data.errors.title_ar) {
                            $('.title_ar').removeClass('hidden');
                            $('.title_ar').text(data.errors.title_ar);
                        }
                        if (data.errors.title_en) {
                            $('.title_en').removeClass('hidden');
                            $('.title_en').text(data.errors.title_en);
                        }
                        if (data.errors.original_price) {
                            $('.original_price').removeClass('hidden');
                            $('.original_price').text(data.errors.original_price);
                        }
                        if (data.errors.initial_price) {
                            $('.initial_price').removeClass('hidden');
                            $('.initial_price').text(data.errors.initial_price);
                        }
                        if (data.errors.points) {
                            $('.points').removeClass('hidden');
                            $('.points').text(data.errors.points);
                        }
                        if (data.errors.tender_cost) {
                            $('.tender_cost').removeClass('hidden');
                            $('.tender_cost').text(data.errors.tender_cost);
                        }
                        if (data.errors.tender_edit_cost) {
                            $('.tender_edit_cost').removeClass('hidden');
                            $('.tender_edit_cost').text(data.errors.tender_edit_cost);
                        }
                        if (data.errors.tender_coupon) {
                            $('.tender_coupon').removeClass('hidden');
                            $('.tender_coupon').text(data.errors.tender_coupon);
                        }
                        if (data.errors.disc_ar) {
                            $('.disc_ar').removeClass('hidden');
                            $('.disc_ar').text(data.errors.disc_ar);
                        }
                        if (data.errors.disc_en) {
                            $('.disc_en').removeClass('hidden');
                            $('.disc_en').text(data.errors.disc_en);
                        }
                        if (data.errors.info_ar) {
                            $('.info_ar').removeClass('hidden');
                            $('.info_ar').text(data.errors.info_ar);
                        }
                        if (data.errors.info_en) {
                            $('.info_en').removeClass('hidden');
                            $('.info_en').text(data.errors.info_en);
                        }
                        if (data.errors.category_id) {
                            $('.category_id').removeClass('hidden');
                            $('.category_id').text(data.errors.category_id);
                        }
                        if (data.errors.subcategory_id) {
                            $('.subcategory_id').removeClass('hidden');
                            $('.subcategory_id').text(data.errors.subcategory_id);
                        }
                        if (data.errors.image) {
                            $('.image').removeClass('hidden');
                            $('.image').text(data.errors.image);
                        }
                        if (data.errors.status) {
                            $('.status').removeClass('hidden');
                            $('.status').text(data.errors.status);
                        }         
                        if (data.errors.country_id) {
                            $('.country_id').removeClass('hidden');
                            $('.country_id').text(data.errors.country_id);
                        }       
                        if (data.errors.country_id) {
                            $('.country_id').removeClass('hidden');
                            $('.country_id').text(data.errors.country_id);
                        }         
                        if (data.errors.expiry_date) {
                            $('.expiry_date').removeClass('hidden');
                            $('.expiry_date').text(data.errors.expiry_date);
                        }
                        if (data.errors.expiry_time) {
                            $('.expiry_time').removeClass('hidden');
                            $('.expiry_time').text(data.errors.expiry_time);
                        }          
                        if (data.errors.participants_no) {
                            $('.participants_no').removeClass('hidden');
                            $('.participants_no').text(data.errors.participants_no);
                        }
                  } else {
                   $('.add').disabled =false;
                   date = data.deal ;
                   var y = JSON.stringify(data);
                   title =  "{{trans('admin.edit')}}" ;
                   title2 = "{{trans('admin.delete')}}"   ;
                   title3 = "{{trans('admin.tickets')}}" ;
                   
                   if (data.status == 'active'){
                       status = "{{ trans('admin.active')}}" ;
                    }
                    if (data.status == 'not_active'){
                        status = "{{ trans('admin.not_active')}}" ;
                    }
                    if(data.image){
                        image = "{{asset('img/')}}" +'/'+ data.image ;
                    }
                    else{
                        image = "{{asset('images/addimage.png')}}" ;
                    }
                   
                    
                    toastr.success('{{trans('admin.successfully_added')}}', '{{trans('admin.Success_Alert')}}', {timeOut: 5000});
                    $('#adminstable').prepend(`<tr class="item` + data.id + `"><td><input type="checkbox" name="ids[]" value="` + data.id + `"class="check icheck"></td><td>` + data.title_ar + `</td><td>` + data.original_price + `</td><td>` + data.initial_price + `</td><td>` + data.points + `</td><td>` + data.tickets + `</td><td>` + expiry_date + `</td><td><img src="`+ image +`" width="50px" height="50px"></td><td style="text-align:center"><span  class="badge">` + status + `</span></td><td>   <a href="#" class="edit-modal btn btn-success btn-round " title="`+title+`"  data-id=" `+ data.id + `" data-data=\'` + y +`\'><span class="glyphicon glyphicon-edit "></span> </a>  <a href="#" class="delete-modal btn btn-danger btn-round " data-id="` + data.id + `" ><span class="glyphicon glyphicon-trash " title="`+title2+`"></span>  </a>  <a href="<?php echo url('/')?>/tickets/` + data.id+`" class=" profile-modal btn btn-warning btn-round" title="`+title3+`" data-data=\'` + y +`\' ><span class="glyphicon glyphicon-exclamation-sign"></span></a> </td></tr>`) ;
                    $('#formadddeals')[0].reset();
                    $('#upload-file-success').html('');
                    
                    $('#addModal').modal('hide');
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-blue',
                        increaseArea: '20%' // optional
                    });
                    
                    $('#check-all').on('ifChecked', function(event) {
                        $('.check').iCheck('check');
                    });
                    $('#check-all').on('ifUnchecked', function(event) {
                        $('.check').iCheck('uncheck');
                    });
                    // Removed the checked state from "All" if any checkbox is unchecked
                    $('#check-all').on('ifChanged', function(event){
                        if(!this.changed) {
                            this.changed=true;
                            $('#check-all').iCheck('check');
                        } else {
                            this.changed=false;
                            $('#check-all').iCheck('uncheck');
                        }
                        $('#check-all').iCheck('update');
                    });
                    closeModal();
                    $('#addModal').modal('hide'); 
                }
            },
          });
        });
        
        // this for edit record
        $('#formeditdeals').submit(function(e) {
          {{--  $('#editModal').modal('hide');  --}}
            {{--  alert('done');  --}}
            e.preventDefault();
             openModal();
            var form = $(this);
            id =  $('.foridedit').val();  
            $.ajax({
                type: 'POST',
                url:'{{ URL::route("editdeal") }}',
                data: new FormData($("#formeditdeals")[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.title_ar1').addClass('hidden');
                    $('.title_en1').addClass('hidden');
                    $('.original_price1').addClass('hidden');
                    $('.initial_price1').addClass('hidden');
                    $('.points1').addClass('hidden');
                    $('.tender_cost1').addClass('hidden');
                    $('.tender_edit_cost1').addClass('hidden');
                    $('.tender_coupon1').addClass('hidden');
                    $('.disc_ar1').addClass('hidden');
                    $('.disc_en1').addClass('hidden');
                    $('.info_ar1').addClass('hidden');
                    $('.info_en1').addClass('hidden');
                    $('.category_id1').addClass('hidden');
                    $('.subcategory_id1').addClass('hidden');
                    $('.country_id1').addClass('hidden');
                    $('.expiry_date1').addClass('hidden');
                    $('.expiry_time1').addClass('hidden');
                    $('.image1').addClass('hidden');
                    $('.status1').addClass('hidden');                 
                    $('.participants_no1').addClass('hidden');
                    if ((data.errors)) {
                        closeModal();
                       toastr.error('{{trans('admin.Validation_error')}}', '{{trans('admin.Error_Alert')}}', {timeOut: 5000});

                        {{--  $('#editModal').modal('show');  --}}
                         
                        if (data.errors.title_ar) {
                            $('.title_ar1').removeClass('hidden');
                            $('.title_ar1').text(data.errors.title_ar);
                        }
                        if (data.errors.title_en) {
                            $('.title_en1').removeClass('hidden');
                            $('.title_en1').text(data.errors.title_en);
                        }
                        if (data.errors.original_price) {
                            $('.original_price1').removeClass('hidden');
                            $('.original_price1').text(data.errors.original_price);
                        }
                        if (data.errors.initial_price) {
                            $('.initial_price1').removeClass('hidden');
                            $('.initial_price1').text(data.errors.initial_price);
                        }
                        if (data.errors.points) {
                            $('.points1').removeClass('hidden');
                            $('.points1').text(data.errors.points);
                        }
                        if (data.errors.tender_cost) {
                            $('.tender_cost1').removeClass('hidden');
                            $('.tender_cost1').text(data.errors.tender_cost);
                        }
                        if (data.errors.tender_edit_cost) {
                            $('.tender_edit_cost1').removeClass('hidden');
                            $('.tender_edit_cost1').text(data.errors.tender_edit_cost);
                        }
                        if (data.errors.tender_coupon) {
                            $('.tender_coupon1').removeClass('hidden');
                            $('.tender_coupon1').text(data.errors.tender_coupon);
                        }
                        if (data.errors.disc_ar) {
                            $('.disc_ar1').removeClass('hidden');
                            $('.disc_ar1').text(data.errors.disc_ar);
                        }
                        if (data.errors.disc_en) {
                            $('.disc_en1').removeClass('hidden');
                            $('.disc_en1').text(data.errors.disc_en);
                        }
                        if (data.errors.info_ar) {
                            $('.info_ar1').removeClass('hidden');
                            $('.info_ar1').text(data.errors.info_ar);
                        }
                        if (data.errors.info_en) {
                            $('.info_en1').removeClass('hidden');
                            $('.info_en1').text(data.errors.info_en);
                        }
                        if (data.errors.category_id) {
                            $('.category_id1').removeClass('hidden');
                            $('.category_id1').text(data.errors.category_id);
                        }
                        if (data.errors.subcategory_id) {
                            $('.subcategory_id1').removeClass('hidden');
                            $('.subcategory_id1').text(data.errors.subcategory_id);
                        }
                        if (data.errors.image) {
                            $('.image1').removeClass('hidden');
                            $('.image1').text(data.errors.image);
                        }
                        if (data.errors.status) {
                            $('.status1').removeClass('hidden');
                            $('.status1').text(data.errors.status);
                        }         
                        if (data.errors.country_id) {
                            $('.country_id1').removeClass('hidden');
                            $('.country_id1').text(data.errors.country_id);
                        }       
                        if (data.errors.country_id) {
                            $('.country_id1').removeClass('hidden');
                            $('.country_id1').text(data.errors.country_id);
                        }         
                        if (data.errors.expiry_date) {
                            $('.expiry_date1').removeClass('hidden');
                            $('.expiry_date1').text(data.errors.expiry_date);
                        }          
                      
                        if (data.errors.expiry_time) {
                            $('.expiry_time1').removeClass('hidden');
                            $('.expiry_time1').text(data.errors.expiry_time);
                        } 
                        if (data.errors.participants_no) {
                            $('.participants_no1').removeClass('hidden');
                            $('.participants_no1').text(data.errors.participants_no);
                        }
                        
                    } else {
                        {{-- console.log(data) ; --}}
                        expiry_date = data.expiry_date ;
                        data = data.deal ;
                        var y = JSON.stringify(data);
                        
                        $('#editModal').modal('hide');
                        title =  "{{trans('admin.edit')}}" ;
                        title2 = "{{ trans('admin.delete')}}" ;
                        title3 = "{{trans('admin.tickets')}}" ;
                        if (data.status == 'active'){
                            status = "{{ trans('admin.active')}}" ;
                        }
                        if (data.status == 'not_active'){
                            status = "{{ trans('admin.not_active')}}" ;
                        }
                        if(data.image){
                            image = "{{asset('img/')}}" +'/'+ data.image ;
                        }
                        else{
                            image = "{{asset('images/addimage.png')}}" ;
                        }
                        if( data.tickets == null){
                            data.tickets = '0' ;
                        }
                       
                        toastr.success('{{trans('admin.successfully_edited')}}', '{{trans('admin.Success_Alert')}}', {timeOut: 5000});
                        $('.item' + data.id).replaceWith(`<tr class="item` + data.id + `"><td><input type="checkbox" name="ids[]" value="` + data.id + `"class="check icheck"></td><td>` + data.title_ar + `</td><td>` + data.original_price + `</td><td>` + data.initial_price + `</td><td>` + data.points + `</td><td>` + data.tickets + `</td><td>` + expiry_date + `</td><td><img src="`+ image +`" width="50px" height="50px"></td><td style="text-align:center"><span  class="badge">` + status + `</span></td><td>   <a href="#" class="edit-modal btn btn-success btn-round " title="`+title+`"  data-id=" `+ data.id + `" data-data=\'` + y +`\'><span class="glyphicon glyphicon-edit "></span> </a>  <a href="#" class="delete-modal btn btn-danger btn-round " data-id="` + data.id + `" ><span class="glyphicon glyphicon-trash " title="`+title2+`"></span>  </a>  <a href="<?php echo url('/')?>/tickets/` + data.id+`" class=" profile-modal btn btn-warning btn-round" title="`+title3+`" data-data=\'` + y +`\' ><span class="glyphicon glyphicon-exclamation-sign"></span></a> </td></tr>`);
                        $('#formeditdeals')[0].reset();
                        $('#upload-file-success1').html('');
                        $('#editModal').modal('hide');
                        $('input').iCheck({
                            checkboxClass: 'icheckbox_square-blue',
                            radioClass: 'iradio_square-blue',
                            increaseArea: '20%' // optional
                        });
                            
                        $('#check-all').on('ifChecked', function(event) {
                            $('.check').iCheck('check');
                        });
                        $('#check-all').on('ifUnchecked', function(event) {
                            $('.check').iCheck('uncheck');
                        });
                        // Removed the checked state from "All" if any checkbox is unchecked
                        $('#check-all').on('ifChanged', function(event){
                            if(!this.changed) {
                                this.changed=true;
                                $('#check-all').iCheck('check');
                            } else {
                                this.changed=false;
                                $('#check-all').iCheck('uncheck');
                            }
                            $('#check-all').iCheck('update');
                        });
                        closeModal();
                    }
                }
            });
        });

        $('#category_id_field').on('change', e => {
            $('#subcategory_id_field').empty();
            id = $('#category_id_field').val();
            
            $.ajax({
                type: 'GET',
                url: "<?php echo url('/')?>/categories/"+id+"/subcategories",
                success: data => {
                    if(data.subcategories.length <= 0){
                        alert('لا يوجد اقسام فرعيه لهذا القسم');
                    }
                    data.subcategories.forEach(subcategory =>
                        $('#subcategory_id_field').append(`<option value="${subcategory.id}">${subcategory.name_ar}</option>`)
                    )
                }
            })
        })

        $('#category_id_edit').on('change', e => {
            $('#subcategory_id_edit').empty();
            id = $('#category_id_edit').val();
            
            $.ajax({
                type: 'GET',
                url: "<?php echo url('/')?>/categories/"+id+"/subcategories",
                success: data => {
                    if(data.subcategories.length <= 0){
                        alert('لا يوجد اقسام فرعيه لهذا القسم');
                    }
                    data.subcategories.forEach(subcategory =>
                        $('#subcategory_id_edit').append(`<option value="${subcategory.id}">${subcategory.name_ar}</option>`)
                    )
                }
            })
        })

        
        $('#country_id_field').on('change', e => {
            $('#city_id_field').empty();
            id = $('#country_id_field').val();
            
            $.ajax({
                type: 'GET',
                url: "<?php echo url('/')?>/countries/"+id+"/cities",
                success: data => {
                    data.cities.forEach(city =>
                        $('#city_id_field').append(`<option value="${city.id}">${city.name_ar}</option>`)
                    )
                }
            })
        })

        $('#country_id_edit').on('change', e => {
            $('#city_id_edit').empty();
            id = $('#country_id_edit').val();
            $.ajax({
                type: 'GET',
                url: "<?php echo url('/')?>/countries/"+id+"/cities",
                success: data => {
                    data.cities.forEach(city =>
                        $('#city_id_edit').append(`<option value="${city.id}">${city.name_ar}</option>`)
                    )
                }
            })
        })
        
     });

      function isNumber(e){
            var key = e.charCode;  
            if( key <48 || key >57 )
            {
				if (key != 0)
				{
                e.preventDefault();   
				}
				          
            }
        }
        
  </script>
@endsection