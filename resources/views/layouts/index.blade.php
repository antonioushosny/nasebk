@include('layouts.head')
<?php   
    $lang = session('lang');
    App::setLocale($lang);
    $lang = App::getlocale();
    if($lang == null){
        $lang ='ar';
    }
    if($title){
        $page = $title;
    }
    else {
        $page ='home';
    }
?>
@if($lang == 'ar')
    <body class="hold-transition skin-blue fixed sidebar-mini sidebar-open" dir="rtl">

        <div class="wrapper">
    
            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <span class="logo-mini"><b>{{trans('admin.nasebk')}} </b></span>
                    <span class="logo-lg"><b>{{trans('admin.nasebk')}}</b></span>
                </a>
        
                <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">{{trans('admin.Toggle navigation')}}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
        
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              
                                <span class="">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                        @if(Auth::user()->profile_pic)
                                        <img src="{{asset('img/').'/'.Auth::user()->profile_pic}}" class="img-circle" alt="">
                                        @else 
                                        <img src="{{ asset('images/nasebk.jpeg') }}" class="img-circle" alt="">
                                        @endif
                                   
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">

                                        <a href="{{route('profile',['id'=>Auth::user()->id])}}" class="btn btn-info btn-flat">{{trans('admin.profile')}} </a>
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn btn-info btn-flat" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{trans('admin.logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown" style=" direction: ltr;" >
                            <a href="#" class="dropdown-toggle notificaiton" data-toggle="dropdown">

                                  <span class="glyphicon glyphicon-globe"></span> <span class="hidden-xs">{{trans('admin.notification')}}</span> <span class="badge" id="count">{{count(auth()->user()->unreadnotifications)}}</span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" id="showNofication" style="direction: rtl;">
                            @if(count(auth()->user()->notifications) > 0)
                            @foreach(auth()->user()->notifications as $note)
                                <li style=" float:  right;">
                                    <a href="{{ route('home') }}" class="{{ $note->read_at == null ? 'unread' : '' }}">
                                            {!! $note->data['data']!!}
                                           
                                    </a>
                                </li>
                          
                            @endforeach
                            {{-- @else 
                            <li style=" float:  right;">
                                <a href=" #" >
                                        لا يوجد اشعارات جديدة
                                </a>
                            </li> --}}
                            @endif
                    
                                
                            </ul>
                        </li>
                        <!-- <li> <a class="" href=" {{route('setlang',['lang'=>'en'])}}">{{trans('admin.en')}}</a> </li>
                        <li> <a class="" href=" {{route('setlang',['lang'=>'ar'])}}">{{trans('admin.ar')}}</a> </li> -->
                    
                    </ul>
                </div>
                </nav>
            </header>
    
@else
    <body class="hold-transition skin-blue fixed sidebar-mini ">
        <!-- Site wrapper -->
        <div class="wrapper" id="app">
    
            <header class="flex-container main-header">
                    <!-- Logo -->
                <a href="#" class="logo">
                    <span class="logo-mini"><b>{{trans('admin.nasebk')}} </b></span>
                    <span class="logo-lg"><b>{{trans('admin.nasebk')}}</b></span>
                </a>
    
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">{{trans('admin.Toggle navigation')}}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
        
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
            
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                                    <span class="">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
 
                                        @if(Auth::user()->profile_pic)
                                        <img src="{{asset('img/').'/'.Auth::user()->profile_pic}}" class="img-circle" alt="">
                                        @else 
                                        <img src="{{ asset('images/nasebk.jpeg') }}" class="img-circle" alt="">
                                        @endif
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                            
                                            <a href="{{route('profile',['id'=>Auth::user()->id])}}" class="btn btn-info btn-flat">{{trans('admin.profile')}} </a>
                                        </div>
                                        <div class="pull-right">
                                            <a class="btn btn-info btn-flat" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                                {{trans('admin.logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                
                            
                            <li class="dropdown" >
                                <a href="#" class="dropdown-toggle notificaiton" data-toggle="dropdown">

                                        <span class="glyphicon glyphicon-globe"></span>  <span class="hidden-xs">{{trans('admin.notification')}}</span> <span class="badge" id="count">{{count(auth()->user()->unreadnotifications)}}</span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" id="showNofication" >
                                @foreach(auth()->user()->notifications as $note)
                                    <li>
                                        <a href=" {{ route('home') }}" class="{{ $note->read_at == null ? 'unread' : '' }}">
                                                {!! $note->data['data'] !!}
                                        </a>                                      
                                    </li>
                                
                                @endforeach
                                </ul>
                            </li>
        
                            <!-- <li> <a class="" href=" {{route('setlang',['lang'=>'en'])}}">{{trans('admin.en')}}</a> </li>
                            <li> <a class="" href=" {{route('setlang',['lang'=>'ar'])}}">{{trans('admin.ar')}}</a> </li> -->
                        
                        </ul>
                    </div>
                </nav>
            </header>
    
            <!-- =============================================== -->
    
@endif
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <img src="{{ asset('images/nasebk.jpeg') }}" width="100%" height="100px" alt="" style="object-fit: contain;">
                    </div>
                    
                    <ul class="sidebar-menu " data-widget="tree" style="margin-top:10px">
                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('home') }}" <?php echo ($page == 'home') ? "class='current'" : ""; ?> ><i class="fa fa-home   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.dashboard')}}</span></a></li>

                        
                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('admins') }}" <?php echo ($page == 'admins') ? "class='current'" : ""; ?> ><i class="fa fa-user-cog   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.admins')}}</span></a></li>

                        <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('advertisements') }}" <?php echo ($page == 'advertisements') ? "class='current'" : ""; ?> ><i class="fa fa-newspaper   fa-2x  iconsidebarltr"></i> <span> {{trans('admin.advertisementsm')}}</span></a></li>

                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('countries') }}" <?php echo ($page == 'countries') ? "class='current'" : ""; ?> ><i class="fa fa-flag   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.countriesm')}}</span></a></li>
                        
                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('cities') }}" <?php echo ($page == 'cities') ? "class='current'" : ""; ?> ><i class="fa fa-flag-checkered   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.citiesm')}}</span></a></li>
                       
                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('users') }}" <?php echo ($page == 'users') ? "class='current'" : ""; ?> ><i class="fa fa-users  fa-2x  iconsidebarltr "></i> <span> {{trans('admin.usersm')}}</span></a></li>

                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('categories') }}" <?php echo ($page == 'categories') ? "class='current'" : ""; ?> ><i class="fa fa-list-alt   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.categoriesm')}}</span></a></li>

                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('subcategories') }}" <?php echo ($page == 'subcategories') ? "class='current'" : ""; ?> ><i class="fa fa-layer-group   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.subcategoriesm')}}</span></a></li> 

                        <li class="treeview"  onmouseover=" animationHover(this , 'pulse');">
                            <a href="#"  <?php echo ($page == 'nowdeals') ? "class='current'" : ""; ?> <?php echo ($page == 'deals') ? "class='current'" : ""; ?> <?php echo ($page == 'last_deals') ? "class='current'" : ""; ?>  > <i class="fa fa-plus-square  fa-2x  iconsidebarltr"></i> <span> {{trans('admin.dealss')}}</span> <span class="caret" style=" margin-right: 12rem;"></span></a>
                             <ul class="treeview-menu">
                                <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('deals') }}" <?php echo ($page == 'deals') ? "class='current'" : ""; ?> ><i class="fa fa-plus-square   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.dealsm')}}</span></a></li>
                        
                                <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('nowdeals') }}" <?php echo ($page == 'nowdeals') ? "class='current'" : ""; ?> ><i class="fa fa-plus-square   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.nowdealsm')}}</span></a></li>
                                
                                <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('last_deals') }}" <?php echo ($page == 'last_deals') ? "class='current'" : ""; ?> ><i class="fa fa-plus-square   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.last_dealsm')}}</span></a></li>
                             </ul>
                        </li>
                        
                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('awards') }}" <?php echo ($page == 'awards') ? "class='current'" : ""; ?> ><i class="fa fa-award   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.awardsm')}}</span></a></li> 
                        
                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('interests') }}" <?php echo ($page == 'interests') ? "class='current'" : ""; ?> ><i class="fa fa-life-ring   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.interestsm')}}</span></a></li> 

                        <li onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('packages') }}" <?php echo ($page == 'packages') ? "class='current'" : ""; ?> ><i class="fa fa-box   fa-2x  iconsidebarltr "></i> <span> {{trans('admin.packagesm')}}</span></a></li> 
         
                        <li class="treeview"  onmouseover=" animationHover(this , 'pulse');">
                           <a href="#"  <?php echo ($page == 'users_new') ? "class='current'" : ""; ?> <?php echo ($page == 'users_solved') ? "class='current'" : ""; ?> <?php echo ($page == 'users_not_resolved') ? "class='current'" : ""; ?>  ><i class="fa fa-phone-square   fa-2x  iconsidebarltr"></i> <span> {{trans('admin.contacts_users')}}</span> <span class="caret" style=" margin-right: 7rem;"></span> </a>
                            <ul class="treeview-menu">
                                <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('contactsusers','new') }}" <?php echo ($page == 'users_new') ? "class='current'" : ""; ?> ><i class="fa fa-phone-square   fa-2x  iconsidebarltr"></i> <span> {{trans('admin.new')}}</span></a></li>

                                <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('contactsusers','solved') }}" <?php echo ($page == 'users_solved') ? "class='current'" : ""; ?> ><i class="fa fa-phone-square   fa-2x  iconsidebarltr"></i> <span> {{trans('admin.solved')}}</span></a></li>

                                <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('contactsusers','not_resolved') }}" <?php echo ($page == 'users_not_resolved') ? "class='current'" : ""; ?> ><i class="fa fa-phone-square   fa-2x  iconsidebarltr"></i> <span> {{trans('admin.not_resolved')}}</span></a></li>
                            </ul>
                        </li>

                        <li class="treeview"  onmouseover=" animationHover(this , 'pulse');">
                            <a href="#"  <?php echo ($page == 'policy') ? "class='current'" : ""; ?> <?php echo ($page == 'terms') ? "class='current'" : ""; ?> <?php echo ($page == 'about') ? "class='current'" : ""; ?><?php echo ($page == 'contacts') ? "class='current'" : ""; ?>  ><i class="fa fa-th  fa-2x  iconsidebarltr"></i> <span> {{trans('admin.statics')}}</span> <span class="caret" style=" margin-right: 8.5rem;"></span> </a>
                             <ul class="treeview-menu">
                                 <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('statics','about') }}" <?php echo ($page == 'about') ? "class='current'" : ""; ?> ><i class="fa fa-address-card  fa-2x  iconsidebarltr"></i> <span> {{trans('admin.about')}}</span></a></li>
 
                                 <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('statics','terms') }}" <?php echo ($page == 'terms') ? "class='current'" : ""; ?> ><i class="fa fa-align-center   fa-2x  iconsidebarltr"></i> <span> {{trans('admin.terms')}}</span></a></li>
 
                                 <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('statics','policy') }}" <?php echo ($page == 'policy') ? "class='current'" : ""; ?> ><i class="fa fa-allergies   fa-2x  iconsidebarltr"></i> <span> {{trans('admin.policy')}}</span></a></li>

                                 <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('contacts') }}" <?php echo ($page == 'contacts') ? "class='current'" : ""; ?> ><i class="fa fa-phone-square  sfa-2x  iconsidebarltr"></i> <span> {{trans('admin.social_accounts')}}</span></a></li>
                             </ul>
                         </li>
                         
                        <li  onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('messages') }}" <?php echo ($page == 'messages') ? "class='current'" : ""; ?>><i class="fa fa-comment  fa-2x iconsidebarltr"  ></i> <span>{{trans('admin.messages')}}</span></a></li> 
                        
                        <li class="treeview"  onmouseover=" animationHover(this , 'pulse');">
                            <a href="#"  <?php echo ($page == 'reports') ? "class='current'" : ""; ?> <?php echo ($page == 'reportsdeals') ? "class='current'" : ""; ?> <?php echo ($page == 'about') ? "class='current'" : ""; ?>  ><i class="fa fa-bars  fa-2x  iconsidebarltr"></i> <span> {{trans('admin.reports')}}</span> <span class="caret" style=" margin-right: 13rem;"></span> </a>
                             <ul class="treeview-menu">
                                 <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('charges') }}" <?php echo ($page == 'history_charges') ? "class='current'" : ""; ?> ><i class="fa fa-coins  fa-2x  iconsidebarltr"></i> <span> {{trans('admin.history_charges')}}</span></a></li>
                                 
                                 <li onmouseover=" animationHover(this , 'pulse');"><a href="{{ route('reportsdeals') }}" <?php echo ($page == 'reportsdeals') ? "class='current'" : ""; ?> ><i class="fa fa-tasks   fa-2x  iconsidebarltr"></i> <span> {{trans('admin.reportsdeals')}}</span></a></li>
 
                             </ul>
                         </li>
                         <li></li>
                         <li></li>
                         <li></li>
                         @can('advertisement_list') 
                        {{-- <li  onnasebkseover=" animationHover(this , 'pulse');"><a href="{{ route('reports') }}" ><i class="fa fa-cogs  fa-2x iconsidebarltr"  ></i> <span>{{trans('admin.reports')}}</span></a></li>  --}}
                        @endcan 
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- =============================================== -->

            <div class="content-wrapper">

                @yield('content')           

            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <strong>{{trans('admin.Copyright')}}</strong>&copy; {{trans('admin.All_rights')}}
            </footer>
            <div class="control-sidebar-bg"></div>
            </div>
            <!-- ./wrapper -->

@if($lang == 'ar')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonynasebks"></script>       
    <script src="{{ asset('rtl/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('rtl/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('rtl/plugins/iCheck/icheck.min.js') }}"></script> 
    <script src="{{ asset('rtl/plugins/fastclick/fastclick.min.js') }}"></script>
    <script src="{{ asset('ltr/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('rtl/dist/js/demo.js') }}"></script> 
    <script src="{{ asset('rtl/dist/js/app.js') }}"></script> 
@else
    <script src="{{ asset('ltr/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('ltr/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('ltr/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('ltr/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('rtl/plugins/iCheck/icheck.min.js') }}"></script> 
    <script src="{{ asset('ltr/dist/js/adminlte.min.js') }}"></script>
@endif

    <script src="{{ asset('datatable/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
     <!-- select2 -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script src="{{URL::to('src/js/vendor/tinymce_4.9.2/tinymce/js/tinymce/tinymce.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script> 
    <script>
        toastr.options = {
        "positionClass": "toast-top-full-width",
        "closeButton": true,
        "progressBar": true,
        }
    
    </script>
@if($lang == 'ar')
    <style>
        .toast-top-full-width {
        top: 18%;
        right: 70%;
        width: 30%;
        }
        .select2 {
        width:100%!important;
        }
    </style>
    <script>
            jQuery(function($){
                $(document).ready(function () {
                    $.noConflict();
                    $('.select2').select2();
                    var table = $('#example').DataTable({
                        "language": {
                            "url": "{{asset('datatablelang.json')}}"
                        },
                        dom: 'Blfrtip',
                        buttons: [
                            'copy', 'excel', 'print'
                        ],   
                    });
                    var table1 = $('#example1').DataTable({
                        "language": {
                            "url": "{{asset('datatablelang.json')}}"
                        },
                        dom: 'Blfrtip',
                        buttons: [
                            'copy', 'excel', 'print'
                        ],   
                    });
                    var table2 = $('#example2').DataTable({
                        "language": {
                            "url": "{{asset('datatablelang.json')}}"
                        },
                    });
                    var table3 = $('#example3').DataTable({
                        "language": {
                            "url": "{{asset('datatablelang.json')}}"
                        } 
                    });
                    var table4 = $('#example4').DataTable({
                        "language": {
                            "url": "{{asset('datatablelang.json')}}"
                        } 
                    });

                });
            });
                
    </script>
    <script>
        jQuery(function($){

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

            $('#check-all2').on('ifChecked', function(event) {
                $('.check2').iCheck('check');
            });
            $('#check-all2').on('ifUnchecked', function(event) {
                $('.check2').iCheck('uncheck');
            });
            // Removed the checked state from "All" if any checkbox is unchecked
            $('#check-all2').on('ifChanged', function(event){
                if(!this.changed) {
                    this.changed=true;
                    $('#check-all2').iCheck('check2');
                } else {
                    this.changed=false;
                    $('#check-all2').iCheck('uncheck');
                }
                $('#check-all2').iCheck('update');
            });
        });
    </script>
@else 
    <style>
        .toast-top-full-width {
        top: 18%;
        right: 0%;
        width: 30%;
        }
    </style>
    <script>
        jQuery(function($){
            $(document).ready(function () {
                $.noConflict();
                var table = $('#example').DataTable({
                    dom: 'Blfrtip',
                    buttons: [
                        'copy', 'excel','print',
                    ],

                });
                var table1 = $('#example1').DataTable({
                    dom: 'Blfrtip',
                    buttons: [
                        'copy', 'excel','print',
                    ],

                });
                var table2 = $('#example2').DataTable({

                });
                var table3 = $('#example3').DataTable({

                });
                var table3 = $('#example4').DataTable({

                });
            });
        });
        
        $("form").submit(function() {
        
            $(this).submit(function() {
                return false;
            });
            return true;
        });
        
    </script>
    <script>
        jQuery(function($){

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
        });
    </script>
@endif
<!-- <script src="{{ asset('fastselect/fastselect.min.js') }}"></script>
<script src="{{ asset('fastselect/fastselect.standalone.min.js') }}"></script> -->
    @yield('script1') 

@if($lang == 'en')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
@endif
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@if($lang == 'ar')
    <script>

        var message, ShowDiv = $('#showNofication'), count = $('#count'), c;

        $('.notificaiton').on('click' , function(){
            setTimeout( function(){
                count.html(0);
                $('.unread').each(function(){
                    $(this).removeClass('unread');
                });
            }, 5000);
            $.get( "{{route('MarkAllSeen') }}" , function(){});
        });
    </script>
@else 
    <script>

        var message, ShowDiv = $('#showNofication'), count = $('#count'), c;
        $('.notificaiton').on('click' , function(){
            setTimeout( function(){
                count.html(0);
                $('.unread').each(function(){
                    $(this).removeClass('unread');
                });
            }, 5000);
            $.get( "{{route('MarkAllSeen') }}" , function(){});
        });
    </script>
@endif
    @yield('script') 


    <script src="https://www.gstatic.com/firebasejs/5.5.5/firebase.js"></script>
    <script>

        // Initialize Firebase
        // TODO: Replace with your project's customized code snippet
        var config = {
            apiKey: "AIzaSyAPA5a0FBYt87i0AJMitg0fC3T3C4Vj_qs",
            authDomain: "joud-129d5.firebaseapp.com",
            databaseURL: "https://joud-129d5.firebaseio.com",
            projectId: "joud-129d5",
            storageBucket: "joud-129d5.appspot.com",
            messagingSenderId: "324063917940"
        };
        firebase.initializeApp(config);
        const messaging = firebase.messaging();
        messaging
            .requestPermission()
            .then(function () {
                
                {{--  console.log("Notification permission granted.");  --}}

                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function(token) {
                 console.log("token is : " + token);  
                if(token){
                    $.ajax({
                        url: "<?php echo url('/')?>/token/"+token,
                        success: data => {
                        }
                    })
                }
                
            })
            .catch(function (err) {
                {{--  console.log("Unable to get permission to notify.", err);  --}}
            });

        messaging.onMessage(function(payload) {
            var jsonObj = $.parseJSON('[' + payload.data.message + ']');
            {{-- var jsonObj1 = $.parseJSON('[' + payload.data + ']'); --}}
            {{--  console.log("Message received. ", payload);  --}}
            c = parseInt(count.html());
            count.html(c+1);
            console.log(jsonObj);
            console.log(payload.data);
            @if($lang == 'ar')
                
                   ShowDiv.prepend('<li  style=" float:  right;"><a href="{{ route("home") }}" class="unread">'+jsonObj['0']['ar']+'</a></li>');
                

            @else
            
                ShowDiv.prepend('<li><a href="{{ route("home") }}" class="unread">'+jsonObj['0']['en']+'</a></li>');

            
            @endif


        });

    </script>
    @if($lang == "ar")



    @endif
</body>

</html>
    