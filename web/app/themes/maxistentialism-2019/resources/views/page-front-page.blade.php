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
	@endphp
	

		<header class="bg-black-400 pb-20">
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
				<div class="col-6 offcanvas-collapse px-0">
					<h2 class="text-dark sidenav-title text-capitalize"><span class="sidenav-text"></span> <span class="close float-right">&times;</span></h2>
					<div class="row">
						<div class="choice unset danger-color border-4 open order">
							<div class="card-header p-0  ml-4"><h5 class="title text-uppercase">Your Order</h5></div>
							<div class="card-body mt-48">
								<div class="container-fluid">
									<!-- Title -->
									<h2 class="card-title text-left">Your Order</h2>
									<!-- Text -->
									<p class="card-text">{!! do_shortcode('[woocommerce_cart]') !!}</p>
									<!-- Button -->
									<a href="#" class="btn btn-primary">Button</a>
									
								</div>
							</div>
						</div>
						<div class="choice unset danger-color border-4 collapsed shipping">
							<div class="card-header p-0  ml-4"><h5 class="title text-uppercase">Shipping</h5></div>
							<div class="card-body mt-48">
								<div class="container-fluid">
									<!-- Title -->
									<h2 class="card-title text-left"><a>Card</a></h2>
									<!-- Text -->
									<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
									<!-- Button -->
									<a href="#" class="btn btn-primary">Button</a>
									
								</div>
							</div>
						</div>
						<div class="choice unset danger-color border-4 collapsed billing">
							<div class="card-header p-0  ml-4"><h5 class="title text-uppercase">Billing</h5></div>
							<div class="card-body mt-48">
								<div class="container-fluid">
									<!-- Title -->
									<h2 class="card-title text-left"><a>Card</a></h2>
									<!-- Text -->
									<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
									<!-- Button -->
									<a href="#" class="btn btn-primary">Button</a>
									
								</div>
							</div>
						</div>
						<div class="choice unset danger-color border-4 collapsed submit-order">
							<div class="card-header p-0  ml-4"><h5 class="title text-uppercase text-white">Submit Order</h5></div>
							<div class="card-body mt-48">
								<div class="container-fluid">
									
								</div>
								<!-- Title -->
								<h2 class="card-title text-left"><a>Card</a></h2>
								<!-- Text -->
								<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
								<!-- Button -->
								<a href="#" class="btn btn-primary">Button</a>
							</div>
						</div>
						
					</div>
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
		</section>
		<section class="shop-section position-relative">
			{!! FrontPage::sectionLogoWtihCart('shop', WC()->cart->get_cart_contents_count()) !!}
			{!! FrontPage::sectionLogo('shop', $logo) !!}
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
