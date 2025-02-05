// ProgressModel.js
import { ProgressView } from "../views/ProgressView.js";

export class ProgressModel {
    constructor() {
        this.progressView = new ProgressView();
    }

    // Show loading indicator with optional message
    showLoading(message = "Loading...") {
        this.progressView.showLoading(message);
    }

    // Hide loading indicator
    hideLoading() {
        this.progressView.hideLoading();
    }

    // Handle error by checking error response details
    handleError(errorResponse) {
        let errorMessage;

        if (errorResponse.status === 404) {
            errorMessage = "The requested resource was not found.";
        } else if (errorResponse.status === 500) {
            errorMessage = "A server error occurred. Please try again later.";
        } else if (errorResponse.responseJSON && errorResponse.responseJSON.message) {
            errorMessage = errorResponse.responseJSON.message;
        } else {
            // Convert the error to a string to handle cases where it's an Error object
            errorMessage = errorResponse.toString();
        }
         // Remove "Error: " prefix if present
        if (errorMessage.startsWith("Error: ")) {
            errorMessage = errorMessage.replace("Error: ", "");
        }
        this.progressView.showAlert(errorMessage, "error");
    }

    // Handle success with optional redirection
    handleSuccess(successMessage, redirectUrl = null) {
        this.progressView.showAlert(successMessage, "success");

        if (redirectUrl) {
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 3000); // Redirect after 3 seconds
        }
    }
}
