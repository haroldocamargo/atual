<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de compra</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da compra</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                <?php if($custom_error == true){ ?>
                                <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">Dados incompletos, verifique os campos com asterisco ou se selecionou corretamente pessoa e responsável.</div>
                                <?php } ?>
                                <form action="<?php echo current_url(); ?>" method="post" id="formCompras">

                                    <div class="span12" style="padding: 1%">

                                        <div class="span2">
                                            <label for="dataInicial">Data da Compra<span class="required">*</span></label>
                                            <input id="dataCompra" class="span12 datepicker" type="text" name="dataCompra" value=""  />
                                        </div>
                                        <div class="span5">
                                            <label for="cliente">Pessoa<span class="required">*</span></label>
                                            <input id="cliente" class="span12" type="text" name="cliente" value=""  />
                                            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value=""  />
                                        </div>
                                        <div class="span5">
                                            <label for="tecnico">Comprador<span class="required">*</span></label>
                                            <input id="tecnico" class="span12" type="text" name="tecnico" value=""  />
                                            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value=""  />
                                        </div>

                                    </div>
   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2">
                                            <label for="documentoCompra">Documento</label>
                                            <input id="documentoCompra" class="span12" type="text" name="documentoCompra" maxlength="20" value=""  />
                                        </div>
                                        <div class="span2">
                                            <label for="dataDocumentoCompra">Data documento<span class="required">*</span></label>
                                            <input id="dataDocumentoCompra" class="span12 datepicker" type="text" name="dataDocumentoCompra" value=""  />
                                        </div>
                                        <div class="span2">
                                            <label for="setorCompra">Setor</label>
                                            <input id="setorCompra" class="span12" type="text" name="setorCompra" maxlength="20" value=""  />
                                        </div>
                                        <div class="span6">
                                            <label for="observacaoCompra">Observação</label>
                                            <input id="observacaoCompra" class="span12" type="text" name="observacaoCompra" maxlength="255" value=""  />
                                        </div>
                                    </div>
                              
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6 offset3" style="text-align: center">
                                            <button class="btn btn-success" id="btnContinuar"><i class="icon-share-alt icon-white"></i> Continuar</button>
                                            <a href="<?php echo base_url() ?>index.php/compras" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>
        </div>
    </div>
</div>
</div>



<script type="text/javascript">
$(document).ready(function(){

      $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/compras/autoCompleteCliente",
            minLength: 5,
            select: function( event, ui ) {
                 $("#clientes_id").val(ui.item.id);
            }
      });

      $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/compras/autoCompleteUsuario",
            minLength: 5,
            select: function( event, ui ) {

                 $("#usuarios_id").val(ui.item.id);
            }
      });

      $("#formCompras").validate({
          rules:{
             cliente: {required:true},
             tecnico: {required:true},
             dataCompra: {required:true},
             dataDocumentoCompra: {required:true}
          },
          messages:{
             cliente: {required: 'Campo Requerido.'},
             tecnico: {required: 'Campo Requerido.'},
             dataCompra: {required: 'Campo Requerido.'},
             dataDocumentoCompra: {required: 'Campo Requerido.'}
          },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
       });

    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
   
});

</script>

