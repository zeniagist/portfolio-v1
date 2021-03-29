<?php
session_start();

if(!$_SESSION['user_id']) {
 header('Location: index.php');
 exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"content="IE=edge">
        <meta name="viewport"content="width=device-width, initial-scale=1">
        <title>Contact Us</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 

        <link href="styling.css" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">

        <style>
          #container{
            margin-top:100px;
          }
          textarea{
            width: 100%;
            max-width: 100%;
            min-width: 100%;
            font-size: 16px;
            line-height: 1.5em;
          }
        </style>

    </head>
    
    <body>
      <!-- Navigation Bar -->
      <nav rule="navigation" class="navbar navbar-custom navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <a href="mainpageloggedin.php" class="navbar-brand">Online Notes</a>

            <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
              <span class="sr-only">Toggle Navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>            
          </div>

          <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="nav navbar-nav">
              <li><a href="profile.php">Profile</a></li>
              <li><a href="#">Help</a></li>
              <li class="active"><a href="contactus.php">Contact Us</a></li>
              <li><a href="mainpageloggedin.php">My Notes</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Logged in as a <b>user</b></a></li>
                <li><a href="index.php?logout=1">Log out</a></li>
            </ul>

          </div>
        </div>
      </nav>

      <!-- Container -->
      <div class="container" id="container">
        <div class="row">
          <div class="col-md-offset-3 col-md-6">

            <h2>Contact Us:</h2>
            <aside>
               <p>
                   We would <em>love</em> to hear from you! </p>
                   <p>Please use the <b><em>Contact Form</em></b>
                   to send us a message.
               </p>
           </aside>
           
           <div><br /></div>
           
            <form id="contact-form" name="contact-form" action="mail.php" method="POST">
                <div class="row">
    
                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <label for="name" class="">Your name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    <!--Grid column-->
    
                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <label for="email" class="">Your email</label>
                            <input type="text" id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <!--Grid column-->
    
                </div>
                <!--Grid row-->
    
                <!--Grid row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <label for="subject" class="">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-control">
                        </div>
                    </div>
                </div>
                <!--Grid row-->
    
                <!--Grid row-->
                <div class="row">
    
                    <!--Grid column-->
                    <div class="col-md-12">
    
                        <div class="md-form">
                            <label for="message">Your message</label>
                            <textarea type="text" id="message" name="message" rows="10"></textarea>
                        </div>
    
                    </div>
                </div>
            </form>
            
            <a class="btn btn-primary" onclick="validateForm();">Send</a>
            
          </div>
        </div>
      </div>      
      
      <!-- Footer -->
      <div class="footer">
        <div class="container">
          <p>Zenia Gist Copyright&copy; 2020-
            <!-- <?php 
              $today = date("Y");
              echo $today;
            ?> -->
          .</p>
        </div>
      </div>

      <!-- Update username -->
      <form method="post" id="updateusernameform">
        <div class="modal" id="updateusername" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="myModalLabel">Edit Username:</h4>
              </div>

              <div class="modal-body">
                
              <div id="loginMessage">
                <!-- Login message from PHP File -->
              </div>

                <div class="form-group">
                  <label for="username">Username:</label>
                  <input class="form-control" type="text" name="username" id="username" maxlength="30" value="username value">
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

      <!-- Update email -->
      <form method="post" id="updateemailform">
        <div class="modal" id="updateemail" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="myModalLabel">Enter new email:</h4>
              </div>

              <div class="modal-body">
                
              <div id="loginMessage">
                <!-- Login message from PHP File -->
              </div>

                <div class="form-group">
                  <label for="email">Email:</label>
                  <input class="form-control" type="email" name="email" id="email" maxlength="50" value="email value">
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

      <!-- Update password -->
      <form method="post" id="updatepasswordform">
        <div class="modal" id="updatepassword" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="myModalLabel">Enter Current and New Password:</h4>
              </div>

              <div class="modal-body">
                
              <div id="loginMessage">
                <!-- Login message from PHP File -->
              </div>

                <div class="form-group">
                  <label for="currentpassword" class="sr-only">Your Current Password:</label>
                  <input class="form-control" type="password" name="currentpassword" id="currentpassword" maxlength="30" placeholder="Your Current Password">
                </div>

                <div class="form-group">
                  <label for="password" class="sr-only">Choose a Password:</label>
                  <input class="form-control" type="password" name="password" id="password" maxlength="30" placeholder="Choose a Password">
                </div>

                <div class="form-group">
                  <label for="password2" class="sr-only">Confirm Password:</label>
                  <input class="form-control" type="password" name="password2" id="password2" maxlength="30" placeholder="Confirm Password">
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
    </body>
    
    <script>
        function validateForm() {
  var name =  document.getElementById('name').value;
  if (name == "") {
      document.querySelector('.status').innerHTML = "Name cannot be empty";
      return false;
  }
  var email =  document.getElementById('email').value;
  if (email == "") {
      document.querySelector('.status').innerHTML = "Email cannot be empty";
      return false;
  } else {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if(!re.test(email)){
          document.querySelector('.status').innerHTML = "Email format invalid";
          return false;
      }
  }
  var subject =  document.getElementById('subject').value;
  if (subject == "") {
      document.querySelector('.status').innerHTML = "Subject cannot be empty";
      return false;
  }
  var message =  document.getElementById('message').value;
  if (message == "") {
      document.querySelector('.status').innerHTML = "Message cannot be empty";
      return false;
  }
  document.querySelector('.status').innerHTML = "Sending...";
}
    </script>
    </html>