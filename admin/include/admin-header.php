<?php ob_start() ?>
<?php include"../include/db-connection.php";?>
<?php include_once "functions.php";?>
<?php session_start(); ?>

 <?php 

  if(isset($_SESSION['user_role'])) {
    if($_SESSION['user_role'] !== 'admin') {
      header("Location: ../include/login.php");
    }
  }
  elseif(!isset($_SESSION['username'])) {
    header("Location: ../include/login.php");
  }
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Admin</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Toastr -->
  <link href="../css/toastr.min.css" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">