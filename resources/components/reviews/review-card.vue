<template>
	<div class="card mt-5">
	  <div class="card-content">

	  	<span @click="close" class="p-2" style="cursor: pointer"><font-awesome-icon icon="long-arrow-alt-left" class="icon alt"/></span>
	  	<span style="float: right">
	  		<span v-if="(bookmarkIds.indexOf(review.id) != -1)" @click="bookmark(review.id)" class="icon bookmark">
                      <font-awesome-icon :icon="(bookmarkIds.indexOf(review.id) != -1) ? 'fas' : 'far'" icon="bookmark" class="icon alt"/>
                    </span> 
                    <span v-else @click="bookmark(review.id)" class="icon bookmark">
                      <font-awesome-icon :icon="['far', 'bookmark']" class="icon alt"/>
                    </span>
	                  <span @click="deleteReview(review)" class="icon trash">
	                    <font-awesome-icon icon="trash" class="icon alt"/>
	                  </span>
	  	</span>	
	    <div class="media">
	      <div class="media-content">
	        <p class="title is-4">{{ review.product_title }}</p>
	        <p class="subtitle">
              {{ review.name }}
            </p>
	      </div>
	    </div>

	    <div v-if="review.stars" class="mb-3 rating-col is-flex is-flex-direction-row is-align-items-center">
          <img v-for="star in review.stars" src="img/yello_star.svg" height="20px" width="20px" />
        </div>

        <div v-if="review.is_recommended" class="mb-3">
        	Is recommended: {{ (review.is_recommended) ? 'yes' : 'no' }}
        </div>

	    <div class="content">
	      {{ review.description }}
	      <br>
	      <br>
	      <div class="mb-3" v-if="review.photos.length > 0">
	      	<img :src="url + '/storage/reviews/thumbs/' + photo.photo" v-for="(photo, i) in review.photos" class="mr-3" :key="i" @click="index = i" style="cursor: pointer" />
	      	<vue-gallery-slideshow :images="fullPhotos" :index="index" @close="index = null"></vue-gallery-slideshow>
	      </div>
	      <form @submit.prevent="saveResponse">
		      <textarea v-model="review.comment" class="mb-3 textarea" placeholder="Type your response..."></textarea>
		      <button type="submit" class="mb-3 button is-primary">Save</button>
		  </form>
          <time :datetime="review.created_at_date">{{ review.created_at_date }}</time>
          <notifications group="foo" />
	    </div>
	  </div>
	</div>
</template>

<script>
import Vue from 'vue'
import Notifications from 'vue-notification'
import VueGallerySlideshow from 'vue-gallery-slideshow';
Vue.use(Notifications)

export default {
  props: {
	review: {
	  type: Object,
	  default: false
	},
	bookmarkIds: {
      type: Array,
      default: []
	}
   },
  components: {
    VueGallerySlideshow
  },
  data () {
  	return {
      url: appDomain,
      index: null
    }
  },
  methods: {
  	close () {
      this.$emit('closeReview')
  	},
  	bookmark(reviewId) {
  	  this.$emit('bookmark', reviewId)
  	},
  	deleteReview(review) {
  	  this.$emit('deleteReview', review)
  	},
  	saveResponse() {
  	  axios.put('reviews/' + this.review.id, {
  	  	comment: this.review.comment
  	  })
        .then(response => {
          this.review = response.data.review
          this.$notify({
			  group: 'foo',
			  type: 'success',
			  text: 'Your response was successfully saved'
			});
        }) 
  	}
  },
  computed: {
  	fullPhotos: function () {
      return this.review.photos.map((el) => {
      	return appDomain + '/storage/reviews/original/' + el.photo 
      })
    }
  }
}
</script>

<style>
  .bookmark, .trash {
    cursor: pointer;
  }
</style>
