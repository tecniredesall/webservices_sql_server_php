<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




if ( ! function_exists('in_bsq_array_keys'))
{

    function in_bsq_array_keys($array,$keys)
    {

        if(is_array($array) && is_array($keys))
        {
            $keys=arr_val_eq_keys($keys);
            $cnt=count($keys);
            foreach($keys as $k=>$values)
            {

                if(isset($array["$values"]))
                {
                    if($cnt==1)
                    {
                        return $array["$values"];
                    }else
                    {
                        unset($keys["$values"]);
                        return in_bsq_array_keys($array["$values"],$keys);
                    }

                }else
                {
                    return null;
                }

            }
        }else
        {

            if(isset($array["$keys"]))
            {
                return $array["$keys"];
            }else
            {
                return null;
            }

        }
    }

}



/*

 * ************************************************************************************************************
 *
 * REF-CODIGO: NUNGUNA
 * CODIGO    : FN_002
 * CREADO POR: FREDDY HIDALGO
 * NOMBRE    : arr_val_eq_keys
 * ARGUMENTOS:
 *              - $array= arreglo de solo valores

 * USO       : Esta funcion recie un arreglo de valores, y crea la clave igual que el valor, lo cual lo convierte
 *             en un arreglo asociativo par clave-valor identicos
 * RETORNA   : Arreglo, null
 *
 * ************************************************************************************************************

 */

if ( ! function_exists('arr_val_eq_keys'))
{
    function arr_val_eq_keys($array)
    {
        if(is_array($array))
        {
            $arr=array();
            foreach($array as $val)
            {
                $arr=array_merge($arr, array("$val"=>"$val"));
            }
            return $arr;
        }else
        {
            return null;
        }

    }


}



// cambiar de este lugar

if ( ! function_exists('cmpArrSobrescribir'))
{

    function cmpArrSobrescribir(&$array1,$array2)
    {
        if(!empty ($array1) && !empty ($array2))
        {
            foreach ($array1 as $key=>$valor)
            {
                $valorArray2=in_bsq_array_keys($array2, $key);
                if(!is_null($valorArray2))
                {
                    $array1[$key]=$valorArray2;
                }
            }
        }
    }

}





function get_real_ip()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }
    }
    
    
    
    
function verificarClave($clave,$clave1,&$error_clave)
    {
    
        $salir=true;
        if($clave!=$clave1)
        {
                $error_clave="Las claves deben ser iguales";
                $salir=false;
        }else{
            
                
                $error_clave="";
                if(strlen($clave) < 6){
                    $error_clave.= "La clave debe tener al menos 6 caracteres<br/>";
                    $salir=false;
                }
                if(strlen($clave) > 16){
                    $error_clave.= "La clave no puede tener más de 16 caracteres<br/>";
                    $salir=false;
                }
                if (!preg_match('`[a-z]`',$clave)){
                    $error_clave.= "La clave debe tener al menos una letra minúscula<br/>";
                    $salir=false;
                }
                if (!preg_match('`[A-Z]`',$clave)){
                    $error_clave.= "La clave debe tener al menos una letra mayúscula<br/>";
                    $salir=false;
                }
                if (!preg_match('`[0-9]`',$clave)){
                    $error_clave.= "La clave debe tener al menos un caracter numérico<br/>";
                    $salir=false;
                }
                if($salir==false)
                {
                        $error_clave="El usuario no fue Registrado<br/>".$error_clave;
                        
                }
                return $salir;
        } 
        
    }
    
    
    function encriptarClave($clave)
    {
        $clave1=md5($clave).substr(sha1($clave),5,10);
        return $clave1;
    }








/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */