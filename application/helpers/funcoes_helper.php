<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

//seta um registro na tabela de auditoria
function auditoria($operacao, $obs='', $query=TRUE){
	$CI =& get_instance();
	$CI->load->library('session');
	$CI->load->model('auditoria_model', 'auditoria');
	$CI->load->model('usuarios_model', 'usuarios');
	if ($query):
		$last_query = $CI->db->last_query();
	else:
		$last_query = '';
	endif;

    if((!$CI->session->userdata('session_id')) || (!$CI->session->userdata('logado'))):
		$user_login = 'Desconhecido';
	else:
		$user_id = $CI->session->userdata('id');
		$user_login = $CI->usuarios->getById($user_id)->email;
	endif;
		
	$dados = array(
		'usuario' => $user_login,
		'operacao' => $operacao,
		'query' => $last_query,
		'observacao' => $obs,
	);
	$CI->auditoria->do_insert($dados);
}


//remove acentos e caracteres especiais de uma string
function remove_acentos($string=NULL){
	$procurar    = array('À','Á','Ã','Â','É','Ê','Í','Ó','Õ','Ô','Ú','Ü','Ç','à','á','ã','â','é','ê','í','ó','õ','ô','ú','ü','ç');
	$substituir  = array('A','A','A','A','E','E','I','O','O','O','U','U','C','a','a','a','a','e','e','i','o','o','o','u','u','c');
	return str_replace($procurar, $substituir, $string);
}
