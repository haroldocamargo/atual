<div class="accordion" id="collapse-group">
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Dados do Lançamento</h5>
                </a>
            </div>
        </div>
        <div class="collapse in accordion-body">
            <div class="widget-content">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="text-align: right; width: 30%"><strong>Tipo</strong></td>
                            <td><?php echo $result->tipo ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Descrição</strong></td>
                            <td><?php echo $result->descricao ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Pessoa</strong></td>
                            <td><?php echo $result->cliente_fornecedor ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Grupo</strong></td>
                            <td><?php echo $result->grupo ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Setor</strong></td>
                            <td><?php echo $result->setor ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Documento</strong></td>
                            <td><?php echo $result->documento ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Valor</strong></td>
                            <td><?php echo number_format($result->valor, 2, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Vencimento</strong></td>
                            <td><?php echo date(('d/m/Y'),strtotime($result->data_vencimento)) ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Observação</strong></td>
                            <td><?php echo $result->observacao ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Foi Pago?</strong></td>
                            <?php
                              $baixado = $result->baixado;
                              if ($baixado == 1) {
                              	$mostraBaixado = 'SIM';} 
							  else{
                              	$mostraBaixado = 'NÃO';} 
                            ?>
                            <td><?php echo $mostraBaixado; ?></td>
                        </tr>
                        
                        <?php
                          $baixado = $result->baixado;
                          if ($baixado == 1) { ?>
	                        <tr>
	                            <td style="text-align: right"><strong>Data Pagamento</strong></td>
	                            <td><?php echo date(('d/m/Y'),strtotime($result->data_pagamento)) ?></td>
	                        </tr>
	                        <tr>
	                            <td style="text-align: right"><strong>Forma Pagamento</strong></td>
	                            <td><?php echo $result->forma_pgto ?></td>
	                        </tr>
                        <?php } ?>
                  
                        <tr>
                            <td style="text-align: right"><strong>Compra</strong></td>
                            <td><?php echo $result->compras_id; ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>OS</strong></td>
                            <td><?php echo $result->os_id; ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Venda</strong></td>
                            <td><?php echo $result->vendas_id ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

