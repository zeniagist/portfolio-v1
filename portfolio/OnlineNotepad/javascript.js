//Ajax Call for the sign up form 
//Once the form is submitted
$("#signupform").submit(function(event){
  //prevent default php processing
  event.preventDefault();

  //collect user inputs
  var datatopost = $(this).serializeArray();
  // console.log(datatopost);

  //send them to signup.php using AJAX
  $.ajax({
    url: "signup.php",
    type: "POST",
    data: datatopost,
    // AJAX Call successful
    success: function(data){
      if(data){
        $("#signupmessage").html(data);
      }
    },
    // AJAX Call fails: show error AJAX Call error
    error: function(){
      $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the AJAX Call. Please try again later</div>");
    }
  });
});

// AJAX Call for the login form
$("#loginform").submit(function(event){
  //prevent default php processing
  event.preventDefault();

  //collect user inputs
  var datatopost = $(this).serializeArray();

  //send them to login.php using AJAX
  $.ajax({
    url: "login.php",
    type: "POST",
    data: datatopost,
    // AJAX Call successful
    success: function(data){
      if(data == "success"){
        window.location = "mainpageloggedin.php";
      }else{
        $('#loginMessage').html(data);
      }
    },
    // AJAX Call fails: show error AJAX Call error
    error: function(){
      $("#loginMessage").html("<div class='alert alert-danger'>There was an error with the AJAX Call. Please try again later</div>");
    }
  });
});  
        
// AJAX Call for the forgot password form
$("#forgotpasswordform").submit(function(event){
  //prevent default php processing
  event.preventDefault();

  //collect user inputs
  var datatopost = $(this).serializeArray();
  //send them to forgotpassword.php using AJAX
  $.ajax({
    url: "forgotpassword.php",
    type: "POST",
    data: datatopost,
    // AJAX Call successful
    success: function(data){
      $('#forgotpasswordmessage').html(data);
    },
    // AJAX Call fails: show error AJAX Call error
    error: function(){
      $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the AJAX Call. Please try again later</div>");
    }
  });
});