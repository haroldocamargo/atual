<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>


<style type="text/css">
	
	label.error{
		color: #b94a48;
	}

	input.error{
    border-color: #b94a48;
  }
  input.valid{
    border-color: #5bb75b;
  }


</style>


<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aLancamento')){ ?>
  <div class="span3" style="margin-left: 0">
      <a href="#modalReceita" data-toggle="modal" role="button" class="btn btn-success tip-bottom" title="Cadastrar nova receita"><i class="icon-plus icon-white"></i> Receita</a>  
      <a href="#modalDespesa" data-toggle="modal" role="button" class="btn btn-danger tip-bottom" title="Cadastrar nova despesa"><i class="icon-plus icon-white"></i> Despesa</a>
  </div>
<?php } ?>
	
<div class="span12" style="margin-left: 0">
	<form action="<?php echo current_url(); ?>" method="get" >
	<div class="span12" style="margin-left: 0">
		<div class="span2" style="margin-left: 0">
			<label>Tipo</label>
			<select name="tipo" class="span12">
                   <option value="todos">Todos</option>
                   <option value="receita">Receita</option>
                   <option value="despesa">Despesa</option>
			</select>
		</div>

		<div class="span1">
			<label>Grupo</label>
    	    <div class="controls">
        	    <input id="grupo" class="input-mini" type="text" name="grupo" />
            </div>
		</div>

		<div class="span1">
			<label>Setor</label>
    	    <div class="controls">
        	    <input id="setor" class="input-mini" type="text" name="setor" />
            </div>
		</div>

		<div class="span1">
			<label>Dcto</label>
    	    <div class="controls">
        	    <input id="documento" class="input-mini" type="text" name="documento" />
            </div>
		</div>

        <div class="span2">
            <label for="cliente">Pessoa</label>
            <input id="cliente" class="span12" type="text" name="cliente" value=""  />
            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value=""  />
        </div>
		
		<div class="span1">
			<label>De</label>
    	    <div class="controls">
	    		<input class="input-mini datepicker" id="vencimento" type="text" name="vencimento" />
            </div>
		</div>
		
		<div class="span1">
			<label>Até</label>
    	    <div class="controls">
	    		<input class="input-mini datepicker" id="vencimento2" type="text" name="vencimento2"  />
            </div>
		</div>
		
		<div class="span2">
			<label>Situação</label>
			<select name="situacao" class="span12">
                            <option value="todos">Todos</option>
                            <option value="pago">Pago</option>
                            <option value="pendente">Pendente</option>
			</select>
		</div>

		<div class="span1" >
			&nbsp
			<button type="submit" class="span12 btn btn-primary">Filtrar</button>
		</div>
    </div>
		
	</form>
</div>

<div class="span12" style="margin-left: 0;">

<?php

if(!$results){?>
	<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5>Lançamentos Financeiros</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Tipo</th>
            <th>Grupo</th>
            <th>Setor</th>
            <th>Documento</th>
            <th>Pessoa</th>
            <th>Vencimento</th>
            <th>Situação</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="6">Nenhuma lançamento encontrado</td>
        </tr>
    </tbody>
</table>
</div>
</div>
<?php } else{?>


<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5>Lançamentos Financeiros</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered " id="divLancamentos">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Tipo</th>
            <th>Grupo</th>
            <th>Setor</th>
            <th>Documento</th>
            <th>Pessoa</th>
            <th>Vencimento</th>
            <th>Situação</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $totalReceita = 0;
        $totalDespesa = 0;
        $saldo = 0;
        foreach ($results as $r) {
            $vencimento = date(('d/m/Y'),strtotime($r->data_vencimento));
            if($r->baixado == 0){$status = 'Pendente';}else{ $status = 'Pago';};
            if($r->tipo == 'receita'){ $label = 'success'; $totalReceita += $r->valor;} else{$label = 'important'; $totalDespesa += $r->valor;}
            echo '<tr>'; 
            echo '<td>'.$r->idLancamentos.'</td>';
            echo '<td><span class="label label-'.$label.'">'.ucfirst($r->tipo).'</span></td>';
            echo '<td>'.$r->grupo.'</td>';
            echo '<td>'.$r->setor.'</td>';
            echo '<td>'.$r->documento.'</td>';
            echo '<td>'.$r->cliente_fornecedor.'</td>';
            echo '<td>'.$vencimento.'</td>';   
            echo '<td>'.$status.'</td>';
            echo '<td>'.number_format($r->valor,2,',','.').'</td>';
            
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/financeiro/visualizar/'.$r->idLancamentos.'" class="btn tip-top" title="Visualizar Lançamento"><i class="icon-eye-open"></i></a>  '; 
            }

            if($this->permission->checkPermission($this->session->userdata('permissao'),'eLancamento')){
                echo '<a href="#modalEditar" style="margin-right: 1%" data-toggle="modal" role="button" idLancamento="'.$r->idLancamentos.'" descricao="'.$r->descricao.'" valor="'.$r->valor.'" vencimento="'.date('d/m/Y',strtotime($r->data_vencimento)).'" pagamento="'.date('d/m/Y', strtotime($r->data_pagamento)).'" baixado="'.$r->baixado.'" fornecedoresEditar_id="'.$r->clientes_id.'" fornecedor="'.$r->cliente_fornecedor.'" formaPgto="'.$r->forma_pgto.'" tipo="'.$r->tipo.'" grupo="'.$r->grupo.'" setor="'.$r->setor.'" documento="'.$r->documento.'" observacao="'.$r->observacao.'" class="btn btn-info tip-top editar" title="Editar Lançamento"><i class="icon-pencil icon-white"></i></a>'; 
            }

            if($this->permission->checkPermission($this->session->userdata('permissao'),'dLancamento')){
                echo '<a href="#modalExcluir" data-toggle="modal" role="button" idLancamento="'.$r->idLancamentos.'" class="btn btn-danger tip-top excluir" title="Excluir Lançamento"><i class="icon-remove icon-white"></i></a>'; 
            }
                     
            echo '</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
    <tfoot>
    	<tr>
    		<td colspan="8" style="text-align: right; color: green"> <strong>Total Receitas:</strong></td>
    		<td colspan="2" style="text-align: left; color: green"><strong><?php echo number_format($totalReceita,2,',','.') ?></strong></td>
    	</tr>
    	<tr>
    		<td colspan="8" style="text-align: right; color: red"> <strong>Total Despesas:</strong></td>
    		<td colspan="2" style="text-align: left; color: red"><strong><?php echo number_format($totalDespesa,2,',','.') ?></strong></td>
    	</tr>
    	<tr>
    		<td colspan="8" style="text-align: right"> <strong>Saldo:</strong></td>
    		<td colspan="2" style="text-align: left;"><strong><?php echo number_format($totalReceita - $totalDespesa,2,',','.') ?></strong></td>
    	</tr>
    </tfoot>
</table>
</div>
</div>

</div>
	
<!-- <?php echo $this->pagination->create_links();}?> --> 



<!-- Modal nova receita -->
<div id="modalReceita" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="formReceita" action="<?php echo base_url() ?>index.php/financeiro/adicionarReceita" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Atual ERP - Sistema Administrativo - Adicionar Receita</h3>
  </div>
  <div class="modal-body">
  		
<!--  		<div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>-->
    	<div class="span12" style="margin-left: 0"> 
    		<label for="descricao">Descrição</label>
    		<input class="span12" id="descricao" type="text" name="descricao"  />
    		<input id="urlAtual" type="hidden" name="urlAtual" value="<?php echo current_url() ?>"  />
    	</div>	
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span12" style="margin-left: 0"> 
                <label for="clienteIncluir">Pessoa<span class="required">*</span></label>
                <input id="clienteIncluir" class="span12" type="text" name="cliente" value=""  />
                <input id="clientesIncluir_id" class="span12" type="hidden" name="clientesIncluir_id" value=""  />
    		</div>
    	</div>

        <div class="span12" style="margin-left: 0"> 
	        <div class="span4"> 
	          <label for="grupo">Grupo</label>
	          <input class="span12" id="grupo" type="text" name="grupo"  />
	        </div>  
	
	        <div class="span4"> 
	          <label for="setor">Setor</label>
	          <input class="span12" id="setor" type="text" name="setor"  />
	        </div>  
	
	        <div class="span4"> 
	          <label for="documento">Documento</label>
	          <input class="span12" id="documento" type="text" name="documento"  />
	        </div>  
        </div>  

    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" style="margin-left: 0">  
    			<label for="valor">Valor*</label>
    			<input type="hidden"  name="tipo" value="receita" />	
    			<input class="span12 money"  type="text" name="valor"  />
    		</div>
	    	<div class="span4" >
	    		<label for="vencimento">Data Vencimento*</label>
	    		<input class="span12 datepicker"  type="text" name="vencimento"  />
	    	</div>
    	</div>
    	
        <div class="span12" style="margin-left: 0"> 
	        <div class="span12"> 
	          <label for="observacao">Observação</label>
	          <input class="span12" type="text" name="observacao" id="observacao" />
  	        </div>  
        </div>  
    	
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" style="margin-left: 0">
    			<label for="recebido">Foi pago?</label>
	    		&nbsp &nbsp &nbsp &nbsp<input  id="recebido" type="checkbox" name="recebido" value="1" />	
    		</div>
    		<div id="divRecebimento" class="span8" style=" display: none">
	    		<div class="span6">
	    			<label for="recebimento">Data Pagamento</label>
		    		<input class="span12 datepicker" id="recebimento" type="text" name="recebimento" />	
	    		</div>
	    		<div class="span6">
		    		<label for="formaPgto">Forma Pgto</label>
		    		<select name="formaPgto" id="formaPgto" class="span12">
		    			<option value="Dinheiro">Dinheiro</option>
		    			<option value="Cartão de Crédito">Cartão de Crédito</option>
		    			<option value="Cheque">Cheque</option>
		    			<option value="Boleto">Boleto</option>
		    			<option value="Depósito">Depósito</option>
		    			<option value="Débito">Débito</option>  			
		    		</select>
		    	</div>
	    	</div>
    		
    	</div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-success">Adicionar Receita</button>
  </div>
  </form>
</div>




<!-- Modal nova despesa -->
<div id="modalDespesa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="formDespesa" action="<?php echo base_url() ?>index.php/financeiro/adicionarDespesa" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Atual ERP - Sistema Administrativo - Adicionar Despesa</h3>
  </div>
  <div class="modal-body">
<!--  		<div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>-->
    	<div class="span12" style="margin-left: 0"> 
    		<label for="descricao">Descrição</label>
    		<input class="span12" id="descricao" type="text" name="descricao"  />
    		<input id="urlAtual" type="hidden" name="urlAtual" value="<?php echo current_url() ?>"  />
    	</div>	
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span12" style="margin-left: 0"> 
                <label for="fornecedorIncluir">Pessoa<span class="required">*</span></label>
                <input id="fornecedorIncluir" class="span12" type="text" name="fornecedor" value=""  />
                <input id="fornecedoresIncluir_id" class="span12" type="hidden" name="fornecedoresIncluir_id" value=""  />
    		</div>
    	</div>

        <div class="span12" style="margin-left: 0"> 
	        <div class="span4"> 
	          <label for="grupo">Grupo</label>
	          <input class="span12" id="grupo" type="text" name="grupo"  />
  	        </div>  
	
	        <div class="span4"> 
	          <label for="setor">Setor</label>
	          <input class="span12" id="setor" type="text" name="setor"  />
  	        </div>  
	
	        <div class="span4"> 
	          <label for="documento">Documento</label>
	          <input class="span12" id="documento" type="text" name="documento"  />
	        </div>  
        </div>  

    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" style="margin-left: 0">  
    			<label for="valor">Valor*</label>
    			<input type="hidden"  name="tipo" value="despesa" />	
    			<input class="span12 money"  type="text" name="valor"  />
    		</div>
	    	<div class="span4" >
	    		<label for="vencimento">Data Vencimento*</label>
	    		<input class="span12 datepicker"  type="text" name="vencimento"  />
	    	</div>
	    	
    	</div>
    	
        <div class="span12" style="margin-left: 0"> 
	        <div class="span12"> 
	          <label for="observacao">Observação</label>
	          <input class="span12" type="text" name="observacao" id="observacao" />
	        </div>  
        </div>  
        
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" style="margin-left: 0">
    			<label for="pago">Foi Pago?</label>
	    		&nbsp &nbsp &nbsp &nbsp<input  id="pago" type="checkbox" name="pago" value="1" />	
    		</div>
    		<div id="divPagamento" class="span8" style=" display: none">
	    		<div class="span6">
	    			<label for="pagamento">Data Pagamento</label>
		    		<input class="span12 datepicker" id="pagamento" type="text" name="pagamento" value=""/>	
	    		</div>

	    		<div class="span6">
		    		<label for="formaPgto">Forma Pgto</label>
		    		<select name="formaPgto"  class="span12">
		    			<option value="Dinheiro">Dinheiro</option>
		    			<option value="Cartão de Crédito">Cartão de Crédito</option>
		    			<option value="Cheque">Cheque</option>
		    			<option value="Boleto">Boleto</option>
		    			<option value="Depósito">Depósito</option>
		    			<option value="Débito">Débito</option>  			
		    		</select>
		    	</div>
	    	</div>
    	</div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Adicionar Despesa</button>
  </div>
  </form>
</div>



<!-- Modal editar lançamento -->
<div id="modalEditar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="formEditar" action="<?php echo base_url() ?>index.php/financeiro/editar" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Atual ERP - Sistema Administrativo - Editar Lançamento</h3>
  </div>
  <div class="modal-body">
<!--      <div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>-->
      <div class="span12" style="margin-left: 0"> 
        <label for="descricao">Descrição</label>
        <input class="span12" id="descricaoEditar" type="text" name="descricao"  />
        <input id="urlAtualEditar" type="hidden" name="urlAtual" value=""  />
      </div>  
      <div class="span12" style="margin-left: 0"> 
        <div class="span12" style="margin-left: 0"> 
          <label for="fornecedorEditar">Pessoa<span class="required">*</span></label>
          <input id="fornecedorEditar" class="span12" type="text" name="fornecedor" value="" />
          <input id="fornecedoresEditar_id" class="span12" type="hidden" name="fornecedoresEditar_id" value="" />
        </div>
        
      <div class="span12" style="margin-left: 0"> 
	      <div class="span4"> 
	        <label for="grupo">Grupo</label>
	        <input class="span12" id="grupoEditar" type="text" name="grupo"  />
	      </div>  
	
	      <div class="span4"> 
	        <label for="setor">Setor</label>
	        <input class="span12" id="setorEditar" type="text" name="setor"  />
	      </div>  
	
	      <div class="span4"> 
	        <label for="documento">Documento</label>
	        <input class="span12" id="documentoEditar" type="text" name="documento"  />
	      </div>  
      </div>  
        
      </div>
      <div class="span12" style="margin-left: 0"> 
        <div class="span4" style="margin-left: 0">  
          <label for="valor">Valor*</label>
          <input type="hidden"  name="tipo" value="despesa" />  
          <input type="hidden"  id="idEditar" name="id" value="" /> 
          <input class="span12 money"  type="text" name="valor" id="valorEditar" />
        </div>
        <div class="span4" >
          <label for="vencimento">Data Vencimento*</label>
          <input class="span12 datepicker"  type="text" name="vencimento" id="vencimentoEditar"  />
        </div>
        <div class="span4">
          <label for="vencimento">Tipo*</label>
          <select class="span12" name="tipo" id="tipoEditar">
            <option value="receita">Receita</option>
            <option value="despesa">Despesa</option>
          </select>
        </div>
        
      </div>

      <div class="span12" style="margin-left: 0"> 
	      <div class="span12"> 
	        <label for="observacao">Observação</label>
	        <input class="span12" type="text" name="observacao" id="observacaoEditar" />
	      </div>  
      </div>  

      <div class="span12" style="margin-left: 0"> 
        <div class="span4" style="margin-left: 0">
          <label for="pago">Foi Pago?</label>
          &nbsp &nbsp &nbsp &nbsp<input  id="pagoEditar" type="checkbox" name="pago" value="1" /> 
        </div>
        <div id="divPagamentoEditar" class="span8" style=" display: none">
          <div class="span6">
            <label for="pagamento">Data Pagamento</label>
            <input class="span12 datepicker" id="pagamentoEditar" type="text" name="pagamento" />  
          </div>

          <div class="span6">
            <label for="formaPgto">Forma Pgto</label>
            <select name="formaPgto" id="formaPgtoEditar"  class="span12">
              <option value="Dinheiro">Dinheiro</option>
              <option value="Cartão de Crédito">Cartão de Crédito</option>
              <option value="Cheque">Cheque</option>
              <option value="Boleto">Boleto</option>
              <option value="Depósito">Depósito</option>
              <option value="Débito">Débito</option>        
            </select>
          </div>
        </div>
        
      </div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelarEditar">Cancelar</button>
    <button class="btn btn-primary">Salvar Alterações</button>
  </div>
  </form>
</div>






<!-- Modal Excluir lançamento-->
<div id="modalExcluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Atual ERP - Sistema Administrativo - Excluir Lançamento</h3>
  </div>
  <div class="modal-body">
    <h5 style="text-align: center">Deseja realmente excluir esse lançamento?</h5>
    <input name="id" id="idExcluir" type="hidden" value="" />
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-danger" id="btnExcluir">Excluir Lançamento</button>
  </div>
</div>





<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {

	      $("#cliente").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/financeiro/autoCompleteCliente",
	            minLength: 5,
	            select: function( event, ui ) {
	                 $("#clientes_id").val(ui.item.id);
	            }
	      });
	
	      $("#clienteIncluir").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/financeiro/autoCompleteCliente",
	            minLength: 5,
	            select: function( event, ui ) {
	                 $("#clientesIncluir_id").val(ui.item.id);
	            }
	      });
	
	      $("#fornecedorIncluir").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/financeiro/autoCompleteCliente",
	            minLength: 5,
	            select: function( event, ui ) {
	                 $("#fornecedoresIncluir_id").val(ui.item.id);
	            }
	      });

	      $("#fornecedorEditar").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/financeiro/autoCompleteCliente",
	            minLength: 5,
	            select: function( event, ui ) {
	                 $("#fornecedoresEditar_id").val(ui.item.id);
	            }
	      });

		$(".money").maskMoney({decimal:",", thousands:"."});


		$('#pago').click(function(event) {
			var flag = $(this).is(':checked');
			if(flag == true){
				$('#divPagamento').show();
			}
			else{
				$('#divPagamento').hide();
			}
		});


		$('#recebido').click(function(event) {
			var flag = $(this).is(':checked');
			if(flag == true){
				$('#divRecebimento').show();
			}
			else{
				$('#divRecebimento').hide();
			}
		});

    $('#pagoEditar').click(function(event) {
      var flag = $(this).is(':checked');
      if(flag == true){
        $('#divPagamentoEditar').show();
      }
      else{
        $('#divPagamentoEditar').hide();
      }
    });


		$("#formReceita").validate({
          rules:{
             descricao: {required:true},
             cliente: {required:true},
             valor: {required:true},
             vencimento: {required:true}
      
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             cliente: {required: 'Campo Requerido.'},
             valor: {required: 'Campo Requerido.'},
             vencimento: {required: 'Campo Requerido.'}
          }
    });



		$("#formDespesa").validate({
          rules:{
             descricao: {required:true},
             fornecedor: {required:true},
             valor: {required:true},
             vencimento: {required:true}
      
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             fornecedor: {required: 'Campo Requerido.'},
             valor: {required: 'Campo Requerido.'},
             vencimento: {required: 'Campo Requerido.'}
          }
       	});
    

    $(document).on('click', '.excluir', function(event) {
      $("#idExcluir").val($(this).attr('idLancamento'));
    });


    $(document).on('click', '.editar', function(event) {
      $("#idEditar").val($(this).attr('idLancamento'));
      $("#descricaoEditar").val($(this).attr('descricao'));
      $("#fornecedorEditar").val($(this).attr('fornecedor'));
      $("#fornecedoresEditar_id").val($(this).attr('fornecedoresEditar_id'));
      $("#valorEditar").val($(this).attr('valor'));
      $("#vencimentoEditar").val($(this).attr('vencimento'));
      $("#formaPgtoEditar").val($(this).attr('formaPgto'));
      $("#tipoEditar").val($(this).attr('tipo'));
      $("#urlAtualEditar").val($(location).attr('href'));
      $("#documentoEditar").val($(this).attr('documento'));
      $("#grupoEditar").val($(this).attr('grupo'));
      $("#setorEditar").val($(this).attr('setor'));
      $("#observacaoEditar").val($(this).attr('observacao'));
      var baixado = $(this).attr('baixado');
      if(baixado == 1){
        $("#pagamentoEditar").val($(this).attr('pagamento'));
        $("#pagoEditar").attr('checked', true);
        $("#divPagamentoEditar").show();
      }
      else{
        $("#pagamentoEditar").val('');
        $("#pagoEditar").attr('checked', false); 
        $("#divPagamentoEditar").hide();
      }
      

    });

    $(document).on('click', '#btnExcluir', function(event) {
        var id = $("#idExcluir").val();
    
        $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>index.php/financeiro/excluirLancamento",
          data: "id="+id,
          dataType: 'json',
          success: function(data)
          {
            if(data.result == true){
                $("#btnCancelExcluir").trigger('click');
                $("#divLancamentos").html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
                $("#divLancamentos").load( $(location).attr('href')+" #divLancamentos" );
                
            }
            else{
                $("#btnCancelExcluir").trigger('click');
                alert('Ocorreu um erro ao excluir produto.');
            }
          }
        });
        return false;
    });
 
    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

	});

</script>


