// app/utils/proxy-helpers.js
import Ember from 'ember';

export function isProxy(obj) {
    // note that I added the Ember.ArrayProxy, as arrProxy intanceof Ember.ObjectProxy => false
    return (obj instanceof Ember.ObjectProxy) || (obj instanceof Ember.ArrayProxy);
}

export function withoutProxies(obj) {
    while (isProxy(obj)) {
        obj = obj.get('content');
    }

    return obj;
}

export function isEqualProxied(a, b) {
    return Ember.isEqual(withoutProxies(a), withoutProxies(b));
}

function _itemAt(arr, index) {
    if (typeof arr.objectAt === 'function') {
        return arr.objectAt(index);
    } else {
        return arr[index];
    }
}

export function indexOfProxied(arr, object, fromIndex) {
    if (fromIndex == null) {
        fromIndex = 0;
    } else if (fromIndex < 0) {
        fromIndex = Math.max(0, this.length + fromIndex);
    }

    arr = withoutProxies(arr);

    if (arr == null) {
        return -1;
    }
    for (let i = fromIndex; i < arr.length; i++) {
        let item = _itemAt(arr, i);
        if (isEqualProxied(item, object)) {
            return i;
        }
    }
}