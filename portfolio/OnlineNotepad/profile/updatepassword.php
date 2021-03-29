<?php
//Start session
session_start();

include('connection.php');

// define error messages
$missingCurrentPassword='<p><strong>Please enter your current password!</strong></p>';
$incorrectCurrentPassword='<p><strong>Please enter your current password!</strong></p>';
$missingPassword='<p><strong>Please enter a password!</strong></p>';
$invalidPassword='<p><strong>Your password should be at least 6 characters long and include one capital letter and one number!</strong></p>';
$differentPassword='<p><strong>Passwords must match!</strong></p>';
$missingPassword2='<p><strong>Please confirm a password!</strong></p>';

//Get current password
if(!$_POST["currentpassword"]){
    $errors .= $missingCurrentPassword;
}else{
    $currentPassword = filter_var($_POST["currentpassword"], FILTER_SANITIZE_STRING);
    // prepare for query
    $currentPassword = mysqli_real_escape_string($link, $currentPassword);
    // hash password
    $currentPassword = hash('sha256', $currentPassword);
    
    // check if given password is correct
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT password FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    
    if(!$result){
        echo "error when selecting user_id from users table to check the password!";
        exit;
    }
    
    $count = mysqli_num_rows($result);
    
    if(!$count){
      echo '<div class="alert alert-danger">That password is incorrect</div>';
      exit;
    }
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    echo "hello";
    if($currentPassword !== $row['password']){
        $errors .= '<p><strong>Incorrect current password!</strong></p>';
    }
    echo "hello2";
}

//Get new passwords
if(!$_POST["password"]){
  $errors .= $missingPassword;
}elseif(!(strlen($_POST["password"])>=6 
        and preg_match('/[A-Z]/',$_POST["password"])
        and preg_match('/[1-9]/',$_POST["password"])
)){
  $errors .= $invalidPassword;
}else{
  $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
  if(!$_POST["password2"]){
    $errors .= $missingPassword2;
  }else{
    $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
    if($password !== $password2){
      $errors .= $differentPassword;
    }
  }
}

//If there are any errors print error
if($errors){
  $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
  echo $resultMessage;
}else{
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);
    
    // else run query and update password
    $sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    
    if(!$result){
        echo "<div class='alert alert-danger'>The password could not be reset please try again later!</div>";
    }else{
         echo "<div class='alert alert-success'>The new password has been updated successfully!</div>";
    }
}
?>