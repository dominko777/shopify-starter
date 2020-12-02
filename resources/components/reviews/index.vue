<template>
    <div>
        <div class="mt-4"  v-if="showTable">
          <div class="field has-addons is-fullwidth">
              <div class="control is-expanded">
                <input class="input" type="text" placeholder="Find a review">
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
                  <select>
                    <option>Select product</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>

                <div class="select mr-3 mt-4">
                  <select>
                    <option>Select rating</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>

                <label class="checkbox mr-3 mt-4">
                  <input type="checkbox">
                  Is recommended
                </label>

                <label class="checkbox mr-4 mt-4">
                  <input type="checkbox">
                  Notify answer
                </label>

                <div class="mr-2 mt-4">
                  <datepicker placeholder="From ('d-m-Y')" :config="{ dateFormat: 'd-m-Y', static: true }"></datepicker>
                </div>
                <div class="mr-2 mt-4">-</div> 
                <div class="mr-3 mt-4">
                  <datepicker placeholder="To ('d-m-Y')" :config="{ dateFormat: 'd-m-Y', static: true }"></datepicker>
                </div>
                <label class="checkbox mr-3 mt-4">
                  <input type="checkbox">
                  With comment
                </label>
                <button class="mt-4 button is-danger is-outlined">Clear filters</button>
            </div>
          <table class="table">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Images</th>
                  <th>Description</th>
                  <th>Rating</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Is recommended</th>
                  <th>Notify answer</th>
                  <th>Comment</th>
                  <th>Created At</th>
                  <th> </th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                </tr>
              </tfoot>
              <tbody>
                <tr v-for="review in reviews">
                  <th>222</th> 
                  <th></th>
                  <td>{{ review.description }}</td>
                  <td>
                    <div class="rating">
                      <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                    </div>
                  </td>
                  <td>{{ review.name }}</td>
                  <td>{{ review.email }}</td>
                  <td>{{ review.is_recommended ? 'yes' : 'no' }}</td>
                  <td>{{ review.notify_answer ? 'yes' : 'no' }}</td>
                  <td></td>
                  <td>{{ review.created_at }}</td>
                  <td class="is-flex is-flex-direction-row"> 
                    <button title="Comment" @click="comment" class="button icon-button is-info mr-2">
                        <span class="icon is-small ">
                          <img fill="white" class="pr-2" src="img/comment_white.svg" height="24px" width="24px" /> 
                        </span>
                      </button> 
                    <button title="Bookmark" @click="bookmark" class="button icon-button is-success mr-2">
                        <span class="icon is-small ">
                          <img fill="white" class="pr-2" src="img/white_star.svg" height="24px" width="24px" /> 
                        </span>
                      </button> 
                     <button title="Delete" @click="deleteReview" class="button icon-button is-danger">
                        <span class="icon is-small ">
                          <img fill="white" class="pr-2" src="img/delete.svg" height="24px" width="24px" />
                        </span>
                      </button>
                  </td>
                </tr>
              </tbody>
            </table>

            <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="getReviews()"></pagination>
          </div>
    </div>
</template>

<script>
window.Vue = require('vue'); 
import Pagination from '../common/PaginationComponent.vue'
import Datepicker from 'vue-bulma-datepicker'


export default {
    components: {
        Pagination,
        Datepicker
    },
    data() {
        return {
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
            showTable: false
        };
    },
    mounted () {
        this.getReviews()
    },
    methods: {
        getReviews(page){
            axios.get('api/reviews?page=' + this.pagination.current_page)
                .then(response => {
                    this.reviews = response.data.data.data;
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
        bookmark () {
            console.log('bookmark')
        },
        deleteReview () {
            console.log('deleteReview')
        }
    }
};
</script>
