<?php session_start() ?>
<?php include "../../include/db-connection.php";?>
<?php include "../functions.php";?>

<?php

if(isset($_POST['approve']) && $_SESSION['user_role']== "admin") {

    $comment_id = $_POST['approve'];

    $stmt = mysqli_prepare($connection, "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = ?");
    mysqli_stmt_bind_param($stmt, 's', $comment_id);
    mysqli_execute($stmt);
   
    if(!$stmt) {
        die("QUERY FAILED" . mysqli_error($connection));
        echo mysqli_error($connection);
    }
    else {
        echo "approved";
    }

}

else if(isset($_POST['unapprove']) && $_SESSION['user_role']== "admin") {

    $comment_id = $_POST['unapprove'];

    $stmt = mysqli_prepare($connection, "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = ?");
    mysqli_stmt_bind_param($stmt, 's', $comment_id);
    mysqli_execute($stmt);
   
    if(!$stmt) {
        die("QUERY FAILED" . mysqli_error($connection));
        echo mysqli_error($connection);
    }
    else {
        echo "unapproved";
    }

}

// else {
//     header("Location: login.php");
// }../../include/login.php


else if(isset($_POST['delete']) && $_SESSION['user_role']== "admin") {

    $comment_id = $_POST['delete'];

    $stmt = mysqli_prepare($connection, "DELETE FROM comments WHERE comment_id = ?");
    mysqli_stmt_bind_param($stmt, 's', $comment_id);
    mysqli_execute($stmt);
   
    if(!$stmt) {
        die("QUERY FAILED" . mysqli_error($connection));
        echo mysqli_error($connection);
    }
    else {
        echo "deleted";
    }

}

else {

    header("Location: ../../include/login.php");
    flashMsg('error', 'You must log in');

}
?>