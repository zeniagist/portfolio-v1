<?php
    // <!--Connect to the database-->
    $link = mysqli_connect("localhost", "zeniagi1_rideshare", "Eiffeltower10", "zeniagi1_rideshare");

    if(mysqli_connect_error()){
        die("ERROR: Unable to connect: " . mysqli_connect_error());
    }
?>