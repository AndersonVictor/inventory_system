<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user['name']);
            else echo "FERRESTOCK GREYS";?>
    </title>
	
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" /> -->
    <link rel="stylesheet" href="libs/css/main.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      .btn-secondary {
        background-color: #fff;
        border:none;
        background-color: transparent; 
        border: none; 
        margin-right: 100px;   
        margin-top: 5px;
        outline: none;
        
      }.btn-secondary:hover, .btn-secondary:focus, .btn-secondary.focus, .btn-secondary:active, .btn-secondary.active{
        background-color: #fff;
        border-color: #3d8fd8
        
      }
      .notificacion{
            margin: 20px;
         }       
      .numero {
            display: inline-block;
            width: 20px;
            height: 20px; 
            background-color: red;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
        }  
      .list-desp{
        position: absolute;
        background-color: #f5f5f5; 
        list-style: none;
        float:left;
        padding: 10px;
        border-radius: 20px; 
        color: gray;
        border-width: 10px;
        border-color: red;

      }.general{
        border-width: 20px;
        border-color: #000 !important;  
              
      }ul .list-desp{
        border-width: 20px;
        border-color: #000 !important;          
      }

    </style>
  </head>
  <body>
  <?php  if ($session->isUserLoggedIn(true)): ?>
    <header id="header">
      <div class="logo pull-left">
        <button style="background-color: #415a77; border: none; display: none; outline: none;" class="hamburguer"> <i class="glyphicon glyphicon-menu-hamburger" style="color: #fff;"></i></button> FERRESTOCK GREYS </div>
      <div class="header-content">
      <div class="header-date pull-left">
      <?php  date_default_timezone_set('America/Lima');?>
        <strong><?php echo date("d/m/Y  g:i a");?></strong>
      </div>
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="uploads/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-inline">
              <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                  <a href="profile.php?id=<?php echo (int)$user['id'];?>">
                      <i class="glyphicon glyphicon-user"></i>
                      Perfil
                  </a>
              </li>
             <li>
                 <a href="edit_account.php" title="edit account">
                     <i class="glyphicon glyphicon-cog"></i>
                     Configuración
                 </a>
             </li>
             <li class="last">
                 <a href="logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Salir
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
     
  <div class="pull-right clearfix" id="notificacion" onclick="mostrarProductosBajos()">
        <?php
          require_once('includes/load.php');
          $productosConStockBajo = productosStockBajo();        
        ?>       
        <button class="btn btn-secondary"><img src="./libs/images/figure.png" width="32" height="32" alt="">
            <span class="numero">
              <?php echo count($productosConStockBajo); ?>  
            </span> 
        </button>
        <div class="general">
          <ul id="lista-stock-bajo" style="display: none;" class="list-desp">
              <?php foreach ($productosConStockBajo as $producto) : ?>
                  <li>
                      <a href="edit_product.php?id=<?php echo $producto['id']; ?>">
                          <?php echo $producto['name']; ?> - Stock: <?php echo $producto['quantity']; ?>
                      </a>
                  </li>
              <?php endforeach; ?>
          </ul>       
        </div>
      </div>
      <script>
          // Función para mostrar la lista de productos con stock bajo
          function mostrarProductosBajos() {
              var listaStockBajo = document.getElementById('lista-stock-bajo');
              var cantidadStockBajo = document.getElementById('contador-stock-bajo');
              
              if (listaStockBajo.style.display === 'none') {
                  // Mostrar la lista de productos
                  listaStockBajo.style.display = 'block';
                  // Ocultar el contador de notificaciones
                  cantidadStockBajo.style.display = 'none';
              } else {
                  // Ocultar la lista de productos
                  listaStockBajo.style.display = 'none';
                  // Mostrar el contador de notificaciones nuevamente
                  cantidadStockBajo.style.display = 'block';
              }
          }
      </script>


    </header>
    <div class="sidebar">
      <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
      <?php include_once('admin_menu.php');?>

      <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special user -->
      <?php include_once('special_menu.php');?>

      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
      <?php include_once('user_menu.php');?>

      <?php endif;?>

   </div>
      
   

<?php endif;?>


<div class="page">
  <div class="container-fluid">
