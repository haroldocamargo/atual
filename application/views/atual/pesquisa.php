<div class="span12" style="margin-left: 0; margin-top: 0">
    <div class="span12" style="margin-left: 0">
        <form action="<?php echo current_url()?>">
        <div class="span10" style="margin-left: 0">
            <input type="text" class="span12" name="termo" placeholder="Digite o termo a pesquisar" />
        </div>
        <div class="span2">
            <button class="span12 btn"><i class=" icon-search"></i> Pesquisar</button>
        </div>
        </form>
    </div>
    <div class="span12" style="margin-left: 0; margin-top: 0">

    <!--Pessoas-->
    <div class="span6" style="margin-left: 0; margin-top: 0">
        <div class="widget-box" style="min-height: 200px">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Pessoas</h5>

            </div>

            <div class="widget-content nopadding">


                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>CPF/CNPJ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($clientes == null){
                            echo '<tr><td colspan="4">Nenhuma pessoa foi encontrada.</td></tr>';
                        }
                        foreach ($clientes as $r) {
                            echo '<tr>';
                            echo '<td>' . $r->idClientes . '</td>';
                            echo '<td>' . $r->nomeCliente . '</td>';
                            echo '<td>' . $r->documento . '</td>';
                            echo '<td>';

                            if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                            } 
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
                                echo '<a href="' . base_url() . 'index.php/clientes/editar/' . $r->idClientes . '" class="btn btn-info tip-top" title="Editar Pessoa"><i class="icon-pencil icon-white"></i></a>'; 
                            } 
                            
                            
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    
    <!--Produtos-->
    <div class="span6">
        <div class="widget-box" style="min-height: 200px">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-barcode"></i>
                </span>
                <h5>Produtos</h5>

            </div>

            <div class="widget-content nopadding">

               
                <table class="table table-bordered ">
                    <thead>
                        <tr style="backgroud-color: #2D335B">
                            <th>#</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($produtos == null){
                            echo '<tr><td colspan="4">Nenhum produto foi encontrado.</td></tr>';
                        }
                        foreach ($produtos as $r) {
                            echo '<tr>';
                            echo '<td>' . $r->idProdutos . '</td>';
                            echo '<td>' . $r->descricao . '</td>';
                            echo '<td>' . $r->precoVenda . '</td>';

                            echo '<td>';
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/produtos/visualizar/' . $r->idProdutos . '" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                            }
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'eProduto')){
                                echo '<a href="' . base_url() . 'index.php/produtos/editar/' . $r->idProdutos . '" class="btn btn-info tip-top" title="Editar Produto"><i class="icon-pencil icon-white"></i></a>'; 
                            } 
                            
                            echo '</td>';
                            echo '</tr>';
                        } ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!--Serviços-->
    <div class="span6" style="margin-left: 0">
        <div class="widget-box" style="min-height: 200px">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-wrench"></i>
                </span>
                <h5>Serviços</h5>

            </div>

            <div class="widget-content nopadding">


                <table class="table table-bordered ">
                    <thead>
                        <tr style="backgroud-color: #2D335B">
                            <th>#</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($servicos == null){
                            echo '<tr><td colspan="4">Nenhum serviço foi encontrado.</td></tr>';
                        }
                        foreach ($servicos as $r) {
                            echo '<tr>';
                            echo '<td>' . $r->idServicos . '</td>';
                            echo '<td>' . $r->nome . '</td>';
                            echo '<td>' . $r->preco . '</td>';
                            echo '<td>';
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'eServico')){
                                echo '<a href="' . base_url() . 'index.php/servicos/editar/' . $r->idServicos . '" class="btn btn-info tip-top" title="Editar Serviço"><i class="icon-pencil icon-white"></i></a>'; 
                            } 
                                
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!--Compras-->
    <div class="span6">
        <div class="widget-box" style="min-height: 200px">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-edit"></i>
                </span>
                <h5>Compras</h5>
            </div>

            <div class="widget-content nopadding">

               
                <table class="table table-bordered ">
                    <thead>
                        <tr style="backgroud-color: #2D335B">
                            <th>#</th>
                            <th>Data</th>
                            <th>Pessoa</th>
                            <th>Sub Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($compras == null){
                            echo '<tr><td colspan="4">Nenhuma compra foi encontrada.</td></tr>';
                        }
                        foreach ($compras as $r) {
                            $data = date(('d/m/Y'), strtotime($r->dataCompra));
                            echo '<tr>';
                            echo '<td>' . $r->idCompras . '</td>';
                            echo '<td>' . $data. '</td>';
                            echo '<td>' . $r->nomeCliente . '</td>';
                            echo '<td>' . $r->valorTotal . '</td>';
                            echo '<td>';
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'vCompras')){
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/compras/visualizar/' . $r->idCompras . '" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                            } 
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'eCompras')){
                                echo '<a href="' . base_url() . 'index.php/compras/editar/' . $r->idCompras . '" class="btn btn-info tip-top" title="Editar Compra"><i class="icon-pencil icon-white"></i></a>'; 
                            }  
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Ordens de Serviço-->
    <div class="span6" style="margin-left: 0; margin-top: 0">
         <div class="widget-box" style="min-height: 200px">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Ordens de Serviço</h5>

            </div>

            <div class="widget-content nopadding">


                <table class="table table-bordered ">
                    <thead>
                        <tr style="backgroud-color: #2D335B">
                            <th>#</th>
                            <th>Data Inicial</th>
                            <th>Defeito</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($os == null){
                            echo '<tr><td colspan="4">Nenhuma os foi encontrada.</td></tr>';
                        }
                        foreach ($os as $r) {
                            $dataInicial = date(('d/m/Y'), strtotime($r->dataInicial));
                            $dataFinal = date(('d/m/Y'), strtotime($r->dataFinal));
                            echo '<tr>';
                            echo '<td>' . $r->idOs . '</td>';
                            echo '<td>' . $dataInicial . '</td>';
                            echo '<td>' . $r->defeito . '</td>';

                            echo '<td>';
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                            } 
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
                                echo '<a href="' . base_url() . 'index.php/os/editar/' . $r->idOs . '" class="btn btn-info tip-top" title="Editar OS"><i class="icon-pencil icon-white"></i></a>'; 
                            }  
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Vendas-->
    <div class="span6">
         <div class="widget-box" style="min-height: 200px">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-shopping-cart"></i>
                </span>
                <h5>Vendas</h5>

            </div>

            <div class="widget-content nopadding">


                <table class="table table-bordered ">
                    <thead>
                        <tr style="backgroud-color: #2D335B">
                            <th>#</th>
                            <th>Data</th>
                            <th>Pessoa</th>
                            <th>Sub Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($vendas == null){
                            echo '<tr><td colspan="4">Nenhuma venda foi encontrada.</td></tr>';
                        }
                        foreach ($vendas as $r) {
                            $data = date(('d/m/Y'), strtotime($r->dataVenda));
                            echo '<tr>';
                            echo '<td>' . $r->idVendas . '</td>';
                            echo '<td>' . $data. '</td>';
                            echo '<td>' . $r->nomeCliente . '</td>';
                            echo '<td>' . $r->valorTotal . '</td>';
                            echo '<td>';
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'vVendas')){
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/visualizar/' . $r->idVendas . '" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                            } 
                            if($this->permission->checkPermission($this->session->userdata('permissao'),'eVendas')){
                                echo '<a href="' . base_url() . 'index.php/vendas/editar/' . $r->idVenda . '" class="btn btn-info tip-top" title="Editar Compra"><i class="icon-pencil icon-white"></i></a>'; 
                            }  
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

