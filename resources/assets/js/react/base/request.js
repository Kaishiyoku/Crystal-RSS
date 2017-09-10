import axios from 'axios';
import $loading from "./stores/$loading";

function getUrlWithParams(url, urlParams = []) {
    return `${url}/${urlParams.join('/')}`;
}

function baseRequest(method, url, data = {}, urlParams = {}, successCallback = () => {}, errorCallback = () => {}) {
    $loading.next(true);

    axios({
        method,
        url: getUrlWithParams(url, urlParams),
        data: data,
        params: {api_token: localStorage.getItem('token')}
    }).then((response) => {
        successCallback(response);

        $loading.next(false);
    }).catch((error) => {
        errorCallback(error);

        $loading.next(false);
    });
}

export function get(url, urlParams = {}, successCallback = () => {}, errorCallback = () => {}) {
    baseRequest('get', url, {}, urlParams, successCallback, errorCallback);
}

export function post(url, data = {}, successCallback = () => {}, errorCallback = () => {}) {
    baseRequest('post', url, data, [], successCallback, errorCallback);
}

export function put(url, data = {}, successCallback = () => {}, errorCallback = () => {}) {
    baseRequest('put', url, data, [], successCallback, errorCallback);
}