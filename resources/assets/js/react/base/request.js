import axios from 'axios';

export function get(url, params = {}, successCallback = () => {}, errorCallback = () => {}) {
    axios.get(url, {
        params: Object.assign({}, params, {api_token: localStorage.getItem('token')})
    }).then(function (response) {
        successCallback(response);
    }).catch(function (error) {
        errorCallback(error);
    });
}

export function post(url, data = {}, successCallback = () => {}, errorCallback = () => {}) {
    axios.post(url, Object.assign({}, data, {api_token: localStorage.getItem('token')})).then((response) => {
        successCallback(response);
    }).catch((error) => {
        errorCallback(error);
    });
}