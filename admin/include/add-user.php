<?php 
include "../functions.php";

  if(isset($_POST['add-user'])) {

    if(check_user_role()) {

    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
   
    $user_email = $_POST['user_email'];

    // $post_image = $_FILES['image']['name'];
    // $post_image_temp = $_FILES['image']['tmp_name'];

    $user_role = $_POST['user_role'];

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));


    // $post_date = date('d-m-y');

    // move_uploaded_file($post_image_temp,"../images/$post_image");

    
    $query = "INSERT INTO users (username, user_password, first_name, last_name, user_email, user_role) ";


    $query .= "VALUES( '{$username}', '{$user_password}', '{$first_name}', '{$last_name}', '{$user_email}', '{$user_role}')";

    $create_new_user = mysqli_query($connection, $query);


    if(!$create_new_user){
      die("QUERY FAILED" . mysqli_error($connection));
  }
}
    else {
      header("Location: ../users.php");
    };

  }
  
?>



<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">New Post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                  </div>

                  <div class="form-group">
                    <label for="user_password">Password</label>
                    <input type="text" class="form-control" name="user_password" placeholder="Username">
                  </div>

                  <div class="form-group">
                    <label for="first_name">First name</label>
                    <input type="text" class="form-control" name="first_name" placeholder="First name">
                  </div>

                  <div class="form-group">
                    <label for="user_surname">Surname</label>
                    <input type="text" class="form-control" name="last_name" placeholder="Surname">
                  </div>
                  
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="user_email" placeholder="Email">
                  </div>

                  <div class="form-group">
                    <label for="user_role">Role</label>
                    <select name="user_role" class="form-control" style="width: 200px;">
                        <option value="admin">Admin</option>
                        <option value="subscriber">Subscriber</option>
                    </select>
                    <!-- <input type="emaroleil" class="form-control" name="user_role" placeholder="role"> -->
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="add-user" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


