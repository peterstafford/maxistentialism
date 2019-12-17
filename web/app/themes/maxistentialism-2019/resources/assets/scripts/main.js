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

	
	$(".choice").on("click", function() {
		$(".choice").removeClass("open unset ").addClass("collapsed");
		$(this).removeClass("collapsed").addClass("open");
	});
	let total = $('.logo-cart').data('cart_count') || 0;
	$('.ajax_add_to_cart').on('click', function() {
		let _this = $(this);

		let timeout = setInterval(function() {
			if (_this.hasClass('added')) {
				total++;
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
});