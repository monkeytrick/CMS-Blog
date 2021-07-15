<?php

//-- Sanitize strings
function secure_string($string){
        global $connection;
        $strip_htm = strip_tags($string);
        return mysqli_escape_string($connection, trim($strip_htm));        
};


//Re-direct
function redirect($destination) {
  header("Location: ". $destination);
}


//--Checks user's role for permissions.

function check_user_role() {
      
        global $connection;

        if(isset($_SESSION['user_password']) && $_SESSION['user_role'] == 'admin'){
          return true;
        }
        else {
          header("Location: /include/login.php");
          flashMsg('error', 'Admin login required');
          exit;
        };
}



//-- Register new user
function register_user($username, $email, $password) {

    global $connection; 

    $username = mysqli_escape_string($connection, $username);
    $email    = mysqli_escape_string($connection, $email);
    $hash_password = mysqli_escape_string($connection, $password);

    $hash_password = password_hash($hash_password, PASSWORD_BCRYPT, array('cost' => 12));

    $user_role = 'subscriber';

    $stmt = mysqli_prepare($connection, "INSERT INTO users (username, user_password, user_email, user_role) VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $username, $hash_password, $email, $user_role);
    mysqli_stmt_execute($stmt);

  if(!$stmt) {
    die("ERROR " . mysqli_error($connection));
  }
  //-- Log user in after successful submission
  else {
    login($username, $password);
  }
}



//-- Login

function login($username, $password){

    global $connection; 

    $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    
    if(!$result){
      die("ERROR " . mysqli_error($connection));
    }

    while($row = mysqli_fetch_assoc($result)) {
      $db_username = $row['username'];
      $db_password = $row['user_password'];
      $db_first_name = $row['first_name'];
      $db_last_name = $row['last_name'];
      $db_user_role = $row['user_role'];
      $db_email = $row['user_email'];
      
    }
    
  if(isset($db_password) && password_verify($password, $db_password)) {

      $_SESSION['username'] = $db_username;
      $_SESSION['first_name'] = $db_first_name;
      $_SESSION['last_name'] = $db_last_name;
      $_SESSION['user_role'] = $db_user_role;
      $_SESSION['user_password'] = $db_password;
      $_SESSION['user_email'] = $db_email;
  
      if($db_user_role == 'admin') {
        flashMsg('success', 'Logged in as Admin');
        header("Location: /admin/index.php");
        exit;
      }

      /// THIS DOES NOT WORK WITH NEWLY REGISTERED USERS!?
      // https://www.udemy.com/course/php-for-complete-beginners-includes-msql-object-oriented/learn/lecture/6455300#questions/7477064
      // Seems no session is being set, regardless of user role
      else{
        flashMsg('success', 'Logged In');
        header("Location: /index.php");        
        exit;
      }    

  } 

  // Wrong password supplied../include/login.php
  else { 
    flashMsg('error', 'incorrect username or password');
  }
 
}

?>

<?php
  //-- Flash messages
  function flashMsg($type, $message){
      return $_SESSION['flash'] = $type . "('" . $message . "')";
  }
?>