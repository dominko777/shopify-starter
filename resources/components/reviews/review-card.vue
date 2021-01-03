<template>
	<div class="card mt-5">
	  <div class="card-content">
	  	<div @click="close" class="p-2" style="cursor: pointer"><font-awesome-icon icon="long-arrow-alt-left" class="icon alt"/></div>
	    <div class="media">
	      <div class="media-content">
	        <p class="title is-4">{{ review.product.title }}</p>
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
          <time :datetime="review.created_at_date">{{ review.created_at_date }}</time>
	    </div>
	  </div>
	</div>
</template>

<script>
export default {
  props: {
	review: {
	  type: Object,
	  default: false
	}
   },
  data () {
  	return {

  	}
  },
  methods: {
  	close () {
      this.$emit('closeReview')
  	}
  }
}
</script>