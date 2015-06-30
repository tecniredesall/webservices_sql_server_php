<?php

class Basicauth
{
  
  
  public $table="seguridad.usuarios"; 
  function __construct()
  {
      $this->CI = & get_instance();
  }

  function login($usuario, $password){
      
      $data = array();
      $row_user=$this->CI->db->get_where('seguridad.usuarios',array('usuario'=>$usuario));
      $user=$row_user->row_array();
      if(!empty($user))
      {
          
          if($user["intentos"]=="3" || $user['estatus']=='true')
          {
                $this->CI->db->update("$this->table",array("estatus"=>"false"),array("usuario"=>$usuario));
                $data['error'] = 'Usuario Bloqueado por maximo de intentos';
          }else
          {
              
              if(trim($user["clave"])==trim($password))
              {
                        $rs=$this->CI->db->query("select now() as tiempo");
                        $tiempo=$rs->row()->tiempo;
                        $this->CI->db->insert("seguridad.conexion",array("usuarios_id"=>$user["id"],"fecha_conexion"=>"'".$tiempo."'",'ip'=>$this->CI->input->ip_address(),"browser"=>$this->CI->input->user_agent()));
                        $rs1=$this->CI->db->get_where("seguridad.conexion",array("usuarios_id"=>$user["id"],"fecha_conexion"=>"'".$tiempo."'"));
                        if($this->CI->session->sess_read())
                        {
                            $this->CI->session->sess_destroy();
                        }
                        $this->CI->session->sess_create();
                        $this->CI->session->set_userdata(array('logged_in'=> true, 'usuario'=> $usuario, 'usuario_id'=> $row_user->row()->id,'rol_id'=>$user['rol_id'],"conexion_id"=>$rs1->row()->id));
              }
              else 
              {
                       echo $data['error'] = 'Usuario o Contraseña incorrectaaa';
                        $this->CI->db->update("$this->table",array("intentos"=>$user["intentos"]+1),array("usuario"=>$usuario));
              }   
          }
          
      }else
      {
         echo  $data['error'] = 'Usuario o Contraseña incorrecta';
      }
      
       return $data;
   }
   
   function logout($fin_sistema=1)
   {
        if($fin_sistema==1)
        {
            $this->CI->load->model("admin/auditoria_model","seg");
            $this->CI->seg->registro("Login","Fin Session",$this->CI->sesslg->userdata("usuario_id"),-1,-1);
            $this->CI->seg->finTime();
            $this->CI->db->update("seguridad.conexion",array("fecha_desconexion"=>"now()","conectado"=>"false"),array("id"=>$this->CI->sesslg->userdata("conexion_id")));
        }
 
   }
   
   
   
}




?>