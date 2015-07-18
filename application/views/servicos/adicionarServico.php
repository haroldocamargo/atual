<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Cadastro de Serviço</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formServico" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" class="input-xlarge" type="text" name="nome" maxlength="45" value="<?php echo set_value('nome'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descricao" class="control-label">Descrição</label>
                        <div class="controls">
                            <input id="descricao" class="input-xxlarge" type="text" name="descricao" maxlength="45" value="<?php echo set_value('descricao'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="grupo" class="control-label">Grupo</label>
                        <div class="controls">
                            <input id="grupo" class="input-large" type="text" name="grupo" maxlength="20" value="<?php echo set_value('grupo'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="subgrupo" class="control-label">SubGrupo</label>
                        <div class="controls">
                            <input id="subgrupo" class="input-large" type="text" name="subgrupo" maxlength="20" value="<?php echo set_value('subgrupo'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="categoria" class="control-label">Categoria</label>
                        <div class="controls">
                            <input id="categoria" class="input-large" type="text" name="categoria" maxlength="20" value="<?php echo set_value('categoria'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="classe" class="control-label">Classe</label>
                        <div class="controls">
                            <input id="classe" class="input-large" type="text" name="classe" maxlength="20" value="<?php echo set_value('classe'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="tipo" class="control-label">Tipo</label>
                        <div class="controls">
                            <input id="tipo" class="input-large" type="text" name="tipo" maxlength="20" value="<?php echo set_value('tipo'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="preco" class="control-label">Preço</label>
                        <div class="controls">
                            <input id="preco" class="input-small" class="money" type="text" name="preco" value="<?php echo set_value('preco'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="observacaoServico" class="control-label">Observação</label>
                        <div class="controls">
                            <textarea class="span12" name="observacaoServico" id="observacaoServico" cols="30" rows="5" value="<?php echo set_value('observacaoServico'); ?>"></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/servicos" id="btnAdicionar" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
          $(".money").maskMoney();
           $('#formServico').validate({
            rules :{
                  nome:{ required: true},
                  preco:{ required: false}
            },
            messages:{
                  nome :{ required: 'Campo Requerido.'},
                  preco :{ required: 'Campo Requerido.'}
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
      });
</script>




                                    
