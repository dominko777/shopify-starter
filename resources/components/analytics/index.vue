<template>
	<div class="mt-3 columns">
		<div class="column is-one-quarter is-flex is-flex-direction-column is-align-items-start is-flex-wrap-wrap">
				<div class="select">
				  <select @change="getStat" v-model="daysAgo">
				    <option value="30">30 days</option>
				    <option value="60">60 days</option>
				    <option value="90">90 days</option>
				    <option value="180">180 days</option>
				    <option value="360">360 days</option>
				  </select>
				</div>

        <div class="dropdown is-active mt-4">
          <div class="dropdown-trigger">
              <div class="field">
                  <p class="control is-expanded has-icons-right">
                      <input @change="getStat" v-model="searchProduct" class="input" type="search" placeholder="Enter product name"/>
                      <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
                  </p>
              </div>
          </div>
          <div v-if="products.length > 0" class="dropdown-menu" id="dropdown-menu" role="menu">
              <div class="dropdown-content">
                  <a @click="selectProduct(product)" v-for="product in products" href="#" class="dropdown-item">{{ product.title }}</a>
              </div>
          </div>
      </div>

        <div v-if="showRating" class="select mr-3 mt-4">
            <select v-model="rating">
              <option value="null">Select rating</option>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>

          <div class="mr-2 mt-4" v-if="false">
            <date-picker v-model="fromDate" placeholder="From"></date-picker>
          </div>
          <div class="mr-3 mt-4" v-if="false">
            <date-picker class="filter-datepicker"  v-model="toDate" placeholder="To"></date-picker>
          </div>
          <button @click="clearFilters" class="mt-4 button is-danger is-outlined">Clear filters</button>
      </div>
    <div class="column" style="padding-left: 0px;">
		  <Chart :data="data" />
    </div>
	</div>
</template>

<script>
import Vue from 'vue'
import Chart from './chart';
import DatePicker from 'vue2-datepicker';

export default {
	components: {
        Chart,
        DatePicker
  },
	data() {
        return {
        	daysAgo: 30,
        	data: {},
        	queryProduct: '',
          product: null,
          rating: null,
          recommended: false,
          fromDate: null,
          toDate: null,
          products: [],
          loading: false,
          timeoutId: null,
          searchProduct: '',
          showRating: true
        }
    },
    created () {
    	this.getStat()
      this.getSettings()
    },
    methods: {
      getSettings () {
        axios.get('settings/show')
          .then(response => {
            this.showRating = true
            if (response.data) {
              if (parseInt(response.data.rating) !== 1) {
                this.showRating = false
              }
            }
          })
          .catch(error => {
              console.log(error);
          });
      },
      getStat () {
      	const that = this
      	axios.get('reviews/stat/' + this.daysAgo, {
          params: {
            product_id: this.product ? this.product.id : null,
            rating: this.rating ? this.rating : ''
          }
        })
	        .then(response => {
	        	that.data = response.data
	        }) 
	        .catch(error => {
	            console.log(error);
	        });
      },
      async searchProducts (search) {
        const lettersLimit = 2;

        if (search.length < lettersLimit) {
          this.products = [];
          return;
        }
        this.loading = true;
        this.product = null

        clearTimeout(this.timeoutId);
        const that = this
        this.timeoutId = setTimeout(async () => {
          await axios.get(appDomain + '/products?q=' + search)
            .then(function (response) {
              that.products = response.data.body.data.products.edges.map(function(item) {
                return item.node;
              })
              that.loading = false;

              console.log(that.products);
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
        }, 500);
	    },
	    selectProduct (product) {
        this.product = product
	      this.searchProduct = product.title
	      this.products = []
	      this.getStat()
	    },
	    clearFilters () {
          this.filterProduct = {}
          this.queryProduct = ''
          this.productId = null
          this.product = null
          this.searchProduct = null
          this.products = []
          this.rating = ''
          this.getStat()
        }
    },
    watch: {
      searchProduct: function (val) {
        if (!this.product || val !== this.product.title) {
          this.searchProducts(val)
        }
      },
      rating: function (val) {
        this.getStat()
      },
    }
  }
</script>
