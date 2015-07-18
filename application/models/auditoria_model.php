<?php
class Auditoria_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idAuditoria','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function count($table) {
        return $this->db->count_all($table);
    }
    
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
	public function do_insert($dados=NULL, $redir=FALSE){
		if ($dados != NULL):
			$this->db->insert('auditoria', $dados);
			if ($this->db->affected_rows()>0){
				return TRUE;}
		endif;

		return FALSE;       
	}
}