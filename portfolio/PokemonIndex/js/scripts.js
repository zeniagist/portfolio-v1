let pokemonRepository = (function (){
  // declare variables
  let repository = [];
  let pokemonUrl = 'https://pokeapi.co/api/v2/pokemon/';
  let modalContainer = document.querySelector("#modal-container");

  // Add pokemon to array
  function add(pokemon) { repository.push(pokemon); }    

  // return pokemon list
  function getAll() { return repository; }

  // add styling for pokemon list
  function addListItem(pokemon){
    let pokemonList = document.querySelector(".pokemon-list");
    let listpokemon = document.createElement("li");
    let button = document.createElement("button");    
    // button text
    button.innerText = pokemon.name;
    // add class
    listpokemon.classList.add("group-list-item");
    // button.classList.add("pokemon-btn");
    button.classList.add("btn");
    // show details of pokemon name
    button.addEventListener('click', function() {
      showDetails(pokemon);
    });
    // create list item button for each pokemon
    listpokemon.appendChild(button);
    pokemonList.appendChild(listpokemon);
  }
  
  // show pokemon details list
  function showDetails(pokemon) {
      loadDetails(pokemon).then(function () {
        console.log(pokemon);  
        showModal(pokemon);        
      });
  }

  // load pokemon list
  function loadList() {
    return fetch(pokemonUrl).then(function (response) {
      return response.json();
    }).then(function (json) {
      json.results.forEach(function (item) {
        let pokemon = {
          name: item.name,
          detailsUrl: item.url
        };
        add(pokemon);
      });
    }).catch(function (e) {
      console.error(e);
    })
  }

  // load pokemon details
  function loadDetails(item) {
    let url = item.detailsUrl;
    return fetch(url).then(function (response) {
      return response.json();
    }).then(function (details) {
      // Now we add the details to the item
      item.imageUrl = details.sprites.other.dream_world.front_default;
      item.height = details.height;
      item.types = [];
      details.types.forEach(function (pokemonType) {
          item.types.push(pokemonType.type.name);
      });
      item.abilities = [];
      details.abilities.forEach(function (pokemonAbility) {
      item.abilities.push(pokemonAbility.ability.name);
      });
    }).catch(function (e) {
      console.error(e);
    });
  }

  // show modal
  function showModal(pokemon) {
    let modalContainer = document.getElementById("modal-container");// Get the modal
    
    modalContainer.innerHTML = '';// clear modal content

    let modal = document.createElement('div');
    modal.classList.add('modal-content');

    // create button element that closes the modal
    let closeBtn = document.createElement('SPAN');
    closeBtn.classList.add('modal-close');
    closeBtn.innerHTML = "&times;";   

    // pokemon image
    let pokemonImg = document.createElement("img");
    pokemonImg.classList.add("modal-img");
    pokemonImg.setAttribute("src", pokemon.imageUrl);
    // pokemon name
    let pokemonName = document.createElement('h1');
    pokemonName.innerText = pokemon.name;    
    // pokemon height
    let pokemonHeight = document.createElement('div');
    pokemonHeight.innerText = "Height: " + pokemon.height;
    // pokemon type
    let pokemonType = document.createElement('div');
    if (pokemon.types.length > 1){
      pokemonType.innerText = "Types: " + pokemon.types.join(', ');      
    } else {
      pokemonType.innerText = "Type: " + pokemon.types;
    }
    // pokemon abilities
    let pokemonAbilities = document.createElement('div');
    pokemonAbilities.innerText = "Abilities: " + pokemon.abilities.join(', ');

    // show pokemon list contents
    modal.appendChild(closeBtn);
    modal.appendChild(pokemonImg);
    modal.appendChild(pokemonName);    
    modal.appendChild(pokemonHeight);
    modal.appendChild(pokemonType);
    modal.appendChild(pokemonAbilities);
    modalContainer.appendChild(modal);

    // display modal
    modalContainer.classList.add('modalShow');

    // close when clicking on close button
    closeBtn.addEventListener("click", function(){
      modalContainer.classList.remove("modalShow");
    }); 

    // close when clicking anywhere outside of the modal
    window.onclick = function(event) {
      if (event.target == modalContainer) {
        modalContainer.style.display = "none";
      }
    }
  }  

  // return functions
  return {
    add: add,
    getAll: getAll,
    addListItem: addListItem,
    loadList: loadList,
    loadDetails: loadDetails,
    showDetails: showDetails,
    showModal: showModal,
  };  
}());

// populate pokemon list
pokemonRepository.loadList().then(function() {
  pokemonRepository.getAll().forEach(function(pokemon){
    pokemonRepository.addListItem(pokemon);
  });
});