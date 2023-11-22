<?php
  $page_title = 'Agregar proveedor';
  require_once('Controllers/load.php');
  
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['add_supplier'])){
   $req_fields = array('supplier-title','address','phone', 'email' );
   validate_provider_fields($req_fields);
   
   /*Obtener la lista de los proveedores desde la 
     base de datos*/
   $all_suppliers = find_all('supplier');

   if(empty($errors)){
     $s_name  = remove_junk($db->escape($_POST['supplier-title']));
     $p_addr  = remove_junk($db->escape($_POST['address']));
     $p_phn   = remove_junk($db->escape($_POST['phone']));
     $p_mai   = remove_junk($db->escape($_POST['email']));
     //Variable
     $sup_name = $_POST['supplier-title'];
     // Verificar si el proveedor ya existe  
     // Asume que $all_suppliers contiene todos los proveedores
     if(!empty($sup_name)) {
        $existing_providers = array_column($all_suppliers, 'name');   
        // Eliminar espacios en blanco al principio y al final
       $sup_name = trim($sup_name);  
       //************************************************** */
       if (in_array($sup_name, $existing_providers)) {
        $session->msg("d", "El proveedor ya existe.");
        redirect('add_supplier.php', false);
        exit; // Agregamos una salida para detener la ejecución del código
      } else {
        // Comprobar si el nombre del proveedor contiene solo espacios en blanco
        if (strlen($sup_name) == 0) {
          $session->msg("d", "No se permiten espacios en blanco.");
          redirect('add_supplier.php', false);
          exit; // Salir para evitar el registro
        }
      }  
     }else {
      $session->msg("d", "El nombre del proveedor no puede estar vacío.");
      redirect('add_supplier.php', false);
    } 
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
                  <input type="text" class="form-control" name="supplier-title" 
                  placeholder="Nombre de Proveedor" maxlength="30" autocomplete="off"
                  oninput="formatInput(this)">
               </div>
              </div>
              <script>
                function formatInput(input) {
                  let text = input.value;
                  text = text.charAt(0).toUpperCase() + text.slice(1);  // Capitaliza la primera letra
                  input.value = text;
                }                                 
              </script>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-map-marker"></i>
                  </span>
                  <input type="text" class="form-control" name="address" 
                  placeholder="Dirección" maxlength="35" autocomplete="off">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-earphone"></i>
                  </span>
                  <input type="text" class="form-control" 
                  name="phone" id="phone" placeholder="Celular" autocomplete="off">
               </div>              
              </div>
              <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    // Seleccionar el campo de entrada
                    var phoneInput = document.getElementById("phone");

                    // Agregar un controlador de eventos para el evento de entrada (input)
                    phoneInput.addEventListener("input", function() {
                      // Eliminar caracteres no numéricos
                      var inputValue = phoneInput.value.replace(/\D/g, "");

                    // Limitar la longitud a 9 caracteres
                      if (inputValue.length > 9) {
                        inputValue = inputValue.slice(0, 9);
                      }

                      phoneInput.value = inputValue;
                    });
                  });
              </script>              
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-envelope"></i>
                  </span>
                  <input type="email" class="form-control" name="email" 
                  placeholder="Correo Electrónico" maxlength="30" autocomplete="off">
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
