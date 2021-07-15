<?php ob_start(); ?>
<?php session_start(); ?>
  
<?php include"include/db-connection.php";?>
<?php include"admin/functions.php";?>

<?php

//-- Cookies ----//

if(!isset($_COOKIE['page_views'])){
      $pages = json_encode([$_GET['p-id']]);
  setcookie('page_views', $pages, time()+60*60*24*30);
}
else{
    $viewed_pages = json_decode($_COOKIE['page_views'], true);
        if(!in_array($_GET['p-id'], $viewed_pages)) {
          array_push($viewed_pages, $_GET['p-id']);
          setcookie('page_views', json_encode($viewed_pages), time()+60*60*24*30);
    }
}

?>

<?php

if(isset($_POST['login'])) {
  $username = secure_string($_POST['username']);
  $password = secure_string($_POST['password']);
  $redirect = false;
  
  login($username, $password, $redirect);
}

if(isset($_POST['update'])) {
  $post_id = secure_string($_GET['p-id']); 


    $stmt = mysqli_prepare($connection, "UPDATE posts SET view_count = view_count + 1 WHERE post_id = ? ");
    mysqli_stmt_bind_param($stmt, 'i', $post_id);
    mysqli_stmt_execute($stmt);

  }

  ?>


<!-- Send comment data -->
<?php
if(isset($_POST['submit-comment'])) {

      $comment_author = $_SESSION['username'];
      $comment_content = strip_tags($_POST['comment-content']);

      $comment_post_id = secure_string($_GET['p-id']);

      $comment_status = 'Approved';

      $stmt = mysqli_prepare($connection, "INSERT INTO comments (comment_post_id, comment_author, comment_content, comment_status, comment_date) VALUES (?,?,?,?,now())");
      mysqli_stmt_bind_param($stmt, "isss", $comment_post_id, $comment_author, $comment_content, $comment_status);
      mysqli_stmt_execute($stmt);

      if(!$stmt) {
        die("Error ". mysqli_error($connection));
      }

      else flashMsg('success', 'comment added');
    }
?>

<?php

    $post_retrieve = $_GET['p-id'];
    $post_id = secure_string($_GET['p-id']);

    $stmt = mysqli_prepare($connection, "SELECT posts.post_title, posts.post_author, posts.post_date, posts.post_article,
                                        comments.comment_author, comments.comment_content, comments.comment_date FROM posts 
                                        LEFT OUTER JOIN comments ON posts.post_id = comments.comment_post_id WHERE post_id = ?
                                        ORDER BY comments.comment_date DESC");



    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

?>


<!DOCTYPE html>
<html lang="en">

<head>


  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Clean Blog - Start Bootstrap Theme</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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


<!-- Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="card">
    <div class="card-body login-card-body">

      <form action=" " method="post">
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
        <a href="forgot-password.php">I forgot my password</a>
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
                              <a class='nav-link' href='/admin/index.php'>Admin</a>
                         </li>";
          } ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <header class="masthead" style="background-image: url('img/post-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-heading">

            <h1><?php echo $row['post_title'] ?></h1>
            <h2 class="subheading">Problems look mighty small from 150 miles up</h2>
            
            <span class="meta">Posted by
              <a href="#"><?php echo $row['post_author'] ?></a>
              <br><?php echo $row['post_date'] ?></span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Post Content -->

  <article>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
        
        <?php
          echo nl2br($row['post_article']);
        ?>

<!-- <?php print_r($result); ?> -->
  
  <!-- COMMENTS SECTION -->

      <div class="container mt-5 mb-5">
          <div class="d-flex justify-content-center row">
              <div class="d-flex flex-column col-md-12">
                  


                  <div class="coment-bottom bg-white p-2 px-4">

                  <?php 

                  if(isset($_SESSION['username']) && isset($_SESSION['user_password'])){
                  echo'<form action="" method="post"> 

                      <div class="form-group">
                          <div class="d-flex flex-row add-comment-section mt-4 mb-4">
                            <textarea name="comment-content" style="height: 70px;" type="text" class="form-control mr-3" placeholder="Add comment"></textarea>
                      </div>      
                        
                        <button name="submit-comment" class="btn btn-primary" type="submit">Comment</button>
                      </div>
                  </form>';}
                  else {
                    echo '<p>Please <a data-toggle="modal" data-target="#login-modal">log-in</a> or <a >sign-up</a> to comment</p>';
                  }               
                  ?>
                  


                  <div class="commented-section mt-2">
                          <div class="d-flex flex-row align-items-center commented-user">
                              <h5 class="mr-2"><?echo $row['comment_author'] ?></h5><span class="dot mb-1"></span><span class="mb-1 ml-2"><?php echo $row['comment_date'] ?></span>
                          </div>
                          <div class="comment-text-sm"><span><?php echo $row['comment_content'] ?></span></div>
                          <hr>

                          <!-- <div class="reply-section">
                              <div class="d-flex flex-row align-items-center voting-icons"><i class="fa fa-sort-up fa-2x mt-3 hit-voting"></i><i class="fa fa-sort-down fa-2x mb-3 hit-voting"></i><span class="ml-2">25</span><span class="dot ml-2"></span>
                                  <h6 class="ml-2 mt-1">Reply</h6>
                              </div>
                          </div> -->
                      </div>                


                  <?php 

                          while($row = mysqli_fetch_array($result)) {
                  // ?>

                      
                      <div class="commented-section mt-2">
                          <div class="d-flex flex-row align-items-center commented-user">
                              <h5 class="mr-2"><?echo $row['comment_author'] ?></h5><span class="dot mb-1"></span><span class="mb-1 ml-2"><?php echo $row['comment_date'] ?></span>
                          </div>
                          <div class="comment-text-sm"><span><?php echo nl2br($row['comment_content']) ?></span></div>
                          <hr>
 
                      </div>

                   <?php }; ?>

                      

                  </div>
              </div>
          </div>
      </div>

          <!-- <p>Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center — an equal earth which all men occupy as equals. The airman's earth, if free men make it, will be truly round: a globe in practice, not in theory.</p>

          <p>Science cuts two ways, of course; its products can be used for both good and evil. But there's no turning back from science. The early warnings about technological dangers also come from science.</p>

          <p>What was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.</p>

          <p>A Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That's how I felt seeing the Earth for the first time. I could not help but love and cherish her.</p>

          <p>For those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.</p>

          <h2 class="section-heading">The Final Frontier</h2>

          <p>There can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>

          <p>There can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>

          <blockquote class="blockquote">The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>

          <p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>

          <h2 class="section-heading">Reaching for the Stars</h2>

          <p>As we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.</p>

          <a href="#">
            <img class="img-fluid" src="img/post-sample-image.jpg" alt="">
          </a>
          <span class="caption text-muted">To go places and do things that have never been done before – that’s what living is all about.</span>

          <p>Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before.</p>

          <p>As I stand out here in the wonders of the unknown at Hadley, I sort of realize there’s a fundamental truth to our nature, Man must explore, and this is exploration at its greatest.</p>

          <p>Placeholder text by -->
            <a href="http://spaceipsum.com/">Space Ipsum</a>. Photographs by
            <a href="https://www.flickr.com/photos/nasacommons/">NASA on The Commons</a>.</p>
        </div>
      </div>
    </div>
  </article>

  <hr>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <ul class="list-inline text-center">
            <li class="list-inline-item">
              <a href="#">
                <span class="fa-stack fa-lg">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                </span>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <span class="fa-stack fa-lg">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                </span>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <span class="fa-stack fa-lg">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                </span>
              </a>
            </li>
          </ul>
          <p class="copyright text-muted">Copyright &copy; Your Website 2020</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  
  <!-- Toastr -->
  <script src="js/toastr.min.js"></script>
  <script>
      toastr.options = {
        "showDuration": "30",
        "hideDuration": "10",
        "timeOut": "1000",
      }

      <?php 
          if(isset($_SESSION['flash'])) {
          echo "toastr." . $_SESSION['flash'];
          unset($_SESSION['flash']);
        }
      ?>
  </script>



  <!-- Custom scripts for this template -->
  <script src="js/clean-blog.min.js"></script>

  <script>
    //increment post view count after 25 secs on page
      window.onload = () => {
        setTimeout(() => {
          ajaxCall();      
        }, 25000);
      }

      function ajaxCall() {
      let xhttp = new XMLHttpRequest();

      xhttp.open("POST", '', true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.responseType = "";  
      xhttp.send('update');
    } 
  
  </script>

</body>

</html>
