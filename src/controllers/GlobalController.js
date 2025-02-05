import { ProgressModel } from "../models/ProgressModel.js";
import { UIView } from "../views/UIView.js";

export class GlobalController {
    constructor() {
        this.uiView = new UIView();
        this.progressModel = new ProgressModel();
    }

    Init() {
        console.log("GlobalController initialized. Starting session timer.");

        // Ensure the progress view is only added once
        if (!document.querySelector("#progress-view")) {
            document.body.insertAdjacentHTML('afterbegin', this.uiView.progressUI());
        }
    }

}
