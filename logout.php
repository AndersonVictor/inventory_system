<?php
  require_once('Controllers/load.php');
  if(!$session->logout()) {redirect("index.php");}
?>
