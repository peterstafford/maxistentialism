<!--
  Page: Front Page
  @package brightbrightgreat/maxistentialism-2019
  @author  Bright Bright Great <sayhello@brightbrightgreat.com>
-->
@php 
use App\Controllers\FrontPage;
@endphp
@extends('layouts.app')

@section('content')
	@while(have_posts())

	@php
		the_post();
		$logo = App\asset_path('images/fixed logo@1x.png');
		$slider = \App\Controllers\FrontPage::getNews();
		$headline = carbon_get_post_meta(get_the_ID(), 'hero_body');
		$sub_hero = carbon_get_post_meta(get_the_ID(), 'sub_hero_snippet');
		$email = carbon_get_post_meta(get_the_ID(), 'hero_email');
		$l_snippet = carbon_get_post_meta(get_the_ID(), 'hero_link_snippet');
		$link = carbon_get_post_meta(get_the_ID(), 'hero_link');
		$l_text = carbon_get_post_meta(get_the_ID(), 'hero_link_text');
		$press_links = carbon_get_post_meta(get_the_ID(), 'press_links');
		$faqs = \App\Controllers\FrontPage::getFAQs();
		$links_email = carbon_get_post_meta(get_the_ID(), 'links_email');

		$is_empty_cart = WC()->cart->is_empty();
		// $is_empty_cart = true;
	@endphp

		<header class="bg-black-400 pb-20">
			<div class="fixed-top d-lg-none {{WC()->cart->get_cart_contents_count() > 0 ? '' : 'd-none'}}">
				<div class="row bg-black checkout-header">
					<div class="col">
						{!! FrontPage::headerLogoWithCart(WC()->cart->get_cart_contents_count()) !!}
					</div>
					<div class="col text-center">
						<button class="btn bg-light rounded-0 my-3 open-link">Checkout</button>
					</div>
					<div class="col">
						
					</div>
				</div>
			</div>
			<div class="px-6 max-w-8xl relative sm:px-10 md:pr-20 md:pl-48 md:pt-16 lg:pr-20 lg:pl-48 xl:px-48 xl:mx-auto">
				<h1 class="color-a leading-snug text-h1 font-sans font-700 text-white-400 mb-16">
					<div class="bg-black-400 md:absolute">
						<div class="py-8 md:hidden">
							{{svg('header-logo')}}
						</div>
						<div class="hidden head-logo md:block md:absolute text-center">
							{{-- <a href="javascript:void(0);" class="open-cart open-link mr-2" data-link="cart">Cart</a>
							<a href="javascript:void(0);" class="open-checkout open-link" data-link="checkout">Checkout</a> --}}
							{{svg('header-logo-2')}}
						</div>
					</div>
					{!! $headline !!}
				</h1>
				<div class="col-lg-6 offcanvas-collapse">
					<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>" enctype="multipart/form-data">
						<div class="row vh-100">
							<div class="col-12">
								<div class="row bg-black checkout-header d-lg-none">
									<div class="col">
										{!! FrontPage::headerLogoWithCart(WC()->cart->get_cart_contents_count()) !!}
									</div>
									<div class="col text-center">
										<div class="mt-4 text-light">Checkout</div>
									</div>
									<div class="col">
										<span class="close-offcanvas text-light float-right">&times;</span>
									</div>
								</div>
							</div>
								<div class="choice border-4 open order">
									<div class="card-header p-lg-0 {{!$is_empty_cart ? 'next-tab-bar' : ''}}"><div class="title text-uppercase">Your Order</div></div>
									<div class="card-body position-relative">
										<div class="text-dark sidenav-title text-capitalize position-absolute"><span class="close">&times;</span></div>
										<div class="container-fluid lg:mt-10">
											<!-- Title -->
											<h2 class="card-title text-left">Your Order</h2>
											<!-- Text -->
											<div class="card-text overflow-hidden">
												{!! do_shortcode('[woocommerce_cart]') !!}

												<button class="btn rounded-0 bg-black-400 text-light btn-block {{!$is_empty_cart ? 'next-tab' : ''}}" {{ $is_empty_cart ? 'disabled' : '' }} type="button">NEXT</button>
											</div>
											
										</div>
									</div>
								</div>
								<div class="choice border-4 collapsed shipping">
									<div class="card-header p-lg-0"><div class="title text-uppercase">Shipping</div></div>
									<div class="card-body position-relative">
										<div class="text-dark sidenav-title text-capitalize position-absolute"><span class="close">&times;</span></div>
										<div class="container-fluid lg:mt-10">
											<!-- Title -->
											<h2 class="card-title text-left">Tell me where to <br>to ship this.</h2>
											<!-- Text -->
											<div class="card-text overflow-hidden">
												
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="First Name *" name="billing_first_name">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Last Name *" name="billing_last_name">
												</div>
												<div class="form-group">
													<input type="text" class="form-control border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Company (optional)" name="billing_company">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Address *" name="billing_address_1">
												</div>
												<div class="form-group">
													<input type="text" class="form-control border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Apartment, suite, unit etc. (optional)" name="billing_address_2">
												</div>
												<div class="form-group">
													<select name="billing_country" class="form-control required border-4 rounded-0 bg-transparent p-3 text-dark">
														<option value="">Select a country…</option>
														@foreach(WC()->countries->get_countries() as $code => $name) 
															<option value="{{$code}}">{{$name}}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="City *" name="billing_city">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="State *" name="billing_state">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Postcode *" name="billing_postcode">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Phone *" name="billing_phone">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Email *" name="billing_email">
												</div>
												<button class="btn rounded-0 bg-black-400 text-light btn-block" disabled type="button">NEXT</button>
											</div>
											
										</div>
									</div>
								</div>
								<div class="choice border-4 collapsed billing">
									<div class="card-header p-lg-0"><div class="title text-uppercase">Billing</div></div>
									<div class="card-body position-relative">
										<div class="text-dark sidenav-title text-capitalize position-absolute"><span class="close">&times;</span></div>
										<div class="container-fluid lg:mt-10">
											<!-- Title -->
											<h2 class="card-title text-left">Tell me who's <br>paying for this.</h2>
											<!-- Text -->
											<div class="card-text overflow-hidden">
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="First Name *" name="shipping_first_name">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Last Name *" name="shipping_last_name">
												</div>
												<div class="form-group">
													<input type="text" class="form-control border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Company (optional)" name="shipping_company">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Address *" name="shipping_address_1">
												</div>
												<div class="form-group">
													<input type="text" class="form-control border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Apartment, suite, unit etc. (optional)" name="shipping_address_2">
												</div>
												<div class="form-group">
													<select name="billing_country" class="form-control required border-4 rounded-0 bg-transparent p-3 text-dark">
														<option value="">Select a country…</option>
														@foreach(WC()->countries->get_countries() as $code => $name) 
															<option value="{{$code}}">{{$name}}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="City *" name="shipping_city">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="State *" name="shipping_state">
												</div>
												<div class="form-group">
													<input type="text" class="form-control required border-4 rounded-0 bg-transparent p-4 text-dark" placeholder="Postcode *" name="shipping_postcode">
												</div>
												<button class="btn rounded-0 bg-black-400 text-light btn-block" disabled type="button">NEXT</button>
												{{-- {{wp_create_nonce( 'wc_checkout_form' )}} --}}
												{{-- {!! wp_nonce_field( 'wc_checkout_form' ) !!} --}}
											</div>
											
										</div>
									</div>
								</div>
								<div class="choice border-4 collapsed submit-order">
									<div class="card-header p-lg-0"><div class="title text-uppercase text-white">Submit Order</div></div>
									<div class="card-body position-relative">
										<div class="text-dark sidenav-title text-capitalize position-absolute"><span class="close text-light">&times;</span></div>
										<div class="container-fluid lg:mt-10">
											<!-- Title -->
											<h2 class="card-title text-left">Make sure this <br>looks right.</h2>
											<!-- Text -->
											<div class="card-text overflow-hidden">
												<div class="container-fluid">
													<div id="result"></div>
													{{do_action( 'woocommerce_checkout_order_review' )}}
												</div>
												{{-- <input type="hidden" name="payment_method" value="">
												<input type="hidden" name="woocommerce-process-checkout-nonce" value="{{wp_create_nonce( 'wc_checkout_form' )}}"> --}}
											</div>
										</div>
									</div>
								</div>
							
						</div>
					</form>
				</div>
				<div class="max-w-2xl">
					<article class="leading-normal text-white-400">
						{!! $sub_hero !!}
					</article>
				</div>
			</div>
		</header>

		@if ($slider)
			@include('partials/front-page-tabs')
		@endif

		@if ($faqs)
			<section id="faq-section" style="background-image: url('@asset('images/Shapes Background@2x.png')')" class="position-relative">
				{!! FrontPage::sectionLogo('faq', $logo) !!}
				<accordion :items="{{ json_encode( $faqs) }}"></accordion>
			<br>
			{{-- {!! do_action( 'woocommerce_checkout_billing' ) !!}
			{!! do_action( 'woocommerce_checkout_order_review' ) !!} --}}
			</section>
		@endif

		<section class="contact-form py-20 px-8 bg-lightblue-400 text-black-400 border-4 position-relative px-0">
			{!! FrontPage::sectionLogo('updates', $logo) !!}
			@php
				$contact_title = carbon_get_post_meta(get_the_ID(), 'contact_title');
				$contact_body = carbon_get_post_meta(get_the_ID(), 'contact_body');
				$contact_success = carbon_get_post_meta(get_the_ID(), 'contact_success');

				if (!$contact_success) {
					$contact_success = 'Message Sent!';
				}
			@endphp
			<div class="text-center mx-auto max-w-3xl">
				<h2 class="block leading-tight">
					{!! $contact_title !!}
				</h2>

				<article class="mt-10">
					{!! $contact_body !!}
				</article>

				<div v-if="!subscribed" class="w-full">
					<form @submit.prevent="subscribe" class="mt-8 md:mt-12" novalidate>
						<div class="md:flex md:-mx-4">
							<div class="w-full mb-8 md:mx-4">
								<div class="relative">
									<span v-if="showErrors && firstNameError" class="error-label absolute left-0 font-sans text-xs text-left text-red-400 transition-opacity" v-text="firstNameError"></span>
									<input v-model="first_name" type="text" placeholder="First name" :class="{'border-red-400': firstNameError && showErrors}" class="block border-4 border-black-400 w-full h-16 p-4 font-sans text-lg font-700 outline-none transition-border-color" required>
								</div>

								<div class="hidden items-center mt-2 md:flex">
									<label class="checkcontainer">
										<span>I live in Chicago</span>
										<input v-model="city" type="checkbox">
										<span class="checkmark"></span>
									</label>
								</div>
							</div>
							<div class="relative w-full mb-8 md:mx-4">
								<span v-if="showErrors && emailError" class="error-label absolute left-0 font-sans text-xs text-left text-red-400 transition-opacity" v-text="emailError"></span>
								<input v-model="email" @change="emailIsValid(email)" type="email" placeholder="Email address" :class="{'border-red-400': emailError && showErrors}" class="block border-4 border-black-400 w-full h-16 p-4 font-sans text-lg font-700 outline-none transition-border-color">
							</div>
						</div>

						<div class="flex justify-center items-center mb-8 md:hidden">
							<label class="checkcontainer">
								<span>I live in Chicago</span>
								<input v-model="city" type="checkbox">
								<span class="checkmark"></span>
							</label>
						</div>

						<button type="submit" class="w-40 h-16 bg-black-400 hover:bg-white-400 transition-bg text-white-400 hover:text-black-400 transition-text text-center font-sans font-700 text-lg leading-tight tracking-wide uppercase">
							Submit
						</button>
					</form>
				</div>

				<div v-if="!!subscribed" class="flex flex-col justify-center items-center text-center mt-12">
					<div class="w-28 h-24">
						@php svg('message-sent'); @endphp
					</div>

					<span class="block mt-8 text-h2">
						{!! $contact_success !!}
					</span>
				</div>
			</div>
			{{-- {{var_dump(bazaarvoice_data())}} --}}
			{{-- {!! do_shortcode('[woocommerce_cart]') !!} --}}
			{{-- {{ print_r( FrontPage::getCart() ) }} --}}
		</section>
		<section class="shop-section position-relative">
			<div class="{{ (WC()->cart->get_cart_contents_count() > 0 ? '' : ' d-none') }} section-logo-container">
				{!! FrontPage::sectionLogoWtihCart('shop', WC()->cart->get_cart_contents_count()) !!}
			</div>
			<div class="{{ (WC()->cart->get_cart_contents_count() > 0 ? 'd-none' : '') }} simple-logo-container">
				{!! FrontPage::sectionLogo('shop', $logo) !!}
			</div>
			<div class="container py-5">
				<div class="row">
					@foreach(FrontPage::getProducts() as $product)
						<div class="col-sm-6 col-md-4 col-lg-3">
							<div class="card mb-4 woocommerce border-4 rounded-0">
								<img src="https://via.placeholder.com/140x100" class="card-img-top rounded-0" alt="">
								<div class="card-body">
									<h4 class="card-title text-center">{{$product['title']}}</h4>
									<p class="card-text">{{$product['short_description']}}</p>
								</div>
								<div class="card-footer font-weight-bold text-uppercase p-0">
									<h4>
										<a href="#" class="button product_type_{{$product['type']}} add_to_cart_button ajax_add_to_cart text-light btn-block rounded-0 px-md-2 px-lg-3" data-quantity="1" data-product_id="{{$product['id']}}" data-product_sku="{{$product['sku']}}">
											Add to Cart <span class="float-right price">${{$product['price']}}</span>
										</a>
									</h4>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>

		<section class="border-b-4 border-r-4 border-l-4 bg-grey-400 position-relative">
			{!! FrontPage::sectionLogo('press', $logo) !!}
			<div class="px-6 py-20 max-w-4xl md:mx-auto md:px-12">
				<div class="mb-16 col-2-break">
				@foreach ($press_links as $link)
					<div class="flex items-center font-sans hover:text-red-400 transition-all">
						<a class="font-700" target=”_blank” href="{!! $link['url'] !!}">
							<h6>{!! $link['title'] !!}</h6>
						</a>
						<p class="font-200 text-xs ml-2 font-700">
							{!! $link['date'] !!}
						</p>
					</div>
				@endforeach
				</div>
				<p class="mb-10">
					For press and inquiries, you can reach me at
					<a href="mailto:{!! $links_email !!}" class=" text-red-400 leading-normal red-link transition-all">
						Max (at) Temkin (dot) com.
					</a>
				</p>
			</div>
		</section>

	@endwhile
@endsection
