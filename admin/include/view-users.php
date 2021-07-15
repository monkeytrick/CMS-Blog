<?php

//-- Approve and unapprove seem to have been deleted in DB, so consider deleting this (lines 7 - 44)
if(isset($_GET['approve'])) {

  $user_id = secure_string($_GET['approve']);

  // $query = " UPDATE users SET user_status = 'Approved' WHERE user_id = $user_id ";

  // $approve_user = mysqli_query($connection, $query);

  $stmt = mysqli_prepare($connection, "UPDATE users SET user_status WHERE user_id = ?");
  mysqli_stmt_bind_param($stmt, 'i', $user_id);
  mysqli_stmt_execute($stmt);

  
  if(!$stmt) {
    die("QUERY FAILED" . mysqli_error($connection));
  }
  header("Location: users.php");
  }


if(isset($_GET['unapprove'])) {

  $user_id = secure_string($_GET['unapprove']);

  // $query = " UPDATE users SET user_status = 'Unapproved' WHERE user_id = $user_id ";

  // $unapprove_user = mysqli_query($connection, $query);

  $stmt = mysqli_prepare($connection, "UPDATE users SET user_status = 'Unapproved' WHERE user_id = ?");
  mysqli_stmt_bind_param($stmt, $user_id);
  mysqli_stmt_execute($stmt);
  
  if(!$stmt) {
    die("QUERY FAILED" . mysqli_error($connection));
  }
  header("Location: users.php");

}

//- Change roles

if(isset($_GET['change_role'])) {

    $user_id = secure_string($_GET['change_role']);

    $stmt = mysqli_prepare($connection, "SELECT user_role FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $current_role = mysqli_fetch_row($result)[0];

    if($current_role == 'admin'){
      $new_role = 'subscriber';
    }
    else{
      $new_role = 'admin';
    };    

    $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = ? WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $new_role, $user_id);
    mysqli_execute($stmt);

    if(!$stmt) {
        die("ERROR " . mysqli_error($connection));
    }
}

?>

<div class="wrapper">

  

      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px !important;>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                     <th>ID</th>
                    <th>Username</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                            $get_users = " SELECT * FROM users ";
                            $returned_users = mysqli_query($connection, $get_users);
                            while($row = mysqli_fetch_assoc($returned_users)) {
                               
                                    $user_id = $row['user_id'];
                                    $username = $row['username'];
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name']; 
                                    $user_email = $row['user_email'];
                                    $user_image = $row['user_image'];
                                    $user_role = $row['user_role'];

                              echo "<tr>";
                                  echo "<td>$user_id</td>";
                                  echo "<td>$username</td>";
                                  echo "<td>$first_name</td>";                              
                                  echo "<td>$last_name</td>";
                                  echo "<td>$user_email</td>";
                                  echo "<td>$user_role</td>";
                                  echo "<td>$user_image</td>";

                                  echo "<td><a href='users.php?change_role={$user_id}'>Change</a></td>";




                                  echo "<td><a href='users.php?source=edit-user&edit-user={$user_id}'>Edit</a></td>";
                                  echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";                               
                               
                              echo "</tr>";
                                
                                };
                    ?>

              
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <a href="admin/users.php?source=add-user">Add User</a>

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- ./wrapper -->





<!-- REQUIRED SCRIPTS -->


