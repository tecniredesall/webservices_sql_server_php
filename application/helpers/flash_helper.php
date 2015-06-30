<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*

 * ************************************************************************************************************
 *
 * REF-CODIGO: NINGUNA
 * CODIGO    : FN_001
 * CREADO POR: FREDDY HIDALGO
 * NOMBRE    : flash
 * ARGUMENTOS:
 *              - $keys=recibe un arreglo o un string
 * USO       : Esta Funcion recibe una variable de tipos arreglo o string y la busca en el arreglo $_POST,
 *             si es en un string verifica si existe y la devuelve, si es un arreglos de claves, entonces busca las claves
 *             por orden de poscision de manera recursiva al llegar al final devuelve el valor
 * RETORNA   : String , Arreglo, null
 *
 * ************************************************************************************************************

 */

if ( ! function_exists('flash'))
{
	function flash($class,$msj,$tipo,$img)
	{
            if($tipo==FALSE)
            {
                $tipo="st";
            }else
            if($tipo==TRUE)
            {
                $tipo="dy";
            }
            
            $html=<<<EOD
                    <div class="$class flash $tipo">
                     <table>
                        <tr>
                            <td valign="top" align="right" height="24px"><img alt="" src="$img" height='24px' /></td>
                            <td valign="middle" align="left">$msj</td>
                        <tr>
                     </table>
                     </div>
EOD;
                return $html;
        }

}

if ( ! function_exists('msj_exitoso'))
{
	function msj_exitoso($msj,$out=FALSE,$tipo=TRUE,$img=null)
	{
            if($img==null)
            {
                $img=base_url()."/img/iconos/valid.png";
            }
            if($out==FALSE)
            {
                $obj=instancia_controller();
                $obj->flash.=flash("valid",$msj,$tipo,$img);
            }else
            if($out==TRUE)
            {
                return flash("valid",$msj,$tipo,$img);
            }
        }
}


if (! function_exists('msj_error'))
{
	function msj_error($msj,$out=FALSE,$tipo=TRUE,$img=null)
	{
            if($img==null)
            {
                $img=base_url()."/img/iconos/error.png";
            }
           if($out==FALSE)
            {
                $obj=instancia_controller();
                $obj->flash.=flash("error",$msj,$tipo,$img);
            }else
            if($out==TRUE)
            {
                return flash("error",$msj,$tipo,$img);
            }
        }
}

if (! function_exists('imprimir_msj'))
{
	function imprimir_msj()
	{
            $obj=instancia_controller();
            echo $obj->flash;
            $obj->flash="";
        }
}














/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */