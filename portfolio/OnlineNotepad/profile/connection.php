<?php
    // <!--Connect to the database-->
    $link = mysqli_connect("localhost", "zeniagi1_onlinenotes", "Eiffeltower10", "zeniagi1_onlinenotes");

    if(mysqli_connect_error()){
        die("ERROR: Unable to connect: " . mysqli_connect_error());
    }
?>