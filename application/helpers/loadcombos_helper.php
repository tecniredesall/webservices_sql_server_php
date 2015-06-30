<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('load_cmb'))
{
        function load_cmb($modelo,$campos=array(),$function="",$params=array())
        {
            if($modelo!="" && !empty($campos) && count($campos)>=2)
            {
                $obj=instancia_controller();
                $vari="cmb_".$modelo;
                $obj->load->model($modelo."_model",$vari);
                $obj->$vari->id=$campos[0];
                $obj->$vari->valor=$campos[1];
                
                if($function=="")
                {
                    
                    $rs=$obj->$vari->getCmb();
                    
                    
                    return crear_array_cmb($rs,$campos);
                    
                }else
                {
                    if(empty($params))
                    {
                        
                        $rs=$obj->$vari->$function();
                        return crear_array_cmb($rs,$campos);
                    }else
                    {
                        
                        $rs=$obj->$vari->$function($params);
                        return crear_array_cmb($rs,$campos);
                    }
                }

            }else
            {
                return array();
            }
        }
}


if ( ! function_exists('crear_array_cmb'))
{
        function crear_array_cmb($result=array(),$campos)
        {
            $data=array();
            if(!empty($result))
            {
                
                foreach($result as $value)
                {
                    $id=$value->$campos[0];
                    $id="$id"." ";
                    $data=array_merge($data, array($id=>$value->$campos[1]));
                }
            }
          
            return $data;
        }

}
















/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */