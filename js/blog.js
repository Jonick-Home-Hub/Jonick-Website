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
  
  
  
  //   General Plumbering Script
  
  // JavaScript for accordion functionality with icons
  document.addEventListener('DOMContentLoaded', function() {
  const items = document.querySelectorAll('.accordion-item');
  
  items.forEach(item => {
      const header = item.querySelector('.accordion-header');
      const body = item.querySelector('.accordion-body');
      const icon = item.querySelector('.icon');
  
      header.addEventListener('click', function() {
          const isOpen = item.classList.contains('active');
  
          // Close any open item
          document.querySelectorAll('.accordion-item').forEach(i => {
              i.classList.remove('active');
              i.querySelector('.accordion-body').style.display = 'none';
              i.querySelector('.icon').textContent = '+';
          });
  
          // Open clicked item if it was closed
          if (!isOpen) {
              item.classList.add('active');
              body.style.display = 'block';
              icon.textContent = '-';
          }
      });
  });
  });
  document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll('.card');
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
          }
        });
      },
      { threshold: 0.1 } // Trigger when 10% of the card is visible
    );
  
    cards.forEach((card) => {
      observer.observe(card);
    });
  });
  

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems);
});

