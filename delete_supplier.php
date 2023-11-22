<?php
  require_once('Controllers/load.php');

  page_require_level(2);
?>
<?php
  $supplier = find_by_id('supplier',(int)$_GET['id']);
  if(!$supplier){
    $session->msg("d","ID vacío");
    redirect('supplier.php');
  }
?>
<?php
  $delete_id = delete_by_id('supplier',(int)$supplier['id']);
  if($delete_id){
      $session->msg("s","Proveedor eliminado");
      redirect('supplier.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('supplier.php');
  }
?>
