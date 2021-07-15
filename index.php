<?php ob_start() ?>
<?php session_start(); ?>
  
<?php include "include/db-connection.php";?>
<?php include "admin/functions.php";?>

<?php         

  if(isset($_COOKIE['page_views'])){
    $viewed_pages = json_decode($_COOKIE['page_views'], true);
  }

?>

<?php
    if(isset($_POST['login'])) {
      $username = secure_string($_POST['username']);
      $password = secure_string($_POST['password']);
      $redirect = false;
      
      login($username, $password, $redirect);
    }
?>



<?php 
         

if(isset($_GET['order-by'])){
  
  $secure_query = secure_string($_GET['order-by']);

  if($secure_query == "view_count") {
    $currentQuery = 'view_count';
  }
  elseif($secure_query == "post_likes") {
    $currentQuery = 'post_likes';
  }
  else {
    $currentQuery = "post_date";
  }
}

if(isset($_GET['page'])){

  $page = secure_string($_GET['page']);
  $page = ($page - 1) * 8;
}
else {
  $page = 0;
}

if(!isset($_GET['page']) && !isset($_GET['order-by'])) {
  $currentQuery = "post_date";
  $page = 0;
}

$stmt = mysqli_prepare($connection, "SELECT p.post_title, p.post_author, p.post_date, p.post_article, p.post_id, p.view_count,
                                        (SELECT COUNT(*)FROM comments c WHERE c.comment_post_id = p.post_id) as num_comments
                                    FROM posts p
                                    WHERE post_status = 'publish' ORDER BY $currentQuery DESC LIMIT $page, 8");

mysqli_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>


  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>CMS</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="\CMS\admin\dist\css\adminlte.min.css">


  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="css/clean-blog.min.css" rel="stylesheet">

  <!-- Toastr -->
  <link href="css/toastr.min.css" rel="stylesheet">

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
          </li>
          
          <!-- Admin log-in  -->
          <?php if(isset($_SESSION['user_password']) && $_SESSION['user_role'] == "admin") {
                   echo "<li class='right badge badge-danger nav-item'>
                              <a class='nav-link' href='admin/index.php'>Admin</a>
                         </li>";

          } ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <header class="masthead">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Coding Diary</h1>
            <span class="subheading">A Journey into Binary Hell</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->

  <!-- Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="card">
    <div class="card-body login-card-body">

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name ="username" class="form-control" placeholder="username" autocomplete="on">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name ="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <p class="mb-1">
        <a href="include/forgot-password.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.php" class="text-center">Register a new membership</a>
      </p>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    <!-- /.login-card-body -->
  </div>
</div>
        </a>
      </div>
    </div>
  </div>
</div>

  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">

       <form action="" method="get" id="submit-order-by">
            <select name="order-by" id="order-by">
              <?php
                $options = ["post_date" => "Most Recent", "post_likes" => "Most Liked", "view_count" => "Most Read"];

                foreach($options as $key => $value) {
                  //Make sure currently selected option is highlighted by adding
                  if($key == $currentQuery) {

                    echo "<option value='$key' selected>$value</option>";
                  }
                  else{
                    echo "<option value='$key'>$value</option>";
                  }
                }
              ?>
          </select>
      </form>


     <?php
                while($row = mysqli_fetch_assoc($result)) {                


                  echo "<div class='post-preview'>";

                    $post_date=strtotime($row['post_date']);

                    $today_date=strtotime(date("d-m-Y"));
                    $diff= $today_date-$post_date;
                    $interval = ($diff/(60*60*24));

                    if($interval < 5) {
                      if(!isset($viewed_pages) || !in_array($row['post_id'], $viewed_pages)) {

                    echo "<div class='post-preview'>
                            <div style='position: relative; float: right;'class='ribbon-wrapper ribbon-lg'>
                                <div class='ribbon bg-primary'>NEW ENTRY</div>
                            </div>
                          </div>";
                  };
                };

                  echo "<a href='post.php?p-id=$row[post_id]'>     

                  <h2 class='post-title'>{$row['post_title']}</h2>"; 

                    $textPreview = $row['post_article'];
                    $prev = substr($textPreview, 0, 225);

                    echo nl2br($prev) . "...";

                  echo "<h3 class='post-subtitle'> ... </h3>
                  </a>
                  <p class='post-meta'>Posted by
                    <a href='authors_posts.php?author=$row[post_author]&p=$row[post_id]'>{$row['post_author']}</a><br>";

                  $dbDate = $row['post_date'];

                  $convertDate = date("jS, F, Y", strtotime($dbDate));

                  echo  "{$convertDate}</p>
                  <div>                  <i style='padding-right: 0.25rem;' class='fas fa-eye'></i>
                     <span style='padding-right:0.55rem;' 'class='view-count'>{$row['view_count']}</span>  
                     <span style='float:right; font-size: 85%;' class='badge badge-danger'>{$row['num_comments']}</span>
                     <i style='float:right; margin-right: 0.55rem;'class='far fa-comments'></i>
                     
                  
                  </div>

                  
                </div>
                <hr>";
                }

                $post_count = "SELECT * FROM posts ";
                $post_count_query = mysqli_query($connection, $post_count);
                $count = mysqli_num_rows($post_count_query);

                $count = ceil($count / 8); 


?>
        <!-- Pager -->
        <div class="clearfix">

        <ul class="pagination pagination-lg justify-content-center">   

          <?php

                  for($i=1; $i<= $count; $i++){
                    echo "<li class='page-item'><a class='page-link' href='index.php?page={$i}&order-by={$currentQuery}'>{$i}</a></li>";
                  };
          ?>

        </ul> 

        </div>
      </div>
    </div>
  </div>

  <hr>

  <?php include "include/footer.php"; ?>
  
  <script>

    var selector = document.getElementById("order-by");
    selector.addEventListener('change', function (){
      var formSub = document.getElementById('submit-order-by').submit();
    })

  </script>




 
