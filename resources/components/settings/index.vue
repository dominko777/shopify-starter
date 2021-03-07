<template>
	<div class="mt-4">
		<form @submit.prevent="saveSettings">
		  <div class="card pl-5 pt-4 pb-4">
			<div class="field">
			  <label class="label">Rating</label>
			  <div class="control">
			    <div class="select">
			      <select v-model="form.rating">
			        <option value="1">Yes</option>
			        <option value="0">No</option>
			      </select>
			    </div>
			  </div>
			</div>

			<div class="field">
			  <label class="label">Reviews per Page</label>
			  <div class="control">
			      <input style="width: 80px;" type="number" class="input" v-model="form.pagination_count">
			  </div>
			</div>

			<div class="field">
			  <label class="label">Admin Reviews per Page</label>
			  <div class="control">
			      <input style="width: 80px;" type="number"class="input" v-model="form.admin_pagination_count">
			  </div>
			</div>

			<div class="field">
			  <label class="label">Review Background Color</label>
			  <div class="control">
			      <chrome-picker v-model="colors" />
			  </div>
			</div>

            <!-- <div class="field">
			  <label class="label">Images</label>
			  <div class="control">
			    <div class="select">
			      <select v-model="form.images">
			        <option value="true">Yes</option>
			        <option value="false">No</option>
			      </select>
			    </div>
			  </div>
			</div> -->

			<div class="field is-grouped">
			  <div class="control">
			    <button class="button is-link">Save</button>
			  </div>
			</div>

		  </div>

		  <!-- <div class="card pl-5 pt-4 pb-4 mt-4">
	
			<div class="field">
			  <label class="label">Enable Review Reminder Email</label>
			  <div class="control">
			    <div class="select">
			      <select v-model="form.review_reminder">
			        <option value="true">Yes</option>
			        <option value="false">No</option>
			      </select>
			    </div>
			  </div>
			</div>

			<div class="field">
			  <label class="label">Your Email</label>
			  <div class="control">
			      <input class="input" type="text" v-model="form.reminder_email">
			  </div>
			</div>

			<div class="field">
			  <label class="label">Subject</label>
			  <div class="control">
			      <input type="text" rows="3" class="input" v-model="form.reminder_email_subject">
			  </div>
			</div>

			<div class="field">
			  <label class="label">Message</label>
			  <div class="control">
			      <textarea rows="3" class="textarea" v-model="form.reminder_email_message">
			      </textarea>
			  </div>
			</div>
          
            <div class="field is-grouped">
			  <div class="control">
			    <button class="button is-link">Save</button>
			  </div>
			</div>
		  </div> -->
		</form>
		<notifications group="foo" />
	</div>
</template>

<script>

import { Chrome } from 'vue-color'
import Notifications from 'vue-notification'

export default {
	components: {
      'chrome-picker': Chrome
    },
	data() {
		return {
			form: {
				rating: true,
				images: true,
				review_reminder: true,
				reminder_email: '',
				reminder_email_subject: 'You received feedback',
				reminder_email_message: 'Hello, you received feedback...',
				rating_color: 'FFCC00'
			},
			colors: '#ffffff'
		}
	},
	mounted () {
		this.getSettings()
	},
	methods: {
		saveSettings () {
			this.form.modal_background_color = this.colors.hex
  			axios.post('settings', this.form)
	        .then(response => {
	        	if (response.data.success) {
		        	this.$notify({
					  group: 'foo',
					  type: 'success',
					  text: 'Your settings was successfully saved'
					});
				}
		    }) 
	        .catch(error => {
	            console.log(error);
	        });
  		},
  		getSettings () {
  			axios.get('settings/show')
	        .then(response => {
	        	if (response.data) {
	        		this.form = response.data
	        		this.colors = response.data.modal_background_color
	        	}
		    }) 
	        .catch(error => {
	            console.log(error);
	        });
  		}
	}
  }
</script>

<style>
	@media screen and (min-width: 769px), print {
	  .email-settings-label .field-label {
	    flex-grow: 2; /* overwrites previous value of 1 */
	    margin-left: 15px;
	  }
	}
</style>