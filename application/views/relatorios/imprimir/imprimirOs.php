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
                          <h4 style="text-align: center">Ordens de Serviço</h4>
                      </div>
                      <div class="widget-content nopadding">

		                  <table class="table table-bordered">
		                      <thead>
		                          <tr>
		                              <th style="font-size: 1.0em; padding: 1px;">Os</th>
		                              <th style="font-size: 1.0em; padding: 1px;">Pessoa</th>
		                              <th style="font-size: 1.0em; padding: 1px;">Técnico</th>
		                              <th style="font-size: 1.0em; padding: 1px;">Status</th>
		                              <th style="font-size: 1.0em; padding: 1px;">Data</th>
		                              <th style="font-size: 1.0em; padding: 1px;">Documento</th>
		                              <th style="font-size: 1.0em; padding: 1px;">Serviço</th>
		                              <th style="font-size: 1.0em; padding: 1px;">Produto</th>
		                              <th style="font-size: 1.0em; padding: 1px;">Total</th>
		                          </tr>
		                      </thead>
		                      <tbody>
		                          <?php
		                          $totalServicos = 0;
		                          $totalValor = 0;
		                          foreach ($os as $c) {
			                          $totalServicos = $totalServicos + $c->valorServicos;
		    	                      $totalValor = $totalValor + $c->valorTotal;
		                              echo '<tr>';
		                              echo '<td>' . $c->idOs . '</td>';
		                              echo '<td>' . $c->nomeCliente . '</td>';
		                              echo '<td>' . $c->nomeUsuario . '</td>';
		                              echo '<td>' . $c->status . '</td>';
		                              echo '<td>' . date('d/m/Y',  strtotime($c->dataInicial)) . '</td>';
		                              echo '<td>' . $c->documentoOs. '</td>';
		                              echo '<td>'.number_format($c->valorServicos,2,',','.').'</td>';
		                              echo '<td>'.number_format($c->valorTotal - $c->valorServicos,2,',','.').'</td>';
		                              echo '<td>'.number_format($c->valorTotal,2,',','.').'</td>';
		                              echo '</tr>';
		                          }
		                          ?>
		                      </tbody>

							 <tfoot>
		                          <?php
		                              echo '<tr>';
		                              echo '<td>' . '</td>';
		                              echo '<td>' . '</td>';
		                              echo '<td>' . '</td>';
		                              echo '<td>' . '</td>';
		                              echo '<td>' . '</td>';
		                              echo '<td>' . 'Totais'. '</td>';
		                              echo '<td>'.number_format($totalServicos,2,',','.').'</td>';
		                              echo '<td>'.number_format($totalValor - $totalServicos,2,',','.').'</td>';
		                              echo '<td>'.number_format($totalValor,2,',','.').'</td>';
		                              echo '</tr>';
		                          ?>
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
            <script src="<?php echo base_url();?>js/jquery.flot.min.js"></script>
            <script src="<?php echo base_url();?>js/jquery.flot.resize.min.js"></script>
            <script src="<?php echo base_url();?>js/jquery.peity.min.js"></script>
            <script src="<?php echo base_url();?>js/fullcalendar.min.js"></script>
            <script src="<?php echo base_url();?>js/sosmc.js"></script>
            <script src="<?php echo base_url();?>js/dashboard.js"></script>
  </body>
</html>







