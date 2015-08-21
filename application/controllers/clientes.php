<?php

class Clientes extends CI_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('atual/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('clientes_model','',TRUE);
            $this->load->model('estoque_model','',TRUE);
            $this->data['menuClientes'] = 'clientes';
	}	
	
	function index(){
		$this->gerenciar();
	}

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->clientes_model->autoCompleteCliente($q);
        }
    }


	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar pessoas.');
           redirect(base_url());
        }

        $where = '';
		$codigo = $this->input->get('codigo');
		$cliente = $this->input->get('clientes_id');
		$cnpjcpf = $this->input->get('cnpjcpf');
		$iergcompleto = $this->input->get('iergcompleto');

	    if(rtrim($codigo) <> ''){
	        $where = 'idClientes = '.$codigo;
        };
	        
	    if(rtrim($cliente) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'idClientes = '.$cliente;
        };
	
	    if(rtrim($cnpjcpf) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'documento = "'.$cnpjcpf.'"';
        };

	    if(rtrim($iergcompleto) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'documento2 = "'.$iergcompleto.'"';
        };

        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'index.php/clientes/gerenciar/';
        $config['total_rows'] = $this->clientes_model->count('clientes');
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
        
	    $this->data['results'] = $this->clientes_model->get('clientes','*',$where,$config['per_page'],$this->uri->segment(3));
       	
       	$this->data['view'] = 'clientes/clientes';
       	$this->load->view('tema/topo',$this->data);
		
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar pessoas.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $limite = str_replace(",",".", set_value('limite'));
            $data = array(
                'nomeCliente' => set_value('nomeCliente'),
                'documento' => set_value('documento'),
                'documento2' => set_value('documento2'),
                'telefone' => set_value('telefone'),
                'telefone2' => set_value('telefone2'),
                'celular' => $this->input->post('celular'),
                'email' => set_value('email'),
                'rua' => set_value('rua'),
                'numero' => set_value('numero'),
                'bairro' => set_value('bairro'),
                'cidade' => set_value('cidade'),
                'estado' => set_value('estado'),
                'cep' => set_value('cep'),
                'limite' => $limite,
                'observacaoCliente' => set_value('observacaoCliente'),
                'dataCadastro' => date('Y-m-d')
            );

            if ($this->clientes_model->add('clientes', $data) == TRUE) {
				auditoria('Inclusão de pessoas', 'Pessoa "'.set_value('nomeCliente').'" cadastrada no sistema');
                $this->session->set_flashdata('success','Pessoa adicionada com sucesso!');
                redirect(base_url() . 'index.php/clientes/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'clientes/adicionarCliente';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para editar pessoas.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $limite = str_replace(",",".", $this->input->post('limite'));
            $data = array(
                'nomeCliente' => $this->input->post('nomeCliente'),
                'documento' => $this->input->post('documento'),
                'documento2' => $this->input->post('documento2'),
                'telefone' => $this->input->post('telefone'),
                'telefone2' => $this->input->post('telefone2'),
                'celular' => $this->input->post('celular'),
                'email' => $this->input->post('email'),
                'rua' => $this->input->post('rua'),
                'numero' => $this->input->post('numero'),
                'bairro' => $this->input->post('bairro'),
                'cidade' => $this->input->post('cidade'),
                'estado' => $this->input->post('estado'),
                'cep' => $this->input->post('cep'),
                'limite' => $limite,
                'observacaoCliente' => $this->input->post('observacaoCliente')
            );

            if ($this->clientes_model->edit('clientes', $data, 'idClientes', $this->input->post('idClientes')) == TRUE) {
				auditoria('Alteração de pessoas', 'Alterado cadastro da pessoa "'.$this->input->post('nomeCliente').'"');
                $this->session->set_flashdata('success','Pessoa editada com sucesso!');
                redirect(base_url() . 'index.php/clientes/editar/'.$this->input->post('idClientes'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['view'] = 'clientes/editarCliente';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar pessoas.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['results'] = $this->clientes_model->getOsByCliente($this->uri->segment(3));
        $this->data['view'] = 'clientes/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
               $this->session->set_flashdata('error','Você não tem permissão para excluir pessoas.');
               redirect(base_url());
            }

            
            $id =  $this->input->post('id');
            $nomeCliente = $this->clientes_model->getById($id)->nomeCliente;
            if ($id == null){
                $this->session->set_flashdata('error','Erro ao excluir pessoa.');            
                redirect(base_url().'index.php/clientes/gerenciar/');
            }

            //$id = 2;
            // excluindo OSs vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $os = $this->db->get('os')->result();

            if($os != null){

                foreach ($os as $o) {
                    if($this->clientes_model->delete('servicos_os', 'os_id', $o->idOs) == FALSE){
	    	            $this->session->set_flashdata('error','Erro ao excluir serviço da OS da pessoa.');            
    	    	        redirect(base_url().'index.php/clientes/gerenciar/');
					}	

			        $this->db->where('os_id', $v->idOs);
			        $itensOs = $this->db->get('produto_os')->result();
			
			        if($itensOs != null){
						foreach ($itensOs as $i) {
							$this->estoque_model->somaEstoque($i->quantidade, $i->produtos_id);
			            }
			        }
					auditoria('Exclusão de pessoas', 'Atualizado estoque dos produtos da OS da pessoa "'.$nomeCliente.'"');

                    if($this->clientes_model->delete('produtos_os', 'os_id', $o->idOs) == FALSE){
	    	            $this->session->set_flashdata('error','Erro ao excluir produto da OS da pessoa.');            
    	    	        redirect(base_url().'index.php/clientes/gerenciar/');
					}	
					auditoria('Exclusão de pessoas', 'Excluídos produtos da OS da pessoa "'.$nomeCliente.'"');

                    if($this->clientes_model->delete('os', 'idOs', $o->idOs) == FALSE){
	    	            $this->session->set_flashdata('error','Erro ao excluir OS da pessoa.');            
    	    	        redirect(base_url().'index.php/clientes/gerenciar/');
					}	
					auditoria('Exclusão de pessoas', 'Excluídas OS da pessoa "'.$nomeCliente.'"');
                }
            }

            // excluindo Vendas vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $vendas = $this->db->get('vendas')->result();

            if($vendas != null){

                foreach ($vendas as $v) {

			        $this->db->where('vendas_id', $v->idVendas);
			        $itensVenda = $this->db->get('itens_de_vendas')->result();
			
			        if($itensVenda != null){
						foreach ($itensVenda as $i) {
							$this->db->query($sql, array($i->quantidade, $i->produtos_id));
							$this->estoque_model->somaEstoque($i->quantidade, $i->produtos_id);
			            }
			        }
					auditoria('Exclusão de pessoas', 'Atualizado estoque dos produtos de vendas da pessoa "'.$nomeCliente.'"');

                    if($this->clientes_model->delete('itens_de_vendas', 'vendas_id', $v->idVendas) == FALSE){
	    	            $this->session->set_flashdata('error','Erro ao excluir item de vendas da pessoa.');            
    	    	        redirect(base_url().'index.php/clientes/gerenciar/');
					}	
					auditoria('Exclusão de pessoas', 'Excluídos produtos de vendas da pessoa "'.$nomeCliente.'"');

                    if($this->clientes_model->delete('vendas', 'idVendas', $v->idVendas) == FALSE){
	    	            $this->session->set_flashdata('error','Erro ao excluir venda da pessoa.');            
    	    	        redirect(base_url().'index.php/clientes/gerenciar/');
					}	
					auditoria('Exclusão de pessoas', 'Excluídas vendas da pessoa "'.$nomeCliente.'"');
                }
            }

            // excluindo Compras vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $compras = $this->db->get('compras')->result();

            if($compras != null){

                foreach ($compras as $v) {
                	
			        $this->db->where('compras_id', $v->idCompras);
			        $itensCompra = $this->db->get('itens_de_compras')->result();
			
			        if($itensCompra != null){
						foreach ($itensCompra as $i) {
							$this->estoque_model->somaEstoque($i->quantidade, $i->produtos_id);
			            }
			        }
					auditoria('Exclusão de pessoas', 'Atualizado estoque dos produtos de compras da pessoa "'.$nomeCliente.'"');

                    if($this->clientes_model->delete('itens_de_compras', 'compras_id', $v->idCompras) == FALSE){
	    	            $this->session->set_flashdata('error','Erro ao excluir item de compra da pessoa.');            
    	    	        redirect(base_url().'index.php/clientes/gerenciar/');
					}	
					auditoria('Exclusão de pessoas', 'Excluídos produtos de compras da pessoa "'.$nomeCliente.'"');

                    if($this->clientes_model->delete('compras', 'idCompras', $v->idCompras) == FALSE){
	    	            $this->session->set_flashdata('error','Erro ao excluir compra da pessoa.');            
    	    	        redirect(base_url().'index.php/clientes/gerenciar/');
					}	
					auditoria('Exclusão de pessoas', 'Excluídas compras da pessoa "'.$nomeCliente.'"');
                }
            }

            //excluindo receitas vinculadas ao cliente
            if($this->clientes_model->delete('lancamentos','clientes_id', $id) == FALSE){ 
   	            $this->session->set_flashdata('error','Erro ao excluir lancamento da pessoa.'.$id);            
    	        redirect(base_url().'index.php/clientes/gerenciar/');
			}	
			auditoria('Exclusão de pessoas', 'Excluídas receitas e despesas da pessoa "'.$nomeCliente.'"');

            if($this->clientes_model->delete('clientes','idClientes',$id) == FALSE){
   	            $this->session->set_flashdata('error','Erro ao excluir pessoa.');            
    	        redirect(base_url().'index.php/clientes/gerenciar/');
			}	
			auditoria('Exclusão de pessoas', 'Excluído cadastro da pessoa "'.$nomeCliente.'"');
			
            $this->session->set_flashdata('success','Pessoa excluida com sucesso!');            
            redirect(base_url().'index.php/clientes/gerenciar/');
    }
}

