import deepMerge from 'deepmerge';
import {isPlainObject} from 'is-plain-object';
import {is, reduce, length} from 'ramda';

const overwriteMerge = (destinationArray, sourceArray, options) => sourceArray;

function merge(...values) {
    const [firstValue, ...otherValues] = values;

    const isArrayCheckFn = is(Array);
    const valueCheckFn = (checkFn) => reduce((accum, obj) => accum && checkFn(obj), true);

    if (length(values) < 2) {
        return null;
    }

    if (!isArrayCheckFn(firstValue) && !isPlainObject(firstValue)) {
        return null;
    }

    if (isArrayCheckFn(firstValue) && !valueCheckFn(isArrayCheckFn)(otherValues)) {
        return null;
    }

    if (isPlainObject(firstValue) && !valueCheckFn(isPlainObject)(otherValues)) {
        return null;
    }

    return deepMerge.all(values, {
        arrayMerge: overwriteMerge,
        isMergeableObject: isPlainObject,
    });
}

export default merge;
