<?php session_start(); ?>
<?php include"include/db-connection.php";?>
<?php include"admin/functions.php";?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Code Diary</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="\CMS\admin\dist\css\adminlte.min.css">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  
  <!-- Toastr -->
  <link href="css/toastr.min.css" rel="stylesheet">


  <!-- Custom styles for this template -->
  <link href="css/clean-blog.min.css" rel="stylesheet">

</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="index.php">Diary/Brand</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.html">About</a>
          </li>
          <li class="nav-item">
            <?php if(isset($_SESSION['username']) && isset($_SESSION['user_password'])) {            
              echo "<a class='nav-link' href='include\log-out.php'>Log out</a>";                 
            }
            else{
              echo "<a class='nav-link' data-toggle='modal' data-target='#login-modal'>log-in/sign-up</a>";
            }
            ?>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact</a>
          
          <!-- Admin log-in  -->
          <?php if(isset($_SESSION['user_password']) && $_SESSION['user_role'] == "admin") {
                   echo "<li class='right badge badge-danger nav-item'>
                              <a class='nav-link' href='/admin/index.php'>Admin</a>
                         </li>";
          } ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <?php echo var_dump($_SESSION) ?>