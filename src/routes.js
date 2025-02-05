import { PageController } from "./controllers/PageController.js";
import { AuthController } from "./controllers/AuthController.js";

export class Router {
    #PageController = new PageController();
    #CurrentPage = this.#PageController.getCurrentPage();
    #pages = this.#PageController.getPages();
    #Controllers = {
        [this.#pages.index]: () => new AuthController().Init(),
        // Add more page-specific controllers if needed
    };

    Route() {
        let currentPageFile = this.#CurrentPage;
        
        for (const page in this.#pages) {
            if (currentPageFile.includes(this.#pages[page])) {
                console.log("Routing to:", this.#pages[page]);
                const controller = this.#Controllers[this.#pages[page]];
                if (controller) {
                    controller();
                    break;
                }
            }
        }
    }
}
