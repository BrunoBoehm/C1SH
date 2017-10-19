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

	//* Partial located in /templates folder
	get_template_part( 'templates/custom-template' );

	if ( get_field('kpi_banner', 'option') ) {
		// var_dump(get_field('kpi_banner', 'option'));
		$kpi_banner = get_field('kpi_banner', 'option');
		echo '<section class="kpi-banner">';
		echo 	'<h3>' . $kpi_banner['title'] . '</h3>';
		echo 	'<div class="one-third first">';
		echo 		'<span class="kpi-count">' . $kpi_banner['members_count'] . '</span>';
		echo 		'<p class="kpi-text">' . $kpi_banner['members_text'] . '</p>';
		echo 	'</div>';
		echo 	'<div class="one-third">';
		echo 		'<span class="kpi-count">' . $kpi_banner['actions_count'] . '</span>';
		echo 		'<p class="kpi-text">' . $kpi_banner['actions_text'] . '</p>';
		echo 	'</div>';
		echo 	'<div class="one-third">';
		echo 		'<span class="kpi-count">' . $kpi_banner['stories_count'] . '</span>';
		echo 		'<p class="kpi-text">' . $kpi_banner['stories_text'] . '</p>';
		echo 	'</div>';
		echo 	'<div class="clearfix"></div>';				
		echo '</section>';
	}

	$main_cta_banner = get_field('main_cta_banner', 'option');
	if ( $main_cta_banner ) {
		echo '<section class="main-cta-banner">';
		echo 	'<h3>' . $main_cta_banner['title'] . '</h3>';
		echo 	'<a href="' . $main_cta_banner['btn_link']['url'] . '">' . $main_cta_banner['btn_text'] . '</a>';
		echo '</section>';
	}

}

// Build the page
get_header();
do_action( 'cush_content_area' );
get_footer();