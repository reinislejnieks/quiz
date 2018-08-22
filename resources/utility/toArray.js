function toArray(obj){
    return Object.keys(obj).map(function(key) {
        return [Number(key), obj[key]];
    })
}
export {toArray}

// import {toArray} from '../../toArray.js`