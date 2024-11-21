$(document).ready(function(){
    $('.slider').slider({
      indicators: false,      // Show navigation indicators
      height: 450,           // Height of the slider
      interval: 4000,        // Transition interval in milliseconds
      transition: 600        // Duration of transition
  });
    $('.dropdown-trigger').dropdown();
    $('.sidenav').sidenav();

    // Open services sidenav
    $('.sidenav-trigger[data-target="services-sidenav"]').on('click', function() {
      $('#services-sidenav').sidenav('open');
      $('#mobile-demo').sidenav('close'); // Close main sidenav
    });

    // Open main sidenav when "Back" is clicked
    $('.sidenav-close').on('click', function() {
      $('#services-sidenav').sidenav('close');
      $('#mobile-demo').sidenav('open'); // Reopen the main sidenav
    });

    // Close the main sidenav completely when the close icon is clicked
    $('.sidenav-close-icon').on('click', function() {
      $('.sidenav').sidenav('close');
    });

    // Scroll Up Functionality
$('#scroll-up').on('click', function(e) {
  e.preventDefault(); // Prevent the default anchor click behavior
  $('html, body').animate({ scrollTop: 0 }, 500); // Scroll to top smoothly
});

  });

