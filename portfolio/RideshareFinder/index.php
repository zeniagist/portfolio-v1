<?php
//Start session
session_start();

//Connect to the database
include("connection.php");

//logout
include("logout.php");

// rememberme
//include("rememberme.php");
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
        
        <!-- Favicon-->
        <link rel="shortcut icon" href="favicon.ico">
        
        <style>
            /*Container*/
            #myContainer{
                margin-top: 50px;
                text-align: center;
                color: white;
            }
            
            #departure, #destination{
                color: black;
            }
            
            #searchBtn{
                margin-top: 20px;
            }
            
            #signup{
                margin: 30px auto;
            }
            
            .signupButton{
                color: white;
            }
            
            /*Search Query*/
            h1{
                font-size: 4em;
            }
            
            .btn{
                border: none;
            }
        </style>

    </head>
    
    <body>
        <!-- Navigation Bar -->
        <nav rule="navigation" class="navbar navbar-default navbar-fixed-top" id="custom-bootstrap-menu">
            <div class="container-fluid">
              <div class="navbar-header">
                <a href="index.php" class="navbar-brand">Rideshare Finder</a>
            
                <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                  <span class="sr-only">Toggle Navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>            
              </div>
            
              <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="nav navbar-nav">
                  <!--<li class="active"><a href="index.php">Home</a></li>-->
                  <!--<li><a href="#">Help</a></li>-->
                  <!--<li><a href="#">Contact Us</a></li>-->
                </ul>
            
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="#loginModal" data-toggle="modal">Login</a></li>
                </ul>
            
              </div>
            </div>
        </nav>
    
        <!--Container-->
        <div class="container-fluid" id="myContainer">
            <div class="row">
                <div class="col-lg-6 col-md-offset-3">
                    <h1>Plan Your Next Trip Now</h1>
                    <p class="lead">Save Money! Save the Environment!</p>
                    
                    <!--Search Form-->
                    <form class="form-inline" method="get" id="searchForm">
                        <div class="form-group">
                            <!--Departure-->
                            <!--<label for="departure" class="sr-only">Departure</label>-->
                            <!--<input type="text" placeholder="Departure" name="departure" id="departure">-->
                            
                            <!--Destination-->
                            <!--<label for="destination" class="sr-only">Destination</label>-->
                            <!--<input type="text" placeholder="Destination" name="destination" id="destination">-->
                        </div>
                        
                        <!--Search Button-->
                        <!--<input type="submit" value="Search" class="btn btn-lg purple" name="search" id="searchBtn">-->
                    </form>
                    
                    <!--Google Map-->
                    <div id="googleMap"></div>
                    
                    <!--Sign up button-->
                    <button class="btn btn-lg purple signupButton" id="signup"data-toggle="modal" data-target="#signupModal">Sign up-It's free!</button>
                    
                    <!--Trips Search-->
                    <!--<div id="searchResults2"></div>-->
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

      <!-- Login Form -->
      <form method="post" id="loginform">
        <div class="modal" id="loginModal" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="myModalLabel">Login:</h4>
                <p style="color:red;">
                    <!--<strong>-->
                    <!--    Email: username@test.com<br />-->
                    <!--    Password: Password123<br />-->
                    <!--    <php?echo hash('sha256', Password123);?>-->
                    <!--</strong>-->
                </p>
              </div>

              <div class="modal-body">
                
              <div id="loginMessage">
                <!-- Login message from PHP File -->
              </div>

                <div class="form-group">
                  <label for="loginemail" class="sr-only">Email:</label>
                  <input class="form-control" type="email" name="loginemail" id="loginemail" placeholder="Email" maxlength="50">
                </div>

                <div class="form-group">
                  <label for="loginpassword" class="sr-only">Password:</label>
                  <input class="form-control" type="password" name="loginpassword" id="loginpassword" placeholder="Password" maxlength="30">
                </div>

                <!--<div class="checkbox">-->
                <!--  <label>-->
                <!--    <input type="checkbox" name="rememberme" id="rememberme">-->
                <!--    Remember me-->
                <!--  </label>-->
                <!-- </div>-->
                
                <div>
                  <a class="pull-right" style="cursor: pointer" data-dismiss="modal" data-target="#forgotpasswordModal" data-toggle="modal">
                    Forgot Password?
                  </a>
                  
                  <br />

                </div>
              </div>

              <div class="modal-footer">                
                <input class="btn purple" name="login" type="submit" value="Login">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
              </div>

            </div>
          </div>
        </div>
      </form>

      <!-- Sign up form -->
      <form method="post" id="signupform">
        <div class="modal" id="signupModal" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="myModalLabel">Sign up today and start using Rideshare Finder!</h4>
                <!--<p style="color:red;">-->
                <!--    <strong>-->
                <!--        If you wish to log in without registering, please use login credentials provided in the Login Modal.-->
                <!--    </strong>-->
                <!--</p>-->
              </div>

              <div class="modal-body">
                
              <div id="signupmessage">
                <!-- Sign up message from PHP File -->
              </div>

                <div class="form-group">
                  <label for="username" class="sr-only">Username:</label>
                  <input class="form-control" type="text" name="username" id="username" placeholder="Username" maxlength="30">
                </div>
                
                <div class="form-group">
                  <label for="firstname" class="sr-only">First Name:</label>
                  <input class="form-control" type="text" name="firstname" id="firstname" placeholder="First Name" maxlength="30">
                </div>
                
                <div class="form-group">
                  <label for="lastname" class="sr-only">Last Name:</label>
                  <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Last Name" maxlength="30">
                </div>

                <div class="form-group">
                  <label for="email" class="sr-only">Email Address:</label>
                  <input class="form-control" type="email" name="email" id="email" placeholder="Email Address" maxlength="50">
                </div>

                <div class="form-group">
                  <label for="password" class="sr-only">Choose a Password:</label>
                  <input class="form-control" type="password" name="password" id="password" placeholder="Choose a Password" maxlength="30">
                </div>

                <div class="form-group">
                  <label for="password2" class="sr-only">Confirm Password:</label>
                  <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm Password" maxlength="30">
                </div>
                
                <div class="form-group">
                  <label for="phonenumber" class="sr-only">Telephone Number:</label>
                  <input class="form-control" type="text" name="phonenumber" id="phonenumber" placeholder="Telephone Number" maxlength="30">
                </div>
                
                <div class="form-group">
                  <label>
                      <input type="radio" name="gender" id="male">
                      Male
                  </label>
                  <label>
                      <input type="radio" name="gender" id="female">
                      Female
                  </label>
                </div>
                
                <div class="form-group">
                    <label for="moreinformation">Comments:</label>
                    <textarea name="moreinformation" id="moreinformation" class="form-control" rows="5" maxlength="300"></textarea>
                </div>
                
              </div>

              <div class="modal-footer">
                <input class="btn purple signupButton" name="signup" type="submit" value="Sign Up">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>

            </div>
          </div>
        </div>
      </form>

      <!-- Forgot password form -->
      <form method="post" id="forgotpasswordform">
        <div class="modal" id="forgotpasswordModal" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="myModalLabel">Forgot Password? Enter your Email Address.</h4>
              </div>

              <div class="modal-body">
                
              <div id="forgotpasswordmessage">
                <!-- Forgot Password message from PHP File -->
              </div>
                <div class="form-group">
                  <label for="forgotemail" class="sr-only">Email:</label>
                  <input class="form-control" type="email" name="forgotemail" id="forgotemail" placeholder="Email" maxlength="50">
                </div>

              <div class="modal-footer">                
                <input class="btn purple" name="forgotpassword" type="submit" value="Submit">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
              </div>

            </div>
          </div>
        </div>
      </form>     
    
                    
    <!--Google Map API-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFLMFaU5ZWKX-DheNPBrL1yE_ZVQmBvjo&libraries=places"></script>
      <script src="javascript.js"></script>
      <script src="map.js"></script>
    </body>
    
    </html>