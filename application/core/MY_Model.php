<?php if(!defined('BASEPATH'))         exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    function  __construct()
    {
            parent::__construct();
           
    }
}



  ////////////////////////////////////////////////////



class MY_ModelCrud extends CI_Model{

    public $table="";
    public $vst="";
    
    public $id="id";
    public $valor="nombre";
    public $campoBsq;
    public $conexion_id;
    public $usuario_id;
    
    
    function  __construct()
    {
            parent::__construct();
            if(!isset($this->sesslg))
            {
                    $this->load->library("session",array("sess_cookie_name"=>"sslg","sess_expiration"=>0),"sesslg");
            }
            
            $this->conexion_id= $this->sesslg->userdata("conexion_id");
            $this->usuario_id= $this->sesslg->userdata("usuario_id");

    }
    
    
    
    function getSubCmb($padre_id)
    {
        if(is_array($padre_id) && (isset($padre_id['cmpBsq']) || isset($padre_id['padre_id'])))
        {
            if(isset($padre_id['cmpBsq']))
            {
                $padre_id=$padre_id['cmpBsq'];
            }else
            if(isset($padre_id['padre_id']))
            {
                $padre_id=$padre_id['padre_id'];
            }
        }
        if($padre_id!="seleccione" && $padre_id!="@@@***@@@")
        {
            $this->db->from($this->table." as tb");
            $this->db->select("$this->id as id,$this->valor as valor");
            $this->db->where("tb.$this->campoBsq",$padre_id);
            $sql = $this->db->get();
            return $sql->result();
        }else
        {
            return array();
        }
    }
    
    
    function getCmp($cmp,$where,$tabla,&$valor)
    {
        $this->db->from("$tabla");
        $this->db->select($cmp);
        $this->db->where($where);
        $result=$this->db->get();
        if($result->num_rows()>0)
        {
            $valor=$result->row();
            return true;
        }else
        {
            return false;
        }
    }
    
    
    
    
    function getList($id="-1",$where=array())
    {
        $this->db->from($this->table."");
        $this->db->select("*");
        if(!empty($where))
        {
            $this->db->where($where);   
        }else
        if($id!=-1)
        {
            $this->db->where(array('id'=>$id));
        }
        return $this->db->get();
    }

     function getListVst($id="-1",$where=array())
    {
        $this->db->from($this->vst."");
        $this->db->select("*");
        if(!empty($where))
        {
            $this->db->where($where);
        }else
        if($id!=-1)
        {
            $this->db->where(array('id'=>$id));
        }
        return $this->db->get();
    }
    
    
    function getCmb()
    {
        
        $query="select $this->id ,$this->valor  from $this->table order by $this->id,$this->valor asc";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    
    
    function insertar($datos)
    {
        return $this->db->insert("$this->table",$datos);
    }

    
    function actualizar($datos,$id=-1,$table="")
    {
       if(empty($table) && $table=="")
       {
           $table=$this->table;
       }
       return $this->db->update($table, $datos,array("id"=>$id));    
    }
    
    function eliminar($where=array())
    {
        if(!empty($where))
        {
            return $this->db->delete("$this->table", $where);
        }
        return null;
    }
    
    
    

}
