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
        <title>My Notes</title>

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
            margin-top:120px;
          }

          #allNotes, #done, #notepad, .delete{
            display: none;
          }

          .buttons{
            margin-bottom: 20px;
          }

          textarea{
            width: 100%;
            max-width: 100%;
            min-width: 100%;
            font-size: 16px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color: #B2C0B9;
            color: #B2C0B9;
            background-color: #FBEFFF;
            padding: 10px;
          }
          
          .noteheader{
              border: 1px solid grey;
              border-radius: 10px;
              margin-bottom: 10px;
              cursor: pointer;
              padding: 0 10px;
              background: linear-gradient(#FFFFFF, #ECEAE7);
          }
          
          .text{
              font-size: 20px;
              overflow: hidden;
              white-space: nowrap;
              text-overflow: ellipsis;
          }
          
          .timetext{
              overflow: hidden;
              white-space: nowrap;
              text-overflow: ellipsis;
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
              <!--<li><a href="#">Help</a></li>-->
              <!--<li><a href="contactus.php">Contact Us</a></li>-->
              <li class="active"><a href="mainpageloggedin.php">My Notes</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#profile.php">Logged in as 
                <b>
                    <?php
                        echo $_SESSION['username'];
                    ?>
                </b></a></li>
                <li><a href="index.php?logout=1">Log out</a></li>
            </ul>

          </div>
        </div>
      </nav>
      
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

      <!-- Container -->
      <div class="container" id="container">
        <!--Alert Message-->
        <div id="alert" class="alert alert-danger collapse">
            <a class="close" data-dismiss="alert">
                &times;
            </a>
            <p id="alertContent"></p>
        </div>
        <div class="row">
          <div class="col-md-offset-3 col-md-6">

            <!-- Buttons -->
            <div class="buttons">
              <button id="addNote" type="button" class="btn btn-info btn-lg">Add Note</button>
              <button id="edit" type="button" class="btn btn-info btn-lg pull-right">Edit</button>
              <button id="done" type="button" class="btn purple btn-lg pull-right">Done</button>
              <button id="allNotes" type="button" class="btn btn-info btn-lg">All Notes</button>
            </div>

            <div id="notepad">
              <textarea rows="10"></textarea>
            </div>

            <div id="notes" class="notes">
              <!-- Ajax call to a php file-->
            </div>

          </div>
        </div>
      </div>
    
    <script src="notes/mynotes.js"></script>
    </body>
    
    </html>