import replaceParams from "./replaceParams";

const baseTranslator = (translations) => (lookupKey, params = {}) => {
    const translatedStr = _.get(translations, lookupKey);

    if (_.isEmpty(translatedStr)) {
        return `[${lookupKey}]`;
    }

    return replaceParams(translatedStr, params);
};

export default baseTranslator;