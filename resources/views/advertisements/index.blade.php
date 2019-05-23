@extends('layouts.index')

 @section('content')
    <section class="content-header">
        <h1>
            {{trans('admin.advertisements')}}
        <small>{{trans('admin.Control_panel')}}</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> {{trans('admin.home')}}</a></li>
          <li class="active"><a href="#">{{trans('admin.advertisements')}}</a></li>
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
      {!! Form::open(['route'=>['advertisementsdeleteall'],'method'=>'post','autocomplete'=>'off', 'id'=>'advertisementss_form' ])!!}
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="panel panel-green">
                  <div class="panel-heading">
                    <section class="content-header" style=" !important;">
                        <div class="row" style="display:flex;">
                            <div class="col-md-8" >
                                <span style="font-size:2em ;"><i class="fa fa-cog"></i> {{trans('admin.advertisements')}}</span>

                            </div>
                            <div class=" col-md-4">
                                <a href="#" class="add-modal btn btn-primary"><i class="fa fa-plus" ></i> {{trans('admin.add_advertisement')}}</a>  
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
                            <th>{{trans('admin.link')}}</th>
                            <th>{{trans('admin.time')}}</th>
                            <th>{{trans('admin.image')}}</th>
                            <th>{{trans('admin.status')}}</th>
                            <th>{{trans('admin.actions')}}</th>
                          </tr>
                        </thead>

                        <tbody id="adminstable">
                            @foreach ($advertisements as $data)
                              <tr class="item{{$data->id}}">
                               
                                <td><input type="checkbox" name="ids[]" value={{$data->id}} class="check icheck"></td>
                                <td>{{ $data->link}}</td> 
                                <td>{{ $data->time}}</td> 
                                @if($data->image)
                                <td><img src="{{asset('img/').'/'.$data->image }}" width="50px" height="50px"></td>
                                @else 
                                <td><img src="{{asset('images/default.png') }}" width="50px" height="50px"></td>
                                @endif
                                  <td style="text-align:center"><span  class="badge">{{ trans('admin.'.$data->status)}}</span></td> 
                              
                                
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
    </section>
</form>
        <div id="fade"></div>
        <div id="modal" style="z-index:30000">
            <img id="loader" src="{{asset('images/loading.gif')}}" />
        </div>
        <!--modal for add -->
        <div id="addModal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="  width: 50%; ">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="panel-group">
                            
                         {!! Form::open(['route'=>['storeadvertisement'],'method'=>'post','autocomplete'=>'off','role'=>'form','id'=>'formaddadvertisements'])!!}
 
                            <div class="panel panel-green">
                                <div class="panel-heading " style="text-align: center"> 
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4>{{trans('admin.add_advertisement')}}</h4>
                                </div>
                                <div class="panel-body">

                                    {{--  for  link   --}}
                                    <div class="row"  style="display:flex;">
                                        <div class= "col-md-12 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('link',trans('admin.link')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('link','',['class'=>'form-control','id' => 'link_field','placeholder' => trans('admin.placeholder_link')]) !!}
                                                    </span>
                                                    <span style="color: red " class="link text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    {{--  for  time   --}}
                                    <div class="row"  style="display:flex;">
                                        <div class= "col-md-12 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('time',trans('admin.time')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::number('time','',['class'=>'form-control','min'=> 1,'id' => 'time_field','placeholder' => trans('admin.placeholder_time')]) !!}
                                                    </span>
                                                    <span style="color: red " class="time text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                     {{--  for status   --}}
                                    <div class="row"  style="display:flex;">
                                        <div class= "col-md-12 col-xs-12">
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
                                    </div>

                                        {{--  for image  --}}
                                    <div class="row"  style="display:flex;">   
                                        <div class= "col-md-12 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                            <div class="col-xs-3">
                                                <span style="color: black "> *
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
                         <div class="panel-heading " style="text-align: center"> <h4>{{trans('admin.delete_advertisement')}}</h4>
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
                         <div class="panel-heading " style="text-align: center"> <h4>{{trans('admin.delete_advertisement')}}</h4>
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
            <div class="modal-dialog" style="  width: 50%; ">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="panel-group">
                            
                            {!! Form::open(['route'=>['editadvertisement'],'method'=>'post','autocomplete'=>'off','role'=>'form','id'=>'formeditadvertisements'])!!}
                            {!! Form::hidden('id','',['class'=>'form-control foridedit','id' => 'id_edit','placeholder' => trans('admin.placeholder_name')]) !!}
                            <div class="panel panel-green">
                                <div class="panel-heading " style="text-align: center"> 
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4>{{trans('admin.edit_advertisement')}}</h4>
                                </div>
                                <div class="panel-body">
                                    {{--  for  link   --}}
                                    <div class="row"  style="display:flex;">
                                        <div class= "col-md-12 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('link',trans('admin.link')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::text('link','',['class'=>'form-control','id' => 'link_edit','placeholder' => trans('admin.placeholder_link')]) !!}
                                                    </span>
                                                    <span style="color: red " class="link1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    {{--  for  time   --}}
                                    <div class="row"  style="display:flex;">
                                        <div class= "col-md-12 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                                <div class="col-xs-3">
                                                    <span style="color: black "> *
                                                        {!!Form::label('time',trans('admin.time')) !!}
                                                    </span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <span style="color: black "> 
                                                        {!! Form::number('time','',['class'=>'form-control','min'=> 1,'id' => 'time_edit','placeholder' => trans('admin.placeholder_time')]) !!}
                                                    </span>
                                                    <span style="color: red " class="time1 text-center hidden"></span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                         {{--  for status   --}}
                                    <div class="row"  style="display:flex;">
                                        <div class= "col-md-12 col-xs-12">
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
                                    </div> 
                                        {{--  for image  --}}
                                    <div class="row"  style="display:flex;">
                                        <div class= "col-md-12 col-xs-12">
                                            <div class="form-group  row" style="display:flex;">
                                            <div class="col-xs-3">
                                                <span style="color: black "> *
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
                                                        <div class='label label-primary' id="upload-file-success1" ></div>
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
            if(data.image){
                image = "{{asset('img/')}}" +'/'+ data.image ;
            }
            else{
                image = "{{asset('images/default.png')}}" ;
            }
            $('.modal-title').text('{{trans('admin.edit')}}');
            $('#id_edit').val($(this).data('id'));
            $('#changeimage1').attr('src', image);
            $('#status_edit').val(data.status);
            $('#link_edit').val(data.link);
            $('#time_edit').val(data.time);
            id = $('#id_edit').val();

            $('.image1').addClass('hidden');
            $('.status1').addClass('hidden');
            $('.link1').addClass('hidden');
            $('.time1').addClass('hidden');
            $('#editModal').modal('show');
        });
        
        $(document).on('click', '.add-modal', function() {
            $('.modal-title').text('{{trans('admin.add')}}');
            image = "{{asset('images/default.png')}}"  ;
            $('#formaddadvertisements')[0].reset();
            $('#changeimage').attr('src', image );
            $('.image').addClass('hidden');
            $('.status').addClass('hidden');
            $('.link').addClass('hidden');
            $('.time').addClass('hidden');

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
                    url: '{{ URL::route("advertisementsdeleteall") }}',
                    data:  new FormData($("#advertisementss_form")[0]),
                    processData: false,
                      contentType: false,
                    
                    success: function(data) {

                        if ((data.errors)) {
                            closeModal()
                           toastr.error('{{trans('admin.Validation_error')}}', '{{trans('admin.Error_Alert')}}', {timeOut: 5000});
                        } else {
                            closeModal()
                            toastr.success('{{trans('admin.successfully_deleted')}}', '{{trans('admin.Success_Alert')}}', {timeOut: 5000});
                            for (var i=0;i<data.length;i++){
                                console.log(data)
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
                    url: "<?php echo url('/')?>/advertisements/delete/" + id,
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
        $('#advertisementss_form').submit(function(e){
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
        $("#formaddadvertisements").submit(function(e){
           {{--  $('#addModal').modal('hide');  --}}
           $('.add').disabled =true;
          e.preventDefault();
          var form = $(this);
           openModal();
          $.ajax({
              type: 'POST',
              url: '{{ URL::route("storeadvertisement") }}',
              data:  new FormData($("#formaddadvertisements")[0]),
              processData: false,
                contentType: false,
              
              success: function(data) {
                    $('.image').addClass('hidden');
                    $('.link').addClass('hidden');
                    $('.time').addClass('hidden');
                    $('.status').addClass('hidden');
        
  
                  if ((data.errors)) {
                        {{--  $('#addModal').modal('show');  --}}
                        closeModal();
                        $('.add').disabled =false;
                        {{--  console.log(data.errors);                      --}}
                        toastr.error('{{trans('admin.Validation_error')}}', '{{trans('admin.Error_Alert')}}', {timeOut: 5000});
          
                        if (data.errors.image) {
                            $('.image').removeClass('hidden');
                            $('.image').text(data.errors.image);
                        }

                        if (data.errors.status) {
                            $('.status').removeClass('hidden');
                            $('.status').text(data.errors.status);
                        }   
                        if (data.errors.link) {
                            $('.link').removeClass('hidden');
                            $('.link').text(data.errors.link);
                        }

                        if (data.errors.time) {
                            $('.time').removeClass('hidden');
                            $('.time').text(data.errors.time);
                        }                    
                      
       
                  } else {
                   $('.add').disabled =false;
                   var y = JSON.stringify(data);
                   title =  "{{trans('admin.edit')}}" ;
                   title2 = "{{trans('admin.delete')}}"   ;
                   
                   
                   if (data.status == 'active'){
                       status = "{{ trans('admin.active')}}" ;
                    }
                   else if (data.status == 'not_active'){
                        status = "{{ trans('admin.not_active')}}" ;
                    }
                    else{
                        status = " " ;
                    }
                    if(data.image){
                        image = "{{asset('img/')}}" +'/'+ data.image ;
                    }
                    else{
                        image = "{{asset('images/default.png')}}" ;
                    }
                    
                    
                    toastr.success('{{trans('admin.successfully_added')}}', '{{trans('admin.Success_Alert')}}', {timeOut: 5000});
                    type = "{{$title}}" ;

                    $('#adminstable').prepend('<tr class="item' + data.id + '"><td><input type="checkbox" name="ids[]" value="' + data.id + '"class="check icheck"></td><td>'+ data.link +'</td><td>'+ data.time +'</td><td><img src="'+ image +'" width="50px" height="50px"></td><td style="text-align:center"><span  class="badge">' + status + '</span></td><td>   <a href="#" class="edit-modal btn btn-success btn-round " title="'+title+'"  data-id=" '+ data.id + '" data-data=\'' + y +'\'><span class="glyphicon glyphicon-edit "></span> </a><a href="#" class="delete-modal btn btn-danger btn-round " data-id="' + data.id + '" ><span class="glyphicon glyphicon-trash " title="'+title2+'"></span> </a> </td></tr>');
                    $('#formaddadvertisements')[0].reset();
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
        $('#formeditadvertisements').submit(function(e) {
          {{--  $('#editModal').modal('hide');  --}}
            {{--  alert('done');  --}}
            e.preventDefault();
             openModal();
            var form = $(this);
            id =  $('.foridedit').val();  
            $.ajax({
                type: 'POST',
                url:'{{ URL::route("editadvertisement") }}',
                data: new FormData($("#formeditadvertisements")[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.image1').addClass('hidden');
                    $('.status1').addClass('hidden');                   
                    $('.link1').addClass('hidden');                   
                    $('.time1').addClass('hidden');                   
                    if ((data.errors)) {
                        closeModal();
                       toastr.error('{{trans('admin.Validation_error')}}', '{{trans('admin.Error_Alert')}}', {timeOut: 5000});

                        {{--  $('#editModal').modal('show');  --}}
  
                        if (data.errors.image) {
                            $('.image1').removeClass('hidden');
                            $('.image1').text(data.errors.image);
                        }

                        if (data.errors.status) {
                            $('.status1').removeClass('hidden');
                            $('.status1').text(data.errors.status);
                        }
                        if (data.errors.link) {
                            $('.link1').removeClass('hidden');
                            $('.link1').text(data.errors.link);
                        }

                        if (data.errors.time) {
                            $('.time1').removeClass('hidden');
                            $('.time1').text(data.errors.time);
                        }
         
                    } else {
                        var y = JSON.stringify(data);
                        
                        $('#editModal').modal('hide');
                        title =  "{{trans('admin.edit')}}" ;
                        title2 = "{{trans('admin.delete')}}"   ;
                        
                        if (data.status == 'active'){
                            status = "{{ trans('admin.active')}}" ;
                            }
                        else if (data.status == 'not_active'){
                            status = "{{ trans('admin.not_active')}}" ;
                            }
                        else{
                            status = " " ;
                            }
                        if(data.image){
                            image = "{{asset('img/')}}" +'/'+ data.image ;
                        }
                        else{
                            image = "{{asset('images/default.png')}}" ;
                        }
                       
                        toastr.success('{{trans('admin.successfully_edited')}}', '{{trans('admin.Success_Alert')}}', {timeOut: 5000});
                        $('.item' + data.id).replaceWith('<tr class="item' + data.id + '"><td><input type="checkbox" name="ids[]" value="' + data.id + '"class="check icheck"></td><td>'+ data.link +'</td><td>'+ data.time +'</td><td><img src="'+ image +'" width="50px" height="50px"></td><td style="text-align:center"><span  class="badge">' + status + '</span></td><td>  <a href="#" class="edit-modal btn btn-success btn-round " title="'+title+'"  data-id=" '+ data.id + '" data-data=\'' + y +'\'><span class="glyphicon glyphicon-edit "></span> </a><a href="#" class="delete-modal btn btn-danger btn-round " data-id="' + data.id + '" ><span class="glyphicon glyphicon-trash " title="'+title2+'"></span> </a> </td></tr>');
                        $('#formeditadvertisements')[0].reset();
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