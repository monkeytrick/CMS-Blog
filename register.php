<?php include"include/db-connection.php";?>
<?php include"admin/functions.php";?>


<?php 

if(isset($_POST['possibleUseName'])) {

  $check_name = $_POST['possibleUseName'];

    $check_user_name_exists = mysqli_escape_string($connection, $check_name);

      $stmt = mysqli_prepare($connection, "SELECT * From users WHERE username = ?");
      mysqli_stmt_bind_param($stmt, 's', $check_user_name_exists);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      // $result = mysqli_stmt_get_result($stmt);
     
     $num_check = mysqli_stmt_num_rows($stmt);

     $user_exists = null;

    if($num_check !== 0) {
      $user_exists = "false";
    }
    else {
      $num_check = "true";
    }

    echo $user_exists;
    exit();
    
  }
  
  ?>


<?php

//-- Need to return errors on page. See 275, Inline Errors.

global $user_exists;

if(isset($_POST['submit-register'])) {

  $username = trim($_POST['username']);
  $email    = trim($_POST['email']);
  $password = trim($_POST['password']);


  $error = [
    'username' => "",
    "email" => "",
    "password" => ""
  ];


  if(strlen($username) < 5 ) {
    $error['username'] = "username must be more than 4 characters";
  }

  if($username == "") {
    $error['username'] = "username cannot be empty";
  }

  if($user_exists == "false") {
    $error['username'] = "user already exists";
  }
  
  if(strlen("password") < 5 ) {
    $error['password'] = "password must be at least 4 characters long";
  }
  
  if("password" == "") {
    $error['password'] = "password cannot be empty";
  }

  if($email=="") {
    $error['email'] = "email cannot be empty";
  }

  $register_errors = "";

  foreach ($error as $key => $value) {
    if(!empty($value)){
      $register_errors = true;
    }
  }

  if($register_errors == false){
    register_user($username, $email, $password);
  };

}

?>






<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Toastr messages -->
  <link href="scss/toastr.min.css" rel="stylesheet">


</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Register</b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">

    <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" id="usernameInput" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password1" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password2" placeholder="Retype password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div> required
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit-register" id="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="./include/login.php" class="text-center">I already have a membership</a>

      

      
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="js/toastr.min.js"></script>


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

  let userNameCheck = document.getElementById('usernameInput');
  userNameCheck.addEventListener('blur', ()=> {

    if(!userNameCheck.value == " ") {

      let xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function() {

        if(this.readyState == 4 && this.status == 200) {
          // console.log(this.responseText);
          //Remove any white spaces from response
          userExistErr(this.responseText.trim());
        }
      }

      function  userExistErr (resp) {
        console.log(resp)
        if(resp === "false") {
          console.log("The response text is false");
          let errorArea = document.getElementById("usernameInput").parentNode;
          let errorMsg = document.createElement("p");
          errorMsg.setAttribute("id", "deleteTime");
          errorMsg.innerText = "Username not available";
          errorArea.prepend(errorMsg);
          setTimeout(()=>{
            errorMsg.remove();
          },1200);
          let errorAreaClear = document.getElementById("usernameInput").value = "";
          errorAreaClear.placeholder = "Username";
        }

      }


      xhttp.open('POST',"", true);
      xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhttp.responseType = "";   
    
      xhttp.send("possibleUseName=" + userNameCheck.value);

    }

 
  });

</script>

</body>
</html>


