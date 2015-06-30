<?php if(!defined('BASEPATH'))         exit('No direct script access allowed');
/*
ojo esta libreria depende de la vista que se llama v_accesos y su definicion es:
CREATE VIEW accesos_v AS SELECT  usuarios.usuario,
        perfil_menu.perfil_id,
        perfil_menu.modulo_id,
        modulo.nombre as modulo,
        modulo.ruta as rmodulo,
        modulo.icono as imodulo,
        perfil_menu.submodulo_id,
        submodulo.nombre as submodulo,
        submodulo.ruta as rsubmodulo,
        submodulo.icono as isubmodulo,
        perfil_menu.programa_id,
        programa.nombre as programa,
        programa.ruta as rprograma,
        programa.icono as iprograma  
     FROM  usuarios
     JOIN  perfil_persona  ON usuarios.id=perfil_persona.persona_id
     JOIN  perfil ON perfil_persona.perfil_id= perfil.id
     JOIN  perfil_menu ON perfil.id= perfil_menu.perfil_id
     JOIN  modulo ON perfil_menu.modulo_id=modulo.id
     LEFT JOIN  submodulo ON perfil_menu.submodulo_id=submodulo.id
     LEFT JOIN  programa ON perfil_menu.programa_id=programa.id
     ORDER BY usuarios.usuario,modulo.nombre, submodulo.nombre, programa.nombre

*/

class _menufinal{
    private $user;
    private $CI;
    private $db;
    private $i;
    private $modulos;
    private $submodulos;
    private $programas;
    private $menu_final;
    
    function  __construct() {
        $this->CI=& get_instance();
        $this->db=$this->CI->db;
    }

    public  function _crear_maquetado_menu($modelo_menu="menu",$i=7){
           
            $this->user=$this->CI->session->userdata('usuario');
            $this->i=$i;//inicializacion del menu
            $this->menu_final='<ul  class="menu" id="'.$modelo_menu.'">';
            if($modelo_menu==="menu")
                {
                  $this->menu_final.='<li><a href="'.base_url().'index.php/home" class="parent"><span>Principal</span></a></li>';
                }//fin if($modelo_menu==="menu" && $id_divMenu==="menuDiv")
                    $this->modulos=$this->_obtener_modulos();
                    if($this->modulos->num_rows()>0){//si existen modulos
                        foreach($this->modulos->result_array() as $key_modulos=>$value_modulos){//funciona
                             $this->menu_final.='<li><a href="'.base_url().'index.php/'.$value_modulos["rmodulo"].'" class="parent"><span>'.$value_modulos["modulo"].'</span></a>';
                             $this->submodulos=$this->_obtener_submodulos($value_modulos["modulo_id"]);//funciona
                               if($this->submodulos->num_rows()>0){
                                    $this->menu_final.='<ul>'; 
                                    foreach($this->submodulos->result_array() as $key_submodulos=>$value_submodulos){
                                         $this->programas=$this->_obtener_programas($value_submodulos["submodulo_id"]);//funciona
                                         $class=($this->programas->num_rows()>0)?"parent":"";
                                         $this->menu_final.='<li><a href="'.base_url().'index.php/'.$value_submodulos["rsubmodulo"].'" class="'.$class.'"><span>'.$value_submodulos["submodulo"].'</span></a>';

                                          if($this->programas->num_rows()>0){
                                            
                                                $this->menu_final.='<ul>';
                                                
                                                foreach($this->programas->result_array() as $key_programas=>$value_programas){//funciona
                                                    
                                                    $this->menu_final.='<li><a href="'.base_url().'index.php/'.$value_programas["rprograma"].'"><span>'.$value_programas["programa"].'</span></a></li>';
                                                }
                                                $this->menu_final.='</ul>'; 
                                          }else{
                        
                                            $this->menu_final.='</li>';
                                          }
                                    }
                                    $this->menu_final.='</ul>'; 
                               }else{
                                    $this->menu_final.='</li>';
                               }
                             //$link=($this->submodulos->num_rows()>0)?"#":$value_modulos["rmodulo"];
                             
                        }
                    
                    }  
        $this->menu_final.='<li><a href="#" class="parent" title="Ayuda"><span>Ayuda</span></a></li>
                            <li><a href="'.base_url().'index.php/user/logout" title="cerrar"><span>Cerrar Sesión</span></a></li>
                            <li class="parent" style="margin-left: 80px;"><a class="usuario"><span> Usuario: '.$this->user.'</span></a></li>
                            <li><a href="#" class="last calendario_button" title="Calendario" ><i class="icon icon-calendar icon-white " style="margin-bottom: 20px;margin-top: 12px;"></i></a></li>';            
                                                  
        $this->menu_final.='</li></ul>';
       
    }
    
    //---------------------------------------------------------------------------------------------------------------------------------

        /**
          * Metodos Getters y Setters
        */
        public function getMenu() {
            return $this->menu_final;
        }

//---------------------------------------------------------------------------------------------------------------------------------

        public function setMenu($menu){
            $this->menu_final = $menu;
        }

//---------------------------------------------------------------------------------------------------------------------------------

      /**
      *Estas seran la funciones de la logica de negocios, 
      *que deberian estar en un modelo, claro si este archivo fuera un controller
      *pero como es una libreria, debe estar todo junto, para que el dia que yo quiera elimnar esta libreria 
      *lo haga sin preocupaciones que la misma tenga dependencia con modelos u otros archivos
      */  

//---------------------------------------------------------------------------------------------------------------------------------

       private function   _obtener_modulos(){
                $this->db->distinct();
                $this->db->select('modulo_id,modulo,rmodulo,imodulo');
                $this->db->order_by("modulo_id");
                return $this->db->get_where('accesos_v',array("usuario"=>$this->user));
      }//fin obterner_modulos  

//---------------------------------------------------------------------------------------------------------------------------------
 
       private function   _obtener_submodulos($modulo_id){
                $this->db->distinct();
                $this->db->select('submodulo_id,submodulo,rsubmodulo,isubmodulo');
                $this->db->order_by("submodulo_id");
                return $this->db->get_where('accesos_v',array("usuario"=>$this->user,"modulo_id"=>$modulo_id,"submodulo_id is not null"=>null,"submodulo is not null"=>null));
      }//fin obterner_modulos   

//---------------------------------------------------------------------------------------------------------------------------------

       private function   _obtener_programas($submodulo_id){
                $this->db->distinct();
                $this->db->select('programa_id,programa,rprograma,iprograma');
                $this->db->order_by("programa_id,programa");
                return $this->db->get_where('accesos_v',array("usuario"=>$this->user,"submodulo_id"=>$submodulo_id,"programa_id is not null"=>null,"programa is not null"=>null));
      }//fin obterner_modulos   

//---------------------------------------------------------------------------------------------------------------------------------


       /*private function   _obterner_restricciones($table,$clase){
                $this->db->select("seguridad.user_privilegios.privilegios");
                $this->db->from('seguridad.user_privilegios')->join("seguridad.".$table."s", $table."s".".id = seguridad.user_privilegios.id_comando  and (seguridad.user_privilegios.user='".$this->user."' and seguridad.".$table."s.archivo='".$clase."' and seguridad.user_privilegios.tipo='id_".$table."')");
                $id_privilegios=$this->db->get()->row_array();
                return (isset ($id_privilegios["privilegios"]) )?$id_privilegios["privilegios"]:true;
      }//fin obterner_modulos*/
 
    
}//fin class _menufinal{