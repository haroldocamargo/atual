<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aServico')){ ?>
    <a href="<?php echo base_url()?>index.php/servicos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Serviço</a>
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
            <label for="servico">Serviço</label>
            <input id="servico" class="span12" type="text" name="servico" value=""  />
            <input id="servicos_id" class="span12" type="hidden" name="servicos_id" value=""  />
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
            <i class="icon-wrench"></i>
         </span>
        <h5>Serviços</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="5">Nenhum Serviço Cadastrado</td>
        </tr>
    </tbody>
</table>
</div>
</div>



<?php }
else{ ?>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-wrench"></i>
         </span>
        <h5>Serviços</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->idServicos.'</td>';
            echo '<td>'.$r->nome.'</td>';
            echo '<td>'.number_format($r->preco,2,',','.').'</td>';
            echo '<td>'.$r->descricao.'</td>';
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/servicos/visualizar/'.$r->idServicos.'" class="btn tip-top" title="Visualizar Serviço"><i class="icon-eye-open"></i></a>  '; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eServico')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/servicos/editar/'.$r->idServicos.'" class="btn btn-info tip-top" title="Editar Serviço"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dServico')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" servico="'.$r->idServicos.'" class="btn btn-danger tip-top" title="Excluir Serviço"><i class="icon-remove icon-white"></i></a>  '; 
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
  <form action="<?php echo base_url() ?>index.php/servicos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Serviço</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idServico" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este serviço?</h5>
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
        
	        var servico = $(this).attr('servico');
	        $('#idServico').val(servico);

    	});

	});


	      $("#servico").autocomplete({
	            source: "<?php echo base_url(); ?>index.php/servicos/autoCompleteServico",
	            minLength: 3,
	            select: function( event, ui ) {
	                 $("#servicos_id").val(ui.item.id);
	            }
	      });
	

    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

});

</script>