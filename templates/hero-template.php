<?php

/*
*
* Hero Slider : ACF Repeater (hero_slider)
* 
*/
if( have_rows('hero_slider') ) {
    while( have_rows('hero_slider') ) {
        the_row();
        echo '<div class="hero-section overlay">';
        echo 	'<div class="wp-custom-header">';
        echo		'<img src="' . get_sub_field('image')['url'] . '">';			
        echo 	'</div>';
        echo 	'<div class="wrap">';
        echo		'<h1>' . get_sub_field('title') . '</h1>';
        if ( get_sub_field('link') ) {
            echo	'<a href="' . get_sub_field('link')['url'] . '" class="button">' . get_sub_field('link')['title'] . '</a>';				
        }
        echo 	'</div>';
        echo '</div>';
        // print_r(get_sub_field('btn_text'));
    } 
};