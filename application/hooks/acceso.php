<?php

class Acceso {

      function __construct(){

      }
      function identificado()
      {
          
                $this->CI = & get_instance();
                if($this->CI->session->userdata('logged_in')==true && $this->CI->router->method == 'login' && $this->CI->router->class="user")
                {
                    redirect ('jsonweb/query');
                }elseif($this->CI->session->userdata('logged_in')==true && $this->CI->router->method == 'login' && $this->CI->router->class="user_android")
                {
                    redirect ('jsonweb/query_android/xml');
                }
                
                
                if($this->CI->session->userdata('logged_in')!=true && $this->CI->router->method != 'login')
                {
                    $class=$this->CI->router->class;
                    if($class=="query")
                    {
                        redirect("user/login");
                    }elseif($class=="query_android_")
                    {
                        redirect("user_android/login");
                    }
                }
      }
}
?>