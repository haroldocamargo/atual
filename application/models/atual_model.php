<?php
class Atual_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id){
        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao');
        $this->db->join('permissoes', 'permissoes.idPermissao = usuarios.permissoes_id', 'left');
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function alterarSenha($senha,$oldSenha,$id){

        $this->db->where('idUsuarios', $id);
        $this->db->limit(1);
        $usuario = $this->db->get('usuarios')->row();

        if($usuario->senha != $oldSenha){
            return false;
        }
        else{
            $this->db->set('senha',$senha);
            $this->db->where('idUsuarios',$id);
            return $this->db->update('usuarios');    
        }

        
    }

    function pesquisar($termo){
         $data = array();

         // buscando clientes
         $this->db->like('nomeCliente',$termo);
         $this->db->limit(10);
         $data['clientes'] = $this->db->get('clientes')->result();

         // buscando os
		 $this->db->distinct();
         $this->db->select('os.*');
         $this->db->join('produtos_os', 'produtos_os.os_id = os.idOs');
         $this->db->join('produtos', 'produtos.idProdutos = produtos_os.produtos_id');
         $this->db->like('produtos.descricao',$termo);
         $this->db->limit(10);
		 $query1 =  $this->db->get('os')->result();
		 $this->db->distinct();
         $this->db->select('os.*');
         $this->db->join('servicos_os', 'servicos_os.os_id = os.idOs');
         $this->db->join('servicos', 'servicos.idServicos = servicos_os.servicos_id');
         $this->db->like('servicos.descricao',$termo);
         $this->db->limit(10);
		 $query2 =  $this->db->get('os')->result();
		 $this->db->distinct();
         $this->db->select('os.*');
         $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
         $this->db->like('clientes.nomeCliente',$termo);
         $this->db->limit(10);
		 $query3 =  $this->db->get('os')->result();
         $data['os'] = array_merge($query1, $query2, $query3);

         // buscando compras
         $this->db->select('compras.*, clientes.nomeCliente');
         $this->db->join('clientes', 'clientes.idClientes = compras.clientes_id');
         $this->db->join('itens_de_compras', 'itens_de_compras.compras_id = compras.idCompras');
         $this->db->join('produtos', 'produtos.idProdutos = itens_de_compras.produtos_id');
         $this->db->like('produtos.descricao',$termo);
         $this->db->limit(10);
         $query1 = $this->db->get('compras')->result();
         $this->db->select('compras.*, clientes.nomeCliente');
         $this->db->join('clientes', 'clientes.idClientes = compras.clientes_id');
         $this->db->like('clientes.nomeCliente',$termo);
         $this->db->limit(10);
         $query2 = $this->db->get('compras')->result();
         $data['compras'] = array_merge($query1, $query2);

         // buscando vendas
         $this->db->select('vendas.*, clientes.nomeCliente');
         $this->db->join('clientes', 'clientes.idClientes = vendas.clientes_id');
         $this->db->join('itens_de_vendas', 'itens_de_vendas.vendas_id = vendas.idVendas');
         $this->db->join('produtos', 'produtos.idProdutos = itens_de_vendas.produtos_id');
         $this->db->like('produtos.descricao',$termo);
         $this->db->limit(10);
         $query1 = $this->db->get('vendas')->result();
         $this->db->select('vendas.*, clientes.nomeCliente');
         $this->db->join('clientes', 'clientes.idClientes = vendas.clientes_id');
         $this->db->like('clientes.nomeCliente',$termo);
         $this->db->limit(10);
         $query2 = $this->db->get('vendas')->result();
         $data['vendas'] = array_merge($query1, $query2);

         // buscando produtos
         $this->db->like('descricao',$termo);
         $this->db->limit(10);
         $data['produtos'] = $this->db->get('produtos')->result();

         //buscando serviços
         $this->db->like('nome',$termo);
         $this->db->limit(10);
         $data['servicos'] = $this->db->get('servicos')->result();

         return $data;


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
	
	function count($table){
		return $this->db->count_all($table);
	}

    function getOsAbertas(){
        $this->db->select('os.*, clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('os.status','Aberto');
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    function getProdutosMinimo(){

        $sql = "SELECT * FROM produtos WHERE estoque <= estoqueMinimo LIMIT 10"; 
        return $this->db->query($sql)->result();

    }

    function getOsEstatisticas(){
        $sql = "SELECT status, COUNT(status) as total FROM os GROUP BY status ORDER BY status";
        return $this->db->query($sql)->result();
    }

    public function getEstatisticasFinanceiro(){
        $sql = "SELECT SUM(CASE WHEN baixado = 1 AND tipo = 'receita' THEN valor END) as total_receita, 
                       SUM(CASE WHEN baixado = 1 AND tipo = 'despesa' THEN valor END) as total_despesa,
                       SUM(CASE WHEN baixado = 0 AND tipo = 'receita' THEN valor END) as total_receita_pendente,
                       SUM(CASE WHEN baixado = 0 AND tipo = 'despesa' THEN valor END) as total_despesa_pendente FROM lancamentos";
        return $this->db->query($sql)->row();
    }


    public function getEmitente()
    {
        return $this->db->get('emitente')->result();
    }

    public function addEmitente($nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $celular, $email, $logo, $observacaoEmitente){
       
       $this->db->set('nome', $nome);
       $this->db->set('cnpj', $cnpj);
       $this->db->set('ie', $ie);
       $this->db->set('rua', $logradouro);
       $this->db->set('numero', $numero);
       $this->db->set('bairro', $bairro);
       $this->db->set('cidade', $cidade);
       $this->db->set('uf', $uf);
       $this->db->set('telefone', $telefone);
       $this->db->set('celular', $celular);
       $this->db->set('email', $email);
       $this->db->set('url_logo', $logo);
       $this->db->set('observacaoEmitente', $observacaoEmitente);
       return $this->db->insert('emitente');
    }


    public function editEmitente($id, $nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $celular, $email, $observacaoEmitente){
        
       $this->db->set('nome', $nome);
       $this->db->set('cnpj', $cnpj);
       $this->db->set('ie', $ie);
       $this->db->set('rua', $logradouro);
       $this->db->set('numero', $numero);
       $this->db->set('bairro', $bairro);
       $this->db->set('cidade', $cidade);
       $this->db->set('uf', $uf);
       $this->db->set('telefone', $telefone);
       $this->db->set('celular', $celular);
       $this->db->set('email', $email);
       $this->db->where('id', $id);
       $this->db->set('observacaoEmitente', $observacaoEmitente);
       return $this->db->update('emitente');
    }


    public function editLogo($id, $logo){
        
        $this->db->set('url_logo', $logo); 
        $this->db->where('id', $id);
        return $this->db->update('emitente'); 
         
    }
}