<?php
// This file receives the user_id and key generated to create the new password
// This file displays a form to input a new password
session_start();

include('connection.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Password Reset</title>  

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 

  <style>
    h1{
      color: purple;
    }
    .contactForm{
      border: 1px solid purple;
      margin-top: 50px;
      border-radius: 15px;
    }
  </style>

  </head>
  <body>
    <div class="container-fluid">
      
      <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactForm">
          <h1>Reset Password</h1>
          
          <div id="resultmessage"></div>

          <?php
          // if user_id or reset key is missing
          if(!$_GET['user_id'] || !$_GET['key']){
            echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email\n\nPlease check your spam folder.</div>';
            exit;
          }

          //Store them in two variables
          $user_id = $_GET['user_id'];
          $key = $_GET['key'];

          // define time variable: now minus 24 hours
          $time = time() - 86400;

          //Prepare variables for the query
          $user_id = mysqli_real_escape_string($link, $user_id);
          $key = mysqli_real_escape_string($link, $key);

          // Run query: check combination of user_id & key exists and less than 24 hour old
          $sql = "SELECT user_id FROM forgotpassword WHERE user_id='$user_id' AND time > '$time' AND status='pending'";
          $result = mysqli_query($link, $sql);

          if(!$result){
            echo '<div class="alert alert-danger">Error running the query!</div>';
            exit;
          }

          // if combination does not exist
          $count = mysqli_num_rows($result);

          if($count == 1){
              echo '<div class="alert alert-danger">Please try again!</div>';
              exit;
          }
          ?>
          
          <form method='post' id='passwordreset'>
            <input type='hidden' name='key' value='$key'>
            <input type='hidden' name='user_id' value='$user_id'>

            <div class='form-group'>
              <label for='password'>Enter your new Password</label>
              <input type='password' name='password' id='password' placeholder='Enter Password' class='form-control'>

              <label for='password2'>Re-enter Password</label>
              <input type='password' name='password2' id='password2' placeholder='Re-enter Password' class='form-control'>

              <input type='submit' name='resetpassword' class='btn btn-lg btn-success' value='Reset Password'>

            </div>
          </form>
          
        </div>
      </div>
    </div>
    
    <!-- script for AJAX Call to storeresetpassword.php -->
    <script>
      $("#passwordreset").submit(function(event){
        //prevent default php processing
        event.preventDefault();

        //collect user inputs
        var datatopost = $(this).serializeArray();

        //send them to forgotpassword.php using AJAX
        $.ajax({
          url: "storeresetpassword.php",
          type: "POST",
          data: datatopost,
          // AJAX Call successful
          success: function(data){
            $('#resultmessage').html(data);
          },
          // AJAX Call fails: show error AJAX Call error
          error: function(){
            $("#resultmessage").html("<div class='alert alert-danger'>There was an error with the AJAX Call. Please try again later</div>");
          }
        });
      });  
    </script>
    
  </body>
</html>