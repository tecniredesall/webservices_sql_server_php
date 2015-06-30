<?php if(!defined('BASEPATH'))         exit('No direct script access allowed');

class MY_Crud extends CI_Controller{

    public $autoload;
    public $rutamodelo;
    public $modelo;
    public $ruta;
    public $plantilla;
    public $vista;
    public $flash;
    public $accion="/insertar";
    public $data;
    public $erroresbd=array();
    public $db_exception=FALSE;
    public $campos;
    public $agregarCss=FALSE;
    public $agregarJs=FALSE;
    public $objSubClass=null;
    public $atras="";
    public $adelante="";
    
    public $limpiar="/limpiar";
    public $btnLimpiar="";
    public $session_id;
    public $fnActualizar="getList";
    
    
    
    public $imprimir=false;
    public $usuario_id='-1';
    
    public $nombrePrg="NO DEFINIDO";
    public $panelId="-1";
    public $nivel="-1";
    
    public $agregar=false;
    public $modificar=false;
    public $eliminar=false;
    
    public $modePrg=true;
    
    

    function  __construct()
    {
            
            parent::__construct();
            if(!isset($this->sesslg))
            {
                    $this->load->library("session",array("sess_cookie_name"=>"sslg","sess_expiration"=>0),"sesslg");
            }
            
            $this->btnLimpiar=controller_actual()."/limpiar";
            $this->limpiar=$this->ruta;
            $this->load->model("admin/auditoria_model","seg");
            
            $fin_sistema=$this->sesslg->userdata("existe");
            if(!$this->seg->verificarConexion($fin_sistema))
            {
                        if($fin_sistema==false)
                        {
                            redirect("user/salir/0");
                        }else
                        {
                            redirect("user/salir/1");
                        }
                        
            }
            if($this->session->userdata('logged_in')!=true && $this->router->method != 'login')
            {
                redirect ('user/login');
            } 
            
            if($this->ruta!="/menu" && $this->modePrg==false)
            {
                
                $this->usuario_id=$this->session->userdata("usuario_id");
                $data=$this->seg->buscarIdPnl($this->usuario_id, $this->objSubClass->ruta);

                if($data->num_rows() > 0)
                {   
                    $row=$data->row();
                    $this->panelId=$row->programa_id;
                    $this->nombrePrg=$row->nombre_programa;
                    $this->nivel=$row->nivel;
                    $this->agregar=$row->agregar;
                    $this->modificar=$row->modificar;
                    $this->eliminar=$row->eliminar;

                }else
                {
                    msj_error("Usted no tiene permiso para Accesar al Programa anterior");
                    $this->session->set_userdata(array("flash"=>$this->flash));
                    redirect("/menu");
                }

                if($this->session->userdata("panel_id")!=$this->panelId)
                {
                    $this->seg->registro($this->nombrePrg,"Acceso",$this->usuario_id,$this->panelId,$this->nivel);
                    $this->session->set_userdata(array("panel_id"=>$this->panelId));
                }
            }
            
           
    

            $this->load->model($this->rutamodelo.$this->modelo,"mod");
            
            if($this->session->userdata("autoload")!="")
            {
                $id_Update=$this->session->userdata("autoload");
                $id=-1;
                foreach ($id_Update as $key=>$value)
                {
                    if($key=="$this->modelo")
                    {
                        $id=$value['id'];
                    }
                    $function=$value['function'];
                    $this->autoload["$key"]=$this->mod->$function($value['id']);
                }

                $this->accion="/actualizar/$id";
            }
            if($this->session->userdata("flash")!="")
            {

                $this->flash=$this->session->userdata("flash");
                
            }
            $this->session->unset_userdata("autoload");
            $this->session->unset_userdata("flash");

    }

    public function cargarTabla()
    {
         $this->load->helper("tables/table_1");
         add_js_libs("jquery.dataTables","jquery/plugins/DataTables-1.10.3/media/js");
         add_css_libs("demo_table_jui","jquery/plugins/DataTables-1.10.3/media/css");
         //add_css_libs("jquery.dataTables_themeroller","jquery/plugins/DataTables-1.10.3/media/css");

    }
    

    
    public function json()
    {
        $modelo=in_post("modelo");
        $function=in_post("function");
        $padre_id=in_post("padre_id");
        $parametros=in_post("parametros");
        
        if(!is_null($parametros) && is_array($parametros))
        {
                $parametros=array_merge($parametros,array("cmpBsq"=>$padre_id));
        }else
        {
            $parametros=$padre_id;
        }
        
        $data['json']=array();
        if($modelo!="" && $function!="" && $padre_id!="0" && $modelo!=null && $function!=null && $padre_id!=null)
        {
            $this->load->model($modelo,"modulo");
            $data['json']=$this->modulo->$function($parametros);
        }
        data_json($data);
    }

    public function limpiar()
    {
        $this->session->unset_userdata("varTmp");
        redirect($this->limpiar);
    }


    public function insertar()
    {
        if($this->agregar=="t" || $this->modePrg==true)
        {
            if($varii=in_post(array($this->modelo)))
            {
                $insertar=$this->mod->insertar($varii);
                if($insertar[0]==true && empty($this->erroresbd))
                {
                    if($this->modePrg==false)
                    {
                         $this->seg->registro($this->nombrePrg,"Insertar",$this->usuario_id,$this->panelId,$this->nivel);
                    }
                    $this->objSubClass->insertarExito();
                }else
                {
                    $this->objSubClass->insertarError();
                }
            }else
            {
                $this->erroresbd[1]="1";
                $this->objSubClass->insertarError();
            }
            $this->session->set_userdata(array("flash"=>$this->flash));

        }else
        {
            msj_error("Usted no tiene permiso para Agregar Registros");
            $this->session->set_userdata(array("flash"=>$this->flash));
        }
        redirect($this->ruta);
    }


    public function eliminar($id)
    {
            if($this->eliminar=="t" || $this->modePrg==true)
            {
                    $eliminar=$this->mod->eliminar(array("id"=>$id));

                    if($eliminar[0]==true && empty($this->erroresbd))
                    {
                        $this->seg->registro($this->nombrePrg,"Eliminar",$this->usuario_id,$this->panelId,$this->nivel);
                        $this->objSubClass->eliminarExito($id);
                    }else
                    {
                        $this->objSubClass->eliminarError($id);
                    }
                    $this->session->set_userdata(array("flash"=>$this->flash));
            }else
            {
                msj_error("Usted no tiene permiso para Eliminar Registros");
                $this->session->set_userdata(array("flash"=>$this->flash));
            }
            redirect($this->ruta);
    }

    
      public function actualizar($id)
        {
          if($this->modificar=="t" || $this->modePrg==true)
            {
                    if($varii=in_post(array($this->modelo)))
                    {
                         $data=$varii;

                         $update=$this->mod->actualizar($data,$id);
                         if($update[0]==TRUE && empty($this->erroresbd))
                         {

                             $this->seg->registro($this->nombrePrg,"Actualizar",$this->usuario_id,$this->panelId,$this->nivel);
                             $this->objSubClass->actualizarExito($id);
                         }else
                         {
                             $this->session->set_userdata(array("autoload"=>array("$this->modelo"=>array("id"=>$id,"function"=>$this->fnActualizar))));
                             $this->objSubClass->actualizarError($id);
                         }
                         $this->session->set_userdata(array("flash"=>$this->flash));
                         redirect($this->ruta);
                    }else
                    {
                         $this->session->set_userdata(array("autoload"=>array("$this->modelo"=>array("id"=>$id,"function"=>$this->fnActualizar))));
                         redirect($this->ruta);
                     }
           }else
           {
               msj_error("Usted no tiene permiso para Modificar Registros");
               $this->session->set_userdata(array("flash"=>$this->flash));
           }
           
           redirect($this->ruta);
        }
        
        public function actualizarExito($id=-1)
        {
             msj_exitoso("Registro fue actualizado exitosamente");
        }

        public function actualizarError($id=-1)
        {
               msj_error($this->erroresbd[1]);
               msj_error("Error al actualizar El registro");
        }


        public function insertarExito()
        {
            msj_exitoso("Registro fue agregado exitosamente");
        }
        
        public function insertarError()
        {
            msj_error($this->erroresbd[1]);
            msj_error("El Registro no se guardo correctamente");
        }

        
        public function eliminarExito($id)
        {
            msj_exitoso("Registro fue eliminado exitosamente");
            
        }

        public function eliminarError($id)
        {
            msj_error($this->erroresbd[0]);
            msj_error("El Registro no se Elimino correctamente");
        }


}


////////////////////////////




class Snsession extends CI_Controller{

    public $autoload;
    public $rutamodelo;
    public $modelo;
    public $ruta;
    public $plantilla;
    public $vista;
    public $flash;
    public $accion="/insertar";
    public $data;
    public $erroresbd=array();
    public $db_exception=FALSE;
    public $campos;
    public $agregarCss=FALSE;
    public $agregarJs=FALSE;
    public $objSubClass=null;
    public $atras="";
    public $adelante="";
    
    public $limpiar="/limpiar";
    public $btnLimpiar="";
    
    
    
    public $imprimir=false;
    public $usuario_id='-1';
    
    public $nombrePrg="NO DEFINIDO";
    public $panelId="-1";
    public $nivel="-1";
    
    
    
    

    function  __construct()
    {
            
            parent::__construct();
            $this->btnLimpiar=controller_actual()."/limpiar";
            $this->limpiar=$this->ruta;
            
            
            if($this->session->userdata("snsession")===false)
            {
                $this->session->sess_destroy();
                $this->session->sess_create();
                $this->session->set_userdata(array('snsession'=> true));
            }

            $this->load->model($this->rutamodelo.$this->modelo,"mod");
            
            if($this->session->userdata("autoload")!="")
            {
                $id_Update=$this->session->userdata("autoload");

                $id=$id_Update['id'];
                $function=$id_Update['function'];
                $this->autoload["$this->modelo"]=$this->mod->$function($id);
                
                $this->accion="/actualizar/$id";
            }
            if($this->session->userdata("flash")!="")
            {

                $this->flash=$this->session->userdata("flash");
                
            }
            $this->session->unset_userdata("autoload");
            $this->session->unset_userdata("flash");

    }

    public function cargarTabla()
    {
         $this->load->helper("tables/table_1");
         add_js_libs("jquery.dataTables","dataTables_1.8.0/media/js");
         add_css_libs("demo_table_jui","dataTables_1.8.0/media/css");
    }
    

    
    public function json()
    {
        $modelo=in_post("modelo");
        $function=in_post("function");
        $padre_id=in_post("padre_id");
        $parametros=in_post("parametros");
        
        if(!is_null($parametros) && is_array($parametros))
        {
                $parametros=array_merge($parametros,array("cmpBsq"=>$padre_id));
        }else
        {
            $parametros=$padre_id;
        }
        
        $data['json']=array();
        if($modelo!="" && $function!="" && $padre_id!="0" && $modelo!=null && $function!=null && $padre_id!=null)
        {
            $this->load->model($modelo,"modulo");
            $data['json']=$this->modulo->$function($parametros);
        }
        data_json($data);
    }

    public function limpiar()
    {
        redirect($this->limpiar);
    }


    public function insertar()
    {
       
            if($varii=in_post(array($this->modelo)))
            {
                if($this->mod->insertar($varii) && empty($this->erroresbd))
                {
                             
                    $this->objSubClass->insertarExito($varii);
                }else
                {
                    $this->objSubClass->insertarError();
                }
            }else
            {
                $this->objSubClass->insertarError();
            }
            $this->session->set_userdata(array("flash"=>$this->flash));
        redirect($this->ruta);
    }


    public function eliminar($id)
    {
            
                    if($this->mod->eliminar(array("id"=>$id)) && empty($this->erroresbd))
                    {
                        $this->objSubClass->eliminarExito($id);
                    }else
                    {
                        $this->objSubClass->eliminarError($id);
                    }
                    $this->session->set_userdata(array("flash"=>$this->flash));
            redirect($this->ruta);

    }

    
      public function actualizar($id)
        {
          
                    if($varii=in_post(array($this->modelo)))
                    {
                         $data=$varii;

                         if($this->mod->actualizar($data,$id) && empty($this->erroresbd))
                         {
                             $this->objSubClass->actualizarExito($id);
                         }else
                         {
                             $this->session->set_userdata(array("autoload"=>array("id"=>$id,"function"=>"getList")));
                             $this->objSubClass->actualizarError($id);
                         }
                         $this->session->set_userdata(array("flash"=>$this->flash));
                         redirect($this->ruta);
                    }else
                    {
                         $this->session->set_userdata(array("autoload"=>array("id"=>$id,"function"=>"getList")));
                         redirect($this->ruta);
                     } 
           redirect($this->ruta);
        }
        
        
        public function actualizarExito($id=-1)
        {
             msj_exitoso("Registro fue actualizado exitosamente");
        }

        public function actualizarError($id=-1)
        {
               msj_error($this->erroresbd[1]);
               msj_error("Error al actualizar El registro");
        }


        public function insertarExito()
        {
            msj_exitoso("Registro fue agregado exitosamente");
            $this->ruta="";
        }
        
        public function insertarError()
        {
            msj_error($this->erroresbd[1]);
            msj_error("El Registro no se guardo correctamente");
        }

        
        public function eliminarExito($id)
        {
            msj_exitoso("Registro fue eliminado exitosamente");
            
        }

        public function eliminarError($id)
        {
            msj_error($this->erroresbd[0]);
            msj_error("El Registro no se Elimino correctamente");
        }


}

