const baseRequest = (method) => (url, token) => {
    return fetch(url, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json, text-plain, */*',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token,
        },
        credentials: 'same-origin',
        method: method,
    });
};

export default baseRequest;