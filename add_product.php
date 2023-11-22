<?php
  $page_title = 'Agregar material';
  require_once('Controllers/load.php');
  
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
  $all_supplier = find_all('supplier');
?>
<?php
  if(isset($_POST['add_product'])){
    $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price', 'product-supplier' );
    validate_fields($req_fields);
    /*Obtener la lista de los materiales desde la 
      base de datos*/
      $all_products = find_all('products');   
    if(empty($errors)){
      $p_name  = remove_junk($db->escape($_POST['product-title']));
      $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
      $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
      $p_buy   = remove_junk($db->escape($_POST['buying-price']));
      $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
      $p_supplier  = remove_junk($db->escape($_POST['product-supplier']));
      if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
        $media_id = '0';
      } else {
        $media_id = remove_junk($db->escape($_POST['product-photo']));
      }
      //Variable
       $sup_name = $_POST['product-title'];
      // Verificar si el material ya existe  
      // Asume que $all_products contiene todos los materiales
      if(!empty($sup_name)) {
         $existing_providers = array_column($all_products, 'name');   
         // Eliminar espacios en blanco al principio y al final
        $sup_name = trim($sup_name);  
        //************************************************** */
        if (in_array($sup_name, $existing_providers)) {
         $session->msg("d", "El material ya existe.");
         redirect('add_product.php', false);
         exit; // Agregamos una salida para detener la ejecución del código
       } else {
         // Comprobar si el nombre del material contiene solo espacios en blanco
         if (strlen($sup_name) == 0) {
           $session->msg("d", "No se permiten espacios en blanco.");
           redirect('add_product.php', false);
           exit; // Salir para evitar el registro
         }
       }  
      }else {
       $session->msg("d", "El nombre del material no puede estar vacío.");
       redirect('add_product.php', false);
     } 
      $date    = make_date();
      $query  = "INSERT INTO products (";
      $query .=" name,quantity,buy_price,sale_price,categorie_id,media_id,date,supplier_id";
      $query .=") VALUES (";
      $query .=" '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$date}', '{$p_supplier}'";
      $query .=")";
      $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
      if($db->query($query)){
        $session->msg('s',"Material agregado exitosamente. ");
        redirect('add_product.php', false);
      } else {
        $session->msg('d',' Lo siento, registro falló.');
        redirect('product.php', false);
      }
 
    } else{
      $session->msg("d", $errors);
      redirect('add_product.php',false);
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
            <span>Agregar material</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Descripción"
                  oninput="formatInput(this)">
               </div>
               <script>
                function formatInput(input) {
                    let text = input.value;
                    text = text.charAt(0).toUpperCase() + text.slice(1);  // Capitaliza la primera letra
                    input.value = text;
                  }                 
              </script>                  
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6" style="width: 268px !important;">
                    <select class="form-control" name="product-categorie">
                      <option value="">Selecciona una categoría</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6" style="width: 268px !important;">
                    <select class="form-control" name="product-photo">
                      <option value="">Selecciona una imagen</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6" style="width: 268px !important;">
                    <select class="form-control" name="product-supplier">
                      <option value="">Selecciona un proveedor</option>
                    <?php  foreach ($all_supplier as $sup): ?>
                      <option value="<?php echo (int)$sup['id'] ?>">
                        <?php echo $sup['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" min="0" placeholder="Cantidad">
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="number" class="form-control" name="buying-price" min="0" placeholder="Precio de compra">
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="number" class="form-control" name="saleing-price" min="0" placeholder="Precio de venta">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="add_product" class="btn btn-danger">Agregar material</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
