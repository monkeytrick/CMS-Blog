
<?php include"include/db-connection.php";?>
<?php include"include/header.php";?>



<?php

if(isset($_GET['author'])) {
    $post_author = secure_string($_GET['author']);
};

?>

  <!-- Page Header -->
  <header class="masthead" style="background-image: url('img/home-bg.jpg')">
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

  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">

      <?php    


               $stmt = mysqli_prepare($connection, "SELECT * FROM posts WHERE post_author = ? ");
                mysqli_stmt_bind_param($stmt, 's', $post_author);
                mysqli_stmt_execute($stmt);

                $rslt= mysqli_stmt_get_result($stmt);



                while($row = mysqli_fetch_assoc($rslt)) {

                  echo "<div class='post-preview'>
                  <a href='post.php?p-id=$row[post_id]'>

                  <h2 class='post-title'>{$row['post_title']}</h2>"; 

                    $textPreview = $row['post_article'];
                    $prev = substr($textPreview, 0, 225);

                   echo "<h3 class='post-subtitle'>{$prev} ... </h3>
                  </a>
                  <p class='post-meta'>Posted by
                    <a href='authors_posts.php?author=$row[post_author]&p=$row[post_id]'>{$row['post_author']}</a><br>";

                  $dbDate = $row['post_date'];
                  $convertDate = date("jS, F, Y", strtotime($dbDate));

                  echo  "{$convertDate}</p>
                </div>
                <hr>";
                }

?>
        <!-- Pager -->
        <div class="clearfix">
          <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
        </div>
      </div>
    </div>
  </div>

  <hr>

  <?php include "include/footer.php"; ?>

 
