<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Pessoa</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <?php echo form_hidden('idClientes',$result->idClientes) ?>
                        <label for="nomeCliente" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nomeCliente" class="input-xxlarge" type="text" name="nomeCliente"  maxlength="255" value="<?php echo $result->nomeCliente; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="documento" class="control-label">CPF/CNPJ</label>
                        <div class="controls">
                            <input id="documento" class="input-large" type="text" name="documento"  maxlength="20" value="<?php echo $result->documento; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="documento2" class="control-label">RG/IE</label>
                        <div class="controls">
                            <input id="documento2" class="input-large" type="text" name="documento2"  maxlength="20" value="<?php echo $result->documento2; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="telefone" class="control-label">Telefone</label>
                        <div class="controls">
                            <input id="telefone" class="input-small" type="text" name="telefone"  maxlength="20" value="<?php echo $result->telefone; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="telefone2" class="control-label">Telefone 2</label>
                        <div class="controls">
                            <input id="telefone2" class="input-small" type="text" name="telefone2"  maxlength="20" value="<?php echo $result->telefone2; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="celular" class="control-label">Celular</label>
                        <div class="controls">
                            <input id="celular" class="input-small" type="text" name="celular"  maxlength="20" value="<?php echo $result->celular; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label">Email</label>
                        <div class="controls">
                            <input id="email" class="input-xxlarge" type="text" name="email"  maxlength="100" value="<?php echo $result->email; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="rua" class="control-label">Logradouro</label>
                        <div class="controls">
                            <input id="rua" class="input-xxlarge" type="text" name="rua"  maxlength="70" value="<?php echo $result->rua; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="numero" class="control-label">Número</label>
                        <div class="controls">
                            <input id="numero" class="input-mini" type="text" name="numero"  maxlength="15" value="<?php echo $result->numero; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="bairro" class="control-label">Bairro</label>
                        <div class="controls">
                            <input id="bairro" class="input-xlarge" type="text" name="bairro"  maxlength="45" value="<?php echo $result->bairro; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="cidade" class="control-label">Cidade</label>
                        <div class="controls">
                            <input id="cidade" class="input-xlarge" type="text" name="cidade"  maxlength="45" value="<?php echo $result->cidade; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="estado" class="control-label">Estado</label>
                        <div class="controls">
							<select name="estado" class="span1">
								<option value="<?php echo $result->estado; ?>"><?php echo $result->estado; ?></option>
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

                    <div class="control-group" class="control-label">
                        <label for="cep" class="control-label">CEP</label>
                        <div class="controls">
                            <input id="cep" class="input-small" type="text" name="cep"  maxlength="9" value="<?php echo $result->cep; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="limite" class="control-label">Limite<span class="required">*</span></label>
                        <div class="controls">
                            <input id="limite" class="input-small" type="text" name="limite" value="<?php echo number_format($result->limite, 2, ',', '.'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="observacaoCliente" class="control-label">Observação</label>
                        <div class="controls">
                            <textarea class="span12" name="observacaoCliente" id="observacaoCliente" cols="30" rows="5"><?php echo $result->observacaoCliente?></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                <a href="<?php echo base_url() ?>index.php/clientes" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
           $('#formCliente').validate({
            rules :{
                  nomeCliente:{ required: true},
                  documento:{ required: false},
                  documento2:{ required: false},
                  telefone:{ required: false},
                  telefone2:{ required: false},
                  email:{ required: false},
                  rua:{ required: false},
                  numero:{ required: false},
                  bairro:{ required: false},
                  cidade:{ required: false},
                  estado:{ required: false},
                  cep:{ required: false},
                  limite:{ required: true},
                  observacaoCliente:{ required: false}
            },
            messages:{
                  nomeCliente :{ required: 'Campo Requerido.'},
                  documento :{ required: 'Campo Requerido.'},
                  documento2 :{ required: 'Campo Requerido.'},
                  telefone:{ required: 'Campo Requerido.'},
                  telefone2:{ required: 'Campo Requerido.'},
                  email:{ required: 'Campo Requerido.'},
                  rua:{ required: 'Campo Requerido.'},
                  numero:{ required: 'Campo Requerido.'},
                  bairro:{ required: 'Campo Requerido.'},
                  cidade:{ required: 'Campo Requerido.'},
                  estado:{ required: 'Campo Requerido.'},
                  cep:{ required: 'Campo Requerido.'},
                  limite:{ required: 'Campo Requerido.'},
                  observacaoCliente:{ required: 'Campo Requerido.'}

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

