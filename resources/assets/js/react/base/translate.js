import _ from 'lodash';
import allTranslations from "../translations/all";
import $user from "./stores/$user";

const fallbackLocale = 'en';

function getLocale() {
    let locale = null;

    $user.subscribe((state) => {
        locale = state.locale;
    });

    return locale;
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