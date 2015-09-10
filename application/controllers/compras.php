<?php

class Compras extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('atual/login');
        }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('compras_model','',TRUE);
		$this->load->model('estoque_model','',TRUE);
		$this->data['menuCompras'] = 'Compras';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar compras.');
           redirect(base_url());
        }

		$where = '';
		$compras = $this->input->get('compra');
		$cliente = $this->input->get('clientes_id');
		$documento = $this->input->get('documento');
		$vencimento = $this->input->get('vencimento');
		$vencimento2 = $this->input->get('vencimento2');
		$status = $this->input->get('status');
		$usuario = $this->input->get('usuarios_id');
		$setor = $this->input->get('setor');

        
        // busca os lançamentos
	    if(rtrim($compras) <> ''){
	        $where = 'idCompras = '.$compras;
        };

	    if(rtrim($cliente) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'clientes_id = '.$cliente;
        };
	
	    if(rtrim($documento) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'documentoCompra like "%'.$documento.'%"';
        };

		if (rtrim($vencimento) <> '') {
           	$vencimento = explode('/', $vencimento);
            $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'dataCompra >= "'.$vencimento.'"';
		};
		if (rtrim($vencimento2) <> '') {
           	$vencimento2 = explode('/', $vencimento2);
            $vencimento2 = $vencimento2[2].'-'.$vencimento2[1].'-'.$vencimento2[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'dataCompra <= "'.$vencimento2.'"';
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
	        $where = $where.'setorCompra = "'.$setor.'"';
        };

        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/compras/gerenciar/';
        $config['total_rows'] = $this->compras_model->count('compras');
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

		$this->data['results'] = $this->compras_model->get('compras','*',$where,$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'compras/compras';
       	$this->load->view('tema/topo',$this->data);
      
		
    }
	
    function adicionar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar Compras.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        if ($this->form_validation->run('compras') == false) {
           $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            $dataCompra = $this->input->post('dataCompra');
            $dataDocumentoCompra = $this->input->post('dataDocumentoCompra');

            try {
                
                $dataCompra = explode('/', $dataCompra);
                $dataCompra = $dataCompra[2].'-'.$dataCompra[1].'-'.$dataCompra[0];

                $dataDocumentoCompra = explode('/', $dataDocumentoCompra);
                $dataDocumentoCompra = $dataDocumentoCompra[2].'-'.$dataDocumentoCompra[1].'-'.$dataDocumentoCompra[0];

            } catch (Exception $e) {
               $dataCompra = date('Y/m/d'); 
               $dataDocumentoCompra = date('Y/m/d'); 
            }

            $data = array(
                'dataCompra' => $dataCompra,
                'clientes_id' => $this->input->post('clientes_id'),
                'usuarios_id' => $this->input->post('usuarios_id'),
                'faturado' => 0,
                'observacaoCompra' => $this->input->post('observacaoCompra'),
                'documentoCompra' => $this->input->post('documentoCompra'),
                'setorCompra' => $this->input->post('setorCompra'),
                'dataDocumentoCompra' => $dataDocumentoCompra,
            );

            if (is_numeric($id = $this->compras_model->add('compras', $data, true)) ) {
				auditoria('Inclusão de compras', 'Compra "'.$id.'" cadastrada no sistema');
                $this->session->set_flashdata('success','Compra iniciada com sucesso, adicione os produtos.');
                redirect('compras/editar/'.$id);

            } else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
         
        $this->data['view'] = 'compras/adicionarCompra';
        $this->load->view('tema/topo', $this->data);
    }
    

    
    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para editar compras');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('compras') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $dataCompra = $this->input->post('dataCompra');
            $dataDocumentoCompra = $this->input->post('dataDocumentoCompra');

            try {
                
                $dataCompra = explode('/', $dataCompra);
                $dataCompra = $dataCompra[2].'-'.$dataCompra[1].'-'.$dataCompra[0];

                $dataDocumentoCompra = explode('/', $dataDocumentoCompra);
                $dataDocumentoCompra = $dataDocumentoCompra[2].'-'.$dataDocumentoCompra[1].'-'.$dataDocumentoCompra[0];

            } catch (Exception $e) {
               $dataCompra = date('Y/m/d'); 
               $dataDocumentoCompra = date('Y/m/d'); 
            }

            $data = array(
                'dataCompra' => $dataCompra,
                'usuarios_id' => $this->input->post('usuarios_id'),
                'clientes_id' => $this->input->post('clientes_id'),
                'observacaoCompra' => $this->input->post('observacaoCompra'),
                'dataDocumentoCompra' => $dataDocumentoCompra,
                'setorCompra' => $this->input->post('setorCompra'),
                'documentoCompra' => $this->input->post('documentoCompra')
            );

            if ($this->compras_model->edit('compras', $data, 'idCompras', $this->input->post('idCompras')) == TRUE) {
				auditoria('Alteração de compras', 'Alterada compra "'.$id.'"');
                $this->session->set_flashdata('success','Compra editada com sucesso!');
                redirect(base_url() . 'index.php/compras/editar/'.$this->input->post('idCompras'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->compras_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->compras_model->getProdutos($this->uri->segment(3));
        $this->data['view'] = 'compras/editarCompra';
        $this->load->view('tema/topo', $this->data);
   
    }

    public function visualizar(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar compras.');
          redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('atual_model');
        $this->data['result'] = $this->compras_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->compras_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->atual_model->getEmitente();
        
        $this->data['view'] = 'compras/visualizarCompra';
        $this->load->view('tema/topo', $this->data);
       
    }
	
    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para excluir compras');
          redirect(base_url());
        }
        
        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao excluir compra.');            
            redirect(base_url().'index.php/compras/gerenciar/');
        }
		
		$itensCompra = $this->compras_model->getProdutos($id);
        if($itensCompra != null){
			foreach ($itensCompra as $i) {
				$this->estoque_model->subtraiEstoque($i->quantidade, $i->produtos_id);
            }
        }

		if($this->compras_model->delete('itens_de_compras','compras_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir produto da compra.');
	        redirect(base_url().'index.php/compras/gerenciar/');
		}
		auditoria('Exclusão de compras', 'Excluídos produtos da compra "'.$id.'"');

		if($this->compras_model->delete('lancamentos','compras_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir faturamento da compra.');
	        redirect(base_url().'index.php/compras/gerenciar/');
		}
		auditoria('Exclusão de compras', 'Excluído faturamento da compra "'.$id.'"');

		if($this->compras_model->delete('estoque','compras_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir estoque da compra.');
	        redirect(base_url().'index.php/compras/gerenciar/');
		}
		auditoria('Exclusão de compras', 'Excluído estoque da compra "'.$id.'"');

		if($this->compras_model->delete('compras','idCompras', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir compra.');
	        redirect(base_url().'index.php/compras/gerenciar/');
		}
		auditoria('Exclusão de compras', 'Excluída compra "'.$id.'"');

        $this->session->set_flashdata('success','Compra excluída com sucesso!');            
        redirect(base_url().'index.php/compras/gerenciar/');

    }

    public function autoCompleteProduto(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->compras_model->autoCompleteProduto($q);
        }

    }

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->compras_model->autoCompleteCliente($q);
        }

    }

    public function autoCompleteUsuario(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->compras_model->autoCompleteUsuario($q);
        }

    }



    public function adicionarProduto(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para editar compras.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('preco', 'Preço', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required|xss_clean');
        $this->form_validation->set_rules('serie', 'Série', 'trim|xss_clean');
        $this->form_validation->set_rules('observacaoItem', 'Observação', 'trim|xss_clean');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idComprasProduto', 'Compras', 'trim|required|xss_clean');
        
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
                'compras_id'=> $this->input->post('idComprasProduto')
            );

            if($this->compras_model->add('itens_de_compras', $data) == true){

				$this->estoque_model->somaEstoque($quantidade, $produto);

				$dataCompra = $this->input->post('dataCompra');
                $dataCompra = explode('/', $dataCompra);
                $dataCompra = $dataCompra[2].'-'.$dataCompra[1].'-'.$dataCompra[0];

	            $data2 = array(
					'data' => $dataCompra,
					'tipo' => 'entrada',
					'documentoEstoque' => $this->input->post('documentoCompra'),
					'serie' => $this->input->post('serie'),
					'produtos_id' => $produto,
	                'compras_id'=> $this->input->post('idComprasProduto'),
					'quantidade' => $quantidade,
					'valor' => $preco,
					'subTotal' => $subtotal,
	                'setorEstoque' => $this->input->post('setorCompra'),
					'observacaoEstoque' => $this->input->post('observacaoItem')
	            );

	    	    if($this->estoque_model->add('estoque',$data2)){
					auditoria('Inclusão de produto em compras', 'Inclusão do produto "'.$produto.'" na compra '.$this->input->post('idComprasProduto'));
    	            echo json_encode(array('result'=> true));}
				else{
	                echo json_encode(array('result'=> false));
				}
            }else{
                echo json_encode(array('result'=> false));
            }

        }
        
      
    }

    function excluirProduto(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCompra')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Compras');
              redirect(base_url());
            }

            $ID = $this->input->post('idProduto');
            $Compra = $this->input->post('idCompra');
            if($this->compras_model->delete('itens_de_compras','idItens',$ID) == true){
                $quantidade = $this->input->post('quantidade');
                $produto = $this->input->post('produto');
				$this->estoque_model->subtraiEstoque($quantidade, $produto);

				$data = array('compras_id' => $Compra, 
					'produtos_id' => $produto);

		        if ($this->compras_model->deleteWhere('estoque', $data) == FALSE){
	                $this->session->set_flashdata('error','Erro ao editar compra.');
	                echo json_encode(array('result'=> false));
		        }else{
					auditoria('Exclusão de produto em compras', 'Exclusão do produto "'.$produto.'" na compra '.$Compra);
    	            echo json_encode(array('result'=> true));
		        }
            }
            else{
                echo json_encode(array('result'=> false));
            }           
    }



    public function faturar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCompra')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Compras');
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
                'documento' => $this->input->post('documentoCompra'),
                'grupo' => 'Compras',
                'observacao' => $this->input->post('observacaoCompra'),
                'setor' => $this->input->post('setorCompra'),
                'compras_id' => $this->input->post('compras_id')
            );

            if ($this->compras_model->add('lancamentos',$data) == TRUE) {
                $compra = $this->input->post('compras_id');
	            $data = array(
    	            'faturado' => 1,
        	        'valorTotal' => $valor);

				if ($this->compras_model->edit('compras', $data, 'idCompras', $compra) == FALSE){
	                $this->session->set_flashdata('error','Erro ao faturar compra.');
	                $json = array('result'=>  false);
    	            echo json_encode($json);
        	        die();
				}	

			} else {
                $this->session->set_flashdata('error','Erro ao faturar compra.');
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
	                'documento' => $this->input->post('documentoCompra'),
	                'grupo' => 'Compras',
	                'observacao' => $this->input->post('observacaoCompra'),
	                'setor' => $this->input->post('setorCompra'),
    	            'compras_id' => $this->input->post('compras_id')
	            );
	
	            if ($this->compras_model->add('lancamentos',$data) == TRUE) {
	                $compra = $this->input->post('compras_id');
	            	$data = array(
    	            	'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2));

					if ($this->compras_model->edit('compras', $data, 'idCompras', $compra) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar compra.');
	        	        $json = array('result'=>  false);
    		            echo json_encode($json);
    	    	        die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar compra.');
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
	                'documento' => $this->input->post('documentoCompra'),
	                'grupo' => 'Compras',
	                'observacao' => $this->input->post('observacaoCompra'),
	                'setor' => $this->input->post('setorCompra'),
    	            'compras_id' => $this->input->post('compras_id')
	            );
	
	            if ($this->compras_model->add('lancamentos',$data) == TRUE) {
	                $compra = $this->input->post('compras_id');
	            	$data = array(
    	            	'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3));

					if ($this->compras_model->edit('compras', $data, 'idCompras', $compra) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar compra.');
	        	        $json = array('result'=>  false);
    		            echo json_encode($json);
    	    	        die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar compra.');
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
	                'documento' => $this->input->post('documentoCompra'),
	                'grupo' => 'Compras',
	                'observacao' => $this->input->post('observacaoCompra'),
	                'setor' => $this->input->post('setorCompra'),
    	            'compras_id' => $this->input->post('compras_id')
	            );
	
	            if ($this->compras_model->add('lancamentos',$data) == TRUE) {
	                $compra = $this->input->post('compras_id');
	            	$data = array(
    	            	'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4));

					if ($this->compras_model->edit('compras', $data, 'idCompras', $compra) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar compra.');
	        	        $json = array('result'=>  false);
    		            echo json_encode($json);
    	    	        die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar compra.');
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
	                'documento' => $this->input->post('documentoCompra'),
	                'grupo' => 'Compras',
	                'observacao' => $this->input->post('observacaoCompra'),
	                'setor' => $this->input->post('setorCompra'),
    	            'compras_id' => $this->input->post('compras_id')
	            );
	
	            if ($this->compras_model->add('lancamentos',$data) == TRUE) {
	                $compra = $this->input->post('compras_id');
	            	$data = array(
    	            	'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5));

					if ($this->compras_model->edit('compras', $data, 'idCompras', $compra) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar compra.');
	        	        $json = array('result'=>  false);
    		            echo json_encode($json);
    	    	        die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar compra.');
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
	                'documento' => $this->input->post('documentoCompra'),
	                'grupo' => 'Compras',
	                'observacao' => $this->input->post('observacaoCompra'),
	                'setor' => $this->input->post('setorCompra'),
    	            'compras_id' => $this->input->post('compras_id')
	            );
	
	            if ($this->compras_model->add('lancamentos',$data) == TRUE) {
	                $compra = $this->input->post('compras_id');
	            	$data = array(
    	            	'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5 + $valor6));

					if ($this->compras_model->edit('compras', $data, 'idCompras', $compra) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar compra.');
	        	        $json = array('result'=>  false);
    		            echo json_encode($json);
    	    	        die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar compra.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
			}


			auditoria('Faturamento de compras', 'Faturada compra "'.$compra.'"');

            $this->session->set_flashdata('success','Compra faturada com sucesso!');
            $json = array('result'=>  true);
            echo json_encode($json);
            die();
        }

        $this->session->set_flashdata('error','Erro ao faturar compra.');
        $json = array('result'=>  false);
        echo json_encode($json);
        
    }


}

