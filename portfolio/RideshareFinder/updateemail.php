<?php
//Start session
session_start();

include('connection.php');

// get user_id and email sent through AJAX
$user_id = $_SESSION['user_id'];
$newemail = $_POST['email'];

// check if new email exists
$sql = "SELECT * FROM users WHERE email='$newemail'";
$result = mysqli_query($link, $sql);
    
    if(!$result){
        echo "<div class='alert alert-danger'>error when searching email from users table!</div>";
        exit;
    }
    
$count = mysqli_num_rows($result);
    
    if($count>0){
      echo "<div class='alert alert-danger'>There is already a user registered with that email. Please choose another one!</div>";
      exit;
    }

// get the current email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "error when selecting user_id from users table!";
}

$count = mysqli_num_rows($result);

if(!$count){
  echo "<div class='alert alert-danger'>Error when searching for user_id to update the email!</div>";
  exit;
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$email = $row['email'];

// create a unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

// insert new activation code in the users table
$sql = "UPDATE users SET email='$newemail' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
  echo '<div class="alert alert-danger">There was an error inserting the activation2 details in the database!</div>';
}else{
    echo "<div class='alert alert-success'>Thank you for updating your email!<br />You new login email is $newemail.<br />Please log out to see these changes.<br /></div>";
}
// send email to user with link to activatenewemail.php with current email, new email, and activation code
// $message = "Please click on this link to activate this email: \n\n";
// $message .= "Do not reply to this email \n\n";
// $message .= "http://zeniagist.com/projects/onlinenotesapp/activatenewemail.php?email=" . urlencode($email) . "&newemail=" . urlencode($newemail) . "&key=$activationKey";
// $emailSent = mail($newemail, 'Email update for your Online Notes App', $message, 'From:' . 'zeniagi1@zeniagist.com');

// if($emailSent){
//   echo "<div class='alert alert-success'>Thank you for registering!<br />A confirmation email has been sent to $newemail. Please check your spam folder and click on the activiation link to reset your email.<br /></div>";
// }
?>