export class UIView{
    constructor(){
        this.IMAGE_URL = "https://localhost/roshanal/api/routes/products/";
    }

    progressUI = () =>{
        return`
            <div id="progress-view" class="progress-view">
                <!-- Loading spinner -->
                <div class="loading-overlay" id="loading-overlay">
                    <div class="spinner"></div>
                    <p class="loading-text">Please wait...</p>
                </div>

                <!-- Alert box -->
                <div class="alert-toast" id="alert-box">
                    <p id="alert-message"></p>
                    <button id="alert-close" class="btn-close">×</button>
                </div>
            </div>

        `;
    }

    dashboard_user_card = () =>{
        return
    }
   
}