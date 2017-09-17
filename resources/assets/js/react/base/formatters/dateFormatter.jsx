import _ from 'lodash';

function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }

    return i;
}

export function formatTime(date) {
    if (!_.isDate(date)) {
        return '';
    }

    return `${addZero(date.getHours())}:${addZero(date.getMinutes())}:${addZero(date.getSeconds())}`;
}