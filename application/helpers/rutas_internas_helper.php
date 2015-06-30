<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('add_js_template'))
{
	function add_js_template($template,$archivo)
	{
		$obj =& get_instance();
                $ruta=base_url()."js/templates/$template/$archivo.js";
                $javascript="<script src=".$ruta." language='javascript' type='text/javascript' ></script>";
                echo $javascript;
	}
}


if ( ! function_exists('add_css_template'))
{
	function add_css_template($template,$archivo)
	{
                $obj =& get_instance();
                $ruta=base_url()."css/templates/$template/$archivo.css";
                $css="<link media='screen' type='text/css' rel='stylesheet' href=".$ruta."></link>";
                echo $css;
	}
}



/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */