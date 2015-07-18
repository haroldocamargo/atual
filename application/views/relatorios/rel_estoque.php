<div class="row-fluid" style="margin-top: 0">
    <div class="span4">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-list-alt"></i>
                </span>
                <h5>Relatórios Rápidos</h5>
            </div>
            <div class="widget-content">
                <ul class="site-stats">
                    <li><a href="<?php echo base_url()?>index.php/relatorios/estoqueRapid"><i class="icon-user"></i> <small>Relatório do mês</small></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="span8">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-list-alt"></i>
                </span>
                <h5>Relatórios Customizáveis</h5>
            </div>
            <div class="widget-content">
                <form action="<?php echo base_url()?>index.php/relatorios/estoqueCustom" method="get">
                <div class="span12 well">
                    
                    <div class="span6">
                        <label for="">Vencimento de:</label>
                        <input type="date" name="dataInicial" class="span12" />
                    </div>
                    <div class="span6">
                        <label for="">até:</label>
                        <input type="date" name="dataFinal" class="span12" />
                    </div>
                    
                </div>

                <div class="span12 well" style="margin-left: 0">
                    <div class="span6">
                        <label for="">Tipo:</label>
                        <select name="tipo" class="span12">
                            <option value="todos">Todos</option>
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                        </select>
                    </div>
                </div>
                <div class="span12" style="margin-left: 0; text-align: center">
                    <input type="reset" class="btn" value="Limpar" />
                    <button class="btn btn-inverse"><i class="icon-print icon-white"></i> Imprimir</button>
                </div>
                </form>
                &nbsp
            </div>
        </div>
    </div>
</div>