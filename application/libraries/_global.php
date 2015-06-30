<?php if(!defined('BASEPATH'))         exit('No direct script access allowed');
/**
 * Library
 *
 * Library que tendra funciones globales, a utilizar en el sistema
 *
 * @link                http://www.aragua.gob.ve
 * @filesource          ./application/libraries/global.php
 */
// ------------------------------------------------------------------------

/**
 * Clase global
 * 
 * funciones globales para el sistema
 * 
 * @package             GBA
 * @category    principal
 * @fecha       17-12-2010
 */
 class _global{
    public  $CI;
    public  $db;
    function  __construct() {
        $this->CI=& get_instance();
        $this->db=$this->CI->db;
    }


/******************* Database ********************************/

       function Obtener_Permisos($solo_especificos=false)
        {
            /** Variables en uso*/
                $user=$this->CI->session->userdata('xu');

              /** Primero se verifica si el usuario tiene permisos especificos para la clase que esta visitando*/
                  $this->db->select("substring(seguridad.user_privilegios.tipo from 4 for octet_length (seguridad.user_privilegios.tipo)) as table");
                  $tablas=$this->db->get_where("seguridad.user_privilegios",array("user"=>$user));
                  if($tablas->num_rows())
                    {
                      foreach($tablas->result_array() as $valor) 
                          {
                               $this->db->select("seguridad.user_privilegios.privilegios");
                               $this->db->from('seguridad.user_privilegios')->join("seguridad.".$valor["table"]."s", $valor["table"]."s".".id = seguridad.user_privilegios.id_comando  and (seguridad.user_privilegios.user='".$user."' and seguridad.".$valor["table"]."s.archivo='".$this->CI->router->class."')");
                               $id_privilegios=$this->db->get()->row_array();
                                if(!empty($id_privilegios))
                                  {
                                      return $this->buscar_botones_en_la_bd($id_privilegios);                                   
                                  }

                          }//fin foreach
                    }//fin si el usuario tiene algunas restricciones espeficias

               return  $this->privilegios_generales();
        }//fin Obtencion de los permisos para el programa o Funcion

        function  privilegios_generales() 
         {
                $tipos_de_busqueda=array("modulo","submodulo","programa");
              foreach($tipos_de_busqueda as $valor) 
                {
                    $this->db->select("seguridad.det_menu.privilegios");
                    $this->db->from('seguridad.'.$valor.'s')->join("seguridad.det_menu","seguridad.det_menu.id_".$valor."= seguridad.".$valor."s.id  and (seguridad.".$valor."s.archivo='".$this->CI->router->class."')");
                    $id_privilegios=$this->db->get()->row_array();
                        if(!empty($id_privilegios))
                          {
                              return $this->buscar_botones_en_la_bd($id_privilegios);                                     
                          }
                }//fin foreach
         }
        

        function buscar_botones_en_la_bd($id_privilegios)
        {
                  $this->db->from('seguridad.privilegios');
                  $this->db->where_in('id',explode(",",$id_privilegios["privilegios"]));  
                  $this->db->order_by("id", "asc"); 
              return $this->db->get()->result_array();
        }//fin buscar_botones_en_la_bd









//*********************
//fin library
// //*********************
 }
/** End of file _menu_body.php */
/** Location: ./application/libraries/_global.php */
