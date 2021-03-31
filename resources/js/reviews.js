import "../css/reviews.css";
const Uppy = require('@uppy/core')
const XHRUpload = require('@uppy/xhr-upload')
const Dashboard = require('@uppy/dashboard')
require('@uppy/core/dist/style.css')
require('@uppy/dashboard/dist/style.css')
var rater = require("rater-js")
import 'tingle.js/dist/tingle.min.css'
import tingle from 'tingle.js/dist/tingle.min.js'
const axios = require('axios');
const appDomain = "https://betterreview.online"
axios.baseURL = appDomain
import { EmojiButton } from '@joeattardi/emoji-button'
import baguetteBox from 'baguettebox.js'
import 'baguettebox.js/dist/baguetteBox.min.css'

document.addEventListener("DOMContentLoaded", function(event) {
	const starRating = document.getElementById('star-rating')
	let avgRater = null
	if (starRating) {
		avgRater = rater({element: starRating, starSize: 22});
	    avgRater.disable();
	}
    
	var averageRatingInfoBlock = document.getElementsByClassName('average-rating-info')[0]
	

	let settings = {}

	const reviewAppBtn = document.getElementsByClassName('review-app-btn')[0]

	getAverageStars()

	function getAverageStars() {
		if (reviewAppBtn) {
			axios.post(appDomain + '/reviews/average-stars', {
				product_id: reviewAppBtn.getAttribute("data-product"),
				shop_url: reviewAppBtn.getAttribute("data-shop")
			})
		      .then(response => {
		      	if (avgRater && response.data.average.length !== 0) {
		      		avgRater.setRating(response.data.average)
		      	}
		      	settings = response.data.settings
		      	document.getElementById('average-rating').style.display = 'none'
		      	if (response.data.average.length !== 0 && parseInt(response.data.settings.rating) === 1) {
		      		document.getElementById('average-rating').textContent = response.data.average
				    averageRatingInfoBlock.style.visibility = 'visible'
		      	} else { 
		        	averageRatingInfoBlock.style.display = 'none'
		        }
				document.getElementsByClassName('tingle-modal-box__content')[0].style['background-color'] = response.data.settings.modal_background_color
				document.getElementsByClassName('tingle-modal-box__footer')[0].style['background-color'] = response.data.settings.modal_background_color
				document.getElementsByClassName('tingle-modal-box')[0].style['background-color'] = response.data.settings.modal_background_color
		      })
		      .catch(error => {
		          console.log(error);
		      });
		}
	}
	
	let formRater = null
	let picker = null

	function initEmojiPicker () {
		if (!picker) {
			picker = new EmojiButton();
			const trigger = document.querySelector('#emoji-trigger');
			const reviewDescriptionTextarea = document.getElementById('review-description-textarea')
			picker.on('emoji', selection => {
			  reviewDescriptionTextarea.value += selection.emoji	
			  console.log(selection.emoji);
			});
			trigger.addEventListener('click', () => picker.togglePicker(trigger));
		}
	}
		 
	var modal = new tingle.modal({
	    footer: true,
	    stickyFooter: false,
	    closeMethods: ['overlay', 'button', 'escape'],
	    closeLabel: "Close",
	    cssClass: ['custom-class-1', 'custom-class-2'],
	    onOpen: function() {
	    	hideErrors()
	    	reviewsUppy.reset()
	    	const formRating = document.getElementById('form-rating')
	    	if (parseInt(settings.rating) !== 1) {
	    		formRating.style.display = 'none'
	    	} else {
	    		if (!formRater) {
		    		formRater = rater({element: formRating, starSize: 22, rateCallback: function rateCallback(rating, done) {
		    			formRater.setRating(rating);
	                    formRater.disable();
	                    done();
					}});
	    		}
				formRater.clear();
				formRater.enable();
				
	    	}
			const reviewNameInput = document.getElementById('review-name-input')
	        const reviewDescriptionTextarea = document.getElementById('review-description-textarea')
	        reviewNameInput.value = ''
	        reviewDescriptionTextarea.value = ''
	        initEmojiPicker()
	    },
	    onClose: function() {
	    	if (formRater) {
	    		formRater.clear();
	    	}
	    },
	    beforeClose: function() {
	        return true;
	        return false;
	    }
	});
	modal.setContent('<h4>Review</h4><div id="form-rating"></div><div id="review-form">' + 
		    '<input id="review-name-input" name="name" type="text" placeholder="Name">' + 
		    '<span id="review-name-input-error" class="invalid-feedback">Please enter your name</span>' + 
		    '<div id="review-container"><button id="emoji-trigger">&#128512;</button>' + 
		    '<textarea id="review-description-textarea" rows="6" name="name" placeholder="Review"></textarea>' + 
		    '</div>' + 
		    '<span id="review-description-textarea-error" class="invalid-feedback">Please enter your review</span>' + 
		    '<div id="reviewDropzone"></div>' +
		'</div>');
	modal.addFooterBtn('Save', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() { 
		const reviewNameInput = document.getElementById('review-name-input')
		const reviewDescriptionTextarea = document.getElementById('review-description-textarea')
		const reviewNameInputError = document.getElementById('review-name-input-error')
		const reviewDescriptionTextareaError = document.getElementById('review-description-textarea-error')
		reviewNameInput.classList.remove('is-invalid')
		reviewDescriptionTextarea.classList.remove('is-invalid')
		reviewNameInputError.style.display = 'none'
		reviewDescriptionTextareaError.style.display = 'none'
		if (reviewNameInput.value.trim().length === 0) {
			reviewNameInputError.style.display = 'block'
			if (reviewNameInput) {
				reviewNameInput.classList.add('is-invalid')
			}
		}
		if (reviewDescriptionTextarea.value.trim().length === 0) {
			reviewDescriptionTextareaError.style.display = 'block'
			if (reviewDescriptionTextarea) {
				reviewDescriptionTextarea.classList.add('is-invalid')
			}
		}
		if (reviewNameInput.value.trim().length === 0 || reviewDescriptionTextarea.value.trim().length === 0) { return }
			axios.post(appDomain + '/reviews', {
				name: reviewNameInput.value,
				description: reviewDescriptionTextarea.value,
				product_id: reviewAppBtn.getAttribute("data-product"),
				shop_url: reviewAppBtn.getAttribute("data-shop"),
				product_title: reviewAppBtn.getAttribute("data-title"),
				stars: formRater ? formRater.getRating() : ''
			})
	      .then(response => {
	      	if (reviewsUppy) {
	      		reviewsUppy.setMeta({ 
	      			review_id: response.data.review.id, 
	      			shop_url: reviewAppBtn.getAttribute("data-shop")
	      		})
	      		reviewsUppy.upload();
	      	}
	      })
	      .catch(error => {
	          console.log(error);
	      });
	})

	function successReviewSending () {
        hideErrors()
        modal.close()
        getLastReviews()
        getAverageStars()
        successModal.open()
	}

	function hideErrors () {
		const reviewNameInput = document.getElementById('review-name-input')
		const reviewDescriptionTextarea = document.getElementById('review-description-textarea')
		const reviewNameInputError = document.getElementById('review-name-input-error')
		const reviewDescriptionTextareaError = document.getElementById('review-description-textarea-error')
		reviewNameInputError.style.display = 'none'
	    reviewDescriptionTextareaError.style.display = 'none'
	    reviewNameInput.value = ''
        reviewDescriptionTextarea.value = ''
        reviewNameInput.classList.remove('is-invalid')
		reviewDescriptionTextarea.classList.remove('is-invalid')
	}

	modal.addFooterBtn('Cancel', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function() { 
		modal.close()
	})
	document.getElementsByClassName('review-app-btn')[0].addEventListener("click", function () {
		modal.open(); 
	});

	var successModal = new tingle.modal({
	    footer: true,
	    stickyFooter: false,
	    closeMethods: ['overlay', 'button', 'escape'],
	    closeLabel: "Close",
	    cssClass: ['custom-class-1', 'custom-class-2'],
	    beforeClose: function() {
	        return true;
	        return false;
	    }
	});
	successModal.setContent('<h3>Your review was successfully sent</h3>');
	successModal.addFooterBtn('Ok', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() { 
		successModal.close()
	})

	getLastReviews()

	function getLastReviews() {
		axios.post(appDomain + '/shop/reviews', {
			shop_url: reviewAppBtn.getAttribute("data-shop")
		})
	      .then(response => {
	      	setReviewsBlock(response.data)
	      })
	      .catch(error => {
	          console.log(error);
	      });
	}

	function setReviewsBlock(reviewsHtml) {
		const reviewsBlock = document.getElementById('reviews-block')
		if (reviewsBlock) {
			reviewsBlock.innerHTML = reviewsHtml
			initUsersStars()
			initPagination()
			initLightBox()
		}
	}

	function initPagination() {
		const paginationBlock = document.querySelector('#reviews-block .pagination')
		const links = paginationBlock.getElementsByClassName('page-link')
		for (var i = 0; i < links.length; i++) {
			links[i].addEventListener("click", function (e) {
				e.preventDefault()
				if (this.href && this.href !== 'undefined') {
					const page = this.href.split('page=')[1]
					axios.post(appDomain + '/shop/ajax-reviews', {
						page: page,
						shop_url: reviewAppBtn.getAttribute("data-shop")
					})
				      .then(response => {
				      	const reviewsBlock = document.getElementById('reviews-block')
				      	reviewsBlock.innerHTML = response.data
				      	initUsersStars()
				      	initPagination()
				      	reviewsBlock.scrollIntoView()
				      	initLightBox()
				       })
				       .catch(error => {
				          console.log(error);
				        });
				} 
				return false
			});
		}
		
	}

	function initUsersStars() {
		const userStars = document.getElementsByClassName('user-stars')
		if (userStars) {
			for (let i = 0; i < userStars.length; i++) {
				const userStarRating = rater({element: userStars[i], starSize: 15});
	            userStarRating.disable();	
	            userStarRating.setRating(parseInt(userStars[i].getAttribute("data-stars")))
			}
		}
	}

	const reviewsUppy = new Uppy({
		restrictions: {
			maxNumberOfFiles: 3,
	        allowedFileTypes: ['image/*']
	  	}
	 })
	  .use(Dashboard, {
	    target: '#reviewDropzone',
	    inline: true,
        height: 200,
        thumbnailWidth: 180,
        hideUploadButton: true
	  })
	  .use(XHRUpload, { 
	  	endpoint: appDomain + '/reviews/photos'
	  })

	reviewsUppy.on('complete', (result) => {
	  successReviewSending()
	})

	function initLightBox () {
		const reviewImgGalleries = document.getElementsByClassName('review-gallery')
		for (let i = 0; i < reviewImgGalleries.length; i++) {
			const id = reviewImgGalleries[i].getAttribute("data-id")
			baguetteBox.run('.review-gallery-' + id)
		}
		
	}
})
