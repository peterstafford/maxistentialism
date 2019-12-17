<?php

function create_posttype() {

    register_post_type( 'faq',
        array(
            'labels' => array(
                'name' => __('FAQs'),
                'singular_name' => __('FAQ')
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => array(
                'slug' => 'faq',
                'with_front' => false
            ),
            'supports' => array('title', 'editor', 'page-attributes'),
            'hierarchical' => false,
            'menu_icon' => 'dashicons-format-chat',
        )
    );

    register_post_type( 'news',
        array(
            'labels' => array(
                'name' => __('News'),
                'singular_name' => __('News')
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => array(
                'slug' => 'news',
                'with_front' => false
            ),
            'supports' => array('title', 'editor', 'page-attributes', 'thumbnail'),
            'hierarchical' => false,
            'menu_icon' => 'dashicons-megaphone',
        )
    );

}
add_action('init', 'create_posttype');