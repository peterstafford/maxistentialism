<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class FrontPage extends Controller {


	public static function getFAQs() {
		$faq_args = array(
			'post_type' => 'faq',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => -1
		);

		$faqs = new WP_Query($faq_args);
		$faqs = $faqs->posts;
		$pages = array();

		foreach ($faqs as $faq) {
			$page = array(
				'question' => get_the_title($faq->ID),
				'answer' => apply_filters('the_content', $faq->post_content),
			);
			$pages[] = $page;
		}

		return $pages;
	}

	public static function getNews() {
		$news_args = array(
			'post_type' => 'news',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => -1
		);

		$news = new WP_Query($news_args);
		$news = $news->posts;
		$pages = array();

		foreach ($news as $item) {
			$page = array(
				'title' => get_the_title($item->ID),
				'body' => apply_filters('the_content', $item->post_content),
				'image' => get_the_post_thumbnail_url($item->ID),
				'podcast' => carbon_get_post_meta($item->ID, 'feed_url'),
			);
			$pages[] = $page;
		}

		return $pages;
	}
	
	public static function sectionLogo($text, $src) {
		$cart_count = WC()->cart->get_cart_contents_count();
		return '<div class="logo-with-title position-absolute h-100 z-10 logo-simple">
			<div class="">
				<img src="'.$src.'" alt="" class="d-none d-lg-inline mb-2"><span class="font-weight-bold text-uppercase">'.$text.'</span>
			</div>
		</div>';
	}
	public static function sectionLogoWtihCart($text, $count = 0) {
		$cart_count = WC()->cart->get_cart_contents_count();

		return '<div class="logo-with-title position-absolute h-100 z-10 logo-cart'.($cart_count > 0 ? '' : ' d-none').'" data-cart_count="'.$cart_count.'">
			<div class="img-container d-none d-lg-inline-block text-white px-2 text-uppercase text-center">
				<div class="logo-items">
					<img src="'.\App\asset_path('images/bullet 3@1x.png').'" class="d-inline-block bullet-3 w-25">
					<img src="'.\App\asset_path('images/bullet 4@1x.png').'" class="d-inline-block bullet-4 w-25">
					<span class="cart-total">'.$count.'</span>
					<img src="'.\App\asset_path('images/bullet 8@1x.png').'" class="d-inline-block bullet-8 w-25">
					<img src="'.\App\asset_path('images/bullet 2@1x.png').'" class="d-inline-block bullet-2 w-25">
				</div>
				<div class="cart-text">Cart</div>
				<div class="checkout-text"><a href="javascript:void(0);" class="text-white open-link">Checkout</a></div>
			</div>
			<span class="font-weight-bold text-uppercase">'.$text.'</span>
		</div>';
	}

	public static function headerLogoWithCart( $count = 0) {
		$cart_count = WC()->cart->get_cart_contents_count();

		return '<div class="logo-with-title h-100 z-10 logo-cart'.($cart_count > 0 ? '' : ' d-none').'" data-cart_count="'.$cart_count.'">
			<div class="img-container d-inline-block text-white px-2 text-uppercase text-center">
				<div class="logo-items">
					<img src="'.\App\asset_path('images/bullet 3@1x.png').'" class="d-inline-block bullet-3 w-25">
					<img src="'.\App\asset_path('images/bullet 4@1x.png').'" class="d-inline-block bullet-4 w-25">
					<span class="cart-total">'.$count.'</span>
					<img src="'.\App\asset_path('images/bullet 8@1x.png').'" class="d-inline-block bullet-8 w-25">
					<img src="'.\App\asset_path('images/bullet 2@1x.png').'" class="d-inline-block bullet-2 w-25">
				</div>
				<div class="cart-text">Cart</div>
			</div>
		</div>';
	}

	public static function getProducts() {
		
		$product_args = array(
			'post_type' => 'product',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => 8
		);

		$posts = new WP_Query($product_args);
		$posts = $posts->posts;
		
		// $products = wc_get_products( [
		// 	'status' => 'publish',
		// 	'limit' => 8,
		// ] );
		$pages = [];
		foreach ($posts as $post) {
			$product = wc_get_product($post->ID);
			$page = [
				'id' => $product->get_id(),
				'title' => $product->get_name(),
				'short_description' => $product->get_short_description(),
				'price' => $product->get_price(),
				'sale_price' => $product->get_sale_price(),
				'regular_price' => $product->get_regular_price(),
				'sku' => $product->get_sku(),
				'type' => $product->get_type(),
			];
			$pages[] = $page;
		}
		return $pages;
	}

	public static function getCart() {
		$cart = WC()->cart->get_cart();

		return $cart;

	}

}
