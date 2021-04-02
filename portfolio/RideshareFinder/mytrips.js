// define variables
var data, departureLongitude, departureLatitude, destinationLongitude, destinationLatitude, trip;

// create a geocoder object to use geocode
var geocoder = new google.maps.Geocoder();

// get trips
getTrips();

// Hide all the date and time checkbox inputs
$(".regular").hide();
$(".oneoff").hide();
$(".regular2").hide();
$(".oneoff2").hide();

// Add Trips Radio Buttons
var myRadio = $('input[name="regular"]');
myRadio.click(function(){
    if($(this).is(':checked')){
        if($(this).val() == "Y"){// Regular Commute is selected
            // $(".oneoff").hide();
            $(".regular").show();
            $("#date").hide();
        }else{// One-off Commute is selected
            $(".regular").hide();
            $(".oneoff").show();
            $("#date").show();
            $("#time").show();
        }
    }
});

// Edit Trips Radio Buttons
myRadio = $('input[name="regular2"]');
myRadio.click(function(){
    if($(this).is(':checked')){
        if($(this).val() == "Y"){// Regular Commute is selected
            
            $(".regular2").show();
            $("#date2").hide();
        }else{// One-off Commute is selected
            $(".regular2").hide();
            $(".oneoff2").show();
            $("#date2").show();
            $("#time2").show();
        }
    }
});

// Calendar
$('input[name="date"], input[name="date2"]').datepicker({
    numberOfMonths: 1,
    showAnim: "fadeIn",
    dateFormat: "D M d, yy",
    minDate: +1,
    maxDate: "+12M",
    showWeek: true
});
 
// Create Trip Button
$("#addtripform").submit(function(event){
    // show spinner
    $("#spinner").show();
    // hide results
    $("#addtripmessage").hide();
    
    //prevent default php processing
    event.preventDefault();
    
    //collect user inputs
    data = $(this).serializeArray();
    //   console.log(data);
    
    getAddTripDepartureCoordinates();
});

// Edit Button
$('#edittripModal').on('show.bs.modal', function (event) {
    $('#edittripmessage').html("");
    var $invoker = $(event.relatedTarget);
    $.ajax({
            url: "gettripdetails.php",
            method: "POST",
            data: {trip_id:$invoker.data('trip_id')},
            success: function(returnedData){
                if(returnedData == "error"){
                    $('#edittripmessage').html(
                        "<div class='alert alert-danger'>There was an error with the Edit Message Ajax Call. Please try again later.</div>"
                    );
                }else{
                    trip = JSON.parse(returnedData);
                    //fill edit trip form inputs using AJAX returned JSON data
                    formatModal();
                }
        },
            error: function(){
                $('#edittripmessage').html(
                    "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
                );
                $('#edittripmessage').hide();
                $('#edittripmessage').fadeIn();
    
            }
    });
    
    // Submit edit form
    $("#edittripform").submit(function(event){
        // show spinner
        $("#spinner").show();
        // hide results
        $("#edittripmessage").hide();
    
        // empty error message
        $('#edittripmessage').html("");
        //prevent default php processing
        event.preventDefault();
        
        //collect user inputs
        data = $(this).serializeArray();
        data.push({name: 'trip_id', value: $invoker.data('trip_id')});
        
        getEditTripDepartureCoordinates();
        
    });
    
    // Delete a trip
    $("#deletetrip").click(function(){
        // show spinner
        $("#spinner").show();
        // hide results
        $("#edittripmessage").hide();
        
        $invoker = $(event.relatedTarget);
        // AJAX Call to deletetrips.php
        $.ajax({
            url: "deletetrips.php",
            method: "POST",
            data: {trip_id:$invoker.data('trip_id')},
            success: function(returnedData){
                // hide spinner
                    $("#spinner").hide();
                if(returnedData == "error"){
                    $('#edittripmessage').html(
                        "<div class='alert alert-danger'>The trip could not be deleted. Please try again!</div>"
                    );
                    
                    // show results
                    $('#edittripmessage').slideDown();
                }else{
                    // clear edit trips form
                    $("#edittripModal").modal('hide');
                    // get trips
                    getTrips();
                }
        },
            error: function(){
                // hide spinner
                $("#spinner").hide();
                $('#edittripmessage').html(
                    "<div class='alert alert-danger'>There was an error with the Delete Trips Ajax Call. Please try again later.</div>"
                );
                
                // show results
                $('#edittripmessage').slideDown();
            }
        });
    });
});

// **************
// Functions
// **************

// Store Add Trip Departure Coordinates
function getAddTripDepartureCoordinates(){
    // get coordinates of departure
    geocoder.geocode({
        'address': $("#departure").val()
    }, 
    function(results, status){
        if(status == google.maps.GeocoderStatus.OK){
            // console.log(results);
            
            // get latitude and logitude
            departureLongitude = results[0].geometry.location.lng();
            departureLatitude = results[0].geometry.location.lat();
            // add to data array
            data.push({name: 'departureLongitude', value: departureLongitude});
            data.push({name:'departureLatitude', value: departureLatitude});
            
            // console.log(data);
            
            // coordinates of destination
            getAddTripDestinationCoordinates();
        }else{
            // coordinates of destination with missing departure
            getAddTripDestinationCoordinates();
        }
    });
}

// Store Add Trip Desitination Coordinates
function getAddTripDestinationCoordinates(){
    // get coordinates of departure
    geocoder.geocode({
        'address': $("#destination").val()
    }, 
    function(results, status){
        if(status == google.maps.GeocoderStatus.OK){
            // console.log(results);
            
            // get latitude and logitude
            destinationLongitude = results[0].geometry.location.lng();
            destinationLatitude = results[0].geometry.location.lat();
            // add to data array
            data.push({name: 'destinationLongitude', value: destinationLongitude});
            data.push({name:'destinationLatitude', value: destinationLatitude});
            
            // console.log(data);
            
            // Submit trip details
            submitAddTripRequest();
        }else{
            // Submit trip details with missing Destination
            submitAddTripRequest();
        }
    });
}

// Submit Add Trip details
function submitAddTripRequest(){
//send to addtrips.php using AJAX
    $.ajax({
        url: "addtrips.php",
        type: "POST",
        data: data,
        // AJAX Call successful
        success: function(returnedData){
            // hide spinner
            $("#spinner").hide();
            if(returnedData){
                $("#addtripmessage").html(returnedData);
                
                // show results
                $("#addtripmessage").slideDown();
            }else{
                // hide error message
                $("#addtripmessage").hide();
                // hide modal
                $("#addtripModal").modal('hide');
                // reset form
                $("#addtripform")[0].reset();
                // load trips
                getTrips();
            }
        },
        // AJAX Call fails: show error AJAX Call error
        error: function(){
            // hide spinner
            $("#spinner").hide();
          $("#addtripmessage").html(
              "<div class='alert alert-danger'>There was an error with the Add Trips AJAX Call. Please try again later</div>"
          );
          
         // show results
        $("#addtripmessage").slideDown();
        }
    });
}

// get trips
function getTrips(){
    // show spinner
    $("#spinner").show();
    
    //send to addtrips.php using AJAX
    $.ajax({
        url: "gettrips.php",
        // AJAX Call successful
        success: function(returnedData){
            // hide spinner
            $("#spinner").hide();
            // hide results
            $("#myTrips").hide();
            
            $("#myTrips").html(returnedData);
            
            // show results
            $("#myTrips").fadeIn();
        },
        // AJAX Call fails: show error AJAX Call error
        error: function(){
            // hide spinner
            $("#spinner").hide();
            // hide results
            $("#myTrips").hide();
            
          $("#myTrips").html(
              "<div class='alert alert-danger'>There was an error with the Get Trips AJAX Call. Please try again later</div>"
          );
          // show results
            $("#myTrips").fadeIn();
        }
    });
}

// Edit Trips Modal
function formatModal(){
    $('#departure2').val(trip["departure"]);    
    $('#destination2').val(trip["destination"]); 
    $('#price2').val(trip["price"]);    
    $('#seatsavailable2').val(trip["seatsavailable"]);  
    // Regular Trip
    if(trip["regular"] == "Y"){
        $('#no2').prop('checked', false);
        $('#yes2').prop('checked', true);
        $('#monday2').prop('checked', trip["monday"] == "1"? true:false);
        $('#tuesday2').prop('checked', trip["tuesday"] == "2"? true:false);
        $('#wednesday2').prop('checked', trip["wednesday"] == "3"? true:false);
        $('#thursday2').prop('checked', trip["thursday"] == "4"? true:false);
        $('#friday2').prop('checked', trip["friday"] == "5"? true:false);
        $('#saturday2').prop('checked', trip["saturday"] == "6"? true:false);
        $('#sunday2').prop('checked', trip["sunday"] == "7"? true:false);
        $('input[name="time2"]').val(trip["time"]);
        $('.oneoff2').hide(); 
        $('.regular2').show();
    }else{
        // One-off Trip
        $('#yes2').prop('checked', false);
        $('#no2').prop('checked', true);
        $('input[name="date2"]').val(trip["date"]);
        $('input[name="time2"]').val(trip["time"]);
        $('.regular2').hide(); 
        $('.oneoff2').show();
    }
}

// Store Edit Trip Departure Coordinates
function getEditTripDepartureCoordinates(){
    // get coordinates of departure
    geocoder.geocode({
        'address': $("#departure2").val()
    }, 
    function(results, status){
        if(status == google.maps.GeocoderStatus.OK){
            // console.log(results);
            
            // get latitude and logitude
            departureLongitude = results[0].geometry.location.lng();
            departureLatitude = results[0].geometry.location.lat();
            // add to data array
            data.push({name: 'departureLongitude', value: departureLongitude});
            data.push({name:'departureLatitude', value: departureLatitude});
            
            // console.log(data);
            
            // coordinates of destination
            getEditTripDestinationCoordinates();
        }else{
            // coordinates of destination with missing departure
            getEditTripDestinationCoordinates();
        }
    });
}

// Store Add Trip Desitination Coordinates
function getEditTripDestinationCoordinates(){
    // get coordinates of departure
    geocoder.geocode({
        'address': $("#destination2").val()
    }, 
    function(results, status){
        if(status == google.maps.GeocoderStatus.OK){
            // console.log(results);
            
            // get latitude and logitude
            destinationLongitude = results[0].geometry.location.lng();
            destinationLatitude = results[0].geometry.location.lat();
            // add to data array
            data.push({name: 'destinationLongitude', value: destinationLongitude});
            data.push({name:'destinationLatitude', value: destinationLatitude});
            
            // console.log(data);
            
            // Submit trip details
            submitEditTripRequest();
        }else{
            // Submit trip details with missing Destination
            submitEditTripRequest();
        }
    });
}

// Submit Add Trip details
function submitEditTripRequest(){
//send to addtrips.php using AJAX
    $.ajax({
        url: "updatetrips.php",
        type: "POST",
        data: data,
        // AJAX Call successful
        success: function(returnedData){
            if(returnedData){
                // hide spinner
                $("#spinner").hide();
        
                $("#edittripmessage").html(returnedData);
                
                // show results
                 $("#edittripmessage").slideDown();
            }else{
                // hide error message
                $("#edittripmessage").hide();
                // hide modal
                $("#edittripModal").modal('hide');
                // reset form
                $("#edittripform")[0].reset();
                // load trips
                getTrips();
            }
        },
        // AJAX Call fails: show error AJAX Call error
        error: function(){
            // show spinner
            $("#spinner").hide();
            $("#addtripmessage").html(
              "<div class='alert alert-danger'>There was an error with the Add Trips AJAX Call. Please try again later</div>"
            );
          
            // show results
            $("#edittripmessage").slideDown();
        }
    });
}