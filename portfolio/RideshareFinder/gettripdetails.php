<?php
//start session and connect
session_start();
include('connection.php');

// get trip_id
$trip_id = $_POST['trip_id'];
$sql="SELECT * FROM carsharetrips WHERE trip_id='$trip_id'"; 
$result = mysqli_query($link, $sql);

if(!$result){
    echo 'error';
}else{
    
    $row = mysqli_fetch_array($result);
    
    // Get values from table
    $array = array(
        "trip_id"=>$row['trip_id'], "departure"=>$row['departure'], "destination"=>$row['destination'], "price"=>$row['price'], 
        "seatsavailable"=>$row['seatsavailable'], "regular"=>$row['regular'], "date"=>$row['date'], "time"=>$row['time'], 
        "monday"=>$row['monday'], "tuesday"=>$row['tuesday'], "wednesday"=>$row['wednesday'], "thursday"=>$row['thursday'], 
        "friday"=>$row['friday'], "saturday"=>$row['saturday'], "sunday"=>$row['sunday']
    );
    // print
    echo json_encode($array);
}
?>