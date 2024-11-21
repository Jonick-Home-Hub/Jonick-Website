function clearForm(event) {
    event.preventDefault(); // Prevents default form submission
    const form = document.getElementById('login-form');
    form.reset(); // Clears the form input fields
  }
    $(document).ready(function(){
        $('.modal').modal(); // Initialize the modal
    
        // Open login modal when "Login" button is clicked
        $('#login-button').on('click', function(e) {
            e.preventDefault(); // Prevent default anchor click behavior
            $('#login-modal').modal('open');
        });
    
        // Handle the login form submission
        $('#login-form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            // You can add AJAX call or any other logic to handle login here
            alert("Login submitted!"); // Temporary feedback for testing
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
    });


    // LOGIN

     // Facebook Login
     document.getElementById('fb-login-btn').onclick = function() {
        FB.login(function(response) {
          if (response.authResponse) {
            console.log('Welcome! Fetching your information.... ');
            FB.api('/me', { locale: 'en_US', fields: 'name, email' }, function(response) {
              console.log('Good to see you, ' + response.name + '.');
              // You can send the user data to your server here for processing
            });
          } else {
            console.log('User cancelled login or did not fully authorize.');
          }
        }, {scope: 'public_profile,email'});
      };
  
      // Google Login
      function onGoogleSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log('ID: ' + profile.getId());
        console.log('Name: ' + profile.getName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail());
        // You can send the user data to your server here for processing
      }
  
      function onLoad() {
        gapi.load('auth2', function() {
          gapi.auth2.init({
            client_id: 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com' // Replace with your Google Client ID
          }).then(function() {
            document.getElementById('google-login-btn').onclick = function() {
              gapi.auth2.getAuthInstance().signIn().then(onGoogleSignIn);
            };
          });
        });
      }