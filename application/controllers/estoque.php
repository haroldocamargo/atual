<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estoque extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
        	redirect('atual/login');
        }
        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('estoque_model','',TRUE);
        $this->load->helper(array('codegen_helper'));
        $this->data['menuEstoque'] = 'estoque';
	}
	public function index(){
		$this->estoque();
	}

    public function autoCompleteProduto(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->estoque_model->autoCompleteProduto($q);
        }

    }

	public function Estoque(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vEstoque')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar estoque.');
           redirect(base_url());
        }

		$where = '';
		$tipo = $this->input->get('tipo');
		$setor = $this->input->get('setorEstoque');
		$documento = $this->input->get('documento');
		$produto = $this->input->get('produtos_id');
		$serie = $this->input->get('serie');
		$data = $this->input->get('data');
		$data2 = $this->input->get('data2');

        
        // busca os estoque
   	    if(rtrim($tipo) == "entrada"){
	        $where = $where.'estoque.tipo = "entrada"';
        };
	    if(rtrim($tipo) == "saida"){
	        $where = $where.'estoque.tipo = "saida"';
        };

	    if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'estoque.produtos_id = produtos.idProdutos';

	    if(rtrim($produto) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'produtos_id = '.$produto;
        };
	
	    if(rtrim($documento) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'documentoEstoque = "'.$documento.'"';
        };

	    if(rtrim($serie) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'estoque.serie = "'.$serie.'"';
        };

	    if(rtrim($setor) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'setorEstoque = "'.$setor.'"';
        };

		if (rtrim($data) <> '') {
           	$data = explode('/', $data);
            $data = $data[2].'-'.$data[1].'-'.$data[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'data >= "'.$data.'"';
		};
		if (rtrim($data2) <> '') {
           	$data2 = explode('/', $data2);
            $data2 = $data2[2].'-'.$data2[1].'-'.$data2[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'data <= "'.$data2.'"';
		};
		
		$this->load->library('pagination');
        
        $config['base_url'] = base_url().'estoque/estoque';
        $config['total_rows'] = $this->estoque_model->count('estoque');
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

		$this->data['results'] = $this->estoque_model->get('estoque, produtos','estoque.*, produtos.descricao',$where,$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'estoque/estoque';
       	$this->load->view('tema/topo',$this->data);
	}



	function adicionarEntrada() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aEstoque')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar entrada no estoque.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');
        if ($this->form_validation->run('entrada') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else 
        {


            $data = $this->input->post('data');
			$idProduto = $this->input->post('produtosIncluir_id');

            if($data == null){
                $data = date('d/m/Y');
            }
            
            try {
                
                $data = explode('/', $data);
                $data = $data[2].'-'.$data[1].'-'.$data[0];   

            } catch (Exception $e) {
               $data = date('Y/m/d'); 
            }

            $valor = str_replace(",",".", set_value('valor'));
            $subtotal = str_replace(",",".", set_value('subtotal'));
	        $quantidade = str_replace(",",".", $this->input->post('quantidade'));

            $data = array(
				'data' => $data,
				'tipo' => $this->input->post('tipo'),
				'documentoEstoque' => $this->input->post('documento'),
				'serie' => $this->input->post('serie'),
				'produtos_id' => $this->input->post('produtosIncluir_id'),
				'quantidade' => $quantidade,
				'valor' => $valor,
				'subTotal' => $subtotal,
				'setorEstoque' => $this->input->post('setorEstoque'),
				'observacaoEstoque' => $this->input->post('observacao')
            );

            if ($this->estoque_model->add('estoque',$data) == TRUE) {

        		if($idProduto != null){
					$this->estoque_model->somaEstoque($quantidade, $idProduto);
        		}

				auditoria('Inclusão de entradas', 'Entrada do produto "'.$idProduto.'" cadastrada no sistema');
                $this->session->set_flashdata('success','Entrada adicionada com sucesso!');
                redirect($urlAtual);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->session->set_flashdata('error','Erro ao adicionar entrada.');
        redirect($urlAtual);
        
    }


    function adicionarSaida() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aEstoque')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar saída no estoque.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');
        if ($this->form_validation->run('saida') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else 
        {


            $data = $this->input->post('data');
			$idProduto = $this->input->post('produtos2Incluir_id');

            if($data == null){
                $data = date('d/m/Y');
            }
            
            try {
                
                $data = explode('/', $data);
                $data = $data[2].'-'.$data[1].'-'.$data[0];   

            } catch (Exception $e) {
               $data = date('Y/m/d'); 
            }

            $valor = str_replace(",",".", set_value('valor'));
            $subtotal = str_replace(",",".", set_value('subtotal'));
	        $quantidade = str_replace(",",".", $this->input->post('quantidade'));

            $data = array(
				'data' => $data,
				'tipo' => $this->input->post('tipo'),
				'documentoEstoque' => $this->input->post('documento'),
				'serie' => $this->input->post('serie'),
				'produtos_id' => $this->input->post('produtos2Incluir_id'),
				'quantidade' => $quantidade,
				'valor' => $valor,
				'subTotal' => $subtotal,
				'setorEstoque' => $this->input->post('setorEstoque'),
				'observacaoEstoque' => $this->input->post('observacao')
            );

            if ($this->estoque_model->add('estoque',$data) == TRUE) {

        		if($idProduto != null){
					$this->estoque_model->subtraiEstoque($quantidade, $idProduto);
        		}

				auditoria('Inclusão de saídas', 'Saída do produto "'.$idProduto.'" cadastrada no sistema');
                $this->session->set_flashdata('success','Saída adicionada com sucesso!');
                redirect($urlAtual);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->session->set_flashdata('error','Erro ao adicionar saída.');
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
        $this->form_validation->set_rules('data', '', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $valor = str_replace(",",".", $this->input->post('valor'));
            $data = $this->input->post('data');
			
            if($data == null){
                $data = date('d/m/Y');
            }
            
            try {
                
                $data = explode('/', $data);
                $data = $data[2].'-'.$data[1].'-'.$data[0];   

            } catch (Exception $e) {
               $data = date('Y/m/d'); 
            }

            $quantidade = str_replace(",",".", $this->input->post('quantidade'));
            $valor = str_replace(",",".", $this->input->post('valor'));
            $subtotal = str_replace(",",".", $this->input->post('subtotal'));

            $data = array(
				'data' => $data,
				'tipo' => $this->input->post('tipo'),
				'documentoEstoque' => $this->input->post('documento'),
				'serie' => $this->input->post('serie'),
				'produtos_id' => $this->input->post('produtosEditar_id'),
				'quantidade' => $quantidade,
				'valor' => $valor,
				'subTotal' => $subtotal,
				'setorEstoque' => $this->input->post('setor'),
				'observacaoEstoque' => $this->input->post('observacao')
            );
				
            if ($this->estoque_model->edit('Estoque',$data,'idEstoque',$this->input->post('id')) == TRUE) {
				auditoria('Alteração de estoque', 'Alterado estoque "'.$this->input->post('produto').'"');
                $this->session->set_flashdata('success','Estoque editado com sucesso!');
                redirect($urlAtual);
            } else {
                $this->session->set_flashdata('error','Erro ao editar estoque!');
                redirect($urlAtual);
            }
        }

        $this->session->set_flashdata('error','Erro ao editar estoque.'.$data);
        redirect($urlAtual);

    }

    public function excluirEstoque(){   

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dEstoque')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir estoques.');
           redirect(base_url());
        }
		
    	$id = $this->input->post('id');
        $documento = $this->estoque_model->getById($id)->documentoEstoque;
        $idProduto = $this->estoque_model->getById($id)->produtos_id;
        $quantidade = $this->estoque_model->getById($id)->quantidade;
        $tipo = $this->estoque_model->getById($id)->tipo;
		
    	if($id == null || ! is_numeric($id)){
    		$json = array('result'=>  false);
    		echo json_encode($json);
    	}
    	else{
    		$result = $this->estoque_model->delete('estoque','idEstoque',$id); 
    		if($result){
        		if($idProduto != null){
					if ($tipo='saida'){	
						if ($this->estoque_model->somaEstoque($quantidade, $idProduto) == FALSE){
			    			$json = array('result'=>  false);
			    			echo json_encode($json);
							die();
						}
					}
					else{	
						if ($this->estoque_model->subtraiEstoque($quantidade, $idProduto)<> TRUE){
			    			$json = array('result'=>  false);
			    			echo json_encode($json);
							die();
						}
					}
        		}

				auditoria('Exclusão de estoque', 'Excluído lançamento de estoque do produto "'.$idProduto.'"');
    			$json = array('result'=>  true);
    			echo json_encode($json);
    		}
    		else{
    			$json = array('result'=>  false);
    			echo json_encode($json);
    		}
    		
    	}
    }


    function visualizar() {
      
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vEstoque')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar estoque.');
           redirect(base_url());
        }

        $this->data['result'] = $this->estoque_model->getById($this->uri->segment(3));

        if($this->data['result'] == null){
            $this->session->set_flashdata('error','Estoque não encontrado.');
            redirect(base_url() . 'index.php/estoque/editar/'.$this->input->post('idEstoque'));
        }

        $this->data['view'] = 'estoque/visualizarEstoque';
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

