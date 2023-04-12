/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function searchStringInArrayObject (str, arrayObject) {
    var results = [];
    var searchVal = str;
    var i = 0;
    arrayObject.forEach(function(e,row){
        if (JSON.stringify(e).toUpperCase().match(searchVal.toUpperCase())){
            results.push(arrayObject[i]);
        }
        i++;
    });
    return results;
};

function orderByArrayObject(by, arrayObject, order='asc') {
    let result;
    let path = by.split('.');
    
    result = arrayObject.sort((a, b) => {
        let valA = getValue(a, path);
        let valB = getValue(b, path);

        if(order === 'desc'){
            if(isNaN(valA)) {
                if(valB < valA) { return -1; }
                if(valB > valA) { return 1; }
                return 0;
            } else {
                return valB - valA;
            }
        } else {
            if(isNaN(valA)) {
                if(valA < valB) { return -1; }
                if(valA > valB) { return 1; }
                return 0;
            } else {
                return valA - valB;
            }
        }
    });

    function getValue(obj, path){
        path.forEach(path => obj = obj[path])
        return obj;
    }

    return result;
};