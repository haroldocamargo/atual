<?php

class Servicos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('atual/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('servicos_model', '', TRUE);
        $this->data['menuServicos'] = 'Serviços';
    }
	
	function index(){
		$this->gerenciar();
	}

    public function autoCompleteServico(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->servicos_model->autoCompleteServico($q);
        }
    }


	function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar serviços.');
           redirect(base_url());
        }

        $where = '';
		$codigo = $this->input->get('codigo');
		$servico = $this->input->get('servicos_id');
		$grupo = $this->input->get('grupo');
		$subgrupo = $this->input->get('subgrupo');
		$categoria = $this->input->get('categoria');
		$classe = $this->input->get('classe');
		$tipo = $this->input->get('tipo');
		
        // busca os estoque
	    if(rtrim($codigo) <> ''){
	        $where = 'idServicos = '.$codigo;
        };
	        
	    if(rtrim($servico) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'idServicos = '.$servico;
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
        
        $config['base_url'] = base_url().'index.php/servicos/gerenciar/';
        $config['total_rows'] = $this->servicos_model->count('servicos');
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

		$this->data['results'] = $this->servicos_model->get('servicos','idServicos,nome,descricao,preco',$where,$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'servicos/servicos';
       	$this->load->view('tema/topo',$this->data);

       
		
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aServico')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar serviços.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('servicos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $preco = $this->input->post('preco');
            $preco = str_replace(",",".", $preco);

            $data = array(
                'nome' => set_value('nome'),
                'descricao' => set_value('descricao'),
                'grupo' => set_value('grupo'),
                'subgrupo' => set_value('subgrupo'),
                'categoria' => set_value('categoria'),
                'classe' => set_value('classe'),
                'tipo' => set_value('tipo'),
                'observacaoServico' => set_value('observacaoServico'),
                'preco' => $preco
            );

            if ($this->servicos_model->add('servicos', $data) == TRUE) {
				auditoria('Inclusão de serviços', 'Serviço "'.set_value('nome').'" cadastrado no sistema');
                $this->session->set_flashdata('success', 'Serviço adicionado com sucesso!');
                redirect(base_url() . 'index.php/servicos/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'servicos/adicionarServico';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eServico')){
           $this->session->set_flashdata('error','Você não tem permissão para editar serviços.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('servicos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $preco = $this->input->post('preco');
            $preco = str_replace(",",".", $preco);
            $data = array(
                'nome' => $this->input->post('nome'),
                'descricao' => $this->input->post('descricao'),
                'grupo' => set_value('grupo'),
                'subgrupo' => set_value('subgrupo'),
                'categoria' => set_value('categoria'),
                'classe' => set_value('classe'),
                'tipo' => set_value('tipo'),
                'observacaoServico' => set_value('observacaoServico'),
                'preco' => $preco
            );

            if ($this->servicos_model->edit('servicos', $data, 'idServicos', $this->input->post('idServicos')) == TRUE) {
				auditoria('Alteração de serviços', 'Alterado cadastro do serviço "'.$this->input->post('nome').'"');
                $this->session->set_flashdata('success', 'Serviço editado com sucesso!');
                redirect(base_url() . 'index.php/servicos/editar/'.$this->input->post('idServicos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um errro.</p></div>';
            }
        }

        $this->data['result'] = $this->servicos_model->getById($this->uri->segment(3));

        $this->data['view'] = 'servicos/editarServico';
        $this->load->view('tema/topo', $this->data);

    }
	
    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dServico')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir serviços.');
           redirect(base_url());
        }
        
        $id =  $this->uri->segment(3);
        $nomeServico = $this->servicos_model->getById($id)->nome;
        if($id == null){
            $this->session->set_flashdata('error','Erro ao excluir serviço.');            
            redirect(base_url().'index.php/servicos/gerenciar/');
        }

        if($this->servicos_model->delete('servicos_os','servicos_id',$id) == FALSE){             
	        $this->session->set_flashdata('error','Erro ao excluir serviço de OS.');
	        redirect(base_url().'index.php/servicos/gerenciar/');
        }           

        if($this->servicos_model->delete('servicos','idServicos',$id) == FALSE){
	        $this->session->set_flashdata('error','Erro ao excluir serviço!');
	        redirect(base_url().'index.php/servicos/gerenciar/');
        }           
        
		auditoria('Exclusão de serviços', 'Excluído cadastro do serviço "'.$nomeServico.'"');

        $this->session->set_flashdata('success','Serviço excluido com sucesso!');            
        redirect(base_url().'index.php/servicos/gerenciar/');
    }

    function visualizar() {
      
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar serviços.');
           redirect(base_url());
        }

        $this->data['result'] = $this->servicos_model->getById($this->uri->segment(3));

        if($this->data['result'] == null){
            $this->session->set_flashdata('error','Serviço não encontrado.');
            redirect(base_url() . 'index.php/servicos/editar/'.$this->input->post('idServicoos'));
        }

        $this->data['view'] = 'servicos/visualizarServico';
        $this->load->view('tema/topo', $this->data);
     
    }
	
}

