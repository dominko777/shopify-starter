import "../css/reviews.css";
var rater = require("rater-js")
import 'tingle.js/dist/tingle.min.css'
import tingle from 'tingle.js/dist/tingle.min.js'
const axios = require('axios');
const appDomain = "http://shopify-test.local"
axios.baseURL = appDomain

document.addEventListener("DOMContentLoaded", function(event) {
    var avgRater = rater({element: document.getElementById('star-rating'), starSize: 22});
	avgRater.disable();

	var averageRatingInfoBlock = document.getElementsByClassName('average-rating-info')[0]
	let settings = {}

	const reviewAppBtn = document.getElementsByClassName('review-app-btn')[0]
	if (reviewAppBtn) {
		axios.get(appDomain + '/reviews/average-stars/' + reviewAppBtn.getAttribute("data-product"))
	      .then(response => {
	        avgRater.setRating(response.data.average)
	        settings = response.data.settings
	        if (parseInt(response.data.settings.rating) === 1) {
	        	document.getElementById('average-rating').textContent = response.data.average
			    averageRatingInfoBlock.style.visibility = 'visible'
	        } else { 
	        	averageRatingInfoBlock.style.display = 'none'
	        }
			document.getElementsByClassName('tingle-modal-box__content')[0].style['background-color'] = response.data.settings.modal_background_color
			document.getElementsByClassName('tingle-modal-box__footer')[0].style['background-color'] = response.data.settings.modal_background_color
	      })
	      .catch(error => {
	          console.log(error);
	      });
	}
	

	

	function addReiew() {

	}

	var reviewBtn = document.querySelector(".review-app-btn")
	reviewBtn.addEventListener('click', function () {
		console.log('Btn: ' + this)
	})

	const formRater = null
	var modal = new tingle.modal({
	    footer: true,
	    stickyFooter: false,
	    closeMethods: ['overlay', 'button', 'escape'],
	    closeLabel: "Close",
	    cssClass: ['custom-class-1', 'custom-class-2'],
	    onOpen: function() {
	    	const formRating = document.getElementById('form-rating')
	    	if (parseInt(settings.rating) !== 1) {
	    		formRating.style.display = 'none'
	    	} else {
	    		var formRater = rater({element: document.getElementById('form-rating'), starSize: 22});
	    	}
	    },
	    onClose: function() {
	        // console.log('modal closed');
	    },
	    beforeClose: function() {
	        return true;
	        return false;
	    }
	});
	modal.setContent('<h2>Review</h2><div id="form-rating"></div><div id="review-form">' + 
		    '<input id="review-name-input" name="name" type="text" placeholder="Name">' + 
		    '<span id="review-name-input-error" class="invalid-feedback">Please enter your name</span>' + 
		    '<textarea id="review-description-textarea" rows="7" name="name" placeholder="Review"></textarea>' + 
		    '<span id="review-description-textarea-error" class="invalid-feedback">Please enter your review</span>' + 
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
				productId: reviewAppBtn.getAttribute("data-product"),
				stars: formRater ? formRater.getRating() : ''
			})
	      .then(response => {
	        avgRater.setRating(response.data.average)
	        settings = response.data.settings
	        if (parseInt(response.data.settings.rating) === 1) {
	        	document.getElementById('average-rating').textContent = response.data.average
			    averageRatingInfoBlock.style.visibility = 'visible'
	        } else { 
	        	averageRatingInfoBlock.style.display = 'none'
	        }
			document.getElementsByClassName('tingle-modal-box__content')[0].style['background-color'] = response.data.settings.modal_background_color
			document.getElementsByClassName('tingle-modal-box__footer')[0].style['background-color'] = response.data.settings.modal_background_color
	      })
	      .catch(error => {
	          console.log(error);
	      });
	})
	modal.addFooterBtn('Cancel', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function() { 
		modal.close()
	})
	document.getElementsByClassName('review-app-btn')[0].addEventListener("click", function () {
		modal.open(); 
	});

})
