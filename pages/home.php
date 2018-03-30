<?php require '../includes/classes.php'; ?>
<?php $title = 'NCSLocator |Home' ?>
 <?php ob_start() ?>
  <h1>Home page</h1>
 <?php $content = ob_get_clean() ?>
 <?php include '../layout/layout_main.php' ?>