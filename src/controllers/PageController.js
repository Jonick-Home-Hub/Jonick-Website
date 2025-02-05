export class PageController {
    constructor() {
        this.pages = {
            index: 'index',
            services: 'services',
        };
    }

    getPages() {
        return this.pages;
    }

    getCurrentPage() {
        const url = location.href.toString();
        const page = url.split('/').pop().split('.')[0];
        return page;
    }
}