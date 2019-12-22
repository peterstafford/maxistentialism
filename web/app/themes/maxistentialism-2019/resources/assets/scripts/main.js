require('./bootstrap');

// instantiate Vue instance on page
new Vue({
	el: '#app',

	data: {
		first_name: '',
		email: '',
		city: false,

		showErrors: false,
		subscribing: false,
		subscribed: false,
	},

	methods: {
		subscribe() {
			this.showErrors = false;

			if (!this.canSubscribe) {
				if (this.hasErrors) {
					this.showErrors = true;
				}

				return;
			}

			this.subscribing = true;

			axios.post('/wp-json/maxistentialism-2019/v1/subscribers', {
				first_name: this.first_name,
				email: this.email,
				city: this.city,
			})
			.then(() => {
				this.subscribing = false;
				this.subscribed = true;
			})
			.catch(() => {
				this.subscribing = false;
			});
		},

		emailIsValid(email) {
			var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return regex.test(email);
		},
	},

	computed: {
		canSubscribe() {
			return !this.subscribing
				&& !this.hasErrors;
		},

		hasErrors() {
			return this.firstNameError ||this.emailError;
		},

		firstNameError() {
			if (this.first_name === '') return 'A name is required';

			return null;
		},

		emailError() {
			if (this.email === '') return 'An email is required';

			if ( ! this.emailIsValid(this.email)) return 'A valid email is required';

			return null;
		},
	}
});

$ = jQuery.noConflict();
function validateTab(el) {
	let required = $(el).find('.required');

	$(required).on('input focusout keypress change', function(e) {
		let filled = $(el).find('.form-group.filled');
		if ($(e.target).is('select')) {
			if (!$(e.target).find('option:selected').val() == '') {
				$(e.target).closest('.form-group').addClass('filled');
			} else {
				$(e.target).closest('.form-group').removeClass('filled');
			}
		}

		if ($(e.target).is('input')) {
			if (!$(e.target).val() == '') {
				$(e.target).closest('.form-group').addClass('filled');
			} else {
				$(e.target).closest('.form-group').removeClass('filled');
			}
		}

		if ($(e.target).is('textarea')) {
			if (!$(e.target).val() == '') {
				$(e.target).closest('.form-group').addClass('filled');
			} else {
				$(e.target).closest('.form-group').removeClass('filled');
			}
		}

		if (required.length == filled.length) {
			$(el).find('.btn.btn-block').addClass('next-tab').prop('disabled', false);
			$(el).find('.card-header').addClass('next-tab-bar');
			$(el).next('.choice').find('.card-header').addClass('next-tab-bar');
		} else {
			$(el).find('.btn.btn-block').removeClass('next-tab').prop('disabled', true);
			$(el).find('.card-header').removeClass('next-tab-bar');
			$(el).next('.choice').find('.card-header').removeClass('next-tab-bar');
		}
	});

}
$(function() {
	$('.open-link').on('click', function() {
		let linkName = $(this).data('link');
		$('.offcanvas-collapse').addClass('open');
		$('.sidenav-text').text(linkName);
		$('header.bg-black-400 .fixed-top').addClass('d-none');
	});

	$('.offcanvas-collapse .sidenav-title .close, .close-offcanvas').on('click', function(e) {
		$(this).closest('.offcanvas-collapse').removeClass('open');
		$('header.bg-black-400 .fixed-top').removeClass('d-none');
	});

	
	$(document).on("click", ".choice .card-header.next-tab-bar", function(e) {
		e.stopPropagation();
		$(".choice").removeClass("open").addClass("collapsed");
		$(this).closest(".choice").removeClass("collapsed").addClass("open");
	});


	let total = $('.logo-cart').data('cart_count') || 0;
	$('.ajax_add_to_cart').on('click', function() {
		let _this = $(this);

		let timeout = setInterval(function() {
			if (_this.hasClass('added')) {
				total++;
				$('header .fixed-top').removeClass('d-none').find('.cart-total').text(total);
				$('.checkout-header').find('.cart-total').text(total);
				$('.simple-logo-container').addClass('d-none');
				$('.logo-cart').removeClass('d-none');
				$('.section-logo-container').removeClass('d-none').find('.cart-total').text(total);
				clearInterval(timeout);
			}
		}, 100);

		// $.post(site_url.ajaxurl, {'action': 'update_cart'}).done(function(response) {
		// 	$('.sidenav-title').find('.choice.order').find('.container-fluid .card-text').html(response);
		// });
	});

	// checkout tabs
	$(document).on('click', '.next-tab', function(e) {
		$('.choice').removeClass('open').addClass('collapsed');
		$(this).closest('.choice').next('.choice').removeClass('collapsed').addClass('open');
	});


	// tabs validation
	validateTab('.choice.shipping');
	validateTab('.choice.billing');

	// Ajax form on checkout form
	let checkoutForm = $('form.woocommerce-checkout');
	checkoutForm.ajaxForm({
		beforeSubmit: function(formData, $form, options) {
			submitBtn = $($form).find('#place_order');
			submitBtnHtml = submitBtn.html();
			submitBtn.prop('disabled', true).html('Please Wait...')
		},
		success: function(response, textStatus, jqXHR, $form) {
			$($form).find('#place_order').prop('disabled', false).html(submitBtnHtml);
			$($form).find('#result').html(response.messages);
		}
	});
});