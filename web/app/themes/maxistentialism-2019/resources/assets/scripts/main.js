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

function isElementLoaded(el, className, cb, timer = 100) {
	let promise = new Promise(function(resolve, reject) {
		let timeOut = setInterval(function() {
			if (el.hasClass(className)) {
				cb(el);
				clearInterval(timeOut);
				resolve(el);
			}
		}, timer);
	});
	return promise;
}
function validateTab(el) {
	let required = $(el).find('.required');

	$(required).on('input focusout keypress change', function(e) {
		let filled = $(el).find('.form-group.filled');
		let $target = $(e.target);
		if ($target.is('select')) {
			if (!$target.find('option:selected').val() == '') {
				$target.closest('.form-group').addClass('filled');
			} else {
				$target.closest('.form-group').removeClass('filled');
			}
		}

		if ($target.is('input') || $target.is('textarea')) {
			if (!$target.val() == '') {
				$target.closest('.form-group').addClass('filled');
			} else {
				$target.closest('.form-group').removeClass('filled');
			}
		}

		if ($target.closest('.form-group').hasClass('filled')) {
			$target.closest('.form-group').find('input[type="hidden"]').attr('value', $target.val());			
		} else {
			$target.closest('.form-group').find('input[type="hidden"]').attr('value', '');			
		}

		if (required.length == filled.length) {
			$(el).find('.btn.btn-block').prop('disabled', false);
			$(el).find('.card-header').addClass('next-tab-bar');
			$(el).next('.choice').find('.card-header').addClass('next-tab-bar');
		} else {
			$(el).find('.btn.btn-block').prop('disabled', true);
			$(el).find('.card-header').removeClass('next-tab-bar');
			$(el).next('.choice').find('.card-header').removeClass('next-tab-bar');
		}
	});

}

function mutationCB(mutationsList, observer) {
	$('#wc-stripe-cc-form').trigger('stripe-element-change');
}
async function validateTabStrip(stripeTab) {
	let config = { attributes: true, childList: false, subtree: false };
	let tab = $(stripeTab);
	let required = tab.find('.wc-stripe-elements-field');
	let stripe_card = tab.find( '#stripe-card-element' );
	let stripe_exp 	= tab.find( '#stripe-exp-element' );
	let stripe_cvc 	= tab.find( '#stripe-cvc-element' );

	// Create an observer instance linked to the callback function
	const observer = new MutationObserver(mutationCB);

	// Start observing the target node for configured mutations
	observer.observe(stripe_card[0], config);
	observer.observe(stripe_exp[0], config);
	observer.observe(stripe_cvc[0], config);

	$('#wc-stripe-cc-form').on('stripe-element-change', function(e) {
		if ($('#payment').length) {
			$('#payment').find('.payment_methods').remove();
		}

		let filled = $(e.target).find('.wc-stripe-elements-field.StripeElement--complete');
		if (filled.length == 3) {
			$(tab).find('.btn.btn-block').prop('disabled', false);
			$(tab).find('.card-header').addClass('next-tab-bar');
			$(tab).next('.choice').find('.card-header').addClass('next-tab-bar');
		} else {
			$(tab).find('.btn.btn-block').prop('disabled', true);
			$(tab).find('.card-header').removeClass('next-tab-bar');
			$(tab).next('.choice').find('.card-header').removeClass('next-tab-bar');
		}
	});
	// let filled = tab.find('.wc-stripe-elements-field.StripeElement--complete');

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
	validateTabStrip('.choice.billing');

	// Ajax form on checkout form
	let checkoutForm = $('form.checkout-ajax');
	
	if (checkoutForm.find('#payment').length) {
		checkoutForm.find('#payment .payment_methods').remove();
	}
	$( document.body ).trigger('updated_checkout');
	let submitBtn = $(checkoutForm).find('#place_order');
	let submitBtnHtml = submitBtn.html();
	checkoutForm.ajaxForm({
		beforeSubmit: function(formData, $form, options) {
			submitBtn.prop('disabled', true).html('Please Wait...');
		},
		success: function(response, textStatus, jqXHR, $form) {
			$(checkoutForm).find('#place_order').prop('disabled', false).html(submitBtnHtml);
			$(checkoutForm).find('#result').html(response.messages);
		}
	});

	let quantityArrows = `<div class="quantity-nav row">
		<div class="quantity-button quantity-up col-1">+</div>
		<div class="quantity-value col-1">1</div>
		<div class="quantity-button quantity-down col-1">-</div>
	</div>`;
	let productQtyContainer = '.offcanvas-collapse .woocommerce table.shop_table .product-quantity .quantity';
	$(productQtyContainer).append(quantityArrows);

	$(productQtyContainer).each(function() {
		var spinner = $(this),
		input = spinner.find('input[type="number"]'),
		btnUp = spinner.find('.quantity-up'),
		btnDown = spinner.find('.quantity-down'),
		qtyContainer = spinner.find('.quantity-value'),
		min = input.attr('min'),
		max = input.attr('max');

		btnUp.click(function() {
			var oldValue = parseFloat(input.val());
			if (max !== '') {
				if (oldValue >= max) {
					var newVal = oldValue;
				} else {
					var newVal = oldValue + 1;
				}
			} else {
				var newVal = oldValue + 1;
			}
			qtyContainer.text(newVal);
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		});

		btnDown.click(function() {
			var oldValue = parseFloat(input.val());
			if (min !== '') {
				if (oldValue <= min) {
					var newVal = oldValue;
				} else {
					var newVal = oldValue - 1;
				}
			} else {
				var newVal = oldValue - 1;
			}
			qtyContainer.text(newVal);
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		});
	});

	let cartRows = '.offcanvas-collapse .woocommerce table.shop_table tbody tr.cart_item';
	let cartSubTotal = 0.00;
	$(cartRows).each(function() {
		let tr = $(this);
		let amount = tr.find('.product-subtotal .amount').text().replace(/\$/g, '');
		amount = parseFloat(amount);
		cartSubTotal += amount;
	});
	$(`.offcanvas-collapse .woocommerce`).append(`<div class="row"><div class="col-md-12"><h2>Subtotal: <span class="float-right">$<span class="currency-symbol">${cartSubTotal}</span></span></h2></div></div>`);
});