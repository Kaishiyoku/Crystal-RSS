import axios from 'axios';
import loading$ from "./stores/loading$";

function getUrlWithParams(url, urlParams = []) {
    return `${url}/${urlParams.join('/')}`;
}

function baseRequest(method, url, data = {}, urlParams = {}, successCallback = () => {}, errorCallback = () => {}, token = null) {
    loading$.next(true);

    axios({
        method,
        url: getUrlWithParams(url, urlParams),
        data,
        params: {api_token: token || localStorage.getItem('token')}
    }).then((response) => {
        successCallback(response);

        loading$.next(false);
    }).catch((error) => {
        errorCallback(error);

        loading$.next(false);
    });
}

export function get(url, urlParams = [], successCallback = () => {}, errorCallback = () => {}, token = null) {
    baseRequest('get', url, {}, urlParams, successCallback, errorCallback, token);
}

export function post(url, data = {}, successCallback = () => {}, errorCallback = () => {}, token = null) {
    baseRequest('post', url, data, [], successCallback, errorCallback, token);
}

export function put(url, data = {}, successCallback = () => {}, errorCallback = () => {}, token = null) {
    baseRequest('put', url, data, [], successCallback, errorCallback, token);
}

export function del(url, urlParams = [], successCallback = () => {}, errorCallback = () => {}, token = null) {
    baseRequest('delete', url, {}, urlParams, successCallback, errorCallback, token);
}