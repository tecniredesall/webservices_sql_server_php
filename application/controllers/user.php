<?php


class User extends CI_Controller{

      function __construct(){
         parent::__construct();
      }



      public function index()
      {
            redirect("user/login");
      }

      public function test()
      {
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
           if($varii=in_post(array("acceso")))
           {
              
              $clave= encriptarClave($varii["clave"]);
              
              $respuesta = $this->basicauth->login($varii["usuario"],$clave);
              if (!isset($respuesta['error']))
              {
                    redirect("jsonweb/query");
              }
              else 
              {
                  echo "ERRLOGIN";
              }
           }else
           {
               echo "SINPARAM";   
           }   
      }

      function salir($desconectado=1)
      {
          redirect("user/login");
      }
      
      


}

?>