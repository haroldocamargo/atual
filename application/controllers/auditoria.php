<?php

class Auditoria extends CI_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('atual/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('auditoria_model','',TRUE);
            $this->data['menuAuditoria'] = 'auditoria';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vAuditoria')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar auditoria.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
   
        $config['base_url'] = base_url().'index.php/auditoria/gerenciar/';
        $config['total_rows'] = $this->auditoria_model->count('auditoria');
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
        
	    $this->data['results'] = $this->auditoria_model->get('auditoria','*','',$config['per_page'],$this->uri->segment(3));
       	
       	$this->data['view'] = 'auditoria/auditoria';
       	$this->load->view('tema/topo',$this->data);

    }
	
}

