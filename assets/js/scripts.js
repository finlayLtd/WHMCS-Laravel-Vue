    /* Add JavaScript to toggle the mode */



    const toggleSwitch = document.querySelector('#modeSwitch');
    const currentTheme = localStorage.getItem('theme');
    
    if (currentTheme) {
      document.documentElement.setAttribute('data-theme', currentTheme);
      
      if (currentTheme === 'dark') {
        toggleSwitch.checked = true;
      }
    }
    
    function switchTheme(event) {
      if (event.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
      } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
      }
    }
    
    toggleSwitch.addEventListener('change', switchTheme, false);



  /*toggle sort box*/
  function toggleSortingItems() {
    var sortingItems = document.getElementsByClassName('sorting-items');
    
    for (var i = 0; i < sortingItems.length; i++) {
      var item = sortingItems[i];
      
      if (item.style.display === 'none') {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    }
  }

  /*toggle sort box*/
  function toggleSortingItems_2() {
    var sortingItems = document.getElementsByClassName('sorting-items_2');
    
    for (var i = 0; i < sortingItems.length; i++) {
      var item = sortingItems[i];
      
      if (item.style.display === 'none') {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    }
  }

  function toggleSortingItems_3() {

    var sortingItems = document.getElementsByClassName('sorting-items_3');
    
    for (var i = 0; i < sortingItems.length; i++) {
      var item = sortingItems[i];
      
      if (item.style.display === 'none') {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    }
  }


var toggleButton = document.getElementById('toggleButton');
toggleButton.addEventListener('click', toggleSortingItems);

// var toggleButton_2 = document.getElementById('toggleButton-2');
// toggleButton_2.addEventListener('click', toggleSortingItems_2);

/*modal*/


// Get the button element to open the modal
var openButton = document.querySelector('.add-funds');
var closeButton = document.querySelector('.modal-close');

// Get the modal element
var modal = document.querySelector('.modal-balance');

// Add a click event listener to the button
closeButton.addEventListener('click', function() {
  // Hide the modal by adding a "hidden" class
  modal.classList.add('hidden');
});

// Add a click event listener to the button
openButton.addEventListener('click', function() {
  // Show the modal by removing the "hidden" class
  modal.classList.remove('hidden');
});