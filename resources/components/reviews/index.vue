<template>
    <div>
        <div class="mt-4"  v-if="showTable && !isActiveReviewShow">
          <div class="field has-addons is-fullwidth">
              <span @click="deleteReviews" class="mt-2 mr-2 icon" style="cursor: pointer">
                <font-awesome-icon icon="trash" class="icon alt mr-2"/>
              </span>
              <div class="control is-expanded">
                <input v-model="searchQuery" class="input" type="text" placeholder="Find a review">
              </div>
              <div class="control">
                <a class="button is-info">
                  Search
                </a>
              </div>
              <div class="ml-2 control">
                <a @click="showFiltersBlock = !showFiltersBlock" class="button">
                  Filter
                </a>
              </div>
            </div>
            <div class="mb-4 is-flex is-flex-direction-row is-align-items-center is-flex-wrap-wrap"  v-if="showFiltersBlock">
                <div class="select mr-3 mt-4">
                  <input type="text"
                     class="input search-products-input"
                     placeholder="Search products"
                     autocomplete="off"
                     v-model="queryProduct"
                     @keydown.down="down"
                     @keydown.up="up"
                     @keydown.enter.prevent
                     @keydown.enter="hit"
                     @keydown.esc="reset"
                     @input="searchProducts"/>
                     <ul v-show="products.length> 0" class="products-autocomplete">
                        <li v-for="(item, product) in products" :class="activeClass(product)" @mousedown="selectProduct(item)">
                          <span v-text="item.title"></span>
                        </li>
                      </ul>
                </div>  

                <div class="select mr-3 mt-4" v-if="showRating">
                  <select v-model="rating">
                    <option value="null">Select rating</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>

                <div class="mr-2 mt-4">
                  <date-picker v-model="fromDate" placeholder="From"></date-picker>
                </div>
                <div class="mr-2 mt-4">-</div> 
                <div class="mr-3 mt-4">
                  <date-picker class="filter-datepicker"  v-model="toDate" placeholder="To"></date-picker>
                </div>
                <button @click="clearFilters" class="mt-4 button is-danger is-outlined">Clear filters</button>
            </div>
          <table class="table is-fullwidth" id="reviews-table">
              <thead>
                <tr>
                  <th><input @change="checkAll($event)"  class="select-review-checkbox select-all" type="checkbox"></th>
                  <th>Product</th>
                  <th>Review</th>
                  <th v-if="showRating">Rating</th>
                  <th>Name</th>
                  <th>Created At</th>
                  <th> </th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                </tr>
              </tfoot>
              <tbody>
                <tr></tr>
                <tr v-for="review in reviews" :class="[review.is_read == 0 ? 'unread' : '']" class="reviews-item">
                  <td>
                    <label class="checkbox">
                      <input @change="toogleSelectStatus(review, $event)"  class="select-review-checkbox" type="checkbox">
                    </label>
                    </td> 
                  <td @click="showFullReview(review)">{{ review.product_title }}</td>
                  <td @click="showFullReview(review)"><div class="overme-100">{{ review.description }}</div></td>
                  <td @click="showFullReview(review)" v-if="showRating">
                    <div class="mt-1 rating-col is-flex is-flex-direction-row is-align-items-center">
                      <img v-for="star in review.stars" src="img/yello_star.svg" height="20px" width="20px" />
                    </div>
                  </td>
                  <td @click="showFullReview(review)">{{ review.name }}</td>
                  <td @click="showFullReview(review)">{{ review.created_at_date }}</td>  
                  <td class="is-flex is-flex-direction-row">  
                    <span v-if="(bookmarkIds.indexOf(review.id) != -1)" @click="bookmark(review.id)" class="icon">
                      <font-awesome-icon :icon="(bookmarkIds.indexOf(review.id) != -1) ? 'fas' : 'far'" icon="bookmark" class="icon alt"/>
                    </span> 
                    <span v-else @click="bookmark(review.id)" class="icon">
                      <font-awesome-icon :icon="['far', 'bookmark']" class="icon alt"/>
                    </span>
                      <span @click="deleteReview(review)" class="icon">
                        <font-awesome-icon icon="trash" class="icon alt"/>
                      </span>
                  </td>
                </tr>
              </tbody>
            </table>

            <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="getReviews()"></pagination>
          </div>
          <div class="modal" ref="deleteReviewModal">
            <div class="modal-background"></div>
            <div class="modal-content delete-review-modal">
              <div class="box">
                Delete this review?
                <div class="buttons mt-4 is-flex is-flex-direction-row is-justify-content-flex-end">
                  <button @click="deleteReviewRequest" class="button is-danger">Delete</button>
                  <button @click="closeDeleteReviewModal" class="button is-primary">Cancel</button>
                </div>
              </div>
            </div>
            <button @click="closeDeleteReviewModal" class="modal-close is-large" aria-label="close"></button>
          </div>
          <div class="modal" ref="deleteReviewsModal">
            <div class="modal-background"></div>
            <div class="modal-content delete-review-modal">
              <div class="box">
                Delete reviews?
                <div class="buttons mt-4 is-flex is-flex-direction-row is-justify-content-flex-end">
                  <button @click="deleteReviewsRequest" class="button is-danger">Delete</button>
                  <button @click="closeDeleteReviewsModal" class="button is-primary">Cancel</button>
                </div>
              </div>
            </div>
            <button @click="closeDeleteReviewsModal" class="modal-close is-large" aria-label="close"></button>
          </div>
          <review-card  @bookmark='bookmark' @deleteReview='deleteReview' @closeReview='onCloseReview' v-if="isActiveReviewShow" :review="activeReview" :bookmarkIds="bookmarkIds" />
    </div>
</template>

<script>

window.Vue = require('vue');  
import Pagination from '../common/PaginationComponent.vue'
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import VueTypeahead from 'vue-typeahead'
import moment from 'moment'

import { mapState } from 'vuex';
import ReviewCard from './review-card';

export default {
    extends: VueTypeahead,
    components: {
        Pagination,
        DatePicker,
        ReviewCard
    },
    props: {
      bookmarks: {
        type: Boolean,
        default: false
      }
    },
    data() {
        return {
            searchQuery: '',
            showFiltersBlock: false,
            reviews: [],
            pagination: {},
            getAllBook: {},
            fields: [
                {
                    name: "description",
                    title: "description"
                }
            ],
            showTable: false,
            filterProduct: '',
            products: [],
            minChars: 2,
            productsSrc: appDomain + '/api/products?q=',
            queryParamName: 'name',
            queryProduct: '',
            productId: null,
            rating: null,
            recommended: false,
            fromDate: null,
            toDate: null,
            withComment: null,
            activeReview: null,
            activeReviews: [],
            bookmarkIds: [],
            isActiveReviewShow: false,
            showRating: true
        };
    },
    mounted () {
        this.getReviews()
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
        getReviews(page){
            axios.get('reviews',{ params: {
            productId: this.productId,
            page: this.pagination.current_page,
            rating: this.rating,
            recommended: this.recommended,
            from_date: (this.fromDate) ? moment(this.fromDate).format('DD-MM-YYYY') : '',
            to_date: (this.toDate) ? moment(this.toDate).format('DD-MM-YYYY') : '',
            with_comment: this.withComment,
            search_query: this.searchQuery,
            bookmarks: this.bookmarks
          }})
                .then(response => {
                    this.reviews = response.data.data.data;
                    this.bookmarkIds = []
                    this.reviews.forEach(el => {
                      if (el.bookmarks.length > 0) {
                        this.bookmarkIds.push(el.id)
                      } 
                    })
                    this.reviews
                    this.pagination = response.data.pagination;
                    this.showTable = true
                }) 
                .catch(error => {
                    console.log(error.response.data);
                });
        },
        comment () {
            console.log('comment')
        },
        bookmark (id) {
            axios.post('reviews/bookmark/' + id)
            .then(response => {
              for (let i = 0; i < this.reviews.length; i++) {
                if (this.reviews[i].id === id) {
                  console.log(id)
                  if(response.data.status === 'attached') {
                    this.bookmarkIds.push(this.reviews[i].id)
                  } else {
                    const index = this.bookmarkIds.indexOf(this.reviews[i].id);
                    if (index > -1) {
                      this.bookmarkIds.splice(index, 1);
                    }
                  }
                }
              }
            }) 
            .catch(error => {
                console.log(error.response.data);
            });
        },
        deleteReview (review) {
          this.activeReview = review
          this.$refs.deleteReviewModal.classList.add('is-active')
        },
        deleteReviews () {
          this.$refs.deleteReviewsModal.classList.add('is-active')
        },
        closeDeleteReviewModal () {
          this.$refs.deleteReviewModal.classList.remove('is-active')
        },
        closeDeleteReviewsModal () {
          this.$refs.deleteReviewsModal.classList.remove('is-active')
        },
        showFullReview (review) {
          this.activeReview = review
          this.isActiveReviewShow = true
          if (this.activeReview.is_read == 0) {
            axios.post('reviews/toogle-read-status/' + this.activeReview.id)
            .then(response => {
              if (response.data.status == 'success') {
                this.reviews = this.reviews.map(el => {
                  if (el.id == this.activeReview.id) {
                    el.is_read = 1
                  }
                  return el
                })
                console.log(this.reviews)
              }
            })
            .catch(error => {
              console.log(error)
            })
          }
        },
        clearFilters () {
          this.filterProduct = {}
          this.queryProduct = ''
          this.productId = null
          this.products = []
          this.rating = null
          this.recommended = null
          this.fromDate = null
          this.toDate = ''
          this.withComment = null
        },
        searchProducts (seachString) {
          const that = this
          axios.get(appDomain + '/products?q=' + this.queryProduct)
            .then(function (response) {
              that.products = response.data.body.data.products.edges.map(function(item) {
                return item.node;
              })
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
        },
        selectProduct (item) {
          this.queryProduct = item.title
          this.productId = item.id
          this.products = []
          this.getReviews()
        },
        deleteReviewRequest () {
          const that = this
          axios.delete(appDomain + '/reviews/' + this.activeReview.id)
            .then(function (response) {
              if(response.status === 200) {
                that.closeDeleteReviewModal()
                that.getReviews(that.pagination.current_page)
                that.isActiveReviewShow = false
              }
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
        },
        deleteReviewsRequest () {
          const that = this
          const ids = this.activeReviews.map(a => a.id);
          if (ids.length > 0) {
            axios.delete(appDomain + '/reviews/delete-multiply/' + ids.join(','))
            .then(function (response) {
              if(response.status === 200) {
                that.closeDeleteReviewsModal()
                that.getReviews(that.pagination.current_page)
                that.toogleSelectAll(false)
                that.activeReviews = []
              }
            })
            .catch(function (error) {
              console.log(error);
            })
          } else {
            that.closeDeleteReviewsModal()
            that.toogleSelectAll(false)
          }
        },
        setActive (item) {},
        prepareResponseData (data) {
          // data = ...
          return data
        },
        toogleSelectStatus (review, $event) {
          const checked = $event.target.checked
          if (checked) {
            this.activeReviews.push(review)
          } else {
            this.activeReviews = this.activeReviews.filter((e)=>e.id !== review.id )
          }
        },
        toogleSelectAll (status) {
          const reviewsTable = document.getElementById('reviews-table')
          if (reviewsTable) {
            const selectReviews = reviewsTable.getElementsByClassName('select-review-checkbox')
            Array.prototype.forEach.call(selectReviews, function(el) {
              el.checked = status
            }) 
          }
        },
        checkAll ($event) {
          const checked = $event.target.checked
          if (checked) {
            this.activeReviews = this.reviews
            this.toogleSelectAll(true)
          } else {
            this.activeReviews = []
            this.toogleSelectAll(false)
          }
        },
        onCloseReview () {
          this.isActiveReviewShow = false
          this.activeReview = null
        }
    },
    watch: {
      rating: function (val) {
        this.getReviews()
      },
      recommended: function (val) {
        this.getReviews()
      },
      fromDate: function (val) {
        this.getReviews()
      },
      toDate: function (val) {
        this.getReviews()
      },
      withComment: function (val) {
        this.getReviews()
      },
      searchQuery: function (val) {
        this.getReviews()
      }
    }
};
</script>

<style>
  .mx-input {
    padding-bottom: calc(0.5em - 1px);
    padding-left: calc(0.75em - 1px);
    padding-right: calc(0.75em - 1px);
    padding-top: calc(0.5em - 1px);
  }

  .delete-review-modal {
    width: 300px;
  }

  .select-all {
    cursor: pointer;
  }

  .unread {
    font-weight: 500;
  }
</style>
