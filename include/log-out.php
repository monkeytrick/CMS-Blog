<?php ob_start(); ?>
<?php session_start(); ?>
<?php include "db-connection.php";?>
<?php include "../admin/functions.php";?>

<?php session_destroy(); ?>

<?php
  session_start();

  flashMsg('success', 'Logged Out');
  header("Location: /index.php");
  exit;
?>