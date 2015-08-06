
<!DOCTYPE html>
<html lang="en">
<head>
<title>Atual ERP</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" /> 
<link rel="shortcut icon" href="<?php echo base_url()?>assets/img/sistema.png" />

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>

</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="">Atual ERP - Sistema Administrativo</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
   
    <li class=""><a title="" href="<?php echo base_url();?>index.php/atual/minhaConta"><i class="icon icon-star"></i> <span class="text">Minha Conta</span></a></li>
    <li class=""><a title="" href="<?php echo base_url();?>index.php/atual/sair"><i class="icon icon-share-alt"></i> <span class="text">Sair do Sistema</span></a></li>
  </ul>
</div>

<!--start-top-serch-->
<div id="search">
  <form action="<?php echo base_url()?>index.php/atual/pesquisar">
    <input type="text" name="termo" placeholder="Pesquisar..."/>
    <button type="submit"  class="tip-bottom" title="Pesquisar"><i class="icon-search icon-white"></i></button>
    
  </form>
</div>
<!--close-top-serch--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
  <ul>
    <li class="<?php if(isset($menuPainel)){echo 'active';};?>"><a href="<?php echo base_url()?>"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){ ?>
        <li class="<?php if(isset($menuClientes)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/clientes"><i class="icon icon-group"></i> <span>Pessoas</span></a></li>
    <?php } ?>
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){ ?>
        <li class="<?php if(isset($menuProdutos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/produtos"><i class="icon icon-barcode"></i> <span>Produtos</span></a></li>
    <?php } ?>
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){ ?>
        <li class="<?php if(isset($menuServicos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/servicos"><i class="icon icon-wrench"></i> <span>Serviços</span></a></li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCompra')){ ?>
        <li class="<?php if(isset($menuCompras)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/compras"><i class="icon icon-edit"></i> <span>Compras</span></a></li>
    <?php } ?>
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){ ?>
        <li class="<?php if(isset($menuOs)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/os"><i class="icon icon-tags"></i> <span>Ordens de Serviço</span></a></li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){ ?>
        <li class="<?php if(isset($menuVendas)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/vendas"><i class="icon icon-shopping-cart"></i> <span>Vendas</span></a></li>
    <?php } ?>
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vEstoque')){ ?>
        <li class="submenu <?php if(isset($menuEstoque)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-folder-close"></i> <span>Estoque</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <li><a href="<?php echo base_url()?>index.php/estoque">Lançamentos</a></li>
          </ul>
        </li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){ ?>
        <li class="submenu <?php if(isset($menuFinanceiro)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-money"></i> <span>Financeiro</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <li><a href="<?php echo base_url()?>index.php/financeiro/lancamentos">Lançamentos</a></li>
          </ul>
        </li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCliente') || $this->permission->checkPermission($this->session->userdata('permissao'),'rProduto') || $this->permission->checkPermission($this->session->userdata('permissao'),'rServico') || $this->permission->checkPermission($this->session->userdata('permissao'),'rOs') || $this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro') || $this->permission->checkPermission($this->session->userdata('permissao'),'rVenda') || $this->permission->checkPermission($this->session->userdata('permissao'),'rCompra')){ ?>
        <li class="submenu <?php if(isset($menuRelatorios)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-list-alt"></i> <span>Relatórios</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/clientes">Pessoas</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/produtos">Produtos</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/servicos">Serviços</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCompra')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/compras">Compras</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){ ?>
                 <li><a href="<?php echo base_url()?>index.php/relatorios/os">Ordens de Serviço</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/vendas">Vendas</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rEstoque')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/estoque">Estoque</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/financeiro">Financeiro</a></li>
            <?php } ?>
          </ul>
        </li>

    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')  || $this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente') || $this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao') || $this->permission->checkPermission($this->session->userdata('permissao'),'cBackup') || $this->permission->checkPermission($this->session->userdata('permissao'),'vAuditoria')){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-cog"></i> <span>Configurações</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){ ?>
                <li><a href="<?php echo base_url()?>index.php/usuarios">Usuários</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){ ?>
                <li><a href="<?php echo base_url()?>index.php/atual/emitente">Emitente</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao')){ ?>
                <li><a href="<?php echo base_url()?>index.php/permissoes">Permissões</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vAuditoria')){ ?>
                <li><a href="<?php echo base_url()?>index.php/auditoria">Auditoria</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
                <li><a href="<?php echo base_url()?>index.php/atual/backup">Backup</a></li>
            <?php } ?>
 
          </ul>
        </li>
    <?php } ?>
    
    
  </ul>
</div>
<div id="content">
  <div id="content-header">
<!--    <div id="breadcrumb"> <a href="<?php echo base_url()?>" title="Dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <?php if($this->uri->segment(1) != null){?><a href="<?php echo base_url().'index.php/'.$this->uri->segment(1)?>" class="tip-bottom" title="<?php echo ucfirst($this->uri->segment(1));?>"><?php echo ucfirst($this->uri->segment(1));?></a> <?php if($this->uri->segment(2) != null){?><a href="<?php echo base_url().'index.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2) ?>" class="current tip-bottom" title="<?php echo ucfirst($this->uri->segment(2)); ?>"><?php echo ucfirst($this->uri->segment(2));} ?></a> <?php }?></div>-->
	<div id="breadcrumb"> <a href="<?php echo base_url()?>" title="Dashboard" class="tip-bottom"><i class="icon-home"></i>Dashboard</a></div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
          <?php if($this->session->flashdata('error') != null){?>
                            <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('error');?>
                           </div>
                      <?php }?>

                      <?php if($this->session->flashdata('success') != null){?>
                            <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('success');?>
                           </div>
                      <?php }?>
                          
                      <?php if(isset($view)){echo $this->load->view($view);}?>


      </div>
    </div>
  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12">&copy; 2014 | Todos os direitos reservados para <a href="http://www.atualinformaticataubate.com.br">Atual Informática Taubaté Ltda</a></div>
</div>
<!--end-Footer-part-->


<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/matrix.js"></script> 


</body>
</html>







