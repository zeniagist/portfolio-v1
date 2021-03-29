<?php
session_start();

if(!$_SESSION['user_id']) {
 header('Location: index.php');
 exit;
}

include('connection.php');

$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "error when selecting user_id from users table!";
}

$count = mysqli_num_rows($result);

if(!$count){
  echo '<div class="alert alert-danger">Error</div>';
  exit;
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$picture = $row['profilepicture'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"content="IE=edge">
        <meta name="viewport"content="width=device-width, initial-scale=1">
        <title>My Trips</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 

        <link href="styling.css" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">
        
        <!--jQuery UI-->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/dark-hive/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        
        <!-- Favicon-->
        <link rel="shortcut icon" href="favicon.ico">
        
        <style>
          #container{
            margin-top:120px;
          }
          
            .preview{
              height: 30px;
              border-radius: 50%;
            }
            
            .preview2{
              height: auto;
              max-width: 100%;
              border-radius: 50%;
            }
            
            .edittripsbutton{
                display: none;
            }
            
            /*Show autocomplete for cities*/
            .modal{
                z-index: 20;
                margin-top:50px;
            }
            
            .modal-backdrop{
                z-index: 10;
            }
            
            .days{
                padding-right: 15px;
            }
            
            .time{
                margin-top:10px;
            }
            /*Map*/
            /*#googleMap{*/
            /*    width: 300px;*/
            /*    height: 200px;*/
            /*    margin: 30px auto;*/
            /*}*/
            
            /*Trips*/
            .trip{
                border:1px solid grey;
                border-radius: 10px;
                margin-bottom:10px;
                background: linear-gradient(#ECE9E6, #FFFFFF);
                padding: 10px;
            }
            .departure, .destination, .price{
                font-size:1.5em;
            } 
            .price{
               text-align:right; 
            }
            .perseat{
                font-size:0.5em;
                text-align:right;
            }
            .seatsavailable{
                font-size:0.8em;
                text-align:right;
            }
            .time{
                margin-top:10px;  
            }  
            .notrips{
            text-align:center;
            }
            .trips{
                margin-top: 20px;
            }
          #mytrips{
            margin-bottom: 100px;   
          }
            
        </style>

    </head>
    
    <body>
      <!-- Navigation Bar -->
      <nav rule="navigation" class="navbar navbar-default navbar-fixed-top" id="custom-bootstrap-menu">
        <div class="container-fluid">
          <div class="navbar-header">
            <a href="mainpageloggedin.php" class="navbar-brand">Rideshare Finder</a>

            <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
              <span class="sr-only">Toggle Navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>            
          </div>

          <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="nav navbar-nav">
              <li><a href="search.php">Search</a></li>
              <li><a href="profile.php">Profile</a></li>
              <!--<li><a href="#">Help</a></li>-->
              <!--<li><a href="contactus.php">Contact Us</a></li>-->
              <li class="active"><a href="mainpageloggedin.php">My Trips</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#">
                        <div data-toggle="modal" data-target="#updatepicture">
                            <!--<img src='https://cdn.pixabay.com/photo/2017/01/06/05/28/car-1957037_960_720.jpg' class='preview'>-->
                            <?php
                            if(!file_exists($picture) || $picture == ''){
                                echo "<img src='https://cdn.pixabay.com/photo/2017/01/06/05/28/car-1957037_960_720.jpg' class='preview'>";
                            }else{
                                echo "<img src='$picture' class='preview'>";
                            }
                            ?>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="profile.php"> 
                    <?php
                        echo $_SESSION['username'];
                    ?>
                    </a>
                </li>
                <li><a href="index.php?logout=1">Log out</a></li>
            </ul>

          </div>
        </div>
      </nav>
      
      <!-- Update profile picture -->
      <form method="post" id="updatepictureform" enctype="multipart/form-data">
        <div class="modal" id="updatepicture" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="myModalLabel">Upload Picture:</h4>
              </div>

              <div class="modal-body">
                
              <div id="updatePictureMessage">
                <!-- Update Username message from PHP File -->
              </div>
              
              <!--Profile Picture-->
              <div>
                <?php
                if(!file_exists($picture) || $picture == '' ){
                    echo "<img src='https://cdn.pixabay.com/photo/2017/01/06/05/28/car-1957037_960_720.jpg' class='preview2' id='preview2'>";
                }else{
                    echo "<img src='$picture' class='preview2' id='preview2'>";
                }
                ?>
              </div>

                <div class="form-group">
                  <label for="picture">Select a Picture:</label>
                  <input type="file" name="picture" id="picture">
                </div>

              </div>

              <div class="modal-footer">                
                <input class="btn purple" name="updateusername" type="submit" value="Submit">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>

            </div>
          </div>
        </div>
      </form>

      <!-- Container -->
      <div class="container" id="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div>
                    <button type="button" class="btn btn-lg purple" data-toggle="modal" data-target="#addtripModal">
                        Add Trips
                    </button>
                    
                    <button type="button" class="btn btn-lg purple edittripsbutton" data-toggle="modal" data-target="#edittripModal">
                        Edit Trips
                    </button>
                </div>
                <div id="myTrips" class="trips">
                    <!--AJAX Call to PHP File-->
                </div>
            </div>
        </div>
      </div>
      
      <!-- Add Trip form -->
        <form method="post" id="addtripform">
            <div class="modal" id="addtripModal" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
            
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">New Trip:</h4>
                    </div>
                    
                    <div class="modal-body">
                    
                    <div id="addtripmessage">
                        <!-- Add trip message from PHP File -->
                    </div>
                    
                    <!--Google Map-->
                    <div id="googleMap"></div>
                    
                    <!--Input Boxes-->
                    <div class="form-group">
                      <label for="departure" class="sr-only">Departure:</label>
                      <input class="form-control" type="text" name="departure" id="departure" placeholder="Departure">
                    </div>
                    
                    <div class="form-group">
                      <label for="destination" class="sr-only">Destination:</label>
                      <input class="form-control" type="text" name="destination" id="destination" placeholder="Destination">
                    </div>
                    
                    <div class="form-group">
                      <label for="price" class="sr-only">Price:</label>
                      <input class="form-control" type="number" name="price" id="price" placeholder="Price">
                    </div>
                    
                    <div class="form-group">
                      <label for="seatsavailable" class="sr-only">Seats Available:</label>
                      <input class="form-control" type="number" name="seatsavailable" id="seatsavailable" placeholder="Seats Available">
                    </div>
                    
                    <!--Radios-->
                    <div class="form-group">
                      <label>
                          <input type="radio" name="regular" id="yes" value="Y">
                          Regular Commute
                      </label>
                      <label>
                          <input type="radio" name="regular" id="no" value="N">
                          One-off
                      </label>
                    </div>
                    
                    <!--Checkboxes-->
                    <div class="checkbox checkbox-inline regular">
                        <label>
                          <input type="checkbox" name="monday" id="monday" value="1">
                          Monday
                        </label>
                        <label>
                          <input type="checkbox" name="tuesday" id="tuesday" value="2">
                          Tuesday
                        </label>
                        <label>
                          <input type="checkbox" name="wednesday" id="wednesday" value="3">
                          Wednesday
                        </label>
                        <label>
                          <input type="checkbox" name="thursday" id="thursday" value="4">
                          Thrusday
                        </label>
                        <label>
                          <input type="checkbox" name="friday" id="friday" value="5">
                          Friday
                        </label>
                        <label>
                          <input type="checkbox" name="saturday" id="saturday" value="6">
                          Saturday
                        </label>
                        <label>
                          <input type="checkbox" name="sunday" id="sunday" value="7">
                          Sunday
                        </label>
                    </div>
                    
                    <!--Date-->
                    <div class="form-group oneoff">
                      <label for="date" class="sr-only">Date:</label>
                      <input class="form-control" name="date" id="date" readonly="readonly">
                    </div>
                    
                    <!--Time for Regular-->
                    <div class="form-group regular oneoff time">
                      <label for="time" class="sr-only">Time:</label>
                      <input class="form-control" type="time" name="time" id="time">
                    </div>
                    
                    <!--End-->
                  </div>
            
                  <div class="modal-footer">
                    <input class="btn purple addtripButton" name="createtrip" type="submit" value="Create Trip">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
            
                </div>
              </div>
            </div>
        </form>
        
        <!-- Edit Trip form -->
        <form method="post" id="edittripform">
            <div class="modal" id="edittripModal" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
            
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Edit Trip:</h4>
                    </div>
                    
                    <div class="modal-body">
                    
                    <div id="edittripmessage">
                        <!-- Add trip message from PHP File -->
                    </div>
                    
                    <!--Input Boxes-->
                    <div class="form-group">
                      <label for="departure2" class="sr-only">Departure:</label>
                      <input class="form-control" type="text" name="departure2" id="departure2" placeholder="Departure">
                    </div>
                    
                    <div class="form-group">
                      <label for="destination2" class="sr-only">Destination:</label>
                      <input class="form-control" type="text" name="destination2" id="destination2" placeholder="Destination">
                    </div>
                    
                    <div class="form-group">
                      <label for="price2" class="sr-only">Price:</label>
                      <input class="form-control" type="number" name="price2" id="price2" placeholder="Price">
                    </div>
                    
                    <div class="form-group">
                      <label for="seatsavailable2" class="sr-only">Seats Available:</label>
                      <input class="form-control" type="number" name="seatsavailable2" id="seatsavailable2" placeholder="Seats Available">
                    </div>
                    
                    <!--Radios-->
                    <div class="form-group">
                      <label>
                          <input type="radio" name="regular2" id="yes2" value="Y">
                          Regular Commute
                      </label>
                      <label>
                          <input type="radio" name="regular2" id="no2" value="N">
                          One-off
                      </label>
                    </div>
                    
                    <!--Checkboxes-->
                    <div class="checkbox checkbox-inline regular2">
                        <label>
                          <input type="checkbox" name="monday2" id="monday2" value="1">
                          Monday
                        </label>
                        <label>
                          <input type="checkbox" name="tuesday2" id="tuesday2" value="2">
                          Tuesday
                        </label>
                        <label>
                          <input type="checkbox" name="wednesday2" id="wednesday2" value="3">
                          Wednesday
                        </label>
                        <label>
                          <input type="checkbox" name="thursday2" id="thursday2" value="4">
                          Thrusday
                        </label>
                        <label>
                          <input type="checkbox" name="friday2" id="friday2" value="5">
                          Friday
                        </label>
                        <label>
                          <input type="checkbox" name="saturday2" id="saturday2" value="6">
                          Saturday
                        </label>
                        <label>
                          <input type="checkbox" name="sunday2" id="sunday2" value="7">
                          Sunday
                        </label>
                    </div>
                    
                    <!--Date-->
                    <div class="form-group oneoff2">
                      <label for="date2" class="sr-only">Date:</label>
                      <input class="form-control" name="date2" id="date2" readonly="readonly">
                    </div>
                    
                    <!--Time for Regular-->
                    <div class="form-group regular2 oneoff2 time">
                      <label for="time2" class="sr-only">Time:</label>
                      <input class="form-control" type="time" name="time2" id="time2">
                    </div>
                    
                    <!--End-->
                  </div>
            
                  <div class="modal-footer">
                    <input class="btn purple addtripButton" name="updatetrip" type="submit" value="Edit Trip">
                    <input class="btn btn-danger" name="deletetrip" value="Delete" id="deletetrip" type="button">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
            
                </div>
              </div>
            </div>
        </form>
        
        <!-- Footer -->
        <div class="footer">
            <div class="container">
              <p>Zenia Gist Copyright&copy; 2020 -
                <?php 
                  $today = date("Y");
                  echo $today;
                ?>
              .</p>
            </div>
        </div>
        
        <!--Spinner-->
        <div id="spinner">
          <img src="spinner.gif" width='64' height='64'>
          <br /> 
          Loading
        </div>
        <!--Google Map API-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFLMFaU5ZWKX-DheNPBrL1yE_ZVQmBvjo&libraries=places"></script>
        
        <script src="javascript.js"></script>
        <script src="map.js"></script>
        <script src="mytrips.js"></script>
        <script src="profile.js"></script>
    </body>
    
    </html>