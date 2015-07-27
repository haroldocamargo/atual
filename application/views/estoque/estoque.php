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


<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aEstoque')){ ?>
  <div class="span3" style="margin-left: 0">
      <a href="#modalEntrada" data-toggle="modal" role="button" class="btn btn-success tip-bottom" title="Cadastrar nova entrada"><i class="icon-plus icon-white"></i> Nova Entrada</a>  
      <a href="#modalSaida" data-toggle="modal" role="button" class="btn btn-danger tip-bottom" title="Cadastrar nova saída"><i class="icon-plus icon-white"></i> Nova Saída</a>
  </div>
<?php } ?>
	
<div class="span12" style="margin-left: 0">
	<form action="<?php echo current_url(); ?>" method="get" >
		<div class="span2" style="margin-left: 0">
			<label>Tipo</label>
			<select name="tipo" class="span12">
                   <option value="todos">Todos</option>
                   <option value="entrada">Entrada</option>
                   <option value="saida">Saída</option>
			</select>
		</div>

		<div class="span1">
			<label>Setor</label>
    	    <div class="controls">
        	    <input class="input-mini" id="setorEstoque"type="text" name="setorEstoque" />
            </div>
		</div>

        <div class="span3">
            <label for="produto">Produto</label>
            <input id="produto" class="span12" type="text" name="produto" value=""  />
            <input id="produtos_id" class="span12" type="hidden" name="produtos_id" value=""  />
        </div>
		
		<div class="span1">
			<label>Dcto</label>
    	    <div class="controls">
        	    <input class="input-mini" id="documento" type="text" name="documento" />
            </div>
		</div>

		<div class="span1">
			<label>Serie</label>
    	    <div class="controls">
        	    <input class="input-mini" id="serie" type="text" name="serie" />
            </div>
		</div>

		<div class="span1">
			<label>De</label>
    	    <div class="controls">
	    		<input class="input-mini datepicker" id="data" type="text" name="data" />
            </div>
		</div>
		
		<div class="span1">
			<label>Até</label>
    	    <div class="controls">
	    		<input class="input-mini datepicker" id="data2" type="text" name="data2"  />
            </div>
		</div>
		
		<div class="span1" >
			&nbsp
			<button type="submit" class="span12 btn btn-primary">Filtrar</button>
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
        <h5>Lançamentos Estoque</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Tipo</th>
            <th>Setor</th>
            <th>Produto</th>
            <th>Documento</th>
            <th>Serie</th>
            <th>Data</th>
            <th>Qtd</th>
            <th>Valor</th>
            <th>SubTotal</th>
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
        <h5>Lançamentos Estoque</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered " id="divEstoque">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Tipo</th>
            <th>Setor</th>
            <th>Produto</th>
            <th>Documento</th>
            <th>Serie</th>
            <th>Data</th>
            <th>Qtd</th>
            <th>Valor</th>
            <th>SubTotal</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $totalEntrada = 0;
        $totalSaida = 0;
        $saldo = 0;
        foreach ($results as $r) {
            $data = date(('d/m/Y'),strtotime($r->data));
            if($r->tipo == 'entrada'){ $label = 'success'; $totalEntrada += $r->quantidade;} else{$label = 'important'; $totalSaida += $r->quantidade;}
            echo '<tr>'; 
            echo '<td>'.$r->idEstoque.'</td>';
            echo '<td><span class="label label-'.$label.'">'.ucfirst($r->tipo).'</span></td>';
            echo '<td>'.$r->setorEstoque.'</td>';
            echo '<td>'.$r->descricao.'</td>';
            echo '<td>'.$r->documentoEstoque.'</td>';
            echo '<td>'.$r->serie.'</td>';
            echo '<td>'.$data.'</td>';   
            echo '<td>'.$r->quantidade.'</td>';
            echo '<td>'.number_format($r->valor,2,',','.').'</td>';
            echo '<td>'.number_format($r->subTotal,2,',','.').'</td>';
            
            echo '<td>';

            if($this->permission->checkPermission($this->session->userdata('permissao'),'vEstoque')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/estoque/visualizar/'.$r->idEstoque.'" class="btn tip-top" title="Visualizar Estoque"><i class="icon-eye-open"></i></a>  '; 
            }

            if($this->permission->checkPermission($this->session->userdata('permissao'),'dEstoque')){
                echo '<a href="#modalExcluir" data-toggle="modal" role="button" idEstoque="'.$r->idEstoque.'" class="btn btn-danger tip-top excluir" title="Excluir Estoque"><i class="icon-remove icon-white"></i></a>'; 
            }
                     
            echo '</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
    <tfoot>
    	<tr>
    		<td colspan="4" style="text-align: right; color: green"> <strong>Total Entradas:</strong></td>
    		<td colspan="1" style="text-align: left; color: green"><strong><?php echo number_format($totalEntrada,2,',','.') ?></strong></td>
    		<td colspan="11" style="text-align: right"> <strong> </strong></td>
    	</tr>
    	<tr>
    		<td colspan="4" style="text-align: right; color: red"> <strong>Total Saídas:</strong></td>
    		<td colspan="1" style="text-align: left; color: red"><strong><?php echo number_format($totalSaida,2,',','.') ?></strong></td>
    		<td colspan="11" style="text-align: right"> <strong> </strong></td>
    	</tr>
    	<tr>
    		<td colspan="4" style="text-align: right"> <strong>Saldo:</strong></td>
    		<td colspan="1" style="text-align: left;"><strong><?php echo number_format($totalEntrada - $totalSaida,2,',','.') ?></strong></td>
    		<td colspan="11" style="text-align: right"> <strong> </strong></td>
    	</tr>
    </tfoot>
</table>
</div>
</div>

</div>
	
<!-- <?php echo $this->pagination->create_links();}?> --> 



<!-- Modal nova entrada -->
<div id="modalEntrada" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="formEntrada" action="<?php echo base_url() ?>index.php/estoque/adicionarEntrada" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Atual ERP - Sistema Administrativo - Adicionar Entrada</h3>
  </div>
  <div class="modal-body">

    	<div class="span12" style="margin-left: 0"> 
	    	<div class="span3" >
	    		<label for="data">Data*</label>
	    		<input class="span12 datepicker"  type="text" name="data"  />
    			<input type="hidden"  name="tipo" value="entrada" />	
	    		<input id="urlAtual" type="hidden" name="urlAtual" value="<?php echo current_url() ?>"  />
	    	</div>

	        <div class="span3"> 
	          <label for="setor">Setor</label>
	          <input class="span12" id="setorEstoque" type="text" name="setorEstoque"  />
	        </div>  
	
	        <div class="span3"> 
	          <label for="documento">Documento</label>
	          <input class="span12" id="documento" type="text" name="documento"  />
	        </div>  

	        <div class="span3"> 
	          <label for="serie">Série</label>
	          <input class="span12" id="serie" type="text" name="serie"  />
	        </div>  
    	</div>

    	<div class="span12" style="margin-left: 0"> 
    		<div class="span12" style="margin-left: 0"> 
                <label for="produtoIncluir">Produto<span class="required">*</span></label>
                <input id="produtoIncluir" class="span12" type="text" name="produto" value=""  />
                <input id="produtosIncluir_id" class="span12" type="hidden" name="produtosIncluir_id" value=""  />
    		</div>
    	</div>

    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" >  
    			<label for="quantidade">Quantidade*</label>
    			<input class="span12"  type="text" name="quantidade"  />
    		</div>

    		<div class="span4">  
    			<label for="valor">Valor*</label>
    			<input class="span12 money"  type="text" name="valor"  />
    		</div>

    		<div class="span4">  
    			<label for="subtotal">SubTotal*</label>
    			<input class="span12 money"  type="text" name="subtotal"  />
    		</div>
    	</div>

        <div class="span12" style="margin-left: 0"> 
	        <div class="span12"> 
	          <label for="observacao">Observação</label>
	          <input class="span12" type="text" name="observacao" id="observacao" />
  	        </div>  
        </div>  
    	
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-success">Adicionar Entrada</button>
  </div>
  </form>
</div>




<!-- Modal nova saida -->
<div id="modalSaida" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="formSaida" action="<?php echo base_url() ?>index.php/estoque/adicionarSaida" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Atual ERP - Sistema Administrativo - Adicionar Saída</h3>
  </div>
  <div class="modal-body">

    	<div class="span12" style="margin-left: 0"> 
	    	<div class="span3" >
	    		<label for="data">Data*</label>
	    		<input class="span12 datepicker"  type="text" name="data"  />
    			<input type="hidden"  name="tipo" value="saida" />	
	    		<input id="urlAtual" type="hidden" name="urlAtual" value="<?php echo current_url() ?>"  />
	    	</div>

	        <div class="span3"> 
	          <label for="setorEstoque">Setor</label>
	          <input class="span12" id="setorEstoque" type="text" name="setorEstoque"  />
	        </div>  
	
	        <div class="span3"> 
	          <label for="documento">Documento</label>
	          <input class="span12" id="documento" type="text" name="documento"  />
	        </div>  

	        <div class="span3"> 
	          <label for="serie">Série</label>
	          <input class="span12" id="serie" type="text" name="serie"  />
	        </div>  
    	</div>

    	<div class="span12" style="margin-left: 0"> 
    		<div class="span12" style="margin-left: 0"> 
                <label for="produto2Incluir">Produto<span class="required">*</span></label>
                <input id="produto2Incluir" class="span12" type="text" name="produto2" value=""  />
                <input id="produtos2Incluir_id" class="span12" type="hidden" name="produtos2Incluir_id" value=""  />
    		</div>
    	</div>

    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" >  
    			<label for="quantidade">Quantidade*</label>
    			<input class="span12"  type="text" name="quantidade"  />
    		</div>

    		<div class="span4">  
    			<label for="valor">Valor*</label>
    			<input class="span12 money"  type="text" name="valor"  />
    		</div>

    		<div class="span4">  
    			<label for="subtotal">SubTotal*</label>
    			<input class="span12 money"  type="text" name="subtotal"  />
    		</div>
    	</div>

        <div class="span12" style="margin-left: 0"> 
	        <div class="span12"> 
	          <label for="observacao">Observação</label>
	          <input class="span12" type="text" name="observacao" id="observacao" />
  	        </div>  
        </div>  
        
</div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Adicionar Saída</button>
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

	      $("#produto").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/estoque/autoCompleteProduto",
	            minLength: 5,
	            select: function( event, ui ) {
	                 $("#produtos_id").val(ui.item.id);
	            }
	      });
	
	      $("#produto2").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/estoque/autoCompleteProduto",
	            minLength: 5,
	            select: function( event, ui ) {
	                 $("#produtos_id").val(ui.item.id);
	            }
	      });
	
	      $("#produtoIncluir").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/estoque/autoCompleteProduto",
	            minLength: 5,
	            select: function( event, ui ) {
	                 $("#produtosIncluir_id").val(ui.item.id);
	            }
	      });
	
	      $("#produto2Incluir").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/estoque/autoCompleteProduto",
	            minLength: 5,
	            select: function( event, ui ) {
	                 $("#produtos2Incluir_id").val(ui.item.id);
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

		$("#formEntrada").validate({
          rules:{
             descricao: {required:true},
             produto: {required:true},
             valor: {required:true},
             data: {required:true}
      
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             produto: {required: 'Campo Requerido.'},
             valor: {required: 'Campo Requerido.'},
             data: {required: 'Campo Requerido.'}
          }
    });



		$("#formSaida").validate({
          rules:{
             descricao: {required:true},
             produto: {required:true},
             valor: {required:true},
             data: {required:true}
      
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             produto: {required: 'Campo Requerido.'},
             valor: {required: 'Campo Requerido.'},
             data: {required: 'Campo Requerido.'}
          }
       	});
    

    $(document).on('click', '.excluir', function(event) {
      $("#idExcluir").val($(this).attr('idEstoque'));
    });


    $(document).on('click', '#btnExcluir', function(event) {
        var id = $("#idExcluir").val();
    
        $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>index.php/estoque/excluirEstoque",
          data: "id="+id,
          dataType: 'json',
          success: function(data)
          {
            if(data.result == true){
                $("#btnCancelExcluir").trigger('click');
                $("#divEstoque").html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
                $("#divEstoque").load( $(location).attr('href')+" #divEstoque" );
                
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


