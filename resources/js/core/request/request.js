import axios from 'axios';

const headers = {
    'Content-Type': 'application/json',
};

const get = (url) => axios.get(url, {headers});

const post = (url, data) => axios.post(url, data, {headers});

const put = (url, data) => axios.put(url, data, {headers});

export {
    get,
    post,
    put,
};
