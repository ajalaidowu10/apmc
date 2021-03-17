/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import Vue from 'vue';
import Vuetify from 'vuetify'

window.Vue = Vue;
Vue.use(Vuetify);

import User from './api/User';
import Admin from './api/Admin';
window.User = User;
window.Admin = Admin;

import Exception from './api/Exception';
window.Exception = Exception;

window.EventBus = new Vue();

import router from './routes';
import App from './App.vue';


Vue.mixin({
	data: function () {
	    return {
	    	hasAccess: false,
	      permission: '',
	    }
	  },
  created: function () {
      this.hasPermission()
      		.then( resp =>{
      			if (resp.status == 204) {
      				this.hasAccess = true;
      			}
      		})
    },
    methods: {
      async hasPermission() {

      	if (this.permission) {
      		  let fetchData = await axios.get(`permission/${this.permission}`);

      		 return fetchData;
      	}
      	return {'status': 401};
      }
    }
});


const app = new Vue({
    el: '#app',
    vuetify : new Vuetify(),
    router,
    render: h => h(App)
});



