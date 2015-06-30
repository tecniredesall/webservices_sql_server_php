<?php


class User_android extends CI_Controller{

      function __construct(){
         parent::__construct();
      }

      public function index()
      {
            redirect("user_android/login");
      }

      public function test()
      {
          $this->session->sess_destroy();
          $test=in_get("test");
          if($test==1)
          {
              echo "true";
          }else
          {
              echo "false";
          }
      }
   

      function login()
       {  
          if($this->session->sess_read())
          {
              
                if($this->session->userdata('logged_in')==true && $this->router->method == 'login' && $this->router->class="user_android")
                {
                          $this->session->set_userdata(array("sql"=>in_post('sql')));
                          redirect("jsonweb/query_android/xml");
                }
          }
                $this->session->sess_destroy();
                if($varii=in_post(array("acceso")))
                {
                   $clave= encriptarClave($varii["clave"]);

                   $respuesta = $this->basicauth->login($varii["usuario"],$clave);
                   if (!isset($respuesta['error']))
                   {
                         $this->session->set_userdata(array("params"=>in_post(array("config"))));
                         $this->session->set_userdata(array("sql"=>in_post('sql')));
                         redirect("jsonweb/query_android/xml");
                   }
                   else 
                   {
                       
                       echo "USER_ERRLOGIN";
                   }
                }else
                {
                    echo "USER_SINPARAM";   
                }   
           
      }

      function salir()
      {
          $this->session->sess_destroy();
          redirect("user_android/login");
      }
      
      


}

?>