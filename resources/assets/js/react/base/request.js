import axios from 'axios';

export function get(url, params = {}, successCallback = () => {}, errorCallback = () => {}) {
    axios.get(url, {
        params
    }).then(function (response) {
        successCallback();
    }).catch(function (error) {
        errorCallback();
    });
}

export function post(url, data = {}, successCallback = () => {}, errorCallback = () => {}) {
    axios.post(url, data).then(function (response) {
        successCallback();
    }).catch(function (error) {
        errorCallback();
    });
}