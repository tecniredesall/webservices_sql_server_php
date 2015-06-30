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

if ( ! function_exists('table'))
{
    

	function table($cmp_head=array(),$cmp_foot=array(),$data,$id_table="id_data_table",$opciones=array(),$obj_form=array(),$imprimir=false)
	{
            $obj=instancia_controller();
            //$obj_form=array("Check"=>array("tipo"=>"check","bsq"=>"bsq","valor"=>"id","arr_num"=>"id","obj"=>array("cfgObj"=>array("class"=>"req_check","grupo"=>"grp0","cntchecks"=>"1"),"modelo"=>"tal","nombre"=>"xys")));
           
            if(count($cmp_head)>0)
            {
                
                $colspan=0;
                if(count($opciones)>0){
                    $colspan=count($cmp_head)+count($obj_form)+1;
                }else
                {
                    $colspan=count($cmp_head);
                }

                echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="'.$id_table.'">';
                echo "<thead>";
                
                if($imprimir){
                    echo "<tr  valign='middle'><th colspan='".$colspan."' align='right' style='padding-top: 6px;padding-right: 20px;vertical-align: middle'>";
                    echo '<a target="_blank" href="'.base_url("index.php").$obj->ruta."/imprimir".'"><img width="18px" style="margin-left: 3px" title="Descargar Pdf" alt="Descargar Pdf" src="'.base_url().'img/icons/pdf.png"/></a>&nbsp';
                    echo    "</th></tr>";
                }
                
                echo "<tr>";
                
                foreach($cmp_head as $alias=>$value)
                {
                    echo "<th>$alias</th>";
                }
                foreach($obj_form as $alias=>$value)
                {
                    $extra="";
                    if($value['tipo']=="check")
                    {
                        $selectall=true;
                        if(isset($value['selectall']))
                        {
                            if($value['selectall']==true)
                            {
                                $selectall=true;
                            }else
                            {
                                $selectall=false;
                            }
                         }else
                         {
                            $selectall=true;
                         }

                        
                           
                            if($selectall==true)
                            {
                                
                            
                        $idExtra="id_all_".$value['obj']['nombre'];
                        $nameExtra="name_all_".$value['obj']['nombre'];
                        $grupoExtra=$value['obj']['cfgObj']['grupo'];
                        $extra='<input type="checkbox" id="'.$idExtra.'"   value="seleccionar" name="'.$nameExtra.'">';
$script =<<< EOD

    $('input[id=$idExtra]').change(function()
     {
         checked=$('input[id=$idExtra]:checked').length;

         $('span input[grupo="$grupoExtra"]').each( function() {

                        row=$(this).parent().parent().parent();
                        
                        removerClassError($(this).parent());
			if(checked == 1){
				this.checked = true;
                                row.addClass('row_selected');
			} else {
				this.checked = false;
                                row.removeClass('row_selected');
			}
		});
    });

EOD;
                    instancia_controller()->addjscss_lib->agregar_script($script);
                                echo "<th width='25px'>$extra</th>";
                            }else
                            {
                                echo "<th width='25px'>&nbsp;</th>";
                            }
                        
                    }
                    
                }
                if(count($opciones)>0)
                {
                        echo "<th>Opciones</th>";
                }

                echo "</tr>";
                
                
                
                if(count($obj_form)>0){}
                

                echo "</thead>";


                if(!(count($cmp_foot)>0))
                {
                    $cmp_foot=$cmp_head;
                }

                echo   '<tfoot>';
                echo "<tr>";
                 foreach($cmp_foot as $alias=>$value)
                    {
                        echo "<th>$alias</th>";
                    }
                    foreach($obj_form as $alias=>$value)
                    {
                        echo "<th>$alias</th>";
                    }
                    if(count($opciones)>0)
                    {
                        echo "<th>Opciones</th>";
                    }
                echo "</tr>";
                
                echo   '</tfoot>';


                if(count($data)>0)
                {
                    echo   '<tbody>';
                    foreach($data as $value)
                    {
                        echo "<tr id='$value->id'>";
                         foreach($cmp_head as $nombre)
                         {
                                    if(isset($value->$nombre))
                                    {
                                        echo '<td class="'.$nombre.'">'.$value->$nombre.'</td>';
                                    }else
                                    {
                                        echo '<td class="'.$nombre.'"></td>';
                                    }
                         }

                         foreach($obj_form as $index=>$val)
                         {
                             
                                        $valuesdb=array("ischeck"=>$value->$val["ischeck"],"bsq"=>$value->$val["bsq"],"valor"=>$value->$val["valor"],"arr_num"=>$value->$val['arr_num']);
                                        echo '<td style="text-align: center" >'.table_1_objformtable($val["tipo"],$val['obj'],$valuesdb).'</td>';
                                    
                         }
                         if(count($opciones)>0)
                         {
                            echo "<th>";
                            foreach($opciones as $alias=>$op)
                            {
                                    if($alias=="eliminar")
                                    {
                                            $parametros=array("baseurl"=>base_url("index.php")."/".$obj->ruta,"cmp"=>"id","href"=>"/eliminar/","src"=>base_url()."img/icons/delete.png","titulo"=>"Eliminar Registro","permiso"=>"t");
                                            
                                            if(count($op)>0)
                                            {
                                                param_link($op,$parametros);
                                                if(!isset($value->$parametros["cmp"]))
                                                {
                                                    $parametros["cmp"]="id";
                                                }
                                            }
                                                if($parametros["permiso"]=="t")
                                                {
                                                    echo '<a class ="elim_item_table"  href="'.$parametros["baseurl"].$parametros["href"].$value->$parametros["cmp"].'"><img width="15px" style="margin-left: 3px" title="'.$parametros["titulo"].'" alt="'.$parametros["titulo"].'" src="'.$parametros["src"].'"/></a>&nbsp';
                                                }
                                                
                                    }else
                                    if($alias=="actualizar")
                                    {

                                            $parametros=array("baseurl"=>base_url("index.php")."/".$obj->ruta,"cmp"=>"id","href"=>"/actualizar/","src"=>base_url()."img/icons/edit.png","titulo"=>"Actualizar Registro","permiso"=>"t");
                                            if(count($op)>0)
                                            {
                                                param_link($op,$parametros);
                                                if(!isset($value->$parametros["cmp"]))
                                                {
                                                    $parametros["cmp"]="id";
                                                }
                                            }
                                            
                                            if($parametros["permiso"]=="t")
                                                {
                                                    echo '<a href="'.$parametros["baseurl"].$parametros["href"].$value->$parametros["cmp"].'"><img width="15px" style="margin-left: 3px" title="'.$parametros["titulo"].'" alt="'.$parametros["titulo"].'" src="'.$parametros["src"].'"/></a>&nbsp';
                                                }
                                    }else
                                    if($alias=="url")
                                    {
                                        
                                    }else
                                    if($alias=="pdf")
                                    {

                                            $parametros=array("baseurl"=>base_url("index.php")."/".$obj->ruta,"cmp"=>"id","href"=>"/itemPdf/","src"=>base_url()."img/icons/pdf.png","titulo"=>"Imprimir Pdf","target"=>"_blank","permiso"=>"t");
                                            if(count($op)>0)
                                            {
                                                param_link($op,$parametros);
                                                if(!isset($value->$parametros["cmp"]))
                                                {
                                                    $parametros["cmp"]="id";
                                                }
                                            }
                                            if($parametros["permiso"]=="t")
                                                {
                                                    echo '<a target="'.$parametros["target"].'" href="'.$parametros["baseurl"].$parametros["href"].$value->$parametros["cmp"].'"><img  width="15px" style="margin-left: 3px" title="'.$parametros["titulo"].'" alt="'.$parametros["titulo"].'" src="'.$parametros["src"].'"/></a>&nbsp';
                                                }
                                    }else
                                    if($alias=="otro")
                                    {

                                            $parametros=array("baseurl"=>base_url("index.php")."/".$obj->ruta,"cmp"=>"id","href"=>"/itemPdf/","src"=>base_url()."img/icons/pdf.png","titulo"=>"Imprimir Pdf","target"=>"_blank","permiso"=>"t");
                                            if(count($op)>0)
                                            {
                                                param_link($op,$parametros);
                                                if(!isset($value->$parametros["cmp"]))
                                                {
                                                    $parametros["cmp"]="id";
                                                }
                                            }
                                            if($parametros["permiso"]=="t")
                                                {
                                                    echo '<a  class="item_otro_table" target="'.$parametros["target"].'" href="'.$parametros["baseurl"].$parametros["href"].$value->$parametros["cmp"].'"><img  width="15px" style="margin-left: 3px" title="'.$parametros["titulo"].'" alt="'.$parametros["titulo"].'" src="'.$parametros["src"].'"/></a>&nbsp';
                                                }
                                    }
                            }
                            echo "</th>"; 
                         }
                         echo "</tr>";
                    }
                    echo   '</tbody>';
                }
                echo '</table>';
            }

$scripts='

$("#'.$id_table.'").dataTable( {"sScrollY": 150,"bJQueryUI": true, "sPaginationType": "full_numbers" });
$("#'.$id_table.' input[type=\'checkbox\'].fnClick").on("change",function(event){

        
            row=$(this).parent().parent().parent();

            if ( row.hasClass("row_selected") ) {
                row.removeClass("row_selected");
            }
            else {
                row.addClass("row_selected");
            }

          


        });
$(".elim_item_table").on("click",function()
{
    retorno=confirm("Desea Eliminar El Registro");
    return retorno;
});
';
            $obj->addjscss_lib->agregar_script($scripts);
        }
}

if ( ! function_exists('param_link'))
{
    function param_link(&$vari,&$parm)
    {
        foreach($parm as $alias=>$value)
        {
            if(isset($vari["$alias"]))
            {
                if(!empty($vari["$alias"]) && $vari["$alias"]!="")
                {
                    $parm["$alias"]=$vari["$alias"];
                }
            }
        }
    }
    
}

if ( ! function_exists('table_basico'))
{

        function table_basico()
        {
            $obj=instancia_controller();
            table($obj->data['campos'],array(),$obj->data['datatabla'],'id_data_table',array(),array(),$obj->imprimir);
        }
        
        
}

if ( ! function_exists('table_basico_itemPdf'))
{

        function table_basico_itemPdf()
        {
            $obj=instancia_controller();
            table($obj->data['campos'],array(),$obj->data['datatabla'],'id_data_table',array("pdf"=>array()),array(),$obj->imprimir);
        }
        
        
}

if ( ! function_exists('table_crud_basico'))
{

        function table_crud_basico()
        {
            $obj=instancia_controller();
            table($obj->data['campos'],array(),$obj->data['datatabla'],'id_data_table',array("eliminar"=>array(),"actualizar"=>array()),array(),$obj->imprimir);
        }
}



if ( ! function_exists('table_crud_permisologia'))
{
        function table_crud_permisologia()
        {
            $obj=instancia_controller();
            table($obj->data['campos'],array(),$obj->data['datatabla'],'id_data_table',array("eliminar"=>array("permiso"=>$obj->eliminar),"actualizar"=>array("permiso"=>$obj->modificar)),array(),$obj->imprimir);
        }
}


if ( ! function_exists('table_crud_basico_itemPdf'))
{

        function table_crud_basico_itemPdf()
        {
            $obj=instancia_controller();
            table($obj->data['campos'],array(),$obj->data['datatabla'],'id_data_table',array("eliminar"=>array(),"actualizar"=>array(),"pdf"=>array()),array(),$obj->imprimir);
        }
}


if ( ! function_exists('table_crud_basico_obj'))
{

        function table_crud_basico_obj($obj_form=array())
        {
            $obj=instancia_controller();
            table($obj->data['campos'],array(),$obj->data['datatabla'],'id_data_table',array("eliminar"=>array(),"actualizar"=>array()),$obj_form);
        }
}

if ( ! function_exists('table_basico_obj'))
{

        function table_basico_obj($obj_form=array())
        {
            $obj=instancia_controller();
            table($obj->data['campos'],array(),$obj->data['datatabla'],'id_data_table',array(),$obj_form);
        }
}




if ( ! function_exists('table_1_objformtable'))
{

        function table_1_objformtable($tipo,$parametros,$valuesObj)
        {
            
            if($valuesObj["ischeck"]=="t"){
            switch ($tipo){
            case 'check' :
                instancia_controller()->autoload['independiente'][$parametros['modelo']][$parametros['nombre']]=$valuesObj['bsq'];
                $obHtml=form_checkbox_autoload($parametros['cfgObj'],$valuesObj['valor'],FALSE,'',array('modelo'=>$parametros['modelo'],'autoload'=>TRUE,'name'=>$parametros['nombre'],'arr1'=>$valuesObj['arr_num']));
                return $obHtml;
                break;
            case 'text' :
                instancia_controller()->autoload['independiente'][$parametros['modelo']][$parametros['nombre']]=$valuesObj['bsq'];
                //$obHtml=form_input_autoload(array("class"=>'req_txt mask_cedula form','size' => '40', 'maxlength' => '12'),'','',array('modelo'=>instancia_controller()->modelo,'name'=>'cedula'));
                $obHtml=form_input_autoload($parametros['cfgObj'],$valuesObj['valor'],'',array('modelo'=>$parametros['modelo'],'name'=>$parametros['nombre'],'arr1'=>$valuesObj['arr_num']));
                //$obHtml=form_checkbox_autoload($parametros['cfgObj'],$valuesObj['valor'],FALSE,'',array('modelo'=>$parametros['modelo'],'autoload'=>TRUE,'name'=>$parametros['nombre'],'arr1'=>$valuesObj['arr_num']));
                return $obHtml;
                break;
            default:
                break;
            }
            
            }else
            {
                return "";
            }
        }
}



if ( ! function_exists('table_1_objcheck'))
{
    function table_1_objcheck($nmbcolum,$bsq,$valor,$arr_num,$grupo,$modelo,$nombre,$cntcheck=1)
    {
        return array("$nmbcolum"=>array("tipo"=>"check","bsq"=>"$bsq","valor"=>"$valor","arr_num"=>"$arr_num","obj"=>array("cfgObj"=>array("class"=>"req_check","grupo"=>"$grupo","cntchecks"=>"$cntcheck"),"modelo"=>"$modelo","nombre"=>"$nombre")));
    }
}


if ( ! function_exists('table_1_objtext'))
{
    function table_1_objtext($nmbcolum,$bsq,$valor,$arr_num,$modelo,$nombre,$mascara="",$req="req_txt",$maxlength=20,$size=20,$class="")
    {
        return array("$nmbcolum"=>array("tipo"=>"text","bsq"=>"$bsq","valor"=>"$valor","arr_num"=>"$arr_num","obj"=>array("cfgObj"=>array("class"=>"$req $mascara $class",'size' => $size, 'maxlength' => "$maxlength"),"modelo"=>"$modelo","nombre"=>"$nombre")));
    }
}








/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */