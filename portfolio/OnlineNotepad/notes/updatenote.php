<?php
session_start();
include('connection.php');

// get the id of note sent through AJAX
$id = $_POST['id'];

// get the content of the note
$note = $_POST['note'];

// get time
$time = time();

// run a query to update the note
$sql = "UPDATE notes SET note='$note', time='$time' WHERE id='$id'";
$result = mysqli_query($link, $sql);

if(!$result){
    echo "erorr";
}

?>