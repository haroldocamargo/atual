<?php

class Vendas extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('atual/login');
        }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('vendas_model','',TRUE);
		$this->load->model('estoque_model','',TRUE);
		$this->load->model('financeiro_model','',TRUE);
		$this->data['menuVendas'] = 'Vendas';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar vendas.');
           redirect(base_url());
        }

		$where = '';
		$vendas = $this->input->get('venda');
		$cliente = $this->input->get('clientes_id');
		$documento = $this->input->get('documento');
		$vencimento = $this->input->get('vencimento');
		$vencimento2 = $this->input->get('vencimento2');
		$status = $this->input->get('status');
		$usuario = $this->input->get('usuarios_id');
		$setor = $this->input->get('setor');

        
        // busca os lançamentos
	    if(rtrim($vendas) <> ''){
	        $where = 'idVendas = '.$vendas;
        };

	    if(rtrim($cliente) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'clientes_id = '.$cliente;
        };
	
	    if(rtrim($documento) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'documentoVenda like "%'.$documento.'%"';
        };

		if (rtrim($vencimento) <> '') {
           	$vencimento = explode('/', $vencimento);
            $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'dataVenda >= "'.$vencimento.'"';
		};
		if (rtrim($vencimento2) <> '') {
           	$vencimento2 = explode('/', $vencimento2);
            $vencimento2 = $vencimento2[2].'-'.$vencimento2[1].'-'.$vencimento2[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'dataVenda <= "'.$vencimento2.'"';
		};
        
	    if(rtrim($status) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'faturado = "'.$status.'"';
        };

	    if(rtrim($usuario) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'usuarios_id = "'.$usuario.'"';
        };

	    if(rtrim($setor) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'setorVenda = "'.$setor.'"';
        };

        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/vendas/gerenciar/';
        $config['total_rows'] = $this->vendas_model->count('vendas');
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

		$this->data['results'] = $this->vendas_model->get('vendas','*',$where,$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'vendas/vendas';
       	$this->load->view('tema/topo',$this->data);
      
		
    }
	
    function adicionar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar Vendas.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        if ($this->form_validation->run('vendas') == false) {
           $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            $dataVenda = $this->input->post('dataVenda');
            $dataDocumentoVenda = $this->input->post('dataDocumentoVenda');

            try {
                
                $dataVenda = explode('/', $dataVenda);
                $dataVenda = $dataVenda[2].'-'.$dataVenda[1].'-'.$dataVenda[0];

                $dataDocumentoVenda = explode('/', $dataDocumentoVenda);
                $dataDocumentoVenda = $dataDocumentoVenda[2].'-'.$dataDocumentoVenda[1].'-'.$dataDocumentoVenda[0];

            } catch (Exception $e) {
               $dataVenda = date('Y/m/d'); 
               $dataDocumentoVenda = date('Y/m/d'); 
            }

            $data = array(
                'dataVenda' => $dataVenda,
                'clientes_id' => $this->input->post('clientes_id'),
                'usuarios_id' => $this->input->post('usuarios_id'),
                'faturado' => 0,
                'observacaoVenda' => $this->input->post('observacaoVenda'),
                'documentoVenda' => $this->input->post('documentoVenda'),
                'setorVenda' => $this->input->post('setorVenda'),
                'dataDocumentoVenda' => $dataDocumentoVenda
            );

            if (is_numeric($id = $this->vendas_model->add('vendas', $data, true)) ) {
				auditoria('Inclusão de vendas', 'Venda "'.$id.'" cadastrada no sistema');
                $this->session->set_flashdata('success','Venda iniciada com sucesso, adicione os produtos.');
                redirect('vendas/editar/'.$id);

            } else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
         
        $this->data['view'] = 'vendas/adicionarVenda';
        $this->load->view('tema/topo', $this->data);
    }
    

    
    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar vendas');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('vendas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $dataVenda = $this->input->post('dataVenda');
            $dataDocumentoVenda = $this->input->post('dataDocumentoVenda');

            try {
                
                $dataVenda = explode('/', $dataVenda);
                $dataVenda = $dataVenda[2].'-'.$dataVenda[1].'-'.$dataVenda[0];

                $dataDocumentoVenda = explode('/', $dataDocumentoVenda);
                $dataDocumentoVenda = $dataDocumentoVenda[2].'-'.$dataDocumentoVenda[1].'-'.$dataDocumentoVenda[0];

            } catch (Exception $e) {
               $dataVenda = date('Y/m/d'); 
               $dataDocumentoVenda = date('Y/m/d'); 
            }

            $data = array(
                'dataVenda' => $dataVenda,
                'usuarios_id' => $this->input->post('usuarios_id'),
                'clientes_id' => $this->input->post('clientes_id'),
                'observacaoVenda' => $this->input->post('observacaoVenda'),
                'dataDocumentoVenda' => $dataDocumentoVenda,
                'setorVenda' => $this->input->post('setorVenda'),
                'documentoVenda' => $this->input->post('documentoVenda')
            );

            if ($this->vendas_model->edit('vendas', $data, 'idVendas', $this->input->post('idVendas')) == TRUE) {
				auditoria('Alteração de vendas', 'Alterada venda "'.$this->input->post('idVendas').'"');
                $this->session->set_flashdata('success','Venda editada com sucesso!');
                redirect(base_url() . 'index.php/vendas/editar/'.$this->input->post('idVendas'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['view'] = 'vendas/editarVenda';
        $this->load->view('tema/topo', $this->data);
   
    }

    public function visualizar(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar vendas.');
          redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('atual_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->atual_model->getEmitente();
        
        $this->data['view'] = 'vendas/visualizarVenda';
        $this->load->view('tema/topo', $this->data);
       
    }
	
    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para excluir vendas');
          redirect(base_url());
        }
        
        $id =  $this->input->post('id');
        $documentoVenda = $this->vendas_model->getById($id)->documentoVenda;
        if ($id == null){
            $this->session->set_flashdata('error','Erro ao excluir venda.');            
            redirect(base_url().'index.php/vendas/gerenciar/');
        }

		$itensVenda = $this->vendas_model->getProdutos($id);
        if($itensVenda != null){
			foreach ($itensVenda as $i) {
				$this->estoque_model->somaEstoque($i->quantidade, $i->produtos_id);
            }
        }

		if($this->vendas_model->delete('itens_de_vendas','vendas_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir item da venda.');
	        redirect(base_url().'index.php/vendas/gerenciar/');
		}
		auditoria('Exclusão de vendas', 'Excluídos produtos da venda "'.$id.'"');

		if($this->vendas_model->delete('lancamentos','vendas_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir faturamento da venda.');
	        redirect(base_url().'index.php/vendas/gerenciar/');
		}
		auditoria('Exclusão de vendas', 'Excluído faturamento da venda "'.$id.'"');

		if($this->vendas_model->delete('estoque','vendas_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir estoque da venda.');
	        redirect(base_url().'index.php/vendas/gerenciar/');
		}
		auditoria('Exclusão de vendas', 'Excluído estoque da venda "'.$id.'"');

		if($this->vendas_model->delete('vendas','idVendas', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir venda.');
	        redirect(base_url().'index.php/vendas/gerenciar/');
		}
		auditoria('Exclusão de vendas', 'Excluída venda "'.$id.'"');

        $this->session->set_flashdata('success','Venda excluída com sucesso!');            
        redirect(base_url().'index.php/vendas/gerenciar/');
    }

    public function autoCompleteProduto(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteProduto($q);
        }

    }

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteCliente($q);
        }

    }

    public function autoCompleteUsuario(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteUsuario($q);
        }

    }



    public function adicionarProduto(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar vendas.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('preco', 'Preço', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required|xss_clean');
        $this->form_validation->set_rules('serie', 'Série', 'trim|xss_clean');
        $this->form_validation->set_rules('observacaoItem', 'Observação', 'trim|xss_clean');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idVendasProduto', 'Vendas', 'trim|required|xss_clean');
        
        if($this->form_validation->run() == false){
           echo json_encode(array('result'=> false)); 
        }
        else{
		    $preco = str_replace(",",".", $this->input->post('preco'));
    	    $quantidade = str_replace(",",".", $this->input->post('quantidade'));
            $subtotal = $preco * $quantidade;
            $produto = $this->input->post('idProduto');
            $data = array(
                'valor'=> $preco,
                'quantidade'=> $quantidade,
                'subTotal'=> $subtotal,
                'serie'=> $this->input->post('serie'),
                'observacaoItem'=> $this->input->post('observacaoItem'),
                'produtos_id'=> $produto,
                'vendas_id'=> $this->input->post('idVendasProduto'),
            );

            if($this->vendas_model->add('itens_de_vendas', $data) == true){

				$this->estoque_model->subtraiEstoque($quantidade, $produto);

				$dataVenda = $this->input->post('dataVenda');
                $dataVenda = explode('/', $dataVenda);
                $dataVenda = $dataVenda[2].'-'.$dataVenda[1].'-'.$dataVenda[0];

	            $data2 = array(
					'data' => $dataVenda,
					'tipo' => 'saida',
					'documentoEstoque' => $this->input->post('documentoVenda'),
					'serie' => $this->input->post('serie'),
					'produtos_id' => $produto,
	                'vendas_id'=> $this->input->post('idVendasProduto'),
					'quantidade' => $quantidade,
					'valor' => $preco,
					'subTotal' => $subtotal,
	                'setorEstoque' => $this->input->post('setorVenda'),
					'observacaoEstoque' => $this->input->post('observacaoItem')
	            );
	    	    if($this->estoque_model->add('estoque',$data2)){
					auditoria('Inclusão de produto em vendas', 'Inclusão do produto "'.$produto.'" na venda '.$this->input->post('idVendasProduto'));
                	echo json_encode(array('result'=> true));}
				else {
    	            echo json_encode(array('result'=> false));
				}	

            }else{
                echo json_encode(array('result'=> false));
            }

        }
        
      
    }

    function excluirProduto(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Vendas');
              redirect(base_url());
            }

            $ID = $this->input->post('idProduto');
            $Venda = $this->input->post('idVenda');
            if($this->vendas_model->delete('itens_de_vendas','idItens',$ID) == true){
                $quantidade = $this->input->post('quantidade');
                $produto = $this->input->post('produto');
				$this->estoque_model->somaEstoque($quantidade, $produto);
                
				$data = array('vendas_id' => $Venda, 
					'produtos_id' => $produto);
		        if ($this->vendas_model->deleteWhere('estoque', $data) == FALSE){
	                echo json_encode(array('result'=> false));
		        }
				else{
					auditoria('Exclusão de produto em vendas', 'Exclusão do produto "'.$produto.'" na venda '.$Venda);
    	            echo json_encode(array('result'=> true));
				}
            }
            else{
                echo json_encode(array('result'=> false));
            }           
    }



    public function faturar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Vendas');
              redirect(base_url());
            }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
 

        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


            $vencimento = $this->input->post('vencimento');
            $vencimento2 = $this->input->post('vencimento2');
            $vencimento3 = $this->input->post('vencimento3');
            $vencimento4 = $this->input->post('vencimento4');
            $vencimento5 = $this->input->post('vencimento5');
            $vencimento6 = $this->input->post('vencimento6');
            $recebimento = $this->input->post('recebimento');

            $valor = str_replace(",",".", $this->input->post('valor'));
   	        $valor2 = str_replace(",",".", $this->input->post('valor2'));
   	        $valor3 = str_replace(",",".", $this->input->post('valor3'));
   	        $valor4 = str_replace(",",".", $this->input->post('valor4'));
   	        $valor5 = str_replace(",",".", $this->input->post('valor5'));
   	        $valor6 = str_replace(",",".", $this->input->post('valor6'));

            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];

				if (rtrim($vencimento2) <> '') {
                	$vencimento2 = explode('/', $vencimento2);
	                $vencimento2 = $vencimento2[2].'-'.$vencimento2[1].'-'.$vencimento2[0];
				}

				if (rtrim($vencimento3) <> '') {
                	$vencimento3 = explode('/', $vencimento3);
	                $vencimento3 = $vencimento3[2].'-'.$vencimento3[1].'-'.$vencimento3[0];
				}

				if (rtrim($vencimento4) <> '') {
                	$vencimento4 = explode('/', $vencimento4);
	                $vencimento4 = $vencimento4[2].'-'.$vencimento4[1].'-'.$vencimento4[0];
				}

				if (rtrim($vencimento5) <> '') {
                	$vencimento5 = explode('/', $vencimento5);
	                $vencimento5 = $vencimento5[2].'-'.$vencimento5[1].'-'.$vencimento5[0];
				}

				if (rtrim($vencimento6) <> '') {
                	$vencimento6 = explode('/', $vencimento6);
	                $vencimento6 = $vencimento6[2].'-'.$vencimento6[1].'-'.$vencimento6[0];
				}

                if($recebimento != null){
                    $recebimento = explode('/', $recebimento);
                    $recebimento = $recebimento[2].'-'.$recebimento[1].'-'.$recebimento[0];

                }
            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }

            $data = array(
                'descricao' => set_value('descricao'),
                'valor' => $valor,
                'clientes_id' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'baixado' => $this->input->post('recebido'),
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo'),
                'documento' => $this->input->post('documentoVenda'),
                'grupo' => 'Vendas',
                'observacao' => $this->input->post('observacaoVenda'),
                'setor' => $this->input->post('setorVenda'),
                'vendas_id' => $this->input->post('vendas_id')
            );

            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
                $venda = $this->input->post('vendas_id');
	            $data = array(
    	            'faturado' => 1,
       	        	'valorTotal' => $valor);

				if ($this->vendas_model->edit('vendas', $data, 'idVendas', $venda) == FALSE){
	                $this->session->set_flashdata('error','Erro ao faturar venda.');
    	            $json = array('result'=>  false);
   	    	        echo json_encode($json);
       	    	    die();
				}	

            } else {
                $this->session->set_flashdata('error','Erro ao faturar venda.');
                $json = array('result'=>  false);
                echo json_encode($json);
                die();
            }
			
			if ((rtrim($vencimento2) <> '') && ($this->input->post('valor2') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor2,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento2,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'observacao' => $this->input->post('observacaoVenda'),
	                'setor' => $this->input->post('setorVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2));

					if ($this->vendas_model->edit('vendas', $data, 'idVendas', $venda) == FALSE){
	            	    $this->session->set_flashdata('error','Erro ao faturar venda.');
    	    	        $json = array('result'=>  false);
   	    		        echo json_encode($json);
    	   	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}

			if ((rtrim($vencimento3) <> '') && ($this->input->post('valor3') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor3,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento3,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'setor' => $this->input->post('setorVenda'),
	                'observacao' => $this->input->post('observacaoVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3));

					if ($this->vendas_model->edit('vendas', $data, 'idVendas', $venda) == FALSE){
	            	    $this->session->set_flashdata('error','Erro ao faturar venda.');
    	    	        $json = array('result'=>  false);
   	    		        echo json_encode($json);
    	   	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}

			if ((rtrim($vencimento4) <> '') && ($this->input->post('valor4') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor4,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento4,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'observacao' => $this->input->post('observacaoVenda'),
	                'setor' => $this->input->post('setorVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4));

					if ($this->vendas_model->edit('vendas', $data, 'idVendas', $venda) == FALSE){
	            	    $this->session->set_flashdata('error','Erro ao faturar venda.');
    	    	        $json = array('result'=>  false);
   	    		        echo json_encode($json);
    	   	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}

			if ((rtrim($vencimento5) <> '') && ($this->input->post('valor5') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor5,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento5,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'observacao' => $this->input->post('observacaoVenda'),
	                'setor' => $this->input->post('setorVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5));

					if ($this->vendas_model->edit('vendas', $data, 'idVendas', $venda) == FALSE){
	            	    $this->session->set_flashdata('error','Erro ao faturar venda.');
    	    	        $json = array('result'=>  false);
   	    		        echo json_encode($json);
    	   	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}

			if ((rtrim($vencimento6) <> '') && ($this->input->post('valor6') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor6,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento6,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'observacao' => $this->input->post('observacaoVenda'),
	                'setor' => $this->input->post('setorVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5 + $valor6));

					if ($this->vendas_model->edit('vendas', $data, 'idVendas', $venda) == FALSE){
	            	    $this->session->set_flashdata('error','Erro ao faturar venda.');
    	    	        $json = array('result'=>  false);
   	    		        echo json_encode($json);
    	   	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}


			auditoria('Faturamento de vendas', 'Faturada venda "'.$venda.'"');

            $this->session->set_flashdata('success','Venda faturada com sucesso!');
            $json = array('result'=>  true);
            echo json_encode($json);
            die();
        }

        $this->session->set_flashdata('error','Erro ao faturar venda.');
        $json = array('result'=>  false);
        echo json_encode($json);
        
    }


}

