<?php
  $page_title = 'Editar proveedor';
  require_once('includes/load.php');

   page_require_level(2);
?>
<?php
$supplier = find_by_id('supplier',(int)$_GET['id']);

?>
<?php
 if(isset($_POST['supplier'])){
    $req_fields = array('supplier-title','address','phone', 'email' );
    validate_fields($req_fields);

   if(empty($errors)){
    $s_name  = remove_junk($db->escape($_POST['supplier-title']));
    $p_addr   = remove_junk($db->escape($_POST['address']));
    $p_phn   = remove_junk($db->escape($_POST['phone']));
    $p_mai   = remove_junk($db->escape($_POST['email']));

       $query   = "UPDATE supplier SET";
       $query  .=" name ='{$s_name}', address ='{$p_addr}',";
       $query  .=" phone ='{$p_phn}', email ='{$p_mai}'";
       $query  .=" WHERE id ='{$supplier['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"El proveedor ha sido actualizado. ");
                 redirect('supplier.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_supplier.php?id='.$supplier['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_supplier.php?id='.$supplier['id'], false);
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Editar proveedor</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_supplier.php?id=<?php echo (int)$supplier['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-home"></i>
                  </span>
                  <input type="text" class="form-control" name="supplier-title" value="<?php echo remove_junk($supplier['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-map-marker"></i>
                  </span>
                  <input type="text" class="form-control" name="address" value="<?php echo remove_junk($supplier['address']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-earphone"></i>
                  </span>
                  <input type="text" class="form-control" name="phone" value="<?php echo remove_junk($supplier['phone']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-envelope"></i>
                  </span>
                  <input type="text" class="form-control" name="email" value="<?php echo remove_junk($supplier['email']);?>">
               </div>
              </div>
              <button type="submit" name="supplier" class="btn btn-danger">Actualizar</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
