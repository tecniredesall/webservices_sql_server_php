<?php
/**
 * Library
 *
 * Library que genera el menu general, y el menu para cada sistema
 *
 * @package             GBA
 * @author              Gobierno Bolivariano de Aragua
 * @copyright   Copyright (c) 2009 - 2010, Gobierno Bolivariano de Aragua.
 * @link                http://www.aragua.gob.ve
 * @filesource		./application/libraries/cargar.php
 */
// ------------------------------------------------------------------------

/**
 * Clase carga
 * 
 * Generacion del menu
 * 
 * @package		GBA
  * @category    principal
 * @author	Jean Mendoza
 * @fecha	25-11-2010
 */
class Cargar_lib extends CI_Loader{

    private $CI;
    private $db;

    function  __construct() {
        parent::__construct();
        $this->CI=&get_instance();
        $this->db=$this->CI->db;
    }

    function include_library($ruta,$nombre="")
    {
        include_once(APPPATH."libraries/".$ruta);
    }

}

?>
