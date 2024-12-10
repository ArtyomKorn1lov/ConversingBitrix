/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/PageFinder.js":
/*!***************************!*\
  !*** ./src/PageFinder.js ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ PageFinder)\n/* harmony export */ });\nclass PageFinder {\r\n    constructor() {\r\n        this.headers = {};\r\n        this.setHeaders();\r\n    }\r\n\r\n    setHeaders() {\r\n        const headersDOM = document.querySelectorAll(\"h1, h2, h3, h4, h5, h6\");\r\n        headersDOM.forEach((item) => {\r\n            if (!item.innerHTML) {\r\n                return;\r\n            }\r\n            if (!this.headers[item.tagName]) {\r\n                this.headers[item.tagName] = [];\r\n            }\r\n            this.headers[item.tagName].push(item.innerHTML.replace(/<(.|\\n)*?>/g, '').trim());\r\n        });\r\n    }\r\n\r\n    getPageValue() {\r\n        return {\r\n            headers: this.headers\r\n        }\r\n    }\r\n}\n\n//# sourceURL=webpack://convesing/./src/PageFinder.js?");

/***/ }),

/***/ "./src/api.js":
/*!********************!*\
  !*** ./src/api.js ***!
  \********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   visitPage: () => (/* binding */ visitPage)\n/* harmony export */ });\nasync function visitPage(data) {\r\n    return await BX.ajax.runAction('module:conversing.Visit.visitPage', data);\r\n}\n\n//# sourceURL=webpack://convesing/./src/api.js?");

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _PageFinder__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageFinder */ \"./src/PageFinder.js\");\n/* harmony import */ var _api__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./api */ \"./src/api.js\");\n\r\n\r\n\r\nBX.ready(() => {\r\n    const pageFinder = new _PageFinder__WEBPACK_IMPORTED_MODULE_0__[\"default\"]();\r\n    const finderData = pageFinder.getPageValue();\r\n    let finalPageParams = pageParams;\r\n    finalPageParams.params = {\r\n        ...finalPageParams.params,\r\n        ...finderData\r\n    }\r\n    console.log('finalPageParams', finalPageParams);\r\n    (0,_api__WEBPACK_IMPORTED_MODULE_1__.visitPage)({\r\n        data: {\r\n            params: finalPageParams\r\n        }\r\n    })\r\n        .then((response) => {\r\n            console.log(response);\r\n        })\r\n        .catch((error) => {\r\n            console.log(error);\r\n        });\r\n});\n\n//# sourceURL=webpack://convesing/./src/index.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/index.js");
/******/ 	
/******/ })()
;