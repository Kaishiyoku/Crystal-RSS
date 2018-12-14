function replaceParams(str, params = {}) {
    const paramKey = _.first(Object.keys(params));

    if (paramKey) {
        return replaceParams(str.replace(`:${paramKey}`, _.get(params, paramKey)))
    }

    return str;
};

export default replaceParams;