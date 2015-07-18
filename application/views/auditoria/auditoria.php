<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Auditoria</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Operação</th>
                        <th>Usuario</th>
                        <th>Observação</th>
                        <th>Query</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhuma auditoria Cadastrada</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
	

?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Auditoria</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>#</th>
            <th>Data</th>
            <th>Operação</th>
            <th>Usuario</th>
            <th>Observação</th>
            <th>Query</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->idAuditoria.'</td>';
            echo '<td>'.$r->data_hora.'</td>';
            echo '<td>'.$r->operacao.'</td>';
            echo '<td>'.$r->usuario.'</td>';
            echo '<td>'.$r->observacao.'</td>';
            echo '<td>'.$r->query.'</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>
<?php echo $this->pagination->create_links();}?>

