export default class PageFinder {
    constructor() {
        this.headers = {};
        this.picturesData = [];
        this.actions = {};
        this.setHeaders();
        this.setImgParams();
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

    setImgParams() {
        const imgDOM = document.querySelectorAll("img");
        imgDOM.forEach((item) => {
            let imgData = {};
            const alt = item.getAttribute('alt');
            (!!alt) && (imgData.alt = alt);
            const title = item.getAttribute('title');
            (!!title) && (imgData.title = title);
            (!!imgData.alt || !!imgData.title) && (this.picturesData.push(imgData));
        });
    }

    getPageValue() {
        return {
            headers: this.headers,
            pictures: this.picturesData
        }
    }
}