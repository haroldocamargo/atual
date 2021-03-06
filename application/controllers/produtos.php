<?php

class Produtos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('atual/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('produtos_model', '', TRUE);
        $this->data['menuProdutos'] = 'Produtos';
    }

    function index(){
	   $this->gerenciar();
    }

    public function autoCompleteProduto(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->produtos_model->autoCompleteProduto($q);
        }
    }


    function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar produtos.');
           redirect(base_url());
        }

        $where = '';
		$codigo = $this->input->get('codigo');
		$produto = $this->input->get('produtos_id');
		$grupo = $this->input->get('grupo');
		$subgrupo = $this->input->get('subgrupo');
		$categoria = $this->input->get('categoria');
		$classe = $this->input->get('classe');
		$tipo = $this->input->get('tipo');
		
	    if(rtrim($codigo) <> ''){
	        $where = 'idProdutos = '.$codigo;
        };
	        
	    if(rtrim($produto) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'idProdutos = '.$produto;
        };
	
	    if(rtrim($grupo) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'grupo = "'.$grupo.'"';
        };

	    if(rtrim($subgrupo) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'subgrupo = "'.$subgrupo.'"';
        };

	    if(rtrim($categoria) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'categoria = "'.$categoria.'"';
        };
        
	    if(rtrim($classe) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'classe = "'.$classe.'"';
        };
        
	    if(rtrim($tipo) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'tipo = "'.$tipo.'"';
        };
        
        $this->load->library('table');
        $this->load->library('pagination');
        
        $config['base_url'] = base_url().'index.php/produtos/gerenciar/';
        $config['total_rows'] = $this->produtos_model->count('produtos');
        $config['per_page'] = 500;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $this->pagination->initialize($config); 	

	    $this->data['results'] = $this->produtos_model->get('produtos','*',$where,$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'produtos/produtos';
       	$this->load->view('tema/topo',$this->data);
       
		
    }
	
    function adicionar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar produtos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $precoCompra = str_replace(",",".", $this->input->post('precoCompra'));
            $precoVenda = str_replace(",", ".", $this->input->post('precoVenda'));
            $estoque = str_replace(",", ".", $this->input->post('estoque'));
            $estoqueMinimo = str_replace(",", ".", $this->input->post('estoqueMinimo'));
            $data = array(
                'descricao' => set_value('descricao'),
                'unidade' => set_value('unidade'),
                'grupo' => set_value('grupo'),
                'subgrupo' => set_value('subgrupo'),
                'categoria' => set_value('categoria'),
                'classe' => set_value('classe'),
                'tipo' => set_value('tipo'),
                'observacaoProduto' => set_value('observacaoProduto'),
                'precoCompra' => $precoCompra,
                'precoVenda' => $precoVenda,
                'estoque' => $estoque,
                'estoqueMinimo' => $estoqueMinimo
            );

            if ($this->produtos_model->add('produtos', $data) == TRUE) {
				auditoria('Inclusão de produtos', 'Produto "'.set_value('descricao').'" cadastrado no sistema');
                $this->session->set_flashdata('success','Produto adicionado com sucesso!');
                redirect(base_url() . 'index.php/produtos/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        $this->data['view'] = 'produtos/adicionarProduto';
        $this->load->view('tema/topo', $this->data);
     
    }

    function editar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para editar produtos.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            	
            $precoCompra = str_replace(",",".", $this->input->post('precoCompra'));
            $precoVenda = str_replace(",", ".", $this->input->post('precoVenda'));
            $estoque = str_replace(",", ".", $this->input->post('estoque'));
            $estoqueMinimo = str_replace(",", ".", $this->input->post('estoqueMinimo'));
            $data = array(
                'descricao' => $this->input->post('descricao'),
                'unidade' => $this->input->post('unidade'),
                'grupo' => set_value('grupo'),
                'subgrupo' => set_value('subgrupo'),
                'categoria' => set_value('categoria'),
                'classe' => set_value('classe'),
                'tipo' => set_value('tipo'),
                'observacaoProduto' => set_value('observacaoProduto'),
                'precoCompra' => $precoCompra,
                'precoVenda' => $precoVenda,
                'estoque' => $estoque,
                'estoqueMinimo' => $estoqueMinimo
            );

            if ($this->produtos_model->edit('produtos', $data, 'idProdutos', $this->input->post('idProdutos')) == TRUE) {
				auditoria('Alteração de produtos', 'Alterado cadastro do produto "'.$this->input->post('descricao').'"');
                $this->session->set_flashdata('success','Produto editado com sucesso!');
                redirect(base_url() . 'index.php/produtos/editar/'.$this->input->post('idProdutos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';
            }
        }

        $this->data['result'] = $this->produtos_model->getById($this->uri->segment(3));

        $this->data['view'] = 'produtos/editarProduto';
        $this->load->view('tema/topo', $this->data);
     
    }


    function visualizar() {
      
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar produtos.');
           redirect(base_url());
        }

        $this->data['result'] = $this->produtos_model->getById($this->uri->segment(3));

        if($this->data['result'] == null){
            $this->session->set_flashdata('error','Produto não encontrado.');
            redirect(base_url() . 'index.php/produtos/editar/'.$this->input->post('idProdutos'));
        }

        $this->data['view'] = 'produtos/visualizarProduto';
        $this->load->view('tema/topo', $this->data);
     
    }
	
    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir produtos.');
           redirect(base_url());
        }

        
        $id =  $this->uri->segment(3);
        $nomeProduto = $this->produtos_model->getById($id)->descricao;
        if($id == null){
            $this->session->set_flashdata('error','Erro ao excluir o produto.');            
            redirect(base_url().'index.php/produtos/gerenciar/');
        }

        if($this->produtos_model->delete('produtos_os','produtos_id',$id) == FALSE){             
	        $this->session->set_flashdata('error','Erro ao excluir produto de OS.');
	        redirect(base_url().'index.php/produtos/gerenciar/');
        }           
        auditoria('Exclusão de produtos', 'Excluídas OSs do produto "'.$nomeProduto.'"');

        if($this->produtos_model->delete('itens_de_vendas','produtos_id',$id) == FALSE){             
	        $this->session->set_flashdata('error','Erro ao excluir produto da venda.');
	        redirect(base_url().'index.php/produtos/gerenciar/');
        }           
        auditoria('Exclusão de produtos', 'Excluídas vendas do produto "'.$nomeProduto.'"');

        if($this->produtos_model->delete('itens_de_compras','produtos_id',$id) == FALSE){             
	        $this->session->set_flashdata('error','Erro ao excluir produto da compra');
	        redirect(base_url().'index.php/produtos/gerenciar/');
        }           
        auditoria('Exclusão de produtos', 'Excluídas compras do produto "'.$nomeProduto.'"');
        
        if($this->produtos_model->delete('produtos','idProdutos',$id) == FALSE){             
	        $this->session->set_flashdata('error','Erro ao excluir produto!');
	        redirect(base_url().'index.php/produtos/gerenciar/');
        }           
        auditoria('Exclusão de produtos', 'Excluído cadastro do produto "'.$nomeProduto.'"');

        $this->session->set_flashdata('success','Produto excluido com sucesso!');            
        redirect(base_url().'index.php/produtos/gerenciar/');
    }
}

