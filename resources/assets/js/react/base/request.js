import axios from 'axios';
import loading$ from "./stores/loading$";
import Logger from 'js-logger';

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
        Logger.debug(`Loaded ${getUrlWithParams(url, urlParams)}`, response.data);

        loading$.next(false);

        successCallback(response);
    }).catch((error) => {
        Logger.error('Request failed', error);

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

export function put(url, data = {}, urlParams = [], successCallback = () => {}, errorCallback = () => {}, token = null) {
    baseRequest('put', url, data, urlParams, successCallback, errorCallback, token);
}

export function del(url, urlParams = [], successCallback = () => {}, errorCallback = () => {}, token = null) {
    baseRequest('delete', url, {}, urlParams, successCallback, errorCallback, token);
}