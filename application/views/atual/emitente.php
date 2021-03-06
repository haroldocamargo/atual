
<?php if(!isset($dados) || $dados == null) {?>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Dados do Emitente</h5>
            </div>
            <div class="widget-content ">
                <div class="alert alert-danger">Nenhum dado foi cadastrado até o momento. Essas informações 
                estarão disponíveis na tela de impressão de OS.</div>
                <a href="#modalCadastrar" data-toggle="modal" role="button" class="btn btn-success">Cadastrar Dados</a>
            </div>
        </div>    
        
    </div>
</div>   


<div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/atual/cadastrarEmitente" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Atual ERP - Sistema Administrativo - Cadastrar Dados do Emitente</h3>
  </div>
  <div class="modal-body">
        
        
                    <div class="control-group">
                        <label for="nome" class="control-label">Razão Social<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" class="input-xlarge" type="text" name="nome" maxlength="255" value=""  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="cnpj" class="control-label"><span class="required">CNPJ*</span></label>
                        <div class="controls">
                            <input class="input-large" type="text" name="cnpj" maxlength="45" value=""  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">IE*</span></label>
                        <div class="controls">
                            <input class="input-large" type="text" name="ie" value="" maxlength="45" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Logradouro*</span></label>
                        <div class="controls">
                            <input  class="input-xlarge" type="text" name="logradouro" maxlength="70" value=""  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Número*</span></label>
                        <div class="controls">
                            <input  class="input-mini" type="text" name="numero" maxlength="15" value=""  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Bairro*</span></label>
                        <div class="controls">
                            <input type="text" name="bairro" maxlength="45" value=""  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Cidade*</span></label>
                        <div class="controls">
                            <input type="text" name="cidade" maxlength="45" value=""  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">UF*</span></label>
                        <div class="controls">
							<select name="uf" class="span3">
								<option value=""></option>
								<option value="AC">Acre</option>
								<option value="AL">Alagoas</option>
								<option value="AP">Amapá</option>
								<option value="AM">Amazonas</option>
								<option value="BA">Bahia</option>
								<option value="CE">Ceará</option>
								<option value="DF">Distrito Federal</option>
								<option value="ES">Espirito Santo</option>
								<option value="GO">Goiás</option>
								<option value="MA">Maranhão</option>
								<option value="MS">Mato Grosso do Sul</option>
								<option value="MT">Mato Grosso</option>
								<option value="MG">Minas Gerais</option>
								<option value="PA">Pará</option>
								<option value="PB">Paraíba</option>
								<option value="PR">Paraná</option>
								<option value="PE">Pernambuco</option>
								<option value="PI">Piauí</option>
								<option value="RJ">Rio de Janeiro</option>
								<option value="RN">Rio Grande do Norte</option>
								<option value="RS">Rio Grande do Sul</option>
								<option value="RO">Rondônia</option>
								<option value="RR">Roraima</option>
								<option value="SC">Santa Catarina</option>
								<option value="SP">São Paulo</option>
								<option value="SE">Sergipe</option>
								<option value="TO">Tocantins</option>
							</select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Telefone*</span></label>
                        <div class="controls">
                            <input type="text" name="telefone" maxlength="15" value=""  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Celular*</span></label>
                        <div class="controls">
                            <input type="text" name="celular" maxlength="15" value=""  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">E-mail*</span></label>
                        <div class="controls">
                            <input class="input-xlarge" type="text" name="email" maxlength="255" value="" />
                        </div>
                    </div>
<!--
                    <div class="control-group">
                        <label for="logo" class="control-label"><span class="required">Logomarca*</span></label>
                        <div class="controls">
                            <input type="file" name="userfile" value="" />
                        </div>
                    </div>
-->               
                    <div class="control-group" class="control-label">
                        <label for="observacaoEmitente" class="control-label">Observação</label>
                        <div class="controls">
                            <textarea class="span12" name="observacaoEmitente" id="observacaoEmitente" cols="30" rows="7" value=""></textarea>
                        </div>
                    </div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-success">Cadastrar</button>
  </div>
  </form>
</div>

<?php } else { ?>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Dados do Emitente</h5>
            </div>
            <div class="widget-content ">
            <div class="alert alert-info">Os dados abaixo serão utilizados no cabeçalho das telas de impressão.</div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
<!--                            <td style="width: 25%"><img src=" <?php echo $dados[0]->url_logo; ?> "></td> -->
                            <td> <span style="font-size: 20px; "> <?php echo $dados[0]->nome; ?> </span> </br><span><?php echo $dados[0]->cnpj; ?> </br> <?php echo $dados[0]->rua.', nº:'.$dados[0]->numero.', '.$dados[0]->bairro.' - '.$dados[0]->cidade.' - '.$dados[0]->uf; ?> </span> </br> <span> E-mail: <?php echo $dados[0]->email.' - Fone: '.$dados[0]->telefone; ?></span></td>
                        </tr>
                    </tbody>
                </table>

                <a href="#modalAlterar" data-toggle="modal" role="button" class="btn btn-primary">Alterar Dados</a>
<!--                <a href="#modalLogo" data-toggle="modal" role="button" class="btn btn-inverse">Alterar Logo</a>-->
            </div>
        </div>
    </div>
</div>




<div id="modalAlterar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/atual/editarEmitente" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">Atual ERP - Sistema Administrativo - Editar Dados do Emitente</h3>
  </div>
  <div class="modal-body">
        
        
                    <div class="control-group">
                        <label for="nome" class="control-label">Razão Social<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" class="input-xlarge" type="text" name="nome" maxlength="255" value="<?php echo $dados[0]->nome; ?>"  />
                            <input id="nome" type="hidden" name="id" value="<?php echo $dados[0]->id; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="cnpj" class="control-label"><span class="required">CNPJ*</span></label>
                        <div class="controls">
                            <input class="" type="text" class="input-large" name="cnpj" maxlength="45" value="<?php echo $dados[0]->cnpj; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">IE*</span></label>
                        <div class="controls">
                            <input class="input-large" type="text" name="ie" class="input-large" maxlength="45" value="<?php echo $dados[0]->ie; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Logradouro*</span></label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="logradouro" maxlength="70" value="<?php echo $dados[0]->rua; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Número*</span></label>
                        <div class="controls">
                            <input  class="input-mini" type="text" name="numero" maxlength="15" value="<?php echo $dados[0]->numero; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Bairro*</span></label>
                        <div class="controls">
                            <input type="text" name="bairro" maxlength="45" value="<?php echo $dados[0]->bairro; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Cidade*</span></label>
                        <div class="controls">
                            <input type="text" name="cidade" maxlength="45" value="<?php echo $dados[0]->cidade; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">UF*</span></label>
                        <div class="controls">
							<select name="uf" class="span3">
								<option value="<?php echo $dados[0]->uf; ?>"><?php echo $dados[0]->uf; ?></option>
								<option value="AC">AC</option>
								<option value="AL">AL</option>
								<option value="AP">AP</option>
								<option value="AM">AM</option>
								<option value="BA">BA</option>
								<option value="CE">CE</option>
								<option value="DF">DF</option>
								<option value="ES">ES</option>
								<option value="GO">GO</option>
								<option value="MA">MA</option>
								<option value="MS">MS</option>
								<option value="MT">MT</option>
								<option value="MG">MG</option>
								<option value="PA">PA</option>
								<option value="PB">PB</option>
								<option value="PR">PR</option>
								<option value="PE">PE</option>
								<option value="PI">PE</option>
								<option value="RJ">RJ</option>
								<option value="RN">RN</option>
								<option value="RS">RS</option>
								<option value="RO">RO</option>
								<option value="RR">RR</option>
								<option value="SC">SC</option>
								<option value="SP">SP</option>
								<option value="SE">SE</option>
								<option value="TO">TO</option>
							</select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Telefone*</span></label>
                        <div class="controls">
                            <input type="text" name="telefone" maxlength="20" value="<?php echo $dados[0]->telefone; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Celular*</span></label>
                        <div class="controls">
                            <input type="text" name="celular" maxlength="20" value="<?php echo $dados[0]->celular; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">E-mail*</span></label>
                        <div class="controls">
                            <input class="input-xlarge" type="text" name="email" maxlength="255" value="<?php echo $dados[0]->email; ?>" />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="observacaoEmitente" class="control-label">Observação</label>
                        <div class="controls">
                            <textarea class="span12" name="observacaoEmitente" id="observacaoEmitente" cols="30" rows="7"><?php echo $dados[0]->observacaoEmitente; ?></textarea>
                        </div>
                    </div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
  </form>
</div>


<div id="modalLogo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/atual/editarLogo" id="formLogo" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">Atual ERP - Sistema Administrativo - Alterar Logomarca</h3>
  </div>
  <div class="modal-body">
         <div class="span12 alert alert-info">Selecione uma nova imagem da logomarca. Tamanho indicado (130 X 130).</div>          
         <div class="control-group">
            <label for="logo" class="control-label"><span class="required">Logomarca*</span></label>
            <div class="controls">
                <input type="file" name="userfile" value="" />
                <input id="nome" type="hidden" name="id" value="<?php echo $dados[0]->id; ?>"  />
            </div>
        </div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
  </form>
</div>



<?php } ?>


<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
    
$(document).ready(function(){

    $("#formLogo").validate({
      rules:{
         userfile: {required:true}
      },
      messages:{
         userfile: {required: 'Campo Requerido.'}
      },

        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
            $(element).parents('.control-group').removeClass('success');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
   });


    $("#formCadastrar").validate({
      rules:{
         userfile: {required:true},
         nome: {required:true},
         cnpj: {required:true},
         ie: {required:true},
         logradouro: {required:true},
         numero: {required:true},
         bairro: {required:true},
         cidade: {required:true},
         uf: {required:true},
         telefone: {required:true},
         celular: {required:true},
         email: {required:true},
         observacaoEmitente: {required:false}
      },
      messages:{
         userfile: {required: 'Campo Requerido.'},
         nome: {required: 'Campo Requerido.'},
         cnpj: {required: 'Campo Requerido.'},
         ie: {required: 'Campo Requerido.'},
         logradouro: {required: 'Campo Requerido.'},
         numero: {required:'Campo Requerido.'},
         bairro: {required:'Campo Requerido.'},
         cidade: {required:'Campo Requerido.'},
         uf: {required:'Campo Requerido.'},
         telefone: {required:'Campo Requerido.'},
         celular: {required:'Campo Requerido.'},
         email: {required:'Campo Requerido.'},
         observacaoEmitente: {required:'Campo Requerido.'}
      },

        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
            $(element).parents('.control-group').removeClass('success');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
   });


    $("#formAlterar").validate({
      rules:{
         userfile: {required:true},
         nome: {required:true},
         cnpj: {required:true},
         ie: {required:true},
         logradouro: {required:true},
         numero: {required:true},
         bairro: {required:true},
         cidade: {required:true},
         uf: {required:true},
         telefone: {required:true},
         celular: {required:true},
         email: {required:true},
         observacaoEmitente: {required:false}
      },
      messages:{
         userfile: {required: 'Campo Requerido.'},
         nome: {required: 'Campo Requerido.'},
         cnpj: {required: 'Campo Requerido.'},
         ie: {required: 'Campo Requerido.'},
         logradouro: {required: 'Campo Requerido.'},
         numero: {required:'Campo Requerido.'},
         bairro: {required:'Campo Requerido.'},
         cidade: {required:'Campo Requerido.'},
         uf: {required:'Campo Requerido.'},
         telefone: {required:'Campo Requerido.'},
         celular: {required:'Campo Requerido.'},
         email: {required:'Campo Requerido.'},
         observacaoEmitente: {required:'Campo Requerido.'}
},

        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
            $(element).parents('.control-group').removeClass('success');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
   });

});
    
</script>