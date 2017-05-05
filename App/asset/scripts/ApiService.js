/**
 * @typedef {Promise} IExtendedXHR
 * @property {XMLHttpRequest} xhr
 */

class ApiService {

    constructor() {
        this._baseUrl = `${location.protocol}//${location.host}`;
        this._storage = localStorage;
        this._tokenKeyName = 'token';
        this._tokenHeaderKeyName = 'X-AUTH-TOKEN';
    }

    /**
     *
     * @param {XMLHttpRequest} xhr
     */
    _onBeforeSend(xhr) {
        let token = this._storage.getItem(this._tokenKeyName);
        if (token) {
            xhr.setRequestHeader(this._tokenHeaderKeyName, token);
        }
        // xhr.responseType = 'application/json';
    }

    /**
     *
     * @param {XMLHttpRequest} xhr
     */
    _onAfterReceive(xhr) {
        let token = xhr.getResponseHeader(this._tokenHeaderKeyName);
        if (token) {
            this._storage.setItem(this._tokenKeyName, token);
        }
    }

    /**
     *
     * @param {string} method
     * @param {string} endpoint
     * @param {string|ArrayBuffer|Blob|Document|FormData} data
     * @returns {IExtendedXHR}
     */
    _xhr(method, endpoint, data) {
        let xhr = new XMLHttpRequest();
        let promise = new Promise((resolve, reject) => {
            xhr.onreadystatechange = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    this._onAfterReceive(xhr);
                    if (xhr.status === 200) {
                        // switch (xhr.responseType) {
                        //     case 'json':
                        let data = JSON.parse(xhr.responseText);
                        data.error ? reject(new Error(data.error)) : resolve(data);
                        // break;
                        // default:
                        //     resolve(xhr.responseText);
                        // }
                    } else {
                        reject(new Error(xhr.statusText));
                    }
                }
            };
            xhr.open(method, `${this._baseUrl}/${endpoint}`, true);
            this._onBeforeSend(xhr);
            xhr.send(data);
        });
        promise.xhr = xhr;
        return promise;
    }

    /**
     *
     * @param {string} endpoint
     * @returns {IExtendedXHR}
     */
    get(endpoint) {
        return this._xhr('GET', endpoint, null);
    }

    /**
     *
     * @param {string} endpoint
     * @param {Object} data
     */
    post(endpoint, data) {
        return this._xhr('POST', endpoint, JSON.stringify(data));
    }
}

ApiService.getInstance = function () {
    if (!ApiService._instance) {
        ApiService._instance = new ApiService();
    }
    return ApiService._instance;
};