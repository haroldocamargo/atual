<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estoque_model extends CI_Model {
	
	function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idEstoque', 'asc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }


    function getById($id){
        $this->db->where('idEstoque',$id);
        $this->db->limit(1);
        return $this->db->get('estoque')->row();
    }
    
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function delete($table,$fieldID,$ID){
    	try {
        	$this->db->where($fieldID,$ID);
        	$this->db->delete($table);
			return TRUE;
		} catch (Exception $e) {
			return FALSE;
		}		
	}

    public function autoCompleteProduto($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('descricao', $q);
        $query = $this->db->get('produtos');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricao'].' | Preço: R$ '.$row['precoVenda'].' | Estoque: '.$row['estoque'],'estoque'=>$row['estoque'],'id'=>$row['idProdutos'],'preco'=>$row['precoVenda']);
            }
            echo json_encode($row_set);
        }
    }



    function somaEstoque($quantidade,$produtos_id){

		$sql = "UPDATE produtos set estoque = estoque + ? WHERE idProdutos = ?";
		$this->db->query($sql, array($quantidade, $produtos_id));

        if ($this->db->affected_rows() >= '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }

    function subtraiEstoque($quantidade,$produtos_id){

		$sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";
		$this->db->query($sql, array($quantidade, $produtos_id));

        if ($this->db->affected_rows() >= '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }

    function count($table) {
        return $this->db->count_all($table);
    }

}

