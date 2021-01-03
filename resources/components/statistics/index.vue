<template>
	<div>
		<Chart :data="data" />
		<div class="select mt-3">
		  <select @change="getStat" v-model="daysAgo">
		    <option value="30">30 days</option>
		    <option value="60">60 days</option>
		    <option value="90">90 days</option>
		    <option value="180">180 days</option>
		    <option value="360">360 days</option>
		  </select>
		</div>
	</div>
</template>

<script>
import Chart from './chart';

export default {
	components: {
        Chart
    },
	data() {
        return {
        	daysAgo: 30,
        	data: {}
        }
    },
    created () {
    	this.getStat()
    },
    methods: {
      changeInterval () {

      },
      getStat () {
      	const that = this
      	axios.get('reviews/stat/' + this.daysAgo)
	        .then(response => {
	        	that.data = response.data
	        }) 
	        .catch(error => {
	            console.log(error);
	        });
      }
    }
}
</script>