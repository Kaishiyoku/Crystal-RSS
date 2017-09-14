import _ from 'lodash';
import allTranslations from "../translations/all";

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

export default function trans(lookupKey) {
    let translations = allTranslations[getLocale()];

    // if locale not supported use fallback locale
    if (_.isEmpty(translations)) {
        translations = allTranslations[fallbackLocale];
    }

    let translatedStr = _.get(translations, lookupKey);

    if (_.isEmpty(translatedStr)) {
        return `[${lookupKey}]`;
    }

    return translatedStr
}