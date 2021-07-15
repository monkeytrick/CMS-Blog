<?php include "../include/db-connection.php";?>
<?php include "include/admin-header.php";?>


<?php

if(isset($_GET['delete'])) {

  $user_id = secure_string($_GET['delete']);

  $query = " DELETE FROM users WHERE user_id = $user_id ";

  $delete_query = mysqli_query($connection, $query);

  if(!$delete_query) {
      die("Error " . mysqli_error($delete_query));
  }

}

?>

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a href="../include/log-out.php" class="nav-link" style="color: blue">Log Out</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                POSTS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View All</p>
                </a>
              </li>
              
              <?php

              $get_posts = " SELECT post_id, post_title FROM posts LIMIT 5";
              $returned_posts = mysqli_query($connection, $get_posts);

              while($post = mysqli_fetch_assoc($returned_posts)) {
                echo " <li class='nav-item'>
                      <a href='/post.php?p-id={$post['post_id']}' class='nav-link'>
                        <i class='far fa-circle nav-icon'></i>
                        <p>{$post['post_title']}</p>
                      </a>
                      </li> ";
                };
               echo "<li class='nav-item'><a href='/admin/posts.php' class='nav-link'> <i class='fas fa-plus-circle nav-icon'></i><p>View All</p></a></li>";
              
              ?>

            </ul>
          </li>
              <a href="comments.php" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    COMMENTS
                  </p>
                </a>

                <li class="nav-item has-treeview">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                USERS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./users.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View All</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./include/add-user.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <section class="content">
          <div class="container-fluid">

      

    <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
              <a href="admin/comments.php">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-comments"></i></span>

              <?php
                $comment_query = " SELECT * FROM comments ";
                $comment_count = mysqli_query($connection, $comment_query);

                if(!$comment_count){
                  die("ERROR " . mysqli_error($connection));
                }

                $comment_num = mysqli_num_rows($comment_count)

              ?>

              <div class="info-box-content">
                <span class="info-box-text">Comments</span>
                <span class="info-box-number"><?php echo $comment_num ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>

          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

              <?php
                $post_query = " SELECT * FROM posts ";
                $post_count = mysqli_query($connection, $post_query);

                if(!$post_count){
                  die("ERROR " . mysqli_error($connection));
                }

                $post_num = mysqli_num_rows($post_count)

              ?>

              <div class="info-box-content">
                <span class="info-box-text">Posts</span>
                <span class="info-box-number"><?php echo $post_num ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>


              <?php
                $users_query = " SELECT * FROM users ";
                $users_count = mysqli_query($connection, $users_query);

                if(!$users_count){
                  die("ERROR " . mysqli_error($connection));
                }

                $users_num = mysqli_num_rows($users_count)

              ?>

              <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number"><?php echo $users_num ?> </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
        <!-- /.row -->

        </div>

        </section>

        
            <!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->

</div>
<!-- ./wrapper -->

<?php include "include/admin-footer.php"; ?>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="dist/js/demo.js"></script>


<script>

                
  $(function () {
    /* ChartJS

     */



    var areaChartData = {
      labels  : [<?php $post_names = "SELECT post_title FROM posts";
                        $get_names = mysqli_query($connection, $post_names);
                        while($names = mysqli_fetch_assoc($get_names)){

                          $textPreview = $names['post_title'];
                          $prev = substr($textPreview, 0, 52);

                          echo "'" . $prev . "'" . ",";
                        }?>],
      datasets: [

        {
          label               : 'Posts',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php $post_comments = "SELECT view_count FROM posts";
                        $get_comments = mysqli_query($connection, $post_comments);
                        while($comments = mysqli_fetch_assoc($get_comments)){
                          
                          echo "'" . $comments['view_count'] . "'" . ",";
                        }?>]

                    
        },

      ]
    }


       //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

})

</script>



