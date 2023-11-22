<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<?php
  $page_title = 'Lista de categorías';
  require_once('Controllers/load.php');

  page_require_level(1);
  
  $all_categories = find_all('categories')
?>

<?php
  if (isset($_POST['add_cat'])) {
    $req_field = array('categorie-name');
    validate_fields($req_field);
    $cat_name = $_POST['categorie-name'];
  
    // Verificar si la categoría ya existe
    if (!empty($cat_name)) {
      $existing_categories = array_column($all_categories, 'name');
  
      // Eliminar espacios en blanco al principio y al final
      $cat_name = trim($cat_name);
  
      if (in_array($cat_name, $existing_categories)) {
        $session->msg("d", "La categoría ya existe.");
        redirect('categorie.php', false);
        exit; // Agregamos una salida para detener la ejecución del código
      } else {
        // Comprobar si el nombre de categoría contiene solo espacios en blanco
        if (strlen($cat_name) == 0) {
          $session->msg("d", "No se permiten espacios en blanco.");
          redirect('categorie.php', false);
          exit; // Salir para evitar el registro
        }
  
        // Registro y la verificación si el campo no se halla ingresado
        if (empty($errors)) {
          $sql  = "INSERT INTO categories (name)";
          $sql .= " VALUES ('{$db->escape($cat_name)}')";
          if ($db->query($sql)) {
            $session->msg("s", "Categoría agregada exitosamente.");
            redirect('categorie.php', false);
          } else {
            $session->msg("d", "Lo siento, registro falló");
            redirect('categorie.php', false);
          }
        } else {
          $session->msg("d", $errors);
          redirect('categorie.php', false);
        }
      }
    } else {
      $session->msg("d", "El nombre de la categoría no puede estar vacío.");
      redirect('categorie.php', false);
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
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar categoría</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="categorie.php">
            <div class="form-group">
                <input type="text" class="form-control" name="categorie-name" 
                placeholder="Nombre de la categoría" required maxlength="60" 
                autocomplete="off" oninput="formatInput(this)">
            </div>
            <script>
              function formatInput(input) {
                let text = input.value;
                text = text.charAt(0).toUpperCase() + text.slice(1);  // Capitaliza la primera letra
                input.value = text;
              }                 
            </script>
            <button type="submit" name="add_cat" class="btn btn-primary">Agregar categoría</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Lista de categorías</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Categorías</th>
                    <th class="text-center" style="width: 100px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_categories as $cat):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($cat['name'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="edit_categorie.php?id=<?php echo (int)$cat['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="delete_categorie.php?id=<?php echo (int)$cat['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
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
  </div>
  <script language="javascript" type="text/javascript">
  function removeSpaces(string) {
    
    return string.split(' ').join('');
  }
</script>
  <?php include_once('layouts/footer.php'); ?>
