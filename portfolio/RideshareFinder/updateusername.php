<?php
// start session and connect
session_start();
include("connection.php");

// get the user_id
$id = $_SESSION['user_id'];

// get username sent through AJAX
$username = $_POST['username'];

// Run query and update username
$sql = "UPDATE users SET username='$username' WHERE user_id='$id'";
$result = mysqli_query($link, $sql);

if(!$result){
    echo "<div class='alert alert-danger'>Error storing the new username in the database!</div>";
}
?>