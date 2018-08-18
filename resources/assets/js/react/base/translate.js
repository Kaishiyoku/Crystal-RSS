import _ from 'lodash';
import allTranslations from "../translations/all";
import Logger from 'js-logger';

const fallbackLocale = 'en';

export function setLocale(locale) {
    if (_.isEmpty(localStorage.getItem('locale'))) {
        locale = fallbackLocale;
    }

    localStorage.setItem('locale', locale.substr(0, 2));
}

export function getLocale() {
    return localStorage.getItem('locale');
}

export default function trans(lookupKey, params = {}) {
    let translations = allTranslations[getLocale()];

    // if locale not supported use fallback locale
    if (_.isEmpty(translations)) {
        translations = allTranslations[fallbackLocale];
    }

    let translatedStr = _.get(translations, lookupKey);

    if (_.isEmpty(translatedStr)) {
        Logger.warn(`missing translation for key "${lookupKey}"`);

        return `[${lookupKey}]`;
    }

    // replace params
    _.forEach(params, (value, key) => {
        translatedStr = translatedStr.replace(`{:${key}}`, value);
    });

    return translatedStr
}