import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);

export default class Api{

    constructor(controllerName){
        this.controllerName = controllerName;
    }
    /**
     *
     * @param {string} action
     * @param {{}} [params]
     * @return {AxiosPromise}
     */
    get(action, params){

        return Vue.axios.get(this.buildUrl(action), params ? params : {});
    }
    post(action, params){
        return Vue.axios.post(this.buildUrl(action), params ? Api.parseParams(params) : {});
    }
    buildUrl(url){
        return '/' + this.controllerName + '/' + url;
    }
    static parseParams(object){
        let params = new URLSearchParams();
        for(let key in object){
            params.append(key, object[key]);
        }
        return params;
    }
}
