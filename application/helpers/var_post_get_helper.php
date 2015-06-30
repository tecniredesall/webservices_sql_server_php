<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*

 * ************************************************************************************************************
 *
 * REF-CODIGO: NINGUNA
 * CODIGO    : FN_001
 * CREADO POR: FREDDY HIDALGO
 * NOMBRE    : in_post
 * ARGUMENTOS:
 *              - $keys=recibe un arreglo o un string
 * USO       : Esta Funcion recibe una variable de tipos arreglo o string y la busca en el arreglo $_POST,
 *             si es en un string verifica si existe y la devuelve, si es un arreglos de claves, entonces busca las claves
 *             por orden de poscision de manera recursiva al llegar al final devuelve el valor
 * RETORNA   : String , Arreglo, null
 *
 * ************************************************************************************************************

 */

if ( ! function_exists('in_post'))
{
	function in_post($keys=null)
	{
            if(isset($_POST))
            {
                if($keys!=null)
                {
                    return in_bsq_array_keys($_POST,$keys);
                }else
                {
                    return $_POST;
                }
            }else
            {
                return null;
            }

        }
}


if ( ! function_exists('in_get'))
{
	function in_get($keys=null)
	{
            if(isset($_GET))
            {
                if($keys!=null)
                {

                    return in_bsq_array_keys($_GET,$keys);
                }else
                {
                    return $_GET;
                }
            }else
            {
                return null;
            }

        }
}



/*

 * ************************************************************************************************************
 *
 * REF-CODIGO: FN_001
 * CODIGO    : FN_002
 * CREADO POR: FREDDY HIDALGO
 * NOMBRE    : in_bsq_array_keys
 * ARGUMENTOS:
 *              - $array= arreglo (inicialmente POST)
 *              - $keys=recibe un arreglo o un string
 * USO       : es la funcion recursiva para encontrar el valor (ver referencia)
 * RETORNA   : String , Arreglo, null
 *
 * ************************************************************************************************************

 */










/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */