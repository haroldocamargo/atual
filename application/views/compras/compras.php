<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aCompra')){ ?>
    <a href="<?php echo base_url();?>index.php/compras/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Compra</a>
<?php } ?>

<div class="span12" style="margin-left: 0">
	<form action="<?php echo current_url(); ?>" method="get" >
	<div class="span12" style="margin-left: 0">
		<div class="span1">
			<label>Compra</label>
    	    <div class="controls">
        	    <input id="compra" class="span12" type="text" name="compra" />
            </div>
		</div>

        <div class="span2">
            <label for="cliente">Pessoa</label>
            <input id="cliente" class="span12" type="text" name="cliente" value=""  />
            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value=""  />
        </div>
		
		<div class="span1">
			<label>Dcto</label>
    	    <div class="controls">
        	    <input id="documento" class="span12" type="text" name="documento" />
            </div>
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

        <div class="span1">
            <label for="status">Faturado</label>
            <select class="span12" name="status" id="status" value="">
                <option value="">&nbsp</option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </div>

        <div class="span2">
            <label for="tecnico">Comprador / Responsável</label>
            <input id="tecnico" class="span12" type="text" name="tecnico" value=""  />
            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value=""  />
        </div>

		<div class="span1">
			<label>Setor</label>
    	    <div class="controls">
        	    <input id="setor" class="input-mini" type="text" name="setor" />
            </div>
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
        <h5>Compras</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Data da Compra</th>
            <th>Pessoa</th>
            <th>Documento</th>
            <th>Faturado</th>
            <th>SubTotal</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="6">Nenhuma compra Cadastrada</td>
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
        <h5>Compras</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Data da Compra</th>
            <th>Pessoa</th>
            <th>Documento</th>
            <th>Faturado</th>
            <th>SubTotal</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            $dataCompra = date(('d/m/Y'),strtotime($r->dataCompra));
            if($r->faturado == 1){$faturado = 'Sim';} else{ $faturado = 'Não';}           
            echo '<tr>';
            echo '<td>'.$r->idCompras.'</td>';
            echo '<td>'.$dataCompra.'</td>';
            echo '<td><a href="'.base_url().'index.php/clientes/visualizar/'.$r->idClientes.'">'.$r->nomeCliente.'</a></td>';
            echo '<td>'.$r->documentoCompra.'</td>';
            echo '<td>'.$faturado.'</td>';
            echo '<td>'.number_format($r->valorTotal,2,',','.').'</td>';
            
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vCompra')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/compras/visualizar/'.$r->idCompras.'" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eCompra')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/compras/editar/'.$r->idCompras.'" class="btn btn-info tip-top" title="Editar compra"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dCompra')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" compra="'.$r->idCompras.'" class="btn btn-danger tip-top" title="Excluir compra"><i class="icon-remove icon-white"></i></a>'; 
            }

            echo '</td>';
            echo '</tr>';
        }?>
        
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>
	
<!--?php echo $this->pagination->create_links();}?-->
<?php }?>


<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/compras/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Compra</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCompra" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta compra?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>


<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {

	$(document).ready(function(){

   		$(document).on('click', 'a', function(event) {
        
	        var compra = $(this).attr('compra');
    	    $('#idCompra').val(compra);

    	});

	});


    $("#tecnico").autocomplete({
          source: "<?php echo base_url(); ?>index.php/compras/autoCompleteUsuario",
          minLength: 5,
          select: function( event, ui ) {

               $("#usuarios_id").val(ui.item.id);
          }
    });

    $("#cliente").autocomplete({
          source: "<?php echo base_url(); ?>index.php/compras/autoCompleteCliente",
          minLength: 5,
          select: function( event, ui ) {

               $("#clientes_id").val(ui.item.id);
          }
    });

    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

});

</script>