<?php
//Start session
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
        <title>Rideshare Finder</title>

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
            /*Container*/
            .searchintro{
                margin-top: 50px;
                text-align: center;
                color: white;
                
            }
            
            /*Profile Picture*/
            .preview{
              height: 30px;
              border-radius: 50%;
            }
            
            .preview2{
              height: auto;
              max-width: 100%;
              border-radius: 50%;
            }
            
            /*Search Query*/
            h1{
                font-size: 4em;
            }
            
            .btn{
                border: none;
            }
            
            #departure, #destination{
                color: black;
            }
            
            /*Search Results*/
            #message{
                margin-top:20px;
                background-color: rgba(20, 20, 20, 0.5);
                color: rgba(255, 255, 255, 1);
            }
            #searchResults{
                margin-bottom: 100px;
                margin-top: 20px;
            }
            .noresults, .resultsFound{
                text-align: center;
                background-color: rgba(99,44,33, 0.8);
                color: white;
                font-size: 1.5em
            }
            .journey{
                text-align:left; 
            }
            .driver{
                font-size:1.5em;
                text-transform:capitalize;
                text-align: center;
            }
            .previewing{
                max-width: 100%;
                height: auto;
                border-radius: 50%;
            }
            .departure, .destination{
                font-size:1.5em;
            }
            .time{
                margin-top:10px;  
            }
            .price{
                font-size:1.5em;
            }
            .journey2{
                text-align:right; 
            }
            .perseat{
                font-size:0.5em;
            }
            .seatsavailable{
                  font-size:0.7em; 
                  margin-top:5px;
            }
            .moreinfo{
                text-align:left; 
            }
            .aboutme{
                  border-top:1px solid grey;
                  margin-top:15px;
                  padding-top:5px;
            }
            .telephone{
                margin-top:10px;
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
              <li class="active"><a href="search.php">Search</a></li>
              <li><a href="profile.php">Profile</a></li>
              <!--<li><a href="#">Help</a></li>-->
              <!--<li><a href="contactus.php">Contact Us</a></li>-->
              <li><a href="mainpageloggedin.php">My Trips</a></li>
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
                    echo "<img src='$picture' class='preview2' id='preview2' class='responsive'>";
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
    
        <!--Container-->
        <div class="container-fluid" id="myContainer">
            <div class="row">
                <div class="col-lg-6 col-md-offset-3 searchintro">
                    <h1>Plan Your Next Trip Now</h1>
                    <p class="lead">Save Money! Save the Environment!</p>
                    
                    <!--Search Form-->
                    <form class="form-inline" method="get" id="searchForm">
                        <div class="form-group">
                            <!--Departure-->
                            <label for="departure" class="sr-only">Departure</label>
                            <input type="text" placeholder="Departure" name="departure" id="departure">
                            
                            <!--Destination-->
                            <label for="destination" class="sr-only">Destination</label>
                            <input type="text" placeholder="Destination" name="destination" id="destination">
                        </div>
                        <!--Search Button-->
                    <input type="submit" value="Search" class="btn btn-lg purple" name="search">
                    </form>
                    
                    
                    <!--Google Map-->
                    <div id="googleMap"></div>
                    
                    <!--Trips Search-->
                    <div id="searchResults"></div>
                </div>
            </div>
        </div>

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
      <script src="profile.js"></script>
    </body>
    
    </html>