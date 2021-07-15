<?php session_start(); ?>
<?php use PHPMailer\PHPMailer\PHPMailer; ?>
<?php include"./db-connection.php";?>
<?php include"../admin/functions.php";?>

<?php 

    if(isset($_POST['request_reset']) && !isset($_SESSION['user_password'])) {

      $email = $_POST['email'];

      $stmt = mysqli_prepare($connection, "SELECT user_email FROM users WHERE user_email = ?");
      mysqli_stmt_bind_param($stmt, 's', $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);

      
      if(!$stmt) {
        die("ERROR " . mysqli_error($connection));
      }  
      
      $num_check = mysqli_stmt_num_rows($stmt);


      if(!$num_check == 0) {
        
        $temp_token = bin2hex(openssl_random_pseudo_bytes(50));

        $stmt = mysqli_prepare($connection, "UPDATE users SET temp_token='{$temp_token}' WHERE user_email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);

        if(!$stmt) {
          die("ERROR " . mysqli_error($connection));
        }

        require '../vendor/autoload.php';

        require '../classes/email_config.php';  

        $mail = new PHPMailer();

        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = config::SMTP_HOST;                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = config::SMTP_USER;                     // SMTP username
        $mail->Password   = config::SMTP_PASSWORD;                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = config::SMTP_PORT;                                    // TCP port to connect to, use 465 for 
        $mail->isHTML(true);

        $mail->setFrom('loopholelarry@iispan.com');
        $mail->addAddress($email);
        $mail->Subject = "This is a test";
        $mail->Body = '<h3>Password reset request received<h3><br><p>Click on the link below to reset</p><br>
                        <a href="include\recover-password.php?reset='.$temp_token.'">Reset</a> ';

        if($mail->send()) {
          flashMsg('success', 'Password Email Reset Sent');
          header("Location: /include/login.php");
          exit;
        }
        else {
          flashMsg('error', 'Reset Error. Please try again');
        }
      }  

      else {
        flashMsg('error', 'Email address not found');
      }

    }

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Forgot Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admin/plugins/fontawesome-free/css/all.min.css">

  <!-- ../../plugins/fontawesome-free/css/all.min.css -->

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Toastr-->
  <link href="../css/toastr.min.css" rel="stylesheet">
  

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="request_reset" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="./login.php">Login</a>

      </p>
      <p class="mb-0">
        <a href="../register.php" class="text-center">Register a new membership</a>
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

  <!-- Toastr -->
  <script src="../js/toastr.min.js"></script>

  




  
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

</body>
</html>
