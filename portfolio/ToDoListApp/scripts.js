
function newItem(){

//jQuery
//1. Adding a new item to the list of items: 
  let li = $("<li></li>");
  let inputValue = $("input").val(); //getting input values
  li.append(inputValue);

  if (inputValue === '') {
    alert("You must write something!");
  } else {
    $('#list').append(li);
  }

  //clear input once add button is clicked
  $("input").val('');

//2. Crossing out an item from the list of items:
  function crossOut() {
      li.toggleClass("strike");
    }

    li.on("dblclick", function crossOut() {
      li.toggleClass("strike");
    });

//3(ii). Hide list item 
  let crossOutButton = $('<crossOutButton>X</crossOutButton>');
  li.append(crossOutButton);

  crossOutButton.on("click", function(){ li.hide(); });
// 4. Reordering the items: 
  $('#list').sortable();

}

// enter key adds to list
$('#input').keypress(function(e) {
  if (e.keyCode == '13') {
    e.preventDefault();
    newItem();
  }
});