<?php
  $page_title = 'Lista de proveedores';
  require_once('includes/load.php');
  header('Content-Type: text/html; charset=UTF-8');
   page_require_level(2);
  $suppliers = join_supplier_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_supplier.php" class="btn btn-primary">Agregar proveedor</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Nombre</th>
                <th> Dirección</th>
                <th class="text-center" style="width: 10%;"> Teléfono </th>
                <th class="text-center" style="width: 10%;"> Email </th>
                <th class="text-center" style="width: 100px;"> Acciones </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($suppliers as $supplier):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td> <?php echo remove_junk($supplier['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($supplier['address']); ?></td>
                <td class="text-center"> <?php echo remove_junk($supplier['phone']); ?></td>
                <td class="text-center"> <?php echo remove_junk($supplier['email']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_supplier.php?id=<?php echo (int)$supplier['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_supplier.php?id=<?php echo (int)$supplier['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
