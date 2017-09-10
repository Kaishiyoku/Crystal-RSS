import _ from 'lodash';
import translations from "../translations/en";

export default function trans(lookupKey) {
    let translatedStr = _.get(translations, lookupKey);

    if (_.isEmpty(translatedStr)) {
        return `[${lookupKey}]`;
    }

    return translatedStr
}