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
$username = $row['username'];
$email = $row['email'];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"content="IE=edge">
        <meta name="viewport"content="width=device-width, initial-scale=1">
        <title>Profile</title>

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

          tr{
            cursor: pointer;
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
              <li class="active"><a href="profile.php">Profile</a></li>
              <!--<li><a href="#">Help</a></li>-->
              <!--<li><a href="#">Contact Us</a></li>-->
              <li><a href="mainpageloggedin.php">My Notes</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#profile.php">Logged in as 
                <b>
                    <?php
                        echo $username;
                    ?>
                </b>
                </a></li>
                <li><a href="index.php?logout=1">Log out</a></li>
            </ul>

          </div>
        </div>
      </nav>

      <!-- Container -->
      <div class="container" id="container">
        <div class="row">
          <div class="col-md-offset-3 col-md-6">

            <h2>General Account Settings:</h2>

            <div class="table-responsive">
              <table class="table table-hover table-condensed table-bordered">
                <tr data-target="#updateusername" data-toggle="modal">
                  <td>Username</td>
                  <td>
                  <?php
                        echo $username;
                  ?>
                  </td>
                </tr>

                <tr data-target="#updateemail" data-toggle="modal">
                  <td>Email</td>
                  <td>
                  <?php
                        echo $email;
                  ?>
                  </td>
                </tr>

                <tr data-target="#updatepassword" data-toggle="modal">
                  <td>Password</td>
                  <td>hidden</td>
                </tr>

              </table>
            </div>

          </div>
        </div>
      </div>      
      
      <!-- Footer -->
      <div class="footer">
        <div class="container">
          <p>Zenia Gist Copyright&copy; 2020-
            <?php 
              $today = date("Y");
              echo $today;
            ?>
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
                
              <div id="updateUsernameMessage">
                <!-- Update Username message from PHP File -->
              </div>

                <div class="form-group">
                  <label for="username">Username:</label>
                  <input class="form-control" type="text" name="username" id="username" maxlength="30" value="<?php echo $_SESSION['username'];?>">
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
                
              <div id="updateEmailMessage">
                <!-- Update email message from PHP File -->
              </div>

                <div class="form-group">
                  <label for="email">Email:</label>
                  <input class="form-control" type="email" name="email" id="email" maxlength="50" value="<?php echo "$email";?>">
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
                
              <div id="updatePasswordMessage">
                <!-- Update Email message from PHP File -->
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
        <script src="profile/profile.js"></script>
    </body>
    
    </html>