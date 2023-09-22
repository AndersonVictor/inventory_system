<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php include_once('layouts/header.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Tu Página de Inicio de Sesión</title>
    <style>
        body {
            margin: 0; /* Evita el margen predeterminado */
            padding: 0; /* Evita el relleno predeterminado */
            background-image: url('../Inventario 3/libs/images/background.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Estilos para el formulario */
        .login-page {
            border:none !important;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
        }

        .login-page h1, .login-page p {
            text-align: center;
        }

        /* Estilos para los iconos */
        .form-group {
            position: relative;
        }

        .form-group .icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 10px;
        }

        .form-group .icon i {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
<div class="title-page">
        <h1>SISTEMA DE INVENTARIO</h1>
        <p>FERRESTOCK GREYS</p>
        <center>
        <img src="../Inventario 3/libs/images/icon.png" alt="" style="margin: auto;">
        </center>
        </div>
    <div class="login-page">
        
        <?php echo display_msg($msg); ?>
        <form method="post" action="auth.php" class="clearfix">
            <div class="form-group">
                <span class="icon"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" name="username" placeholder="USUARIO">
            </div>
            <div class="form-group">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="CONTRASEÑA">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info pull-right">LOGIN</button>
            </div>
            <span style="float:right; font-size:14px; font-weight: 700; color: #0000 !important;"><a href="">¿Contraseña Olvidada?</a></span>
        </form>
    </div>
    <div class="popup-content">
      <span class="close-button" id="closePopupButton">&times;</span>
      <p>Comuníquese con el administrador</p>
    </div>
</body>
</html>

<?php include_once('layouts/footer.php'); ?>
