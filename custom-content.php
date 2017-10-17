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
	};

	if( have_rows('content_blocks') ){
		while ( have_rows('content_blocks') ){
			the_row();
			if( get_row_layout() == 'text_block' ){
				echo '<section class="text-block">';
				if( get_sub_field('icon') ) {
					echo '<img src="' . get_sub_field('icon')['url'] . '">';
					echo '<h3>' . get_sub_field('title') . '</h3>';
				} else {
					echo '<h2>' . get_sub_field('title') . '</h2>';
				}
				echo '<p>' . get_sub_field('text') . '</p>';
				echo '</section>';
			} elseif ( get_row_layout() == 'quote_block' ) {
				echo '<section class"quote-block">';
				echo 	'<img src="' . get_sub_field('image')['url'] . '">';
				echo 	'<p>' . get_sub_field('text');
				echo	'<span>' . get_sub_field('autho') . '</span></p>';
				echo '</section>';
			} elseif ( get_row_layout() == '3_blurbs' ) {
				echo '<section class="3-blurbs">';
					// print_r(get_sub_field('3_blurbs'));
					$blurbs = get_sub_field('3_blurbs');
					$i = 0;
					foreach($blurbs as $blurb) {
						// print_r($blurb);
						if ( $i == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
						echo 	'<div class="blurb">';
						echo 		'<img src="' . $blurb['image']['url'] . '">';
						echo 		'<h4>' . $blurb['title'] . '</h4>';
						echo 		'<p>' . $blurb['text'] . '</p>';
						echo		'<a href="' . $blurb['btn_link']['url'] . '" title="' . $blurb['btn_link']['title'] . '">' . $blurb['btn_text'] . '</a>';
						echo 	'</div>';
						echo '</div>';
						$i++;
					}
				echo '<div class="clearfix"></div>';	
				echo '</section>';
			} elseif ( get_row_layout() == 'post_selection' ) {
				echo '<section class="post-selection">';
					$posts = get_sub_field('post_selection');
					$i = 0;
					foreach($posts as $post) {
						if ( $i == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
						echo 	'<div class="post">';
						echo 		'<img src="' . wp_get_attachment_url(get_post_thumbnail_id($post->ID)) . '" alt="" title="">';
						echo 		'<h4>' . $post->post_title . '</h4>';
						echo 	'</div>';
						echo '</div>';
						$i++;
					}
					echo '<div class="clearfix"></div>';	
				echo '</section>';	
			} elseif ( get_row_layout() == '2_blocks' ) {
				echo '<section class="2-blocks">';
					$blocks = get_sub_field('2_blocks');
					$i = 0;
					foreach($blocks as $block) {
						if ( $i == 0 ){ echo '<div class="one-half first">'; } else { echo '<div class="one-half">'; }
						echo 	'<div class="cta-block">';
						// print_r($block);
						echo		'<div class="cta-block-img">';
						echo			'<img src="' . $block['image']['url'] . '" alt="' . $block['image']['alt'] . '" title="' . $block['image']['description'] . '">';
						echo		'</div>';
						echo		'<div class="cta-block-content">';
						echo			'<h4>' . $block['title'] . '</h4>';
						echo			'<p>' . $block['text'] . '</p>';
						echo			'<a href="' . $block['button_link']['url'] . '">' . $block['button_text'] . '</a>';
						echo		'</div>';
						echo 	'</div>';
						echo '</div>';
						$i++;
					}
				echo '<div class="clearfix"></div>';	
				echo '</section>';
			} elseif ( get_row_layout() == 'video_cta_banner' ) {
				$video_cta_banner_code = get_sub_field('banner_slug');
				$video_cta_banner = get_field($video_cta_banner_code, 'option');
				// print_r($video_cta_banner);
				echo '<section class="video-cta-banner">';
				echo 	'<div class="video-cta-banner-video">' . $video_cta_banner['video_link'] . '</div>';
				echo 	'<h3>' . $video_cta_banner['title'] . '</h3>';
				echo 	'<div class="video-cta-banner-video-html">' . $video_cta_banner['html'] . '</div>';
				echo 	'<a href="' . $video_cta_banner['btn_link']['url'] . '" title="' . $video_cta_banner['btn_link']['title'] . '">' . $video_cta_banner['btn_text'] . '</a>';
				echo '</section>';
			}
		}
	};

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