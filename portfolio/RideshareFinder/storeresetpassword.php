<!-- This file receives: user_id, generated key to reset password, password1 and password2-->
<!-- This file the resets password for user_id if all checks are true-->

<?php
session_start();
include('connection.php');
// if user_id or reset key is missing
// if(!$_POST['user_id'] || !$_POST['key']){
//   echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email\n\nPlease check your spam folder.</div>';
//   exit;
// }

//Store them in two variables
$user_id = $_POST['user_id'];
$key = $_POST['key'];
// define time variable: now minus 24 hours
$time = time() - 86400;

//Prepare variables for the query
$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);
// Run query: check combination of user_id & key exists and less than 24 hour old
$sql = "SELECT user_id FROM forgotpassword WHERE user_id='$user_id' AND time > '$time'";
$result = mysqli_query($link, $sql);

if(!$result){
  echo '<div class="alert alert-danger">Error running the query!</div>';
  exit;
}

// if combination does not exist
$count = mysqli_num_rows($result);

if($count == 1){
    echo '<div class="alert alert-danger">Please try again!</div>';
    exit;
}

// Deine Error Messages
$missingPassword='<p><strong>Please enter a password!</strong></p>';
$invalidPassword='<p><strong>Your password should be at least 6 characters long and include one capital letter and one number!</strong></p>';
$differentPassword='<p><strong>Passwords must match!</strong></p>';
$missingPassword2='<p><strong>Please confirm a password!</strong></p>';

//Get passwords
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
  exit;
}

//Prepare variables for the queries
$user_id = mysqli_real_escape_string($link, $user_id);
$password = mysqli_real_escape_string($link, $password);
// hash password
$password = hash('sha256', $password);

// Run query: check combination of user_id & key exists and less than 24 hour old
$sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

if(!$result){
  echo '<div class="alert alert-danger">There was a problem storing the new password!</div>';
}else{
  echo '<div class="alert alert-success">Your password has been updated successfully! <a href="index.php">Login</a></div>';
}

?>