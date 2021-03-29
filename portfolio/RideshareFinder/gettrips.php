<?php
//start session and connect
session_start();
include('connection.php');

//retrieve all trips
$sql="SELECT * FROM carsharetrips WHERE user_id='".$_SESSION['user_id']."'";

if($result = mysqli_query($link, $sql)){
    //print_r($result);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            //check frequency
            if($row['regular']=="N"){
                $frequency = "One-off journey";
                $time = $row['date']." at " .$row['time'];
            }else{
                $frequency = "Regular Journey"; 
                $array = [];
                    if($row['monday']==1){array_push($array,"Mon");}
                    if($row['tuesday']==2){array_push($array,"Tue");}
                    if($row['wednesday']==3){array_push($array,"Wed");}
                    if($row['thursday']==4){array_push($array,"Thu");}
                    if($row['friday']==5){array_push($array,"Fri");}
                    if($row['saturday']==6){array_push($array,"Sat");}
                    if($row['sunday']==7){array_push($array,"Sun");}
                $time = implode("-", $array)." at " .$row['time'];
            }
            $departure = $row['departure'];
            $destination = $row['destination'];
            $price = $row['price'];
            $seatsavailable = $row['seatsavailable'];
            $trip_id = $row['trip_id'];
            
            echo 
             '<div class="row trip">
                    <div class="col-sm-8 journey">
                        <div><span class="departure">Departure:</span> '.$departure.'.</div>
                        <div><span class="destination">Destination:</span> '. $destination .'.</div>
                        <div class="time">'.$time.'</div>
                        <div>'.$frequency.'</div>
                    </div>
                    <div class="col-sm-2 price">
                        <div class="price">$'.$price.'</div>
                        <div class="perseat">Per Seat</div>
                        <div class="seatsavailable">'.$seatsavailable.' left</div>
                    </div>
                    <div class="col-sm-2">
                        <button class= "btn purple edit btn-lg" data-target="#edittripModal" data-toggle="modal" data-trip_id="'.$trip_id.'">Edit</button>
                    </div>
                </div>';
        }
    }else{
        echo '<div class="notrips alert alert-warning" style="font-size:1.5em;">
                <strong>Start an adventure. Share your Rideshare or 
                <a href="search.php">Search</a> 
                for a new journey!</strong>
                </div>';
    }
}
?>