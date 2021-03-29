// AJAX Call to updateusername.php
$("#updateusernameform").submit(function(event){
  //prevent default php processing
  event.preventDefault();

  //collect user inputs
  var datatopost = $(this).serializeArray();
  // console.log(datatopost);

  //send them to signup.php using AJAX
  $.ajax({
    url: "profile/updateusername.php",
    type: "POST",
    data: datatopost,
    // AJAX Call successful
    success: function(data){
      if(data){
        $("#updateUsernameMessage").html(data);
      }else{
          location.reload();
      }
    },
    // AJAX Call fails: show error AJAX Call error
    error: function(){
      $("#updateUsernameMessage").html("<div class='alert alert-danger'>There was an error with the update username AJAX Call. Please try again later</div>");
    }
  });
});

// AJAX Call to updatepassword.php
$("#updatepasswordform").submit(function(event){
  //prevent default php processing
  event.preventDefault();

  //collect user inputs
  var datatopost = $(this).serializeArray();
  // console.log(datatopost);

  //send them to signup.php using AJAX
  $.ajax({
    url: "profile/updatepassword.php",
    type: "POST",
    data: datatopost,
    // AJAX Call successful
    success: function(data){
      if(data){
        $("#updatePasswordMessage").html(data);
      }
    },
    // AJAX Call fails: show error AJAX Call error
    error: function(){
      $("#updatePasswordMessage").html("<div class='alert alert-danger'>There was an error with the update username AJAX Call. Please try again later</div>");
    }
  });
});

// AJAX Call to updateemail.php
$("#updateemailform").submit(function(event){
  //prevent default php processing
  event.preventDefault();

  //collect user inputs
  var datatopost = $(this).serializeArray();
  // console.log(datatopost);

  //send them to signup.php using AJAX
  $.ajax({
    url: "profile/updateemail.php",
    type: "POST",
    data: datatopost,
    // AJAX Call successful
    success: function(data){
      if(data){
        $("#updateEmailMessage").html(data);
      }
    },
    // AJAX Call fails: show error AJAX Call error
    error: function(){
      $("#updateEmailMessage").html("<div class='alert alert-danger'>There was an error with the update username AJAX Call. Please try again later</div>");
    }
  });
});