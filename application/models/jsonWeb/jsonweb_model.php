<?php

class Jsonweb_model extends CI_Model {

    
    public function __construct() 
    {
        parent:: __construct();
    }


    public function queryModel($sql="select -1 as def")
    {
        
        $query=$this->db_java->query($sql);
        return $query;
    }
    
    public function queryTest($sql="select -1 as def")
    {
        
        $query=$this->db->query($sql);
        return $query;
    }
    
    
}
?>