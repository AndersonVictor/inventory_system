<?php
  $page_title = 'Agregar proveedor';
  require_once('includes/load.php');
  
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['add_supplier'])){
   $req_fields = array('supplier-title','address','phone', 'email' );
   validate_fields($req_fields);
   if(empty($errors)){
     $s_name  = remove_junk($db->escape($_POST['supplier-title']));
     $p_addr   = remove_junk($db->escape($_POST['address']));
     $p_phn   = remove_junk($db->escape($_POST['phone']));
     $p_mai   = remove_junk($db->escape($_POST['email']));
    
     $date    = make_date();
     $query  = "INSERT INTO supplier (";
     $query .=" name,address,phone,email";
     $query .=") VALUES (";
     $query .=" '{$s_name}', '{$p_addr}', '{$p_phn}', '{$p_mai}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$s_name}'";
     if($db->query($query)){
       $session->msg('s',"Proveedor agregado exitosamente. ");
       redirect('add_supplier.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('product.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_supplier.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar proveedor</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_supplier.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-home"></i>
                  </span>
                  <input type="text" class="form-control" name="supplier-title" placeholder="Nombre de Proveedor">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-map-marker"></i>
                  </span>
                  <input type="text" class="form-control" name="address" placeholder="Dirección">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-earphone"></i>
                  </span>
                  <input type="text" class="form-control" name="phone" placeholder="Celular">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-envelope"></i>
                  </span>
                  <input type="text" class="form-control" name="email" placeholder="Correo Electrónico">
               </div>
              </div>
              
              <button type="submit" name="add_supplier" class="btn btn-danger">Agregar proveedor</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
