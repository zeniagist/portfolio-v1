<?php
//Start session
session_start();
//Connect to the database
include("connection.php");

//Define error messages
$missingDeparture = '<p><strong>Please enter your departure!</strong></p>';
$invalidDeparture = '<p><strong>Please enter a valid departure location!</strong></p>';
$missingDestination = '<p><strong>Please enter your destination!</strong></p>';
$invalidDestination = '<p><strong>Please enter a valid destination location!</strong></p>';
$missingPrice = '<p><strong>Please enter the price per seat!</strong></p>';
$invalidPrice = '<p><strong>Please enter a valid price!</strong></p>';
$missingSeatsAvailable = '<p><strong>Please enter your how many seats are available for your trip!</strong></p>';
$missingFrequency = '<p><strong>Please select a trip frequency (Regular or One-off)!</strong></p>';
$missingDays = '<p><strong>Please select at least one weekday!</strong></p>';
$missingDate = '<p><strong>Please choose a date for your trip!</strong></p>';
$missingTime = '<p><strong>Please choose a time for your trip!</strong></p>';

// Get inputs
$departure = $_POST["departure"];
$destination = $_POST["destination"];
$price = $_POST["price"];
$seatsavailable = $_POST["seatsavailable"];
$regular = $_POST["regular"];
$date = $_POST["date"];
$time = $_POST["time"];
$monday = $_POST["monday"];
$tuesday = $_POST["tuesday"];
$wednesday = $_POST["wednesday"];
$thrusday = $_POST["thrusday"];
$friday = $_POST["friday"];
$saturday = $_POST["saturday"];
$sunday = $_POST["sunday"];


//Get departure
if(!$departure){
    $errors .= $missingDeparture;   
}else{
    // check coordinates
    if(!$_POST["departureLatitude"] OR !$_POST["departureLongitude"]){
        $errors .= $invalidDeparture;  
    }else{
        $departureLatitude = $_POST["departureLatitude"];
        $departureLongitude = $_POST["departureLongitude"];
        $departure = filter_var($departure, FILTER_SANITIZE_STRING);
    }
}

//Get destination
if(!$destination){
    $errors .= $missingDestination;   
}else{
    // check coordinates
    if(!$_POST["destinationLatitude"] OR !$_POST["destinationLatitude"]){
        $errors .= $invalidDestination;  
    }else{
        $destinationLatitude = $_POST["destinationLatitude"];
        $destinationLongitude = $_POST["destinationLongitude"];
        $destination = filter_var($destination, FILTER_SANITIZE_STRING);
    }
}

// Get Price
if(!$price){
    $errors .= $missingPrice; 
}elseif($price < 0){
    $errors .= $invalidPrice;
}else{
    $price = filter_var($price, FILTER_SANITIZE_STRING);
}

// Get Seats Available
if(!$seatsavailable){
    $errors .= $missingSeatsAvailable; 
}else{
    $seatsavailable = filter_var($seatsavailable, FILTER_SANITIZE_STRING);
}

// Get frequency
if(!$regular){
    $errors .= $missingFrequency; 
}elseif($regular == "Y"){//regular
    if(!$monday && !$tuesday && !$wednesday && !$thrusday && !$friday && !$saturday && !$sunday){
        $errors .= $missingDays;
    }
    if(!$time){
        $errors .= $missingTime;
    }
}else{//one-off
    if(!$date){
       $errors .= $missingDate; 
    }
    if(!$time){
        $errors .= $missingTime;
    }
}

//If there are any errors
if($errors){
    //print error message
    $resultMessage = '<div class="alert alert-danger">' . $errors .'</div>';
    echo $resultMessage;
    exit;
}
    //prepare variables to the query
    $departure = mysqli_real_escape_string($link, $departure);
    $destination = mysqli_real_escape_string($link, $destination);
    $tblName = 'carsharetrips';
    $user_id = $_SESSION['user_id'];
    
    if($regular == "Y"){
        // query for regular trip
        $sql = "INSERT INTO $tblName 
                (user_id, departure, departureLongitude, departureLatitude, destination, destinationLongitude, destinationLatitude, price, seatsavailable,
                regular, date, time, monday, tuesday, wednesday, thursday, friday, saturday, sunday)
                VALUES 
                ('$user_id', '$departure', '$departureLongitude', '$departureLatitude', '$destination', '$destinationLongitude', '$destinationLatitude', 
                '$price', '$seatsavailable', '$regular', '', '$time', '$monday', '$tuesday', '$wednesday', '$thrusday', '$friday', '$saturday', '$sunday')
                ";
        
    }else{
        // query for one-ff trip
        $sql = "INSERT INTO $tblName 
                (user_id, departure, departureLongitude, departureLatitude, destination, destinationLongitude, destinationLatitude, price, seatsavailable,
                regular, date, time, monday, tuesday, wednesday, thursday, friday, saturday, sunday)
                VALUES 
                ('$user_id', '$departure', '$departureLongitude', '$departureLatitude', '$destination', '$destinationLongitude', '$destinationLatitude', 
                '$price', '$seatsavailable', '$regular', '$date', '$time', '', '', '', '', '', '', '')
                ";
    }
    
    $result = mysqli_query($link, $sql);
    if(!$result){
      echo '<div class="alert alert-danger">Error running the query!</div>';
      exit;
    }
    $count = mysqli_num_rows($result);
    
    if($count){
      echo '<div class="alert alert-danger">There was an error! The trip could not be added to the database!</div>';
      exit;
    }