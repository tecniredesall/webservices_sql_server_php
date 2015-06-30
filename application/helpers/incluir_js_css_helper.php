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


if ( ! function_exists('add_js'))
{
	function add_js($js,$ruta=NULL,$out=FALSE)
	{
		$obj =& get_instance();
                if($ruta==NULL){
                    $ruta=base_url()."js/$js.js";
                }else
                {
                    $ruta=base_url()."js/$ruta/$js.js";
                }
                $javascript="<script src='".$ruta."' language='javascript' type='text/javascript'></script>";
                if($out==TRUE)
                {
                    echo $javascript;
                }else
                {

                    $obj->addjscss_lib->agregarjs($javascript);
                }
	}
}

if ( ! function_exists('add_js_vst'))
{
	function add_js_vst($js,$ruta=NULL)
	{

            if($ruta==NULL){
                    add_js($js,"vistas");
                }else
                {
                    add_js($js,"vistas/$ruta");
                }
		
	}
}

if ( ! function_exists('add_js_vst_libs'))
{
	function add_js_libs($js,$ruta=NULL,$out=FALSE)
	{

                if($ruta==NULL){
                    add_js($js,"libs",$out);
                }else
                {
                    add_js($js,"libs/$ruta",$out);
                }
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ( ! function_exists('add_css'))
{
	function add_css($css,$ruta=NULL,$out=FALSE,$media="screen")
	{
		$obj =& get_instance();
                if($ruta==NULL){
                    $ruta=base_url()."css/$css.css";
                }else
                {
                    $ruta=base_url()."css/$ruta/$css.css";
                }
                $css="<link type='text/css' rel='stylesheet' href='".$ruta."'  media='".$media."'/>";
                if($out==TRUE)
                {
                    echo $css;
                }else {
                    $obj->addjscss_lib->agregarcss($css);
                }
                
	}
}


if ( ! function_exists('add_css_vst'))
{
	function add_css_vst($css,$ruta=NULL)
	{
                add_css($css,'vistas');
	}
}



if ( ! function_exists('add_css_libs'))
{
	function add_css_libs($css,$ruta=NULL,$out=FALSE,$media="screen")
	{
            
                if($ruta==NULL){
                    add_css($css,'libs',$out,$media);
                    
                }else
                {
                    
                    add_css($css,"libs/$ruta",$out,$media);
                }
                
	}
}



/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */