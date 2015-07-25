  <head>
    <title>Atual</title>
    <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/blue.css" class="skin-color" />
    <script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.10.2.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
 
  <body style="background-color: transparent">



      <div class="container-fluid">
    
          <div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                      <div class="widget-title">
                          <h4 style="text-align: center">Relatório Estoque</h4>
                      </div>
                      <div class="widget-content nopadding">

                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th style="font-size: 1.2em; padding: 5px;">Data</th>
                              <th style="font-size: 1.2em; padding: 5px;">Tipo</th>
                              <th style="font-size: 1.2em; padding: 5px;">Produto</th>
                              <th style="font-size: 1.2em; padding: 5px;">Qtd</th>
                              <th style="font-size: 1.2em; padding: 5px;">Valor</th>
                              <th style="font-size: 1.2em; padding: 15px;">SubTotal</th>
                              <th style="font-size: 1.2em; padding: 5px;">Os</th>
                              <th style="font-size: 1.2em; padding: 5px;">Compra</th>
                              <th style="font-size: 1.2em; padding: 5px;">Venda</th>
                              <th style="font-size: 1.2em; padding: 5px;">Documento</th>
                              <th style="font-size: 1.2em; padding: 5px;">Serie</th>
                              <th style="font-size: 1.2em; padding: 5px;">Observação</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          $totalEntrada = 0;
                          $totalSaida = 0;
                          $saldo = 0;
                          foreach ($estoque as $l) {
                              $data = date('d/m/Y', strtotime($l->data));
                              if($l->tipo == 'entrada'){ $totalEntrada += $l->subTotal;} else{ $totalSaida += $l->SubTotal;}
                              echo '<tr>';
                              echo '<td>' . $data. '</td>';
                              echo '<td>' . $l->tipo . '</td>';
                              echo '<td>' . $l->descricao . '</td>';
                              echo '<td>' . $l->quantidade . '</td>';
                              echo '<td>' . $l->valor . '</td>';
                              echo '<td>' . $l->subTotal . '</td>';
                              echo '<td>' . $l->os_id . '</td>';
                              echo '<td>' . $l->compras_id . '</td>';
                              echo '<td>' . $l->vendas_id . '</td>';
                              echo '<td>' . $l->documentoEstoque . '</td>';
                              echo '<td>' . $l->serie . '</td>';
                              echo '<td>' . $l->observacaoEstoque . '</td>';
                              echo '</tr>';
                          }
                          ?>
                      </tbody>
                       <tfoot>
                          <tr>
                            <td colspan="5" style="text-align: right; color: green"> <strong>Total Entradas:</strong></td>
                            <td colspan="1" style="text-align: left; color: green"><strong><?php echo number_format($totalEntrada,2,',','.') ?></strong></td>
				    		<td colspan="9" style="text-align: right"> <strong> </strong></td>
                          </tr>
                          <tr>
                            <td colspan="5" style="text-align: right; color: red"> <strong>Total Saídas:</strong></td>
                            <td colspan="1" style="text-align: left; color: red"><strong><?php echo number_format($totalSaida,2,',','.') ?></strong></td>
				    		<td colspan="9" style="text-align: right"> <strong> </strong></td>
                          </tr>
                          <tr>
                            <td colspan="5" style="text-align: right"> <strong>Saldo:</strong></td>
                            <td colspan="1" style="text-align: left;"><strong><?php echo number_format($totalEntrada - $totalSaida,2,',','.') ?></strong></td>
				    		<td colspan="9" style="text-align: right"> <strong> </strong></td>
                          </tr>
                        </tfoot>
                  </table>
                  
                  </div>
                   
              </div>
                  <h5 style="text-align: right">Data do Relatório: <?php echo date('d/m/Y');?></h5>

          </div>
     


      </div>
</div>




            <!-- Arquivos js-->

            <script src="<?php echo base_url();?>js/excanvas.min.js"></script>
            <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
            <script src="<?php echo base_url();?>js/sosmc.js"></script>
            <script src="<?php echo base_url();?>js/dashboard.js"></script>
  </body>
</html>








