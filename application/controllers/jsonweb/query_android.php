<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_android extends CI_Controller {


    private $acceso=false;
    private $sql=false;
        public function  __construct()
        {
            parent::__construct();
            $this->acceso=false;
            $this->sql=false;
            $dbConfigSess=$this->session->userdata("params");
            $dbConfigPoss=in_post(array("config"));
            
            $dbConfigSess['hostname'] = 'localhost';
            $dbConfigSess['username'] = 'oneclick_lg_oneclicksms';
            $dbConfigSess['password'] = 'pw_oneclicksms';
            $dbConfigSess['database'] = 'oneclick_oneclicksms';
            $dbConfigSess['dbdriver'] = 'postgre';
            $dbConfigSess['dbprefix'] = '';
            $dbConfigSess['pconnect'] = TRUE;
            $dbConfigSess['db_debug'] = TRUE;
            $dbConfigSess['cache_on'] = FALSE;
            $dbConfigSess['cachedir'] = '';
            $dbConfigSess['char_set'] = 'utf8';
            $dbConfigSess['dbcollat'] = 'utf8_general_ci';
            $dbConfigSess['swap_pre'] = '';
            $dbConfigSess['autoinit'] = TRUE;
            $dbConfigSess['stricton'] = FALSE;
            

            
            if($dbConfigSess!=null && is_array($dbConfigSess) && count($dbConfigSess)>5)
            {
                $this->sql=$this->session->userdata("sql");
                $this->db_java=$this->load->database($dbConfigSess, true);
                $this->acceso=true;
            }
            elseif($dbConfigPoss!=null && is_array($dbConfigPoss) && count($dbConfigPoss)>5)
            {
                $this->sql=in_post(array("sql"));
                $this->acceso=true;
                $this->db_java=$this->load->database($dbConfigPoss, true);
                
            }
        }
        
        public function xml()
        {
            
            
            //
            $this->acceso=true;
            $this->sql="select id_preenvio,telefono,texto from fn_reservarmsjs(3, 1)";
            if($this->acceso)
            {
                if($this->sql!=false)
                {
                    
                    $this->load->model("jsonWeb/jsonweb_model","mod");
                    //$rs=$this->mod->queryTest($this->sql);
                    $rs=$this->mod->queryModel($this->sql);
                    $data=array();
                    $campos=array();
                    $i=0;
                    
                    //print_r($rs->result_array());
                    foreach ($rs->result_array() as $val0)
                    {
                        
                        foreach($val0 as $val1=>$key1)
                        {
                            $key1=  trim($key1);
                            $campos=  array_merge($campos,array($val1=>htmlentities ( $key1 ,ENT_XML1))); 
                        }
                        
                        $data["data_reg_n_".$i]=$campos;
                        $i++;
                        
                        
                    }
                    
                    
                    $result=array();
                    if(!preg_match('/^\s*"?(INSERT|UPDATE|DELETE)\s+/i', $this->sql))
                    {
                        $metadata=array();
                        foreach ($rs->field_data() as $field)
                        {
                                $attr=array($field->name=>array("attribute"=>array("type"=>$field->type,"max_length"=>$field->max_length,"primary_key"=>$field->primary_key)));
                                $metadata=  array_merge($metadata,$attr);
                        }
                        
                        $result=array("typeSelect"=>array("sql"=>$this->sql,"error"=>"","num_rows"=>$rs->num_rows(),"num_cols"=>$rs->num_fields(),"complete"=>"t",
                "fieldMetadata"=>$metadata));
                        
                        if(is_array($data) && count($data)>=1){
                            $result=  array_merge($result,array("data"=>$data));
                        }
                        
                    }else
                    {
                        $result=array("typeInsertUpdateDelete"=>array("sql"=>$sql,"error"=>"","num_rows_afected"=>$rs['num_rows_affected'],"complete"=>"t"));
                    }
                    
                        
                }else
                {
                    $result=array("typeError"=>array("error"=>"SINSQL"));
                }
            }else
            {
                $result=array("typeError"=>array("error"=>"SINPARAMS"));
            }
            //print_r($result);
            
            $this->load->library('xmlbdparsertoandroid');
            $this->xmlbdparsertoandroid->fromMixed($result);
            header("Content-type: text/xml");
            echo $this->xmlbdparsertoandroid->saveXML();
        }


        
	public function index()
	{
            $acceso=false;
            $sql=false;
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
                if($sql!=false)
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
                        
                        echo json_encode($result);
                        
                }else
                {
                    echo "SINSQL";
                }
            }else
            {
                echo "SINPARAMS";
            }

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
