<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query extends CI_Controller {


        public function  __construct()
        {
            parent::__construct();
        }


        
	public function index()
	{

            
            $acceso=false;
            $dbConfigSess=$this->session->userdata("params");
            $dbConfigPoss=in_post(array("config"));
            
            if($dbConfigSess!=null && is_array($dbConfigSess) && count($dbConfigSess)>5)
            {
                $sql=$this->session->userdata("sql");
                $dbConfig=$dbConfigSess;
                $acceso=true;
            }
            elseif($dbConfigPoss!=null && is_array($dbConfigPoss) && count($dbConfigPoss)>5)
            {
                $sql=in_post(array("sql"));
                $dbConfig=$dbConfigPoss;
                $acceso=true;
            }
            
            
            
            if($acceso)
            {
                
                if($sql)
                {       
                    $this->db_java=$this->load->database($dbConfig, true);
                    $this->load->model("jsonWeb/jsonweb_model","mod");
                    $rs=$this->mod->queryModel($sql);
                    $result=array();
                    if(!preg_match('/^\s*"?(INSERT|UPDATE|DELETE)\s+/i', $sql))
                    {
                        $result=array("typeSelect"=>array("sql"=>$sql,"error"=>"","num_rows"=>$rs->num_rows(),"num_cols"=>$rs->num_fields(),"complete"=>"t",
                        "fieldMetadata"=>$rs->field_data(),"data"=>$rs->result()));
                    
                    }else
                    {
                         $result=array("typeInsertUpdateDelete"=>array("sql"=>$sql,"error"=>"","num_rows_afected"=>$rs['num_rows_affected'],"complete"=>"t"));
                    }

                    echo json_encode($result);;
                    
                    
                }else
                {
                    echo "falta sql";
                }
            }else
            {
                echo "faltan parametros";
            }
	
	}

        
        
        public function limpiar()
        {
            
        }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
