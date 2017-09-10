import axios from 'axios';
import $loading from "./stores/$loading";

function baseRequest(method, url, data = {}, params = {}, successCallback = () => {}, errorCallback = () => {}) {
    $loading.next(true);

    axios({
        method,
        url,
        data: data,
        params: Object.assign({}, params, {api_token: localStorage.getItem('token')})
    }).then((response) => {
        successCallback(response);

        $loading.next(false);
    }).catch((error) => {
        errorCallback(error);

        $loading.next(false);
    });
}

export function get(url, params = {}, successCallback = () => {}, errorCallback = () => {}) {
    baseRequest('get', url, {}, params, successCallback, errorCallback);
}

export function post(url, data = {}, successCallback = () => {}, errorCallback = () => {}) {
    baseRequest('post', url, data, {}, successCallback, errorCallback);
}

export function put(url, data = {}, successCallback = () => {}, errorCallback = () => {}) {
    baseRequest('put', url, data, {}, successCallback, errorCallback);
}