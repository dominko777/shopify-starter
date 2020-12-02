import fontawesome from '@fortawesome/fontawesome'


import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter);

window.axios = require('axios'); 
window.appDomain = "http://3165789c79e6.ngrok.io"

import { routes } from '../routes/routes.js'


const router = new VueRouter({
	linkActiveClass: 'is-active',
	linkExactActiveClass: 'is-active',
    routes,
    mode:'history'
});

const app = new Vue({
    router
}).$mount("#app");


/*import "../css/custom.css"  
require("noty/src/noty.scss")
require("noty/src/themes/mint.scss")
window.Noty = require('noty');  
window.axios = require('axios'); 
const appDomain = "http://33e9aa3f1571.ngrok.io"

function addWhishlist (customerId, productId) {

	axios.post(appDomain + '/api/add-to-whishlist', {
		shop_id: Shopify.shop,  
		customer_id: customerId, 
		product_id: productId
	})
  	.then(function (response) {
  		new Noty({
		    type: 'success',
		    layout: 'topRight',
		    text: response.data,
		    timeout: 3000
		}).show();
	  })
	  .catch(function (error) {
	    console.log(error);
	  })
	  .then(function () {
	    // always executed
	  });
}

function checkWhishlist (customerId, productId) {
	axios.post(appDomain + '/api/check-whishlist', {
		shop_id: Shopify.shop,  
		customer_id: customerId, 
		product_id: productId
	})
  	.then(function (response) {
  		if (response.data == 1) {
  			btn.classList.add('active');
  		}
	  })
	  .catch(function (error) {
	    console.log(error);
	  })
	  .then(function () {
	    // always executed
	  });
}

function removeWhishlist (customerId, productId) {
	axios.post(appDomain + '/api/delete-to-whishlist', {
		shop_id: Shopify.shop,  
		customer_id: customerId, 
		product_id: productId
	})
  	.then(function (response) {
  		new Noty({
		    type: 'warning',
		    layout: 'topRight',
		    text: 'removeWhishlist',
		    timeout: 1000
		}).show();
	  })
	  .catch(function (error) {
	    console.log(error);
	  })
}

var btn = document.querySelector('.whishlist-btn');
btn.addEventListener('click', function () {
	var customerId = this.dataset.customer;
	var productId = this.dataset.product;
	if (this.classList.contains('active')) {
		removeWhishlist(customerId, productId);
	} else { 
		this.classList.add('active');
		addWhishlist(customerId, productId);  
	}
})

if (btn) {
	var customerId = btn.dataset.customer;
	var productId = btn.dataset.product;
	checkWhishlist(customerId, productId); 
}
*/