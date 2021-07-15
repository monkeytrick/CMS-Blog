<?php include"include/db-connection.php";?>
<?php include"admin/functions.php";?>



<?php

if(!isset($_GET['reset'])) {

    redirect("http://localhostindex.php");
}

else {

  $token = $_GET['reset'];

  $stmt = mysqli_prepare($connection, " SELECT username FROM users WHERE temp_token = ?");
  mysqli_stmt_bind_param($stmt, 's', $token);
  mysqli_stmt_execute($stmt);
  
  mysqli_stmt_bind_result($stmt, $username);

  $usern = mysqli_stmt_fetch($stmt);
  $usern = $username;

  mysqli_stmt_close($stmt);

    if($usern) {
    echo "TOKEN WORKING FOR " . $usern;
    }

    else {
      echo "TOKEN NOT WORKING!";
      redirect("http://localhostindex.php");
    }
};


//Handle request to change p/word
if(isset($_POST['change-password'])){

    if($_POST['new-password'] === $_POST['confirm-password'] && isset($usern)) {

        $password = $_POST['new-password'];

        $new_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

        $stmt = mysqli_prepare($connection, " UPDATE users SET temp_token = '', user_password='{$new_password}' WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $usern);
        mysqli_stmt_execute($stmt);

            if(mysqli_stmt_affected_rows($stmt) >= 1) {
              echo "Details updated";
              redirect("localhost\CMS\include\login.php");
            } else {
              // echo "Details not updated";
              redirect("localhost\CMS\include\login.php");
              //redirect to login function
            }
    }
    else{
      echo "USER NO SET, AYE";
    }
};
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Recover Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="password" name="new-password" id="password1" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="confirm-password" id="password2" class="form-control" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" id="submit" name="change-password" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="login.html">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../admin/dist/js/adminlte.min.js"></script>

<script>

let pWordCheck = document.getElementById("submit");
  pWordCheck.addEventListener('click', function(e){
    let pWordField1 = document.getElementById("password1").value;
    let pWordField2 = document.getElementById("password2").value;
    if(pWordField1 !== pWordField2){
      e.preventDefault();
      alert("Passwords must be the same");
    }
  })
</script>
</body>
</html>
