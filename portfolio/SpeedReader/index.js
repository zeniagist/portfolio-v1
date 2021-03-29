$(function(){
  // declare variables
  var myArray, inputLength, counter, action;
  var reading = false;
  var frequency = 200;

  // hide buttons, sliders, word reader, and error message
  $("#new").hide();
  $("#pause").hide();
  $("#resume").hide();
  $("#sliders").hide();
  $("#reader").hide();
  $("#error").hide();

  // Click on Start Reading
  $("#start").click(function(){
    // get text and split words into array
    // \s will match spaces, tabs, new lines, etc and + means one or more
    myArray = $("#userInput").val().split(/\s+/);

    // get number of words
    inputLength = myArray.length;

    if(inputLength>1){//input text has more than 2 words
      // move to reading mode
      reading = true;

      // show new and pause buttons and sliders
      $("#new").show();
      $("#pause").show();
      $("#sliders").show();

      // hide textarea, start reading button, and error message (hide only if user entered 1 word or less before)
      $("#userInput").hide();
      $("#start").hide();
      $("#error").hide();

      // set the progress slider max
      $("#progressslider").attr("max", inputLength-1);

      // start counter at zero
      counter = 0;

      // show word reader with first word   
      $("#reader").show().text(myArray[counter]);

      // start reading from the first word
      action = setInterval(read, frequency);

    }else{//input text has 1 word or less
      // show error message
      $("#error").show();
    }
  });

  // Click on New
  $("#new").click(function(){
    // reload page 
    location.reload();
  });

  // Click on Pause
  $("#pause").click(function(){
    // stop reading
    clearInterval(action);

    // switch off reading mode
    reading = false;

    // hide pause and show resume
    $("#pause").hide();
    $("#resume").show();
  });

  // Click on Resume
  $("#resume").click(function(){
    // start reading
    action = setInterval(read, frequency);

    // switch on reading mode
    reading = true;

    // hide resume and show pause
    $("#pause").show();
    $("#resume").hide();
  });

  // Change Font Size
  $("#fontsizeslider").on("slidestop", function(event, ui){
    // refresh slider
    $(this).slider("refresh");

    // get value of the slider
    var slidervalue = parseInt($(this).val());

    // change font size of text
    $("#reader").css("fontSize", slidervalue);

    // change font size text to match font size
    $("#fontsize").text(slidervalue);
  });
  
  // Change Speed
  $("#speedslider").on("slidestop", function(event, ui){
    // refresh slider
    $(this).slider("refresh");

    // get value of the slider
    var slidervalue = parseInt($(this).val());

    // change speed text to match speed of words
    $("#speed").text(slidervalue);

    // stop reading
    clearInterval(action);

    // change frequency
    frequency = 60000/slidervalue

    // resume reading if in reading mode
    if(reading){
      action = setInterval(read, frequency);
    }
  });

  // Progress Slider
  $("#progressslider").on("slidestop", function(event, ui){
    // refresh slider
    $(this).slider("refresh");

    // get value of the slider
    var slidervalue = parseInt($(this).val());

    // stop reading
    clearInterval(action);

    // change counter
    counter = slidervalue;

    // change word
    $("#reader").text(myArray[counter]);

    // change value progress percentage
     $("#percentage").text(Math.floor(counter/(inputLength-1)*100));

    // resume reading if in reading mode
    if(reading){
      action = setInterval(read, frequency);
    }
  });

  /*************
    Functions 
  **************/

  // read user input text
  function read(){
    if(counter == inputLength-1){//last word
      // stop counter
      clearInterval(action);

      // stop reading mode
      reading = false;

      // hide pause button
      $("#pause").hide();
    }else{//all words but last word
      // counter goes up by one
      counter++;

      // get word
      $("#reader").text(myArray[counter]);

      // change the progress slider value and refresh
      $("#progressslider").val(counter).slider('refresh');

      // change the progress percentage
      $("#percentage").text(Math.floor(counter/(inputLength-1)*100));
    }
  }
});