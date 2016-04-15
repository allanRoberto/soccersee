<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

add_action('after_setup_theme', 'azexo_load_childtheme_languages', 5);

function azexo_load_childtheme_languages() {
    /* this theme supports localization */
    load_child_theme_textdomain('sport-ak', get_stylesheet_directory() . '/languages');
}


add_action('wp_enqueue_scripts', 'azexo_custom_scripts');

function azexo_custom_scripts() {
    wp_register_script('custom-js', get_template_directory_uri() . '-child/js/custom.js', array('jquery'), AZEXO_THEME_VERSION, true);
    wp_enqueue_script('custom-js');
}

add_action( 'wp_ajax_load_checkout', 'load_checkout' );
add_action( 'wp_ajax_nopriv_load_checkout', 'load_checkout' );


function load_checkout() {
	$id=20; 
	$post = get_post($id); 
	$content = apply_filters('the_content', $post->post_content); 
	return $content; 
	wp_die();
}


/* Please add your custom functions code below this line. */


