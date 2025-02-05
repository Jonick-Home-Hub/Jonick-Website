export class ProgressView {
    constructor() {
        this.alertElement = document.querySelector("#alert-box");
        this.alertMessage = document.querySelector("#alert-message");
        this.loaderElement = document.querySelector("#loading-overlay");
        this.loadingText = document.querySelector(".loading-text"); // Ensures only the text changes
    }

    // Show loading indicator with message
    showLoading(message = "Loading...") {
        this.loadingText.textContent = message; // Only change the text content
        this.loaderElement.classList.add('show');
    }

    // Hide loading indicator
    hideLoading() {
        this.loaderElement.classList.remove('show');
    }

    // Display alert with type ("success" or "error")
    showAlert(message, type = "success") {
        this.alertElement.classList.remove('success', 'error');
        this.alertElement.classList.add(type === "error" ? "error" : "success"); // Add appropriate styling
        this.alertMessage.textContent = message;
        this.alertElement.classList.add('show');

        setTimeout(() => {
            this.alertElement.classList.remove('show');
        }, 5000);
    }
}
