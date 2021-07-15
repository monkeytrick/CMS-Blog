<?php 

    if(isset($_GET['edit-user'])) {

      if(check_user_role()) {

        $edit_user = $_GET['edit-user'];

        $get_user = "SELECT first_name, last_name, user_password, user_image, user_email FROM users WHERE user_id = $edit_user ";

        $get_user_data = mysqli_query($connection, $get_user);

        while($row = mysqli_fetch_assoc($get_user_data)) {

        $edit_first_name = $row['first_name'];
        $edit_last_name = $row['last_name'];
        $edit_user_password = $row['user_password'];
        $edit_user_image = $row['user_image'];
        $edit_user_email = $row['user_email'];
        }
      };

    };
  



  if(isset($_POST['edit-user'])) {

    if(check_user_role()){

    $user_password = $_POST['user_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
   
    $user_email = $_POST['user_email'];

    $user_role = $_POST['user_role'];

    $new_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
    
    $query = "UPDATE users SET ";
    $query .= "user_password = '{$new_password}', ";
    $query .= "first_name = '{$first_name}', ";
    $query .= "last_name = '{$last_name}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_role = '{$user_role}' ";

    $query .= " WHERE user_id = $edit_user ";


    $edit_user = mysqli_query($connection, $query);

    if(!$edit_user){
      die("QUERY FAILED" . mysqli_error($connection));
    }
    else {
      flashMsg('success', 'User Edited');
      header("Location: /admin/users.php");
      exit;
    }
  }

  }
  
?>

<!-- IMPORTED CSS BEGINS HERE -->
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="user_password">New Password</label>
                    <input type="password" autocomplete="off" class="form-control" name="user_password" placeholder="password">
                  </div>

                  <div class="form-group">
                    <label for="first_name">First name</label>
                    <input type="text" class="form-control" name="first_name" placeholder="First name" value=<?php echo $edit_first_name ?>>
                  </div>

                  <div class="form-group">
                    <label for="user_surname">Surname</label>
                    <input type="text" class="form-control" name="last_name" placeholder="Surname" value=<?php echo $edit_last_name; ?>>
                  </div>
                  
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" value=<?php echo $edit_user_email ?> class="form-control" name="user_email" placeholder="Email">
                  </div>

                  <div class="form-group">
                    <label for="user_role">Role</label>
                    <select name="user_role" class="form-control" style="width: 200px;">
                        <option value="admin">Admin</option>
                        <option value="subscriber">Subscriber</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="image">Image</label>
                    <div class="input">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="user_image" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" name="">Upload</span>
                      </div>
                    </div>
                  </div>
 
                                <!-- <div class="mb-3">
                <textarea class="textarea" placeholder="article" name="article"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              </div>  -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="edit-user" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
<!-- IMPORT ENDS -->

