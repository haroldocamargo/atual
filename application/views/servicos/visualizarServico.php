<div class="accordion" id="collapse-group">
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Dados do Serviço</h5>
                </a>
            </div>
        </div>
        <div class="collapse in accordion-body">
            <div class="widget-content">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="text-align: right; width: 30%"><strong>Nome</strong></td>
                            <td><?php echo $result->nome ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right; width: 30%"><strong>Descrição</strong></td>
                            <td><?php echo $result->descricao ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Grupo</strong></td>
                            <td><?php echo $result->grupo ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>SubGrupo</strong></td>
                            <td><?php echo $result->subgrupo ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Categoria</strong></td>
                            <td><?php echo $result->categoria ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Classe</strong></td>
                            <td><?php echo $result->classe ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Tipo</strong></td>
                            <td><?php echo $result->tipo ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Preço</strong></td>
                            <td><?php echo number_format($result->preco, 2, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Observação</strong></td>
                            <td><?php echo $result->observacaoServico ?></td>
                        </tr>
                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

