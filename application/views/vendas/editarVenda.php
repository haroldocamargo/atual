<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>


<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Editar Venda</h5>
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da Venda</a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divEditarVenda">
                                
                                <form action="<?php echo current_url(); ?>" method="post" id="formVendas">
                                    <?php echo form_hidden('idVendas',$result->idVendas) ?>
                                    
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <h3>#Venda: <?php echo $result->idVendas ?></h3>
                                        <div class="span2" style="margin-left: 0">
                                            <label for="dataFinal">Data Final</label>
                                            <input id="dataVenda" class="span12 datepicker" type="text" name="dataVenda" value="<?php echo date('d/m/Y', strtotime($result->dataVenda)); ?>"  />
                                        </div>
                                        <div class="span5" >
                                            <label for="cliente">Pessoa<span class="required">*</span></label>
                                            <input id="cliente" class="span12" type="text" name="cliente" value="<?php echo $result->nomeCliente ?>"  />
                                            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value="<?php echo $result->clientes_id ?>"  />
                                            <input id="valorTotal" type="hidden" name="valorTotal" value=""  />
                                        </div>
                                        <div class="span5">
                                            <label for="tecnico">Vendedor<span class="required">*</span></label>
                                            <input id="tecnico" class="span12" type="text" name="tecnico" value="<?php echo $result->nome ?>"  />
                                            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?php echo $result->usuarios_id ?>"  />
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2">
                                            <label for="documentoVenda">Documento</label>
                                            <input id="documentoVenda" class="span12" type="text" name="documentoVenda" maxlength="20" value="<?php echo $result->documentoVenda ?>"  />
                                        </div>
                                        <div class="span2">
                                            <label for="dataDocumentoVenda">Data documento<span class="required">*</span></label>
                                            <input id="dataDocumentoVenda" class="span12 datepicker" type="text" name="dataDocumentoVenda" value="<?php echo date('d/m/Y', strtotime($result->dataDocumentoVenda)); ?>"  />
                                        </div>
                                        <div class="span2">
                                            <label for="setorVenda">Setor</label>
                                            <input id="setorVenda" class="span12" type="text" name="setorVenda" value="<?php echo $result->setorVenda ?>"  />
                                        </div>
                                        <div class="span6">
                                            <label for="observacaoVenda">Observação</label>
                                            <input id="observacaoVenda" class="span12" type="text" name="observacaoVenda" value="<?php echo $result->observacaoVenda ?>"  />
                                        </div>
                                    </div>
                                    
                                   
                                   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
            
                                        <div class="span8 offset2" style="text-align: center">
                                            <?php if($result->faturado == 0){ ?>
    	                                        <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> Faturar</a>
	                                            <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>
                                            <?php } ?>
                                            <a href="<?php echo base_url() ?>index.php/vendas/visualizar/<?php echo $result->idVendas; ?>" class="btn btn-inverse"><i class="icon-eye-open"></i> Visualizar Venda</a>
                                            <a href="<?php echo base_url() ?>index.php/vendas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>

                                    </div>

                                </form>
                                
                                <div class="span12 well" style="padding: 1%; margin-left: 0">
                                        
                                        <form id="formProdutos" action="<?php echo base_url(); ?>index.php/vendas/adicionarProduto" method="post">
                                            <div class="span4">
                                                <input type="hidden" name="idProduto" id="idProduto" />
                                                <input type="hidden" name="idVendasProduto" id="idVendasProduto" value="<?php echo $result->idVendas?>" />
	                                            <input type="hidden" name="dataVenda" id="dataVenda" value="<?php echo date('d/m/Y', strtotime($result->dataVenda)); ?>"  />
										        <input type="hidden" name="documentoVenda" id="documentoVenda" value="<?php echo $result->documentoVenda; ?>">
                                                <input type="hidden" name="estoque" id="estoque" value=""/>
										        <input type="hidden" name="setorVenda" id="setorVenda" value="<?php echo $result->setorVenda; ?>">
                                                <label for="">Produto</label>
                                                <input type="text" class="span12" name="produto" id="produto" placeholder="Digite o nome do produto" />
                                            </div>
                                            <div class="span1">
                                                <label for="">Preço</label>
                                                <input type="text" placeholder="Preço" id="preco" name="preco" class="span12 money" />
                                            </div>
                                            <div class="span1">
                                                <label for="">Quantidade</label>
                                                <input type="text" placeholder="Qtde" id="quantidade" name="quantidade" class="span12" value="1"/>
                                            </div>
                                            
                                            <div class="span2">
                                                <label for="">Série</label>
                                                <input type="text" placeholder="Série" id="serie" name="serie" class="span12" />
                                            </div>

                                            <div class="span3">
                                                <label for="">Observação</label>
                                                <input type="text" placeholder="Observação" id="observacaoItem" name="observacaoItem" class="span12" />
                                            </div>

                                            <div class="span1">
                                                <label for="">&nbsp</label>
                                            <?php if($result->faturado == 0){ ?>
                                                <button class="btn btn-success span12" id="btnAdicionarProduto"><i class="icon-white icon-plus"></i> </button>
                                            <?php } ?>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span12" id="divProdutos" style="margin-left: 0">
                                        <table class="table table-bordered" id="tblProdutos">
                                            <thead>
                                                <tr>
                                                    <th>Produto</th>
                                                    <th>Preço</th>
                                                    <th>Quantidade</th>
                                                    <th>Serie</th>
                                                    <th>Observação</th>
                                                    <th>Sub-total</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total = 0;
                                                foreach ($produtos as $p) {
                                                    
                                                    $total = $total + $p->subTotal;
                                                    echo '<tr>';
                                                    echo '<td>'.$p->descricao.'</td>';
                                                    echo '<td>'.number_format($p->valor,2,',','.').'</td>';
                                                    echo '<td>'.number_format($p->quantidade,2,',','.').'</td>';
                                                    echo '<td>'.$p->serie.'</td>';
                                                    echo '<td>'.$p->observacaoItem.'</td>';
                                                    echo '<td>'.number_format($p->subTotal,2,',','.').'</td>';
                                                  

		                                            if($result->faturado == 0){                                        
													    echo '<td><a href="" idAcao="'.$p->idItens.'" idVenda="'.$p->vendas_id.'" prodAcao="'.$p->idProdutos.'" quantAcao="'.$p->quantidade.'" title="Excluir Produto" class="btn btn-danger"><i class="icon-remove icon-white"></i></a></td>';
													}
													else {
                                                      echo '<td> &nbsp </td>';
													}	
                                                    echo '</tr>';
                                                }?>
                                               
                                                <tr>
                                                    <td colspan="5" style="text-align: right"><strong>Total:</strong></td>
                                                    <td><strong><?php echo number_format($total,2,',','.');?></strong> <input type="hidden" id="total-venda" value="<?php echo number_format($total,2); ?>"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>


<!-- Modal Faturar-->
<div id="modal-faturar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form id="formFaturar" action="<?php echo current_url() ?>" method="post">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Faturar Venda</h3>
</div>
<div class="modal-body">
    <div class="span12" style="margin-left: 0"> 
      <label for="descricao">Descrição</label>
      <input class="span12" id="descricao" type="text" name="descricao" value="Fatura da Venda - #<?php echo $result->idVendas; ?> "  />
    </div>  

    <div class="span12" style="margin-left: 0"> 
      <div class="span12" style="margin-left: 0"> 
        <label for="cliente">Pessoa*</label>
        <input class="span12" id="cliente" type="text" name="cliente" value="<?php echo $result->nomeCliente ?>" />
        <input type="hidden" name="clientes_id" id="clientes_id" value="<?php echo $result->clientes_id ?>">
        <input type="hidden" name="vendas_id" id="vendas_id" value="<?php echo $result->idVendas; ?>">
        <input type="hidden" name="documentoVenda" id="documentoVenda" value="<?php echo $result->documentoVenda; ?>">
        <input type="hidden" name="dataDocumentoVenda" id="dataDocumentoVenda" value="<?php echo $result->dataDocumentoVenda; ?>">
        <input type="hidden" name="observacaoVenda" id="observacaoVenda" value="<?php echo $result->observacaoVenda; ?>">
        <input type="hidden" name="setorVenda" id="setorVenda" value="<?php echo $result->setorVenda; ?>">
      </div>
    </div>

    <div class="span12" style="margin-left: 0"> 
      <div class="span3" >  
        <label for="valor">Valor*</label>
        <input type="hidden" id="tipo" name="tipo" value="receita" /> 
        <input class="span12 money" id="valor" type="text" name="valor" value="<?php echo number_format($total,2); ?> "  />
      </div>
      <div class="span3" >  
        <label for="vencimento">Vencimento*</label>
        <input class="span12 datepicker" id="vencimento" type="text" name="vencimento"  />
      </div>
      <div class="span3" >  
        <label for="valor2">Valor</label>
        <input class="span12 money" id="valor2" type="text" name="valor2" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento2">Vencimento</label>
        <input class="span12 datepicker" id="vencimento2" type="text" name="vencimento2"  />
      </div>
    </div>
    
    <div class="span12" style="margin-left: 0"> 
      <div class="span3" >  
        <label for="valor3">Valor</label>
        <input class="span12 money" id="valor3" type="text" name="valor3" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento3">Vencimento</label>
        <input class="span12 datepicker" id="vencimento3" type="text" name="vencimento3"  />
      </div>
      <div class="span3" >  
        <label for="valor4">Valor</label>
        <input class="span12 money" id="valor4" type="text" name="valor4" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento4">Vencimento</label>
        <input class="span12 datepicker" id="vencimento4" type="text" name="vencimento4"  />
      </div>
    </div>
    
    <div class="span12" style="margin-left: 0"> 
      <div class="span3" >  
        <label for="valor5">Valor</label>
        <input class="span12 money" id="valor5" type="text" name="valor5" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento5">Vencimento</label>
        <input class="span12 datepicker" id="vencimento5" type="text" name="vencimento5"  />
      </div>
      <div class="span3" >  
        <label for="valor6">Valor</label>
        <input class="span12 money" id="valor6" type="text" name="valor6" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento6">Vencimento</label>
        <input class="span12 datepicker" id="vencimento6" type="text" name="vencimento6"  />
      </div>
    </div>
    
    <div class="span12" style="margin-left: 0"> 
      <div class="span3" >  
        <label for="valor7">Valor</label>
        <input class="span12 money" id="valor7" type="text" name="valor7" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento7">Vencimento</label>
        <input class="span12 datepicker" id="vencimento7" type="text" name="vencimento7"  />
      </div>
      <div class="span3" >  
        <label for="valor8">Valor</label>
        <input class="span12 money" id="valor8" type="text" name="valor8" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento8">Vencimento</label>
        <input class="span12 datepicker" id="vencimento8" type="text" name="vencimento8"  />
      </div>
    </div>
    
    <div class="span12" style="margin-left: 0"> 
      <div class="span3" >  
        <label for="valor9">Valor</label>
        <input class="span12 money" id="valor9" type="text" name="valor9" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento9">Vencimento</label>
        <input class="span12 datepicker" id="vencimento9" type="text" name="vencimento9"  />
      </div>
      <div class="span3" >  
        <label for="valor10">Valor</label>
        <input class="span12 money" id="valor10" type="text" name="valor10" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento10">Vencimento</label>
        <input class="span12 datepicker" id="vencimento10" type="text" name="vencimento10"  />
      </div>
    </div>
    
    
    <div class="span12" style="margin-left: 0"> 
      <div class="span3" >  
        <label for="valor11">Valor</label>
        <input class="span12 money" id="valor11" type="text" name="valor11" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento11">Vencimento</label>
        <input class="span12 datepicker" id="vencimento11" type="text" name="vencimento11"  />
      </div>
      <div class="span3" >  
        <label for="valor12">Valor</label>
        <input class="span12 money" id="valor12" type="text" name="valor12" value=""  />
      </div>
      <div class="span3" >  
        <label for="vencimento12">Vencimento</label>
        <input class="span12 datepicker" id="vencimento12" type="text" name="vencimento12"  />
      </div>
    </div>
    
    
    <div class="span12" style="margin-left: 0"> 
      <div class="span4" style="margin-left: 0">
<!--
        <label for="recebido">Recebido?</label>
        &nbsp &nbsp &nbsp &nbsp
-->        
        <input  id="recebido" type="hidden" name="recebido" value="0" /> 
      </div>
      <div id="divRecebimento" class="span8" style=" display: none">
        <div class="span6">
          <label for="recebimento">Data Recebimento</label>
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
  <button class="btn" data-dismiss="modal" aria-hidden="true" id="btn-cancelar-faturar">Cancelar</button>
  <button class="btn btn-primary">Faturar</button>
</div>
</form>
</div>
 

<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){

     $(".money").maskMoney({decimal:",", thousands:"."}); 

     $('#recebido').click(function(event) {
        var flag = $(this).is(':checked');
        if(flag == true){
          $('#divRecebimento').show();
        }
        else{
          $('#divRecebimento').hide();
        }
     });

     $(document).on('click', '#btn-faturar', function(event) {
       event.preventDefault();
         valor = $('#total-venda').val();
         valor = valor.replace(',', '' );
         $('#valor').val(valor);
     });
     
     $("#formFaturar").validate({
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
          },
          submitHandler: function( form ){       
            var dados = $( form ).serialize();
            $('#btn-cancelar-faturar').trigger('click');
            $.ajax({
              type: "POST",
              url: "<?php echo base_url();?>index.php/vendas/faturar",
              data: dados,
              dataType: 'json',
              success: function(data)
              {
                if(data.result == true){
                    
                    window.location.reload(true);
                }
                else{
                    alert('Ocorreu um erro ao efetuar venda.');
                    $('#progress-fatura').hide();
                }
              }
              });

              return false;
          }
     });

     $("#produto").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteProduto",
            minLength: 3,
            select: function( event, ui ) {

                 $("#idProduto").val(ui.item.id);
                 $("#estoque").val(ui.item.estoque);
                 $("#preco").val(ui.item.preco.replace(".",","));
                 $("#preco").focus();
            }
      });



      $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteCliente",
            minLength: 3,
            select: function( event, ui ) {

                 $("#clientes_id").val(ui.item.id);
            }
      });

      $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteUsuario",
            minLength: 3,
            select: function( event, ui ) {

                 $("#usuarios_id").val(ui.item.id);
            }
      });


      $("#formVendas").validate({
          rules:{
             cliente: {required:true},
             tecnico: {required:true},
             dataVenda: {required:true},
             dataDocumentoVenda: {required:true}
          },
          messages:{
             cliente: {required: 'Campo Requerido.'},
             tecnico: {required: 'Campo Requerido.'},
             dataVenda: {required: 'Campo Requerido.'},
             dataDocumentoVenda: {required: 'Campo Requerido.'}
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




      $("#formProdutos").validate({
          rules:{
             quantidade: {required:true}
          },
          messages:{
             quantidade: {required: 'Insira a quantidade'}
          },
          submitHandler: function( form ){
             var quantidade = parseInt($("#quantidade").val());
             var estoque = parseInt($("#estoque").val());
             if(estoque < quantidade){
                alert('Você não possui estoque suficiente.');
             }
             else{
                 var dados = $( form ).serialize();
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/adicionarProduto",
                  data: dados,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divProdutos" ).load("<?php echo current_url();?> #divProdutos" );
                        $("#quantidade").val('1');
                        $("#serie").val('');
                        $("#observacaoItem").val('');
                        $("#produto").val('').focus();
                    }
                    else{
                        alert('Ocorreu um erro ao adicionar produto.');
                    }
                  }
                  });

                  return false;
                }

             }
             
       });

     

       $(document).on('click', 'a', function(event) {
            var idProduto = $(this).attr('idAcao');
            var quantidade = $(this).attr('quantAcao');
            var produto = $(this).attr('prodAcao');
            var idVenda = $(this).attr('idVenda');
            if((idProduto % 1) == 0){
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/excluirProduto",
                  data: "idProduto="+idProduto+"&quantidade="+quantidade+"&produto="+produto+"&idVenda="+idVenda,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $( "#divProdutos" ).load("<?php echo current_url();?> #divProdutos" );
                        
                    }
                    else{
                        alert('Ocorreu um erro ao excluir produto.');
                    }
                  }
                  });
                  return false;
            }
            
       });

       $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
});

</script>

