export default class PageFinder {
    constructor() {
        this.headers = {};
        this.setHeaders();
    }

    setHeaders() {
        const headersDOM = document.querySelectorAll("h1, h2, h3, h4, h5, h6");
        headersDOM.forEach((item) => {
            if (!item.innerHTML) {
                return;
            }
            if (!this.headers[item.tagName]) {
                this.headers[item.tagName] = [];
            }
            this.headers[item.tagName].push(item.innerHTML.replace(/<(.|\n)*?>/g, '').trim());
        });
    }

    getPageValue() {
        return {
            headers: this.headers
        }
    }
}