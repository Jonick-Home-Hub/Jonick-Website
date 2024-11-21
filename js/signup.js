// signup.js

// Your Firebase configuration here
const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
    projectId: "YOUR_PROJECT_ID",
    storageBucket: "YOUR_PROJECT_ID.appspot.com",
    messagingSenderId: "YOUR_SENDER_ID",
    appId: "YOUR_APP_ID"
};

// Redirect URL after successful signup
const redirectURL = "https://example.com/welcome";  // Replace with your actual URL

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const auth = firebase.auth();

// Sign Up with Google
function signUpWithGoogle() {
    const provider = new firebase.auth.GoogleAuthProvider();
    auth.signInWithPopup(provider)
        .then(result => {
            console.log("Google sign-in successful:", result.user);
            window.location.href = redirectURL;  // Redirect on success
        })
        .catch(error => {
            console.error("Error during Google sign-in:", error);
        });
}

// Sign Up with Facebook
function signUpWithFacebook() {
    const provider = new firebase.auth.FacebookAuthProvider();
    auth.signInWithPopup(provider)
        .then(result => {
            console.log("Facebook sign-in successful:", result.user);
            window.location.href = redirectURL;  // Redirect on success
        })
        .catch(error => {
            console.error("Error during Facebook sign-in:", error);
        });
}

// Sign Up with Email and Password
document.getElementById("email-signup-form").addEventListener("submit", function(event) {
    event.preventDefault();
    const email = event.target.email.value;
    const password = event.target.password.value;

    auth.createUserWithEmailAndPassword(email, password)
        .then(result => {
            console.log("Email sign-up successful:", result.user);
            window.location.href = redirectURL;  // Redirect on success
        })
        .catch(error => {
            console.error("Error during email sign-up:", error);
        });
});
