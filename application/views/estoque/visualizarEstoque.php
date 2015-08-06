<div class="accordion" id="collapse-group">
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Dados do Estoque</h5>
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
                            <td style="text-align: right"><strong>Setor</strong></td>
                            <td><?php echo $result->setorEstoque ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Produto</strong></td>
                            <td><?php echo $result->descricao ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Documento</strong></td>
                            <td><?php echo $result->documentoEstoque ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Serie</strong></td>
                            <td><?php echo $result->serie ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Data</strong></td>
                            <td><?php echo date(('d/m/Y'),strtotime($result->data)) ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Qtd</strong></td>
                            <td><?php echo number_format($result->quantidade, 2, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Valor</strong></td>
                            <td><?php echo number_format($result->valor, 2, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>SubTotal</strong></td>
                            <td><?php echo number_format($result->subTotal, 2, ',', '.'); ?></td>
                        </tr>
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
                        <tr>
                            <td style="text-align: right"><strong>Observação</strong></td>
                            <td><?php echo $result->observacaoEstoque ?></td>
                        </tr>
                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

