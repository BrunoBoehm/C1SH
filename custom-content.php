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

	//* Partials located in /templates folder
	get_template_part( 'templates/hero-template' );

	get_template_part( 'templates/custom-template' );

}

// Build the page
get_header();
do_action( 'cush_content_area' );
get_footer();