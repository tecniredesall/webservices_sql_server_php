<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('plantilla'))
{
	function plantilla($plantilla,$vista, $datos_content = null,$datos_partes=null)
	{
		$obj =& get_instance();
                $data_partes['plantilla']=$plantilla;

                $content=null;
                if($datos_content!=null){
                    $content['content']=array_merge((array) $datos_content,(array) $data_partes,array('vista'=>$vista));
                }else
                {
                    $content['content']=array_merge((array) $data_partes,array('vista'=>$vista));
                }
                $data_partes['content']=$content;
                $data['data_global']=$data_partes;
                $obj->load->view("templates/$plantilla/$plantilla",$data);
	}
}

if ( ! function_exists('data_json'))
{
	function data_json($datos_content = null)
	{
                if($datos_content!=null)
                {
                    $obj =& get_instance();
                    $content['content']=(array) $datos_content;
                    $obj->load->view("templates/json/json",$content);
                }       
	}
}


if ( ! function_exists('instancia_controller'))
{
	function instancia_controller()
	{
                $obj =& get_instance();
		return $obj;
	}
}


if ( ! function_exists('controller_actual'))
{
	function controller_actual()
	{
                $obj =& get_instance();
		return $obj->router->class;
	}
}




/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */