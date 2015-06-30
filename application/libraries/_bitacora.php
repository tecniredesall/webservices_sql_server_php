<?php
if(!defined('BASEPATH'))         exit('No direct script access allowed');
/**
 * Library
 *
 * Library para generar bitacora de todos los registros  del sistema

 * @link                http://www.aragua.gob.ve
 * @filesource		./application/libraries/bitacora.php
 */
// ------------------------------------------------------------------------

/**
 * Clase Bitacora
 *
 * Generar Bitacora
 *
  * @category    principal
 * @author	Keyla Bullon
 * @fecha	25-02-2011
 */



class _Bitacora{
    
   public  $CI;
    public  $db;
    function  __construct() {
        $this->CI=& get_instance();
        $this->db=$this->CI->db;
    }

    function generar($params=null){//recibir accion,last_query
       
        $params["usr_accion"]=$this->CI->session->userdata("usuario");
	$params["ip"]=$this->CI->session->userdata("ip_address");
        $params["fch_accion"]=date("Y-m-d H:i:s");
	$params["navegador"]=$this->CI->session->userdata("user_agent");
	
        //$params["modulo"]= $this->uri->slash_segment(1).$this->uri->slash_segment(2);
        $this->db->insert('bitacora',$params);

    }//fin generar
    


}//fin class Bitacora  {
?>
