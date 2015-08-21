<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aProduto')){ ?>
    <a href="<?php echo base_url();?>index.php/produtos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Produto</a>
<?php } ?>

<div class="span12" style="margin-left: 0">
	<form action="<?php echo current_url(); ?>" method="get" >
		<div class="span1" style="margin-left: 0">
			<label>Código</label>
    	    <div class="controls">
        	    <input id="codigo" class="span12" type="text" name="codigo" />
            </div>
		</div>

        <div class="span4">
            <label for="produto">Produto</label>
            <input id="produto" class="span12" type="text" name="produto" value=""  />
            <input id="produtos_id" class="span12" type="hidden" name="produtos_id" value=""  />
        </div>
		
		<div class="span1">
			<label>Grupo</label>
    	    <div class="controls">
        	    <input id="grupo" class="input-mini" type="text" name="grupo" />
            </div>
		</div>

		<div class="span1">
			<label>SubGrupo</label>
    	    <div class="controls">
        	    <input id="subgrupo" class="input-mini" type="text" name="subgrupo" />
            </div>
		</div>

		<div class="span1">
			<label>Categoria</label>
    	    <div class="controls">
        	    <input class="input-mini" id="categoria" type="text" name="categoria" />
            </div>
		</div>

		<div class="span1">
			<label>Classe</label>
    	    <div class="controls">
        	    <input class="input-mini" id="classe" type="text" name="classe" />
            </div>
		</div>

		<div class="span1">
			<label>Tipo</label>
    	    <div class="controls">
        	    <input class="input-mini" id="tipo" type="text" name="tipo" />
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
            <i class="icon-barcode"></i>
         </span>
        <h5>Produtos</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Estoque</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="5">Nenhum Produto Cadastrado</td>
        </tr>
    </tbody>
</table>
</div>
</div>

<?php } else{?>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Produtos</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome</th>
            <th>Estoque</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->idProdutos.'</td>';
            echo '<td>'.$r->descricao.'</td>';
            echo '<td>'.number_format($r->estoque,2,',','.').'</td>';
            echo '<td>'.number_format($r->precoVenda,2,',','.').'</td>';
            
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/produtos/visualizar/'.$r->idProdutos.'" class="btn tip-top" title="Visualizar Produto"><i class="icon-eye-open"></i></a>  '; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eProduto')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/produtos/editar/'.$r->idProdutos.'" class="btn btn-info tip-top" title="Editar Produto"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dProduto')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" produto="'.$r->idProdutos.'" class="btn btn-danger tip-top" title="Excluir Produto"><i class="icon-remove icon-white"></i></a>'; 
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
	
<?php echo $this->pagination->create_links();}?>



<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/produtos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Produto</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idProduto" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este produto?</h5>
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
        
	        var produto = $(this).attr('produto');
    	    $('#idProduto').val(produto);

    	});

	});


	      $("#produto").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/produtos/autoCompleteProduto",
	            minLength: 5,
	            select: function( event, ui ) {
	                 $("#produtos_id").val(ui.item.id);
	            }
	      });
	

    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

});

</script>