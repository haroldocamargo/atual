<?php

class Os extends CI_Controller {
    
    function __construct() {
        parent::__construct();
                if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
                    redirect('atual/login');
                }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('os_model','',TRUE);
		$this->load->model('estoque_model','',TRUE);
		$this->load->model('financeiro_model','',TRUE);
		$this->data['menuOs'] = 'OS';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

		$where = '';
		$os = $this->input->get('os');
		$cliente = $this->input->get('clientes_id');
		$documento = $this->input->get('documento');
		$vencimento = $this->input->get('vencimento');
		$vencimento2 = $this->input->get('vencimento2');
		$status = $this->input->get('status');
		$usuario = $this->input->get('usuarios_id');
		$setor = $this->input->get('setor');
		$modelo = $this->input->get('modelo');

        // busca os lançamentos
	    if(rtrim($os) <> ''){
	        $where = 'idOs = '.$os;
        };

	    if(rtrim($cliente) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'clientes_id = '.$cliente;
        };
	
	    if(rtrim($documento) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'documentoOs like "%'.$documento.'%"';
        };

	    if(rtrim($modelo) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'modelo like "%'.$modelo.'%"';
        };

		if (rtrim($vencimento) <> '') {
           	$vencimento = explode('/', $vencimento);
            $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'dataFinal >= "'.$vencimento.'"';
		};
		if (rtrim($vencimento2) <> '') {
           	$vencimento2 = explode('/', $vencimento2);
            $vencimento2 = $vencimento2[2].'-'.$vencimento2[1].'-'.$vencimento2[0];
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'dataFinal <= "'.$vencimento2.'"';
		};
        
	    if(rtrim($status) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'status = "'.$status.'"';
        };

	    if(rtrim($usuario) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'usuarios_id = "'.$usuario.'"';
        };

	    if(rtrim($setor) <> ''){
	    	if (rtrim($where) <> '') {$where = $where.' and ';}
	        $where = $where.'setorOs = "'.$setor.'"';
        };


        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/os/gerenciar/';
        $config['total_rows'] = $this->os_model->count('os');
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

		$this->data['results'] = $this->os_model->get('os','*',$where,$config['per_page'],$this->uri->segment(3));
	    $this->data['view'] = 'os/os';
       	$this->load->view('tema/topo',$this->data);
      
		
    }
	
    function adicionar(){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        if ($this->form_validation->run('os') == false) {
           $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');

            try {
                
                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2].'-'.$dataInicial[1].'-'.$dataInicial[0];

                $dataFinal = explode('/', $dataFinal);
                $dataFinal = $dataFinal[2].'-'.$dataFinal[1].'-'.$dataFinal[0];

            } catch (Exception $e) {
               $dataInicial = date('Y/m/d'); 
            }

            $data = array(
                'dataInicial' => $dataInicial,
                'clientes_id' => $this->input->post('clientes_id'),//set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'),//set_value('idUsuario'),
                'dataFinal' => $dataFinal,
                'garantia' => set_value('garantia'),
                'descricaoProduto' => set_value('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacaoOs' => $this->input->post('observacaoOs'),
                'laudoTecnico' => set_value('laudoTecnico'),
                'faturado' => 0,
                'setorOs' => $this->input->post('setorOs'),
                'modelo' => $this->input->post('modelo'),
                'documentoOs' => $this->input->post('documentoOs')
            );

            if ( is_numeric($id = $this->os_model->add('os', $data, true)) ) {
				auditoria('Inclusão de OS', 'Os "'.$id.'" cadastrada no sistema');
                $this->session->set_flashdata('success','OS adicionada com sucesso, você pode adicionar produtos ou serviços a essa OS nas abas de "Produtos" e "Serviços"!');
                redirect('os/editar/'.$id);

            } else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
         
        $this->data['view'] = 'os/adicionarOs';
        $this->load->view('tema/topo', $this->data);
    }
    
    public function adicionarAjax(){
        $this->load->library('form_validation');

        if ($this->form_validation->run('os') == false) {
           $json = array("result"=> false);
           echo json_encode($json);
        } else {
            $data = array(
                'dataInicial' => set_value('dataInicial'),
                'clientes_id' => $this->input->post('clientes_id'),//set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'),//set_value('idUsuario'),
                'dataFinal' => set_value('dataFinal'),
                'garantia' => set_value('garantia'),
                'descricaoProduto' => set_value('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacaoOs' => set_value('observacaoOs'),
                'laudoTecnico' => set_value('laudoTecnico'),
                'setorOs' => $this->input->post('setorOs'),
                'modelo' => $this->input->post('modelo'),
                'documentoOs' => $this->input->post('documentoOs')
            );

            if ( is_numeric($id = $this->os_model->add('os', $data, true)) ) {
                $json = array("result"=> true, "id"=> $id);
                echo json_encode($json);

            } else {
                $json = array("result"=> false);
                echo json_encode($json);

            }
        }
         
    }


    
    function editar() {
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('os') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');

            try {
                
                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2].'-'.$dataInicial[1].'-'.$dataInicial[0];

                $dataFinal = explode('/', $dataFinal);
                $dataFinal = $dataFinal[2].'-'.$dataFinal[1].'-'.$dataFinal[0];

            } catch (Exception $e) {
               $dataInicial = date('Y/m/d'); 
            }

            $data = array(
                'dataInicial' => $dataInicial,
                'dataFinal' => $dataFinal,
                'garantia' => $this->input->post('garantia'),
                'descricaoProduto' => $this->input->post('descricaoProduto'),
                'defeito' => $this->input->post('defeito'),
                'status' => $this->input->post('status'),
                'observacaoOs' => $this->input->post('observacaoOs'),
                'laudoTecnico' => $this->input->post('laudoTecnico'),
                'usuarios_id' => $this->input->post('usuarios_id'),
                'clientes_id' => $this->input->post('clientes_id'),
                'setorOs' => $this->input->post('setorOs'),
                'modelo' => $this->input->post('modelo'),
                'documentoOs' => $this->input->post('documentoOs')
            );

            if ($this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs')) == TRUE) {
				auditoria('Alteração de OS', 'Alterada OS "'.$this->input->post('idOs').'"');
                $this->session->set_flashdata('success','Os editada com sucesso!');
                redirect(base_url() . 'index.php/os/editar/'.$this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['anexos'] = $this->os_model->getAnexos($this->uri->segment(3));
        $this->data['view'] = 'os/editarOs';
        $this->load->view('tema/topo', $this->data);
   
    }

    public function visualizar(){

        $this->data['custom_error'] = '';
        $this->load->model('atual_model');
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['emitente'] = $this->atual_model->getEmitente();

        $this->data['view'] = 'os/visualizarOs';
        $this->load->view('tema/topo', $this->data);
       
    }
	
    function excluir(){

        $id =  $this->uri->segment(3);
        $documentoOs = $this->os_model->getById($id)->documentoOs;
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao excluir OS.');            
            redirect(base_url().'index.php/os/gerenciar/');
        }

		if($this->os_model->delete('servicos_os','os_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir serviço da OS.');
	        redirect(base_url().'index.php/os/gerenciar/');
		}

		$itensOs = $this->os_model->getProdutos($id);
        if($itensOs != null){
			foreach ($itensOs as $i) {
				$this->estoque_model->somaEstoque($i->quantidade, $i->produtos_id);
            }
        }

		if($this->os_model->delete('produtos_os','os_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir produto da OS.');
	        redirect(base_url().'index.php/os/gerenciar/');
		}
		auditoria('Exclusão de OS', 'Excluídos produtos da OS "'.$id.'"');

		if($this->os_model->delete('anexos','os_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir anexo da OS.');
	        redirect(base_url().'index.php/os/gerenciar/');
		}
		auditoria('Exclusão de OS', 'Excluídos anexos da OS "'.$id.'"');

		if($this->os_model->delete('lancamentos','os_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir OS.');
	        redirect(base_url().'index.php/os/gerenciar/');
		}
		auditoria('Exclusão de OS', 'Excluído faturamento da OS "'.$id.'"');

		if($this->os_model->delete('estoque','os_id', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir estoque da OS.');
	        redirect(base_url().'index.php/os/gerenciar/');
		}
		auditoria('Exclusão de OS', 'Excluído estoque da OS "'.$id.'"');
		
		if($this->os_model->delete('os','idOs', $id) == FALSE){
			$this->session->set_flashdata('error','Erro ao excluir OS.');
	        redirect(base_url().'index.php/os/gerenciar/');
		}
		auditoria('Exclusão de OS', 'Excluída OS "'.$id.'"');

        $this->session->set_flashdata('success','OS excluída com sucesso!');            
        redirect(base_url().'index.php/os/gerenciar/');
    }

    public function autoCompleteProduto(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteProduto($q);
        }

    }

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteCliente($q);
        }

    }

    public function autoCompleteUsuario(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteUsuario($q);
        }

    }

    public function autoCompleteServico(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteServico($q);
        }

    }

    public function adicionarProduto(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Os');
          redirect(base_url());
        }

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
            'os_id'=> $this->input->post('idOsProduto')
        );

        if($this->os_model->add('produtos_os', $data) == true){

			$this->estoque_model->subtraiEstoque($quantidade, $produto);
            
			$dataOs = $this->input->post('dataOs');
            $dataOs = explode('/', $dataOs);
            $dataOs = $dataOs[2].'-'.$dataOs[1].'-'.$dataOs[0];

            $data2 = array(
 				'data' => $dataOs,
				'tipo' => 'saida',
				'documentoEstoque' => $this->input->post('documentoOs'),
				'serie' => $this->input->post('serie'),
				'produtos_id' => $produto,
                'os_id'=> $this->input->post('idOsProduto'),
				'quantidade' => $quantidade,
				'valor' => $preco,
				'subTotal' => $subtotal,
                'setorEstoque' => $this->input->post('setorOs'),
				'observacaoEstoque' => $this->input->post('observacaoItem')
            );

    	    if($this->estoque_model->add('estoque',$data2)){
				auditoria('Inclusão de produto em os', 'Inclusão do produto "'.$produto.'" na OS '.$this->input->post('idOsProduto'));
    	        echo json_encode(array('result'=> true));}
			else {
                echo json_encode(array('result'=> false));
			}	
			
        }else{
            echo json_encode(array('result'=> false));
        }
      
    }

    function excluirProduto(){

	        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
    	      $this->session->set_flashdata('error','Você não tem permissão para editar Os');
        	  redirect(base_url());
        	}
			
            $ID = $this->input->post('idProduto');
            $Os = $this->input->post('idOs');
            if($this->os_model->delete('produtos_os','idProdutos_os',$ID) == true){
                $quantidade = $this->input->post('quantidade');
                $produto = $this->input->post('produto');
				if($this->estoque_model->somaEstoque($quantidade, $produto) == FALSE){
					$this->session->set_flashdata('error','Erro ao calcular o estoque.');
	                echo json_encode(array('result'=> false));
				}
                
				$data = array('os_id' => $Os, 
					'produtos_id' => $produto);
		        if ($this->os_model->deleteWhere('estoque', $data) == FALSE){
					$this->session->set_flashdata('error','Erro ao excluir o lançamento de estoque.');
	                echo json_encode(array('result'=> false));
		        }
				else{
					auditoria('Exclusão de produto em os', 'Exclusão do produto "'.$produto.'" na Os '.$Os);
    	            echo json_encode(array('result'=> true));
				}

            }
            else{
				$this->session->set_flashdata('error','Erro ao excluir o produto da Os.');
                echo json_encode(array('result'=> false));
            }           
    }



    public function adicionarServico(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Os');
          redirect(base_url());
        }

        $preco = str_replace(",",".", $this->input->post('precoServico'));
        $subtotal = $preco * 1;
        
        $data = array(
            'servicos_id'=> $this->input->post('idServico'),
            'os_id'=> $this->input->post('idOsServico'),
            'valor'=> $preco,
            'quantidade'=> 1,
            'observacaoServicoOs'=> $this->input->post('observacaoItemServico'),
            'subTotal'=> $subtotal
        );

        if($this->os_model->add('servicos_os', $data) == true){

			auditoria('Inclusão de servico em os', 'Inclusão do servico "'.$this->input->post('idServico').'" na OS '.$this->input->post('idOsServico'));
            echo json_encode(array('result'=> true));
        }else{
            echo json_encode(array('result'=> false));
        }

    }

    function excluirServico(){

	        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
    	      $this->session->set_flashdata('error','Você não tem permissão para editar Os');
        	  redirect(base_url());
        	}
			
            $ID = $this->input->post('idServico');
            $Os = $this->input->post('idOs');
            if($this->os_model->delete('servicos_os','idServicos_os',$ID) == true){

				auditoria('Exclusão de serviço em os', 'Exclusão do serviço "'.$ID.'" na os '.$Os);
                echo json_encode(array('result'=> true));
            }
            else{
                echo json_encode(array('result'=> false));
            }
    }


    public function anexar(){

        $this->load->library('upload');
        $this->load->library('image_lib');

        $upload_conf = array(
            'upload_path'   => realpath('./assets/anexos'),
            'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF|cdr|CDR|docx|DOCX|txt', // formatos permitidos para anexos de os
            'max_size'      => 0,
            );
    
        $this->upload->initialize( $upload_conf );
        
        // Change $_FILES to new vars and loop them
        foreach($_FILES['userfile'] as $key=>$val)
        {
            $i = 1;
            foreach($val as $v)
            {
                $field_name = "file_".$i;
                $_FILES[$field_name][$key] = $v;
                $i++;   
            }
        }
        // Unset the useless one ;)
        unset($_FILES['userfile']);
    
        // Put each errors and upload data to an array
        $error = array();
        $success = array();
        
        // main action to upload each file
        foreach($_FILES as $field_name => $file)
        {
            if ( ! $this->upload->do_upload($field_name))
            {
                // if upload fail, grab error 
                $error['upload'][] = $this->upload->display_errors();
            }
            else
            {
                // otherwise, put the upload datas here.
                // if you want to use database, put insert query in this loop
                $upload_data = $this->upload->data();
                
                if($upload_data['is_image'] == 1){

                   // set the resize config
                    $resize_conf = array(
                        // it's something like "/full/path/to/the/image.jpg" maybe
                        'source_image'  => $upload_data['full_path'], 
                        // and it's "/full/path/to/the/" + "thumb_" + "image.jpg
                        // or you can use 'create_thumbs' => true option instead
                        'new_image'     => $upload_data['file_path'].'thumbs/thumb_'.$upload_data['file_name'],
                        'width'         => 200,
                        'height'        => 125
                        );

                    // initializing
                    $this->image_lib->initialize($resize_conf);

                    // do it!
                    if ( ! $this->image_lib->resize())
                    {
                        // if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    }
                    else
                    {
                        // otherwise, put each upload data to an array.
                        $success[] = $upload_data;

                        $this->load->model('Os_model');

                        $this->Os_model->anexar($this->input->post('idOsAnexo'), $upload_data['file_name'] ,base_url().'assets/anexos/','thumb_'.$upload_data['file_name'],realpath('./assets/anexos/'));

                    } 
                }
                else{

                    $success[] = $upload_data;

                    $this->load->model('Os_model');

                    $this->Os_model->anexar($this->input->post('idOsAnexo'), $upload_data['file_name'] ,base_url().'assets/anexos/','',realpath('./assets/anexos/'));
 
                }
                
            }
        }

        // see what we get
        if(count($error) > 0)
        {
            //print_r($data['error'] = $error);
            echo json_encode(array('result'=> false, 'mensagem' => 'Nenhum arquivo foi anexado.'));
        }
        else
        {
            //print_r($data['success'] = $upload_data);			
            auditoria('Inclusão de anexo em os', 'Inclusão do anexo "'.$upload_data['file_name'].'" na OS '.$this->input->post('idOsAnexo'));
            echo json_encode(array('result'=> true, 'mensagem' => 'Arquivo(s) anexado(s) com sucesso .'));
        }
        

    }


    public function excluirAnexo($id = null){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Os');
          redirect(base_url());
        }

        if($id == null || !is_numeric($id)){
            echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao excluir anexo.'));
        }
        else{

            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();
            $idOs = $this->os_model->getAnexoById($id)->os_id;

            unlink($file->path.'/'.$file->anexo);

            if($file->thumb != null){
                unlink($file->path.'/thumbs/'.$file->thumb);    
            }
            
            if($this->os_model->delete('anexos','idAnexos',$id) == true){

				auditoria('Exclusão de anexo em os', 'Exclusão do anexo "'.$id.'" da OS '.$idOs);
                echo json_encode(array('result'=> true, 'mensagem' => 'Anexo excluído com sucesso.'));
            }
            else{
                echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao excluir anexo.'));
            }

            
        }
    }


    public function downloadanexo($id = null){
        
        if($id != null && is_numeric($id)){
            
            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();

            $this->load->library('zip');

            $path = $file->path;

            $this->zip->read_file($path.'/'.$file->anexo); 

            $this->zip->download('file'.date('d-m-Y-H.i.s').'.zip'); 

        }
      
    }


    public function faturar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Os');
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
            $vencimento7 = $this->input->post('vencimento7');
            $vencimento8 = $this->input->post('vencimento8');
            $vencimento9 = $this->input->post('vencimento9');
            $vencimento10 = $this->input->post('vencimento10');
            $vencimento11 = $this->input->post('vencimento11');
            $vencimento12 = $this->input->post('vencimento12');

            $recebimento = $this->input->post('recebimento');

            $valor = str_replace(",",".", $this->input->post('valor'));
   	        $valor2 = str_replace(",",".", $this->input->post('valor2'));
   	        $valor3 = str_replace(",",".", $this->input->post('valor3'));
   	        $valor4 = str_replace(",",".", $this->input->post('valor4'));
   	        $valor5 = str_replace(",",".", $this->input->post('valor5'));
   	        $valor6 = str_replace(",",".", $this->input->post('valor6'));
   	        $valor7 = str_replace(",",".", $this->input->post('valor7'));
   	        $valor8 = str_replace(",",".", $this->input->post('valor8'));
   	        $valor9 = str_replace(",",".", $this->input->post('valor9'));
   	        $valor10 = str_replace(",",".", $this->input->post('valor10'));
   	        $valor11 = str_replace(",",".", $this->input->post('valor11'));
   	        $valor12 = str_replace(",",".", $this->input->post('valor12'));
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

				if (rtrim($vencimento7) <> '') {
                	$vencimento7 = explode('/', $vencimento7);
	                $vencimento7 = $vencimento7[2].'-'.$vencimento7[1].'-'.$vencimento7[0];
				}

				if (rtrim($vencimento8) <> '') {
                	$vencimento8 = explode('/', $vencimento8);
	                $vencimento8 = $vencimento8[2].'-'.$vencimento8[1].'-'.$vencimento8[0];
				}

				if (rtrim($vencimento9) <> '') {
                	$vencimento9 = explode('/', $vencimento9);
	                $vencimento9 = $vencimento9[2].'-'.$vencimento9[1].'-'.$vencimento9[0];
				}

				if (rtrim($vencimento10) <> '') {
                	$vencimento10 = explode('/', $vencimento10);
	                $vencimento10 = $vencimento10[2].'-'.$vencimento10[1].'-'.$vencimento10[0];
				}

				if (rtrim($vencimento11) <> '') {
                	$vencimento11 = explode('/', $vencimento11);
	                $vencimento11 = $vencimento11[2].'-'.$vencimento11[1].'-'.$vencimento11[0];
				}

				if (rtrim($vencimento12) <> '') {
                	$vencimento12 = explode('/', $vencimento12);
	                $vencimento12 = $vencimento12[2].'-'.$vencimento12[1].'-'.$vencimento12[0];
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
                'documento' => $this->input->post('documentoOs'),
                'grupo' => 'Os',
                'observacao' => $this->input->post('observacaoOs'),
                'setor' => $this->input->post('setorOs'),
                'os_id' => $this->input->post('os_id')
                );

            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
                $os = $this->input->post('os_id'); 
	            $data = array(
	                'status' => 'Finalizado',
    	            'faturado' => 1,
       	        	'valorTotal' => $valor);

				if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
    	            echo json_encode($json);
        	        die();
				}	

            } else {
                $this->session->set_flashdata('error','Erro ao faturar OS.');
                $json = array('result'=>  false);
                echo json_encode($json);
                die();
            }

			if ((rtrim($vencimento2) <> '') && ($valor2 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor2,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento2,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }

			if ((rtrim($vencimento3) <> '') && ($valor3 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor3,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento3,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }

			if ((rtrim($vencimento4) <> '') && ($valor4 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor4,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento4,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }

			if ((rtrim($vencimento5) <> '') && ($valor5 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor5,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento5,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }

			if ((rtrim($vencimento6) <> '') && ($valor6 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor6,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento6,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5 + $valor6));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }

			if ((rtrim($vencimento7) <> '') && ($valor7 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor7,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento7,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5 + $valor6 + $valor7));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }


			if ((rtrim($vencimento8) <> '') && ($valor8 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor8,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento8,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5 + $valor6 + $valor7 + $valor8));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }

			if ((rtrim($vencimento9) <> '') && ($valor9 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor9,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento9,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5 + $valor6 + $valor7 + $valor8 + $valor9));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }

			if ((rtrim($vencimento10) <> '') && ($valor10 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor10,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento10,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5 + $valor6 + $valor7 + $valor8 + $valor9 + $valor10));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }


			if ((rtrim($vencimento11) <> '') && ($valor11 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor11,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento11,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5 + $valor6 + $valor7 + $valor8 + $valor9 + $valor10 + $valor11));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }


			if ((rtrim($vencimento12) <> '') && ($valor12 <> '')){
	            $data = array(
	                'descricao' => set_value('descricao'),
	                'valor' => $valor12,
	                'clientes_id' => $this->input->post('clientes_id'),
	                'data_vencimento' => $vencimento12,
	                'baixado' => $this->input->post('recebido'),
	                'cliente_fornecedor' => set_value('cliente'),
	                'forma_pgto' => $this->input->post('formaPgto'),
	                'tipo' => $this->input->post('tipo'),
	                'documento' => $this->input->post('documentoOs'),
	                'grupo' => 'Os',
	                'observacao' => $this->input->post('observacaoOs'),
	                'setor' => $this->input->post('setorOs'),
	                'os_id' => $this->input->post('os_id')
	                );
	
	            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
	                $os = $this->input->post('os_id'); 
		            $data = array(
		                'status' => 'Finalizado',
	    	            'faturado' => 1,
        	        	'valorTotal' => ($valor + $valor2 + $valor3 + $valor4 + $valor5 + $valor6 + $valor7 + $valor8 + $valor9 + $valor10 + $valor11 + $valor12));

					if ($this->os_model->edit('os', $data, 'idOs', $os) == FALSE){
		                $this->session->set_flashdata('error','Erro ao faturar OS.');
	    	            $json = array('result'=>  false);
    	    	        echo json_encode($json);
        	    	    die();
					}	

	            } else {
	                $this->session->set_flashdata('error','Erro ao faturar OS.');
	                $json = array('result'=>  false);
	                echo json_encode($json);
	                die();
	            }
            }


			auditoria('Faturamento de OS', 'Faturada OS "'.$os.'"');

            $this->session->set_flashdata('success','Os faturada com sucesso!');
            $json = array('result'=>  true);
            echo json_encode($json);
            die();
        }

        $this->session->set_flashdata('error','Erro ao faturar OS.');
        $json = array('result'=>  false);
        echo json_encode($json);
        die();
        
    }

}

