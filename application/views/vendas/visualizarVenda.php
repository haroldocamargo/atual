<?php $totalProdutos = 0;?>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Venda</h5>
                <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/vendas/editar/'.$result->idVendas.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                </div>
            </div>
            <div class="widget-content" id="printOs">
                <div class="invoice-content">
                    <div class="invoice-head">
                        <table class="table">
                            <tbody>

                                <?php if($emitente == null) {?>
                                            
                                <tr>
                                    <td colspan="3" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?php echo base_url(); ?>index.php/atual/emitente">Configurar</a><<<</td>
                                </tr>
                                <?php } else {?>

                                <tr>
                                    <td style="width: 10%"><img src="<?php echo base_url()?>assets/img/logocliente.png"></td>
                                    <td> <span style="font-size: 12px; "> <?php echo $emitente[0]->nome; ?></span> </br><span style="font-size: 10px; "><?php echo $emitente[0]->cnpj; ?> </br> <?php echo $emitente[0]->rua.', nº:'.$emitente[0]->numero.', '.$emitente[0]->bairro.' - '.$emitente[0]->cidade.' - '.$emitente[0]->uf; ?> </span> </br> <span style="font-size: 10px; "> E-mail: <?php echo $emitente[0]->email.' - Fone: '.$emitente[0]->telefone; ?></span></td>
                                    <td style="width: 15%; text-align: center; font-size: 10px; ">#Venda: <span  style="font-size: 10px; "><?php echo $result->idVendas?></span></br> <span style="font-size: 10px; ">Emissão: <?php echo date('d/m/Y');?></span></td>
                                    <td style="width: 15%; text-align: center; font-size: 10px; ">Documento: <span  style="font-size: 10px; "><?php echo $result->documentoVenda?></span></br><span style="font-size: 10px; ">Data: <?php echo date('d/m/Y h:m:s', strtotime($result->dataDocumentoVenda));?></span></br><span style="font-size: 10px; ">Setor: <?php echo $result->setorVenda;?></span></td>
                                </tr>

                                <?php } ?>
                            </tbody>
                        </table>
   
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span style="font-size: 12px;">Pessoa</span><br/>
                                                <span style="font-size: 10px;"><?php echo $result->nomeCliente?></span><br/>
                                                <span style="font-size: 10px;"><?php echo $result->rua?>, <?php echo $result->numero?>, <?php echo $result->bairro?></span><br/>
                                                <span style="font-size: 10px;"><?php echo $result->cidade?> - <?php echo $result->estado?></span>
                                            </li>
                                        </ul>
                                    </td>
                                    <td style="width: 50%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span style="font-size: 12px;">Vendedor</span><br/>
                                                <span style="font-size: 10px;"><?php echo $result->nome?></span> <br/>
                                                <span style="font-size: 10px;">Telefone: <?php echo $result->telefone?></span><br/>
                                                <span style="font-size: 10px;">Email: <?php echo $result->email?></span>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
      
                    </div>

                    <?php if($result->observacaoVenda != null){?>
			                                            <li>
	                    <span style="font-size: 12px;">Observações: </span><span style="font-size: 10px;"><?php echo $result->observacaoVenda?></span>
			                                            </li>
                    <?php }?>

                    <div style="margin-top: 0; padding-top: 0">


                        <?php if($produtos != null){?>
              
                        <table style="font-size: 10px; " class="table table-bordered table-condensed" id="tblProdutos">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Valor</th>
                                            <th>Quantidade</th>
                                            <th>Série</th>
                                            <th>Observação</th>
                                            <th>Sub-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        foreach ($produtos as $p) {

                                            $totalProdutos = $totalProdutos + $p->subTotal;
                                            echo '<tr>';
                                            echo '<td>'.$p->descricao.'</td>';
                                            echo '<td>'.number_format($p->valor,2,',','.').'</td>';
                                            echo '<td>'.$p->quantidade.'</td>';
                                            echo '<td>'.$p->serie.'</td>';
                                            echo '<td>'.$p->observacaoItem.'</td>';
                                            echo '<td>'.number_format($p->subTotal,2,',','.').'</td>';
                                            echo '</tr>';
                                        }?>

                                        <tr>
                                            <td colspan="5" style="text-align: right"><strong>Total:</strong></td>
                                            <td><strong><?php echo number_format($totalProdutos,2,',','.');?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                               <?php }?>
                        
                
                        <hr />
                    
                        <h4  style="text-align: right; font-size: 12px; ">Valor Total: <?php echo number_format($totalProdutos,2,',','.');?></h4>

                    </div>
              
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#imprimir").click(function(){         
            PrintElem('#printOs');
        })

        function PrintElem(elem)
        {
            Popup($(elem).html());
        }

        function Popup(data)
        {
            var mywindow = window.open('', 'Atual', 'height=600,width=800');
            mywindow.document.write('<html><head><title>Atual ERP - Sistema Administrativo</title>');
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' />");
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/matrix-style.css' />");
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/matrix-media.css' />");


            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');

            mywindow.print();
            mywindow.close();

            return true;
        }

    });
</script>