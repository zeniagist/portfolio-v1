<?php
//Start session
session_start();

//Connect to the database
include("connection.php");

//Check user inputs
//Define error messages
$missingEmail='<p><strong>Please enter your email!</strong></p>';

//Get email
if(!$_POST["forgotemail"]){
  $errors .= $missingEmail;
}else{
  $email = filter_var($_POST["forgotemail"], FILTER_SANITIZE_EMAIL);
}

//Store errors in errors variable
if($errors){
  $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
  echo $resultMessage;
  exit;
}

//Prepare variables for the query
$email = mysqli_real_escape_string($link, $email);

//email exists in the users table print error
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
  echo '<div class="alert alert-danger">Error running the query!</div>';
  exit;
}
$count = mysqli_num_rows($result);

if(!$count){
  echo '<div class="alert alert-danger">That email is not associated with a user. Would you like to register an account?</div>';
  exit;
}

// get user_id
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$user_id = $row['user_id'];

//Create a unique activation code
$key = bin2hex(openssl_random_pseudo_bytes(16));

//Insert user details and activation code in the forgotpassword table
$time = time();
$status = 'pending';
$sql = "INSERT INTO forgotpassword (user_id, rkey, time, status) VALUES ('$user_id', '$key', '$time', '$status')";

// check if details were updated
$result = mysqli_query($link, $sql);
if(!$result){
  echo '<div class="alert alert-danger">There was an error inserting the user details in the database!</div>';
  exit; 
}

//Send email with link to resetpassword.php with user id and activiaton code
$message = "Please click on this link to reset your password: \n\n";
$message .= "Do not reply to this email \n\n";
$message .= "http://zeniagist.com/projects/RideshareFinder/resetpassword.php?user_id=$user_id&key=$key";
$emailSent = mail($email, 'Reset your password', $message, 'From:' . 'no-reply@zeniagist.com');

if($emailSent){
  echo "<div class='alert alert-success'>An email has been sent to $email. Please check on the link to reset password</div>";
}

?>