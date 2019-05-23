    <?php
//aurl for admin
if(!function_exists('aurl'))
{
    function aurl($url=null)
    {
        return url('admin/'.$url);
    }
}


if(!function_exists('admin'))
{
    function admin()
    {
        return auth()->guard('admin');
    }   
}

if(!function_exists('lang')) {
    function lang(){
        if(session()->has('lang'))
        {
            return session('lang');
        }else{
            return 'ar';
        }
    }
}

//active menu 
if(!function_exists('active_menu'))
{
   function active_menu($link){
       if (preg_match('/'.$link.'/',Request::segment(2)))
       {
           return ['menu_open','display:block'];
       }else{
           return['','',''];
       }
   }
}

if(!function_exists('direction')) {
    function direction(){
        if(session()->has('lang')){
           if(session('lang')=='ar'){
               return 'rtl';
           }else{
               return 'ltr';
           }
        }else{
            return 'ltr';
        }
    }
}


