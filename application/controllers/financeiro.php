<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Financeiro extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
        	redirect('atual/login');
        }
        $this->load->model('financeiro_model','',TRUE);
        $this->data['menuFinanceiro'] = 'financeiro';
        $this->load->helper(array('codegen_helper'));
	}
	public function index(){
		$this->lancamentos();
	}

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->financeiro_model->autoCompleteCliente($q);
        }

    }

	public function lancamentos(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar lançamentos.');
           redirect(base_url());
        }

		$where = '';
		$tipo = $this->input->get('tipo');
		$situacao = $this->input->get('situacao');
		$grupo = $this->input->get('grupo');
		$documento = $this->input->get('documento');
		$cliente = $this->input->get('clientes_id');
		$vencimento = $this->input->get('vencimento');
		$vencimento2 = $this->input->get('vencimento2');
		$setor = $this->input->get('setor');

        
        // busca os lançamentos
   	    if(rtrim($tipo) == "receita"){
	        $where = $where.'tipo = "receita"';
        };
	    if(rtrim($tipo) == "despesa"){
	        $where = $where.'tipo = "despesa"';
        };

	    if(rtrim($situacao) == "pago"){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'baixado = "1"';
        };
	    if(rtrim($situacao) == "pendente"){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'baixado = "0"';
        };

	    if(rtrim($cliente) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'clientes_id = '.$cliente;
        };
	
	    if(rtrim($grupo) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'grupo = "'.$grupo.'"';
        };

	    if(rtrim($setor) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'setor = "'.$setor.'"';
        };

	    if(rtrim($documento) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'documento = "'.$documento.'"';
        };

		if (rtrim($vencimento) <> '') {
           	$vencimento = explode('/', $vencimento);
            $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'data_vencimento >= "'.$vencimento.'"';
		};
		if (rtrim($vencimento2) <> '') {
           	$vencimento2 = explode('/', $vencimento2);
            $vencimento2 = $vencimento2[2].'-'.$vencimento2[1].'-'.$vencimento2[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'data_vencimento <= "'.$vencimento2.'"';
		};
		
		$this->load->library('pagination');
        
        $config['base_url'] = base_url().'financeiro/lancamentos';
        $config['total_rows'] = $this->financeiro_model->count('lancamentos');
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

		$this->data['results'] = $this->financeiro_model->get('lancamentos','*',$where,$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'financeiro/lancamentos';
       	$this->load->view('tema/topo',$this->data);
	}



	function adicionarReceita() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar lançamentos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');
        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $valor = str_replace(",",".", set_value('valor'));
            $vencimento = $this->input->post('vencimento');
            $recebimento = $this->input->post('recebimento');

            if($recebimento != null){
                $recebimento = explode('/', $recebimento);
                $recebimento = $recebimento[2].'-'.$recebimento[1].'-'.$recebimento[0];
            }

            if($vencimento == null){
                $vencimento = date('d/m/Y');
            }
            
            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];   

            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }

            $data = array(
                'descricao' => set_value('descricao'),
				'valor' => $valor,
				'data_vencimento' => $vencimento,
				'data_pagamento' => $recebimento != null ? $recebimento : date('Y-m-d'),
				'baixado' => $this->input->post('recebido'),
				'cliente_fornecedor' => set_value('cliente'),
				'forma_pgto' => $this->input->post('formaPgto'),
				'tipo' => set_value('tipo'),
				'documento' => $this->input->post('documento'),
				'grupo' => $this->input->post('grupo'),
				'observacao' => $this->input->post('observacao'),
				'setor' => $this->input->post('setor'),
				'clientes_id' => $this->input->post('clientesIncluir_id')
            );

            if ($this->financeiro_model->add('lancamentos',$data) == TRUE) {
				auditoria('Inclusão de receitas', 'Receita "'.set_value('descricao').'" cadastrada no sistema');
                $this->session->set_flashdata('success','Receita adicionada com sucesso!');
                redirect($urlAtual);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->session->set_flashdata('error','Erro ao adicionar receita.');
        redirect($urlAtual);
        
    }


    function adicionarDespesa() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar lançamentos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');
        if ($this->form_validation->run('despesa') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $vencimento = $this->input->post('vencimento');
            $pagamento = $this->input->post('pagamento');
            $valor = str_replace(",",".", set_value('valor'));

            if($pagamento != null){
                $pagamento = explode('/', $pagamento);
                $pagamento = $pagamento[2].'-'.$pagamento[1].'-'.$pagamento[0];
            }

            if($vencimento == null){
                $vencimento = date('d/m/Y');
            }

            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];

            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }

            $data = array(
                'descricao' => set_value('descricao'),
				'valor' => $valor,
				'data_vencimento' => $vencimento,
				'data_pagamento' => $pagamento != null ? $pagamento : date('Y-m-d'),
				'baixado' => $this->input->post('pago'),
				'cliente_fornecedor' => set_value('fornecedor'),
				'forma_pgto' => $this->input->post('formaPgto'),
				'tipo' => set_value('tipo'),
				'documento' => $this->input->post('documento'),
				'grupo' => $this->input->post('grupo'),
				'observacao' => $this->input->post('observacao'),
				'setor' => $this->input->post('setor'),
				'clientes_id' => $this->input->post('fornecedoresIncluir_id')
            );

            if ($this->financeiro_model->add('lancamentos',$data) == TRUE) {
				auditoria('Inclusão de despesas', 'Despesa "'.set_value('descricao').'" cadastrada no sistema');
                $this->session->set_flashdata('success','Despesa adicionada com sucesso!');
                redirect($urlAtual);
            } else {
                $this->session->set_flashdata('error','Erro ao adicionar despesa!');
                redirect($urlAtual);
            }
        }

        $this->session->set_flashdata('error','Erro ao adicionar despesa.');
        redirect($urlAtual);
        
        
    }


    public function editar(){   
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para editar lançamentos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');

        $this->form_validation->set_rules('descricao', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('fornecedor', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('valor', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('vencimento', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pagamento', '', 'trim|xss_clean');
        $this->form_validation->set_rules('documento', '', 'trim|xss_clean');
        $this->form_validation->set_rules('grupo', '', 'trim|xss_clean');
        $this->form_validation->set_rules('observacao', '', 'trim|xss_clean');
        $this->form_validation->set_rules('setor', '', 'trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $vencimento = $this->input->post('vencimento');
            $pagamento = $this->input->post('pagamento');
            $valor = str_replace(",",".", $this->input->post('valor'));
			
            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];

                $pagamento = explode('/', $pagamento);
                $pagamento = $pagamento[2].'-'.$pagamento[1].'-'.$pagamento[0];

            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }
			
			if(ltrim(rtrim($pagamento))<>'--'){
					
	            $data = array(
	                'descricao' => $this->input->post('descricao'),
	                'valor' => $valor,
	                'data_vencimento' => $vencimento,
	                'baixado' => $this->input->post('pago'),
	                'cliente_fornecedor' => $this->input->post('fornecedor'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documento'),
	                'grupo' => $this->input->post('grupo'),
	                'observacao' => $this->input->post('observacao'),
					'setor' => $this->input->post('setor'),
					'clientes_id' => $this->input->post('fornecedoresEditar_id'),
					'data_pagamento' => $pagamento != null ? $pagamento : date('Y-m-d')
	            );
			}
			else{
					
	            $data = array(
	                'descricao' => $this->input->post('descricao'),
	                'valor' => $valor,
	                'data_vencimento' => $vencimento,
	                'baixado' => $this->input->post('pago'),
	                'cliente_fornecedor' => $this->input->post('fornecedor'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documento'),
	                'grupo' => $this->input->post('grupo'),
	                'observacao' => $this->input->post('observacao'),
					'setor' => $this->input->post('setor'),
					'clientes_id' => $this->input->post('fornecedoresEditar_id')
	            );
				
			}

            if ($this->financeiro_model->edit('lancamentos',$data,'idLancamentos',$this->input->post('id')) == TRUE) {
				auditoria('Alteração de lançamentos', 'Alterado lançamento "'.$this->input->post('descricao').'"');
                $this->session->set_flashdata('success','lançamento editado com sucesso!');
                redirect($urlAtual);
            } else {
                $this->session->set_flashdata('error','Erro ao editar lançamento!');
                redirect($urlAtual);
            }
        }

        $this->session->set_flashdata('error','Erro ao editar lançamento.');
        redirect($urlAtual);

    }


    public function excluirLancamento(){   

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir lançamentos.');
           redirect(base_url());
        }

    	$id = $this->input->post('id');
        $descricao = $this->financeiro_model->getById($id)->descricao;
		
    	if($id == null || ! is_numeric($id)){
    		$json = array('result'=>  false);
    		echo json_encode($json);
    	}
    	else{

    		$result = $this->financeiro_model->delete('lancamentos','idLancamentos',$id); 
    		if($result){
    			$json = array('result'=>  true);
    			echo json_encode($json);
				auditoria('Exclusão de lançamentos', 'Excluído lançamento "'.$descricao.'"');
    		}
    		else{
    			$json = array('result'=>  false);
    			echo json_encode($json);
    		}
    		
    	}
    }


    function visualizar() {
      
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar lançamento.');
           redirect(base_url());
        }

        $this->data['result'] = $this->financeiro_model->getById($this->uri->segment(3));

        if($this->data['result'] == null){
            $this->session->set_flashdata('error','Lançamento não encontrado.');
            redirect(base_url() . 'index.php/financeiro/editar/'.$this->input->post('idLancamentos'));
        }

        $this->data['view'] = 'financeiro/visualizarLancamentos';
        $this->load->view('tema/topo', $this->data);
    }
	

	protected function getThisYear() {

        $dias = date("z");
        $primeiro = date("Y-m-d", strtotime("-".($dias)." day"));
        $ultimo = date("Y-m-d", strtotime("+".( 364 - $dias)." day"));
        return array($primeiro,$ultimo);

    }

    protected function getThisWeek(){

        return array(date("Y/m/d", strtotime("last sunday", strtotime("now"))),date("Y/m/d", strtotime("next saturday", strtotime("now"))));
    }

    protected function getLastSevenDays() {

        return array(date("Y-m-d", strtotime("-7 day", strtotime("now"))), date("Y-m-d", strtotime("now")));
    }

    protected function getThisMonth(){

        $mes = date('m');
        $ano = date('Y'); 
        $qtdDiasMes = date('t');
        $inicia = $ano."-".$mes."-01";

        $ate = $ano."-".$mes."-".$qtdDiasMes;
        return array($inicia, $ate);
    }

}

