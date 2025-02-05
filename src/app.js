import { Router } from "./routes.js";
import { GlobalController } from "./controllers/GlobalController.js";

class App {
    static Init() {
        const globalController = new GlobalController();
        globalController.Init();

        const router = new Router();
        router.Route();
    }
}

App.Init();
