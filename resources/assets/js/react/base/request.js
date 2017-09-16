import axios from 'axios';
import loading$ from "./stores/loading$";
import Logger from 'js-logger';
import _ from 'lodash';

const HTTP_STATUS_422_UNPROCESSABLE_ENTITY = 422;

function getUrlWithParams(url, urlParams = []) {
    return `${url}/${urlParams.join('/')}`;
}

function baseRequest(method, url, successCallback = () => {}, errorCallback = () => {}, data = {}, urlParams = [], token = null) {
    if (_.isEmpty(data)) {
        data = {};
    }

    if (_.isEmpty(urlParams)) {
        urlParams = [];
    }

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
        if (error.response.status !== HTTP_STATUS_422_UNPROCESSABLE_ENTITY) {
            Logger.error('Request failed.', error.response.status);
        }

        errorCallback(error);

        loading$.next(false);
    });
}

export function get(url, successCallback = () => {}, errorCallback = () => {}, urlParams = [], token = null) {
    baseRequest('get', url, successCallback, errorCallback, {}, urlParams, token);
}

export function post(url, successCallback = () => {}, errorCallback = () => {}, data = {}, token = null) {
    baseRequest('post', url, successCallback, errorCallback, data, [], token);
}

export function put(url, successCallback = () => {}, errorCallback = () => {}, data = {}, urlParams = [], token = null) {
    baseRequest('put', url, successCallback, errorCallback, data, urlParams, token);
}

export function del(url, successCallback = () => {}, errorCallback = () => {}, urlParams = [], token = null) {
    baseRequest('delete', url, successCallback, errorCallback, {}, urlParams, token);
}