<?php
  $page_title = 'Lista de imagenes';
  require_once('Controllers/load.php');

  page_require_level(2);
?>
<?php $media_files = find_all('media');?>


<?php
if(isset($_POST['submit'])) {
  $photo = new Media();

  // Obtén la extensión del archivo
  $file_extension = pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);
  if (empty($_FILES['file_upload']['name'])) {
    $session->msg('d', 'Ningún archivo fue subido.');
    redirect('media.php');
  }
  // Verifica que la extensión sea jpg o png
  if (in_array($file_extension, array('jpg', 'png'))) {
    $photo->upload($_FILES['file_upload']);

    if ($photo->process_media()) {
      $session->msg('s', 'Imagen subida al servidor.');
      redirect('media.php');
    } else {
      $session->msg('d', join($photo->errors));
      redirect('media.php');
    }
  } else {
    $session->msg('d', 'Solo se permiten archivos JPG o PNG.');
    redirect('media.php');
  }
}
?>
<?php include_once('layouts/header.php'); ?>
     <div class="row">
        <div class="col-md-6">
          <?php echo display_msg($msg); ?>
        </div>

      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
            <span>Lista de imagenes</span>
            <div class="pull-right">
              <form class="form-inline" action="media.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <div class="input-group">
                  <label for="">Seleccionar:</label>
                  <span class="input-group-btn">
                    <input type="file" name="file_upload" multiple="multiple" style="margin-right: 10px; width:30px" class="btn btn-primary btn-file"/>
                 </span>

                 <button type="submit" name="submit" class="btn btn-default" style="background-color: #a7c957 !important; color: #fff; margin-left: 10px; width: 100px">Subir</button>
               </div>
              </div>
             </form>
            </div>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">#</th>
                  <th class="text-center">Imagen</th>
                  <th class="text-center">Descripción</th>
                  <th class="text-center" style="width: 20%;">Tipo</th>
                  <th class="text-center" style="width: 50px;">Acciones</th>
                </tr>
              </thead>
                <tbody>
                <?php foreach ($media_files as $media_file): ?>
                <tr class="list-inline">
                 <td class="text-center"><?php echo count_id();?></td>
                  <td class="text-center">
                      <img src="uploads/products/<?php echo $media_file['file_name'];?>" class="img-thumbnail" />
                  </td>
                <td class="text-center">
                  <?php echo $media_file['file_name'];?>
                </td>
                <td class="text-center">
                  <?php echo $media_file['file_type'];?>
                </td>
                <td class="text-center">
                  <a href="delete_media.php?id=<?php echo (int) $media_file['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                </td>
               </tr>
              <?php endforeach;?>
            </tbody>
          </div>
        </div>
      </div>
</div>


<?php include_once('layouts/footer.php'); ?>
