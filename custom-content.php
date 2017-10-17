<?php

/**
* Theme customizations
* @package    C1SH
* @author     Bruno Boehm
* @link       https://www.lyketil.com
* @copyright  Copyright © 2017, Bruno Boehm
* @license    GPL-2.0+ 
*/

//* Template Name: Custom Content

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets', 'footer' ) );

// Add .full class to .site-inner
add_filter( 'genesis_attr_site-inner', 'cush_site_inner_attr' );

function cush_site_inner_attr( $attributes ) {
	$attributes['class'] .= ' full';
	// Add the attributes from .entry, since this replaces the main entry
	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );
	return $attributes;
}

// Create a hook to echo front page content
add_action( 'cush_content_area', 'cush_custom_page' );

function cush_custom_page() {

	if( have_rows('hero_slider') ) {
		while( have_rows('hero_slider') ) {
			the_row();
			echo '<div class="hero-section overlay">';
			echo 	'<div class="wp-custom-header">';
			echo		'<img src="' . get_sub_field('image')['url'] . '">';			
			echo 	'</div>';
			echo 	'<div class="wrap">';
			echo		'<h1>' . get_sub_field('title') . '</h1>';
			echo		'<a href="' . get_sub_field('btn_link')['url'] . '">' . get_sub_field('btn_text') . '</a>';
			echo 	'</div>';
			echo '</div>';
			// print_r(get_sub_field('btn_text'));
		} 
	}
}

// Build the page
get_header();
do_action( 'cush_content_area' );
get_footer();