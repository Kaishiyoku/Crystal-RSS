import Logger from 'js-logger';
import _ from 'lodash';

const LOG_VALUE_ERROR = 8;
const LOG_VALUE_WARN = 4;

export function initLogger() {
    Logger.useDefaults({
        formatter: (messages, context) => {
            let date = new Date();
            let formattedDate = `${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
            let leftPadding = context.level.value === LOG_VALUE_ERROR || context.level.value === LOG_VALUE_WARN ? '' : ' ';
            let rightPadding = 10;
            let formattedLogLevel = `${_.padEnd(`[${context.level.name}]`, rightPadding, ' ')}`;

            messages.unshift(`${leftPadding}${formattedDate} ${formattedLogLevel}`);
        }
    });
}