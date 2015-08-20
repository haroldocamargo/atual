<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aOs')){ ?>
    <a href="<?php echo base_url();?>index.php/os/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar OS</a>
<?php } ?>


<div class="span12" style="margin-left: 0">
	<form action="<?php echo current_url(); ?>" method="get" >
	<div class="span12" style="margin-left: 0">
		<div class="span1">
			<label>Os</label>
    	    <div class="controls">
        	    <input id="os" class="span12" type="text" name="os" />
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

        <div class="span2">
            <label for="status">Status</label>
            <select class="span12" name="status" id="status" value="">
                <option value="">&nbsp</option>
                <option value="Orçamento">Orçamento</option>
                <option value="Aberto">Aberto</option>
                <option value="Em Andamento">Em Andamento</option>
                <option value="Finalizado">Finalizado</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>

        <div class="span2">
            <label for="tecnico">Técnico / Responsável</label>
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
        <h5>Ordens de Serviço</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Pessoa</th>
            <th>Documento</th>
            <th>Data Inicial</th>
            <th>Data Final</th>
            <th>Status</th>
            <th>SubTotal</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="6">Nenhuma OS Cadastrada</td>
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
        <h5>Ordens de Serviço</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Pessoa</th>
            <th>Documento</th>
            <th>Data Inicial</th>
            <th>Data Final</th>
            <th>Status</th>
            <th>SubTotal</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            $dataInicial = date(('d/m/Y'),strtotime($r->dataInicial));
            $dataFinal = date(('d/m/Y'),strtotime($r->dataFinal));
            echo '<tr>';
            echo '<td>'.$r->idOs.'</td>';
            echo '<td>'.$r->nomeCliente.'</td>';
            echo '<td>'.$r->documentoOs.'</td>';
            echo '<td>'.$dataInicial.'</td>';
            echo '<td>'.$dataFinal.'</td>';
            echo '<td>'.$r->status.'</td>';
            echo '<td>'.number_format($r->valorTotal,2,',','.').'</td>';
            
            
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/os/visualizar/'.$r->idOs.'" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/os/editar/'.$r->idOs.'" class="btn btn-info tip-top" title="Editar OS"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dOs')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" os="'.$r->idOs.'" class="btn btn-danger tip-top" title="Excluir OS"><i class="icon-remove icon-white"></i></a>  '; 
            }
            
                      
                      
            echo  '</td>';
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
  <form action="<?php echo base_url() ?>index.php/os/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir OS</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idOs" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta OS?</h5>
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
        
	        var os = $(this).attr('os');
    	    $('#idOs').val(os);

    	});

	});


    $("#tecnico").autocomplete({
          source: "<?php echo base_url(); ?>index.php/os/autoCompleteUsuario",
          minLength: 5,
          select: function( event, ui ) {

               $("#usuarios_id").val(ui.item.id);
          }
    });

    $("#cliente").autocomplete({
          source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
          minLength: 5,
          select: function( event, ui ) {

               $("#clientes_id").val(ui.item.id);
          }
    });

    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

});

</script>