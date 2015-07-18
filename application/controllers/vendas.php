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

        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/vendas/gerenciar/';
        $config['total_rows'] = $this->vendas_model->count('vendas');
        $config['per_page'] = 10;
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

		$this->data['results'] = $this->vendas_model->get('vendas','*','',$config['per_page'],$this->uri->segment(3));
       
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
                'dataDocumentoVenda' => $dataDocumentoVenda,
            );

            if (is_numeric($id = $this->vendas_model->add('vendas', $data, true)) ) {
				auditoria('Inclusão de vendas', 'Venda de documento "'.$this->input->post('documentoVenda').'" cadastrada no sistema');
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
                'documentoVenda' => $this->input->post('documentoVenda')
            );

            if ($this->vendas_model->edit('vendas', $data, 'idVendas', $this->input->post('idVendas')) == TRUE) {
				auditoria('Alteração de vendas', 'Alterada venda de documento "'.$this->input->post('documentoVenda').'"');
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

            $this->session->set_flashdata('error','Erro ao tentar excluir venda.');            
            redirect(base_url().'index.php/vendas/gerenciar/');
        }

		$itensVenda = $this->vendas_model->getProdutos($id);
        if($itensVenda != null){
			foreach ($itensVenda as $i) {
				$this->estoque_model->somaEstoque($i->quantidade, $i->produtos_id);
            }
        }

        $this->vendas_model->delete('itens_de_vendas','vendas_id', $id);

        $this->vendas_model->delete('vendas','idVendas', $id);

        $this->vendas_model->delete('lancamentos','vendas_id', $id);

        $this->vendas_model->delete('estoque','vendas_id', $id);

		auditoria('Exclusão de vendas', 'Excluída venda de documento "'.$documentoVenda.'"');

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

            $preco = $this->input->post('preco');
            $quantidade = $this->input->post('quantidade');
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
					'observacaoEstoque' => $this->input->post('observacaoItem')
	            );
    	        $this->estoque_model->add('estoque',$data2);

				auditoria('Inclusão de produto em vendas', 'Inclusão do produto "'.$produto.'" na venda '.$this->input->post('idVendasProduto'));
                echo json_encode(array('result'=> true));
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
		        $this->vendas_model->deleteWhere('estoque', $data);

				auditoria('Exclusão de produto em vendas', 'Exclusão do produto "'.$produto.'" na venda '.$Venda);
                echo json_encode(array('result'=> true));
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
                'valor' => $this->input->post('valor'),
                'clientes_id' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $this->input->post('recebido'),
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo'),
                'documento' => $this->input->post('documentoVenda'),
                'grupo' => 'Vendas',
                'observacao' => $this->input->post('observacaoVenda'),
                'vendas_id' => $this->input->post('vendas_id')
            );

            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
                $venda = $this->input->post('vendas_id');
	            $data = array(
    	            'faturado' => 1,
        	        'valorTotal' => $this->input->post('valor'));
				$this->vendas_model->edit('vendas', $data, 'idVendas', $venda);	
            } else {
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
                $json = array('result'=>  false);
                echo json_encode($json);
                die();
            }
			
			if ((rtrim($vencimento2) <> '') && ($this->input->post('valor2') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $this->input->post('valor2'),
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento2,
	                'data_pagamento' => $recebimento,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'observacao' => $this->input->post('observacaoVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
	        	        'valorTotal' => ($this->input->post('valor') + $this->input->post('valor2')));
					$this->vendas_model->edit('vendas', $data, 'idVendas', $venda);	
	            } else {
	                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}

			if ((rtrim($vencimento3) <> '') && ($this->input->post('valor3') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $this->input->post('valor3'),
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento3,
	                'data_pagamento' => $recebimento,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'observacao' => $this->input->post('observacaoVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
	        	        'valorTotal' => ($this->input->post('valor') + $this->input->post('valor2') + 
	        	        $this->input->post('valor3')));
					$this->vendas_model->edit('vendas', $data, 'idVendas', $venda);	
	            } else {
	                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}

			if ((rtrim($vencimento4) <> '') && ($this->input->post('valor4') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $this->input->post('valor4'),
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento4,
	                'data_pagamento' => $recebimento,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'observacao' => $this->input->post('observacaoVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
	        	        'valorTotal' => ($this->input->post('valor') + $this->input->post('valor2') + 
	        	        $this->input->post('valor3') + $this->input->post('valor4')));
					$this->vendas_model->edit('vendas', $data, 'idVendas', $venda);	
	            } else {
	                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}

			if ((rtrim($vencimento5) <> '') && ($this->input->post('valor5') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $this->input->post('valor5'),
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento5,
	                'data_pagamento' => $recebimento,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'observacao' => $this->input->post('observacaoVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
	        	        'valorTotal' => ($this->input->post('valor') + $this->input->post('valor2') + 
	        	        $this->input->post('valor3') + $this->input->post('valor4') + 
	        	        $this->input->post('valor5')));
					$this->vendas_model->edit('vendas', $data, 'idVendas', $venda);	
	            } else {
	                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}

			if ((rtrim($vencimento6) <> '') && ($this->input->post('valor6') > 0)){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $this->input->post('valor6'),
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento6,
	                'data_pagamento' => $recebimento,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoVenda'),
	                'grupo' => 'Vendas',
	                'observacao' => $this->input->post('observacaoVenda'),
    	            'vendas_id' => $this->input->post('vendas_id')
	            );
	
	            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
	                $venda = $this->input->post('vendas_id');
		            $data = array(
	    	            'faturado' => 1,
	        	        'valorTotal' => ($this->input->post('valor') + $this->input->post('valor2') + 
	        	        $this->input->post('valor3') + $this->input->post('valor4') + $this->input->post('valor5') + 
	        	        $this->input->post('valor6')));
					$this->vendas_model->edit('vendas', $data, 'idVendas', $venda);	
	            } else {
	                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}


			auditoria('Faturamento de vendas', 'Faturada venda de documento "'.$this->input->post('documentoVenda').'"');

            $this->session->set_flashdata('success','Venda faturada com sucesso!');
            $json = array('result'=>  true);
            echo json_encode($json);
            die();
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
        $json = array('result'=>  false);
        echo json_encode($json);
        
    }


}

