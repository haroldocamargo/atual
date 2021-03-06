
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
                <h5>Editar OS</h5>
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da OS</a></li>
                        <li id="tabProdutos"><a href="#tab2" data-toggle="tab">Produtos</a></li>
                        <li id="tabServicos"><a href="#tab3" data-toggle="tab">Serviços</a></li>
                        <li id="tabAnexos"><a href="#tab4" data-toggle="tab">Anexos</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                
                                <form action="<?php echo current_url(); ?>" method="post" id="formOs">
                                    <?php echo form_hidden('idOs',$result->idOs) ?>
                                    
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <h3>#Os: <?php echo $result->idOs ?></h3>
                                        
                                        <div class="span3" style="margin-left: 0">
                                            <label for="cliente">Pessoa<span class="required">*</span></label>
                                            <input id="cliente" class="span12" type="text" name="cliente" value="<?php echo $result->nomeCliente ?>"  />
                                            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value="<?php echo $result->clientes_id ?>"  />
                                            <input id="valorTotal" type="hidden" name="valorTotal" value=""  />
                                        </div>
                                        <div class="span3">
                                            <label for="tecnico">Técnico / Responsável<span class="required">*</span></label>
                                            <input id="tecnico" class="span12" type="text" name="tecnico" value="<?php echo $result->nome ?>"  />
                                            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?php echo $result->usuarios_id ?>"  />
                                        </div>
                                        <div class="span2">
                                            <label for="documentoOs">Documento<span class="required">*</span></label>
                                            <input id="documentoOs" class="span12" type="text" name="documentoOs" value="<?php echo $result->documentoOs ?>"  />
                                        </div>
                                        <div class="span2">
                                            <label for="modelo">Modelo</label>
                                            <input id="modelo" class="span12" type="text" name="modelo" value="<?php echo $result->modelo ?>"  />
                                        </div>
                                        <div class="span2">
                                            <label for="setorOs">Setor</span></label>
                                            <input id="setorOs" class="span12" type="text" name="setorOs" value="<?php echo $result->setorOs ?>"  />
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3">
                                            <label for="status">Status<span class="required">*</span></label>
                                            <select class="span12" name="status" id="status" value="">
                                                <option <?php if($result->status == 'Orçamento'){echo 'selected';} ?> value="Orçamento">Orçamento</option>
                                                <option <?php if($result->status == 'Aberto'){echo 'selected';} ?> value="Aberto">Aberto</option>
                                                <option <?php if($result->status == 'Faturado'){echo 'selected';} ?> value="Faturado">Faturado</option>
                                                <option <?php if($result->status == 'Finalizado'){echo 'selected';} ?> value="Finalizado">Finalizado</option>
                                                <option <?php if($result->status == 'Cancelado'){echo 'selected';} ?> value="Cancelado">Cancelado</option>
                                            </select>
                                        </div>
                                        <div class="span3">
                                            <label for="dataInicial">Data Inicial<span class="required">*</span></label>
                                            <input id="dataInicial" class="span12 datepicker" type="text" name="dataInicial" value="<?php echo date('d/m/Y', strtotime($result->dataInicial)); ?>"  />
                                        </div>
                                        <div class="span3">
                                            <label for="dataFinal">Data Final<span class="required">*</span></label>
                                            <input id="dataFinal" class="span12 datepicker" type="text" name="dataFinal" value="<?php echo date('d/m/Y', strtotime($result->dataFinal)); ?>"  />
                                        </div>

                                        <div class="span3">
                                            <label for="garantia">Garantia</label>
                                            <input id="garantia" type="text" class="span12" name="garantia" value="<?php echo $result->garantia ?>"  />
                                        </div>
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                        <div class="span6">
                                            <label for="descricaoProduto">Descrição Produto/Serviço</label>
                                            <textarea class="span12" name="descricaoProduto" id="descricaoProduto" cols="30" rows="3"><?php echo $result->descricaoProduto?></textarea>
                                        </div>
                                        <div class="span6">
                                            <label for="defeito">Defeito</label>
                                            <textarea class="span12" name="defeito" id="defeito" cols="30" rows="3"><?php echo $result->defeito?></textarea>
                                        </div>

                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6">
                                            <label for="observacaoOs">Observações</label>
                                            <textarea class="span12" name="observacaoOs" id="observacaoOs" cols="30" rows="3"><?php echo $result->observacaoOs ?></textarea>
                                        </div>
                                        <div class="span6">
                                            <label for="laudoTecnico">Laudo Técnico</label>
                                            <textarea class="span12" name="laudoTecnico" id="laudoTecnico" cols="30" rows="3"><?php echo $result->laudoTecnico ?></textarea>
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6 offset3" style="text-align: center">
                                            <?php if($result->faturado == 0){ ?>
                                                <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> Faturar</a>
	                                            <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>
                                            <?php } ?>
                                            <a href="<?php echo base_url() ?>index.php/os/visualizar/<?php echo $result->idOs; ?>" class="btn btn-inverse"><i class="icon-eye-open"></i> Visualizar OS</a>
                                            <a href="<?php echo base_url() ?>index.php/os" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>


                        <!--Produtos-->
                        <div class="tab-pane" id="tab2">
                            <div class="span12 well" style="padding: 1%; margin-left: 0">
                                <form id="formProdutos" action="<?php echo base_url() ?>index.php/os/adicionarProduto" method="post">
                                    <div class="span4">
                                        <input type="hidden" name="idProduto" id="idProduto" />
                                        <input type="hidden" name="idOsProduto" id="idOsProduto" value="<?php echo $result->idOs?>" />
                                        <input type="hidden" name="dataOs" id="dataOs" value="<?php echo date('d/m/Y', strtotime($result->dataInicial)); ?>"  />
								        <input type="hidden" name="documentoOs" id="documentoOs" value="<?php echo $result->documentoOs; ?>">
                                        <input type="hidden" name="estoque" id="estoque" value=""/>
								        <input type="hidden" name="setorOs" id="setorOs" value="<?php echo $result->setorOs; ?>">
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
                                        <label for=""> &nbsp;</label>
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
                                            echo '<td>'.$p->descricao.'</td>';
                                            echo '<td>'.number_format($p->valor,2,',','.').'</td>';
                                            echo '<td>'.number_format($p->quantidade,2,',','.').'</td>';
                                            echo '<td>'.$p->serie.'</td>';
                                            echo '<td>'.$p->observacaoItem.'</td>';
                                            echo '<td>'.number_format($p->subTotal,2,',','.').'</td>';
                                            if($result->faturado == 0){                                        
	                                            echo '<td><a href="" idAcao="'.$p->idProdutos_os.'" idOs="'.$p->os_id.'" prodAcao="'.$p->idProdutos.'" quantAcao="'.$p->quantidade.'" title="Excluir Produto" class="btn btn-danger"><i class="icon-remove icon-white"></i></a></td>';
  											}
											else {
                                                echo '<td> &nbsp </td>';
											}	
                                            echo '</tr>';
                                        }?>
                                       
                                        <tr>
                                            <td colspan="5" style="text-align: right"><strong>Total:</strong></td>
                                            <td><strong><?php echo number_format($total,2,',','.');?><input type="hidden" id="total-venda" value="<?php echo number_format($total,2); ?>"></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <!--Serviços-->
                        <div class="tab-pane" id="tab3">
                            <div class="span12" style="padding: 1%; margin-left: 0">
                                <div class="span12 well" style="padding: 1%; margin-left: 0">
                                    <form id="formServicos" action="<?php echo base_url() ?>index.php/os/adicionarServico" method="post">
                                    <div class="span7">
                                        <input type="hidden" name="idServico" id="idServico" />
                                        <input type="hidden" name="idOsServico" id="idOsServico" value="<?php echo $result->idOs?>" />
                                        <label for="">Serviço</label>
                                        <input type="text" class="span12" name="servico" id="servico" placeholder="Digite o nome do serviço" />
                                    </div>
                                    <div class="span1">
                                        <label for="">Preço</label>
                                        <input type="text" placeholder="Preço" id="precoServico" name="precoServico" class="span12 money" />
                                    </div>

                                    <div class="span3">
                                        <label for="">Observação</label>
                                        <input type="text" placeholder="Observação" id="observacaoItemServico" name="observacaoItemServico" class="span12" />
                                    </div>

                                    <div class="span1">
                                        <label> &nbsp;</label>
                                        <?php if($result->faturado == 0){ ?>
	                                        <button class="btn btn-success span12"><i class="icon-white icon-plus"></i> </button>
                                        <?php } ?>
                                    </div>
                                    </form>
                                </div>
                                <div class="span12" id="divServicos" style="margin-left: 0">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Serviço</th>
                                                <th>Sub-total</th>
	                                            <th>Observação</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                        $total = 0;
                                        foreach ($servicos as $s) {
                                            $preco = $s->valor;
                                            $total = $total + $preco;
                                            echo '<tr>';
                                            echo '<td>'.$s->nome.'</td>';
											echo '<td>'.number_format($s->valor,2,',','.').'</td>';
                                            echo '<td>'.$s->observacaoServicoOs.'</td>';
                                            if($result->faturado == 0){                                        
                                            	echo '<td><span idAcao="'.$s->idServicos_os.'" idOs="'.$s->os_id.'" title="Excluir Serviço" class="btn btn-danger"><i class="icon-remove icon-white"></i></span></td>';
  											}
											else {
                                                echo '<td> &nbsp </td>';
											}	
                                            echo '</tr>';
                                        }?>

                                        <tr>
                                            <td colspan="1" style="text-align: right"><strong>Total:</strong></td>
                                            <td><strong><?php echo number_format($total,2,',','.');?><input type="hidden" id="total-servico" value="<?php echo number_format($total,2); ?>"></strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>


                        <!--Anexos-->
                        <div class="tab-pane" id="tab4">
                            <div class="span12" style="padding: 1%; margin-left: 0">
                                <div class="span12 well" style="padding: 1%; margin-left: 0" id="form-anexos">
                                    <form id="formAnexos" enctype="multipart/form-data" action="javascript:;" accept-charset="utf-8"s method="post">
                                    <div class="span10">
                                
                                        <input type="hidden" name="idOsAnexo" id="idOsAnexo" value="<?php echo $result->idOs?>" />
                                        <label for="">Anexo</label>
                                        <input type="file" class="span12" name="userfile[]" multiple="multiple" size="20" />
                                    </div>
                                    <div class="span2">
                                        <label for=""> &nbsp;</label>
                                        <?php if($result->faturado == 0){ ?>
	                                        <button class="btn btn-success span12"><i class="icon-white icon-plus"></i> Anexar</button>
                                        <?php } ?>
                                    </div>
                                    </form>
                                </div>
                
                                <div class="span12" id="divAnexos" style="margin-left: 0">
                                    <?php 
                                    $cont = 1;
                                    $flag = 5;
                                    foreach ($anexos as $a) {

                                        if($a->thumb == null){
                                            $thumb = base_url().'assets/img/icon-file.png';
                                            $link = base_url().'assets/img/icon-file.png';
                                        }
                                        else{
                                            $thumb = base_url().'assets/anexos/thumbs/'.$a->thumb;
                                            $link = $a->url.$a->anexo;
                                        }

                                        if($cont == $flag){
                                           echo '<div style="margin-left: 0" class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                           $flag += 4;
                                        }
                                        else{
                                           echo '<div class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                        }
                                        $cont ++;
                                    } ?>
                                </div>

                            </div>
                        </div>
                


                    </div>

                </div>
        </div>

    </div>
</div>
</div>




 
<!-- Modal visualizar anexo -->
<div id="modal-anexo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Visualizar Anexo</h3>
  </div>
  <div class="modal-body">
    <div class="span12" id="div-visualizar-anexo" style="text-align: center">
        <div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
    <a href="" id-imagem="" class="btn btn-inverse" id="download">Download</a>
    <?php if($result->faturado == 0){ ?>
	    <a href="" link="" class="btn btn-danger" id="excluir-anexo">Excluir Anexo</a>
    <?php } ?>
  </div>
</div>





<!-- Modal Faturar-->
<div id="modal-faturar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form id="formFaturar" action="<?php echo current_url() ?>" method="post">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Faturar Os</h3>
</div>
<div class="modal-body">

    <div class="span12" style="margin-left: 0"> 
      <label for="descricao">Descrição</label>
      <input class="span12" id="descricao" type="text" name="descricao" value="Fatura da Os - #<?php echo $result->idOs; ?> "  />
    </div>  
    <div class="span12" style="margin-left: 0"> 
      <div class="span12" style="margin-left: 0"> 
        <label for="cliente">Pessoa*</label>
        <input class="span12" id="cliente" type="text" name="cliente" value="<?php echo $result->nomeCliente ?>" />
        <input type="hidden" name="clientes_id" id="clientes_id" value="<?php echo $result->clientes_id ?>">
        <input type="hidden" name="os_id" id="os_id" value="<?php echo $result->idOs; ?>">
        <input type="hidden" name="documentoOs" id="documentoOs" value="<?php echo $result->documentoOs; ?>">
        <input type="hidden" name="observacaoOs" id="observacaoOs" value="<?php echo $result->observacaoOs; ?>">
        <input type="hidden" name="setorOs" id="setorOs" value="<?php echo $result->setorOs; ?>">
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
         total_servico = $('#total-servico').val();
         valor = valor.replace(',', '' );
         total_servico = total_servico.replace(',', '' );
         total_servico = parseFloat(total_servico); 
         valor = parseFloat(valor);
         $('#valor').val(valor + total_servico);
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
              url: "<?php echo base_url();?>index.php/os/faturar",
              data: dados,
              dataType: 'json',
              success: function(data)
              {
                if(data.result == true){
                    
                    window.location.reload(true);
                }
                else{
                    alert('Ocorreu um erro ao faturar OS.');
                    $('#progress-fatura').hide();
                }
              }
              });

              return false;
          }
     });

     $("#produto").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteProduto",
            minLength: 3,
            select: function( event, ui ) {

                 $("#idProduto").val(ui.item.id);
                 $("#estoque").val(ui.item.estoque);
                 $("#preco").val(ui.item.preco.replace(".",","));
                 $("#preco").focus();
                 

            }
      });

      $("#servico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteServico",
            minLength: 3,
            select: function( event, ui ) {

                 $("#idServico").val(ui.item.id);
                 $("#precoServico").val(ui.item.preco.replace(".",","));
                 $("#precoServico").focus();
                 

            }
      });


      $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
            minLength: 3,
            select: function( event, ui ) {

                 $("#clientes_id").val(ui.item.id);


            }
      });

      $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteUsuario",
            minLength: 3,
            select: function( event, ui ) {

                 $("#usuarios_id").val(ui.item.id);


            }
      });




      $("#formOs").validate({
          rules:{
             cliente: {required:true},
             tecnico: {required:true},
             documentoOs: {required:true},
             dataInicial: {required:true},
             dataFinal: {required:true}
          },
          messages:{
             cliente: {required: 'Campo Requerido.'},
             tecnico: {required: 'Campo Requerido.'},
             documentoOs: {required: 'Campo Requerido.'},
             dataInicial: {required: 'Campo Requerido.'},
             dataFinal: {required: 'Campo Requerido.'}
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
                  url: "<?php echo base_url();?>index.php/os/adicionarProduto",
                  data: dados,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $( "#divProdutos" ).load("<?php echo current_url();?> #divProdutos" );
                        $("#quantidade").val('');
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

       $("#formServicos").validate({
          rules:{
             servico: {required:true}
          },
          messages:{
             servico: {required: 'Insira um serviço'}
          },
          submitHandler: function( form ){       
                 var dados = $( form ).serialize();
                 
                $("#divServicos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/os/adicionarServico",
                  data: dados,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $( "#divServicos" ).load("<?php echo current_url();?> #divServicos" );
                        $("#servico").val('').focus();
                    }
                    else{
                        alert('Ocorreu um erro ao adicionar serviço.');
                    }
                  }
                  });

                  return false;
                }

       });


        $("#formAnexos").validate({
         
          submitHandler: function( form ){       
                //var dados = $( form ).serialize();
                var dados = new FormData(form); 
                $("#form-anexos").hide('1000');
                $("#divAnexos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/os/anexar",
                  data: dados,
                  mimeType:"multipart/form-data",
                  contentType: false,
                  cache: false,
                  processData:false,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divAnexos" ).load("<?php echo current_url();?> #divAnexos" );
                        $("#userfile").val('');

                    }
                    else{
                        $("#divAnexos").html('<div class="alert fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> '+data.mensagem+'</div>');      
                    }
                  },
                  error : function() {
                      $("#divAnexos").html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> Ocorreu um erro. Verifique se você anexou o(s) arquivo(s).</div>');      
                  }

                  });

                  $("#form-anexos").show('1000');
                  return false;
                }

        });

       $(document).on('click', 'a', function(event) {
            var idProduto = $(this).attr('idAcao');
            var quantidade = $(this).attr('quantAcao');
            var produto = $(this).attr('prodAcao');
            var idOs = $(this).attr('idOs');
            if((idProduto % 1) == 0){
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/os/excluirProduto",
                  data: "idProduto="+idProduto+"&quantidade="+quantidade+"&produto="+produto+"&idOs="+idOs,
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



       $(document).on('click', 'span', function(event) {
            var idServico = $(this).attr('idAcao');
            var idOs = $(this).attr('idOs');
            if((idServico % 1) == 0){
                $("#divServicos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/os/excluirServico",
                  data: "idServico="+idServico+"&idOs="+idOs,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divServicos").load("<?php echo current_url();?> #divServicos" );

                    }
                    else{
                        alert('Ocorreu um erro ao excluir serviço.');
                    }
                  }
                  });
                  return false;
            }

       });


       $(document).on('click', '.anexo', function(event) {
           event.preventDefault();
           var link = $(this).attr('link');
           var id = $(this).attr('imagem');
           var url = '<?php echo base_url(); ?>os/excluirAnexo/';
           $("#div-visualizar-anexo").html('<img src="'+link+'" alt="">');
           $("#excluir-anexo").attr('link', url+id);

           $("#download").attr('href', "<?php echo base_url(); ?>index.php/os/downloadanexo/"+id);

       });

       $(document).on('click', '#excluir-anexo', function(event) {
           event.preventDefault();

           var link = $(this).attr('link'); 
           $('#modal-anexo').modal('hide');
           $("#divAnexos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");

           $.ajax({
                  type: "POST",
                  url: link,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divAnexos" ).load("<?php echo current_url();?> #divAnexos" );
                    }
                    else{
                        alert(data.mensagem);
                    }
                  }
            });
       });



       $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });




});

</script>




