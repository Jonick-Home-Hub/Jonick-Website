// AsyncRequest.js
import { ProgressModel } from "./ProgressModel.js";

export class AsyncRequest {
    constructor(url, type, data, isAsync = true, cache = true, contentType = 'application/x-www-form-urlencoded; charset=UTF-8', onsuccess = function(){}, onerror = function(){}, headers = {}) {
        this.url = url;
        this.type = type;
        this.data = data;
        this.isAsync = isAsync;
        this.cache = cache;
        this.contentType = contentType;
        this.headers = headers;
        this.onsuccess = onsuccess;
        this.onerror = onerror;
        this.response = null;
        this.progressModel = new ProgressModel(); // Initialize ProgressModel
    }

    setHeaders(headers = {}) {
        this.headers = headers;
    }

    requestAjax() {
        const success = this.onsuccess;
        const error = this.onerror;
        // Show loading before starting the request
        this.progressModel.showLoading();

        $.ajax({
            url: this.url,
            type: this.type,
            data: this.data,
            async: this.isAsync,
            processData: this.cache,
            contentType: this.contentType,
            headers: this.headers,
            success: (handler) => {
                success(handler);
                this.response = handler;
                this.progressModel.hideLoading(); // Hide loading on success
            },
            error: (error) => {
                // Pass error to ProgressModel's handleError
                this.response = error;
                this.progressModel.handleError(error);
                this.progressModel.hideLoading(); // Hide loading on error
            }
        });
    }
}
