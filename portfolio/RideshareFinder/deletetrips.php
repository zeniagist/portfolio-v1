<?php
//start session and connect
session_start();
include('connection.php');

$trip_id = $_POST["trip_id"];

$sql = "DELETE FROM carsharetrips WHERE trip_id='$trip_id'";
$result = mysqli_query($link, $sql);
    //check if query is successful
    if(!$results){
        echo '<div class=" alert alert-danger">error!</div>';        
    }
?>