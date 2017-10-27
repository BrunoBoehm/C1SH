<?php

/*
*
* Hero Slider : ACF Repeater (hero_slider)
* 
*/
if( have_rows('hero_slider') ) {
    while( have_rows('hero_slider') ) {
        the_row();
        $related_institutions = get_field('related_institution');
        $related_actions = get_field('related_action');
        // print_r($related_institution);

        echo '<div class="hero-section overlay">';
        echo 	'<div class="wp-custom-header">';
        echo		'<img src="' . get_sub_field('image')['url'] . '">';			
        echo 	'</div>';
        echo 	'<div class="wrap">';
        if ( $related_institutions ) {
            foreach ( $related_institutions as $institution ) {
                echo    '<div class="institution-profile-pic">';
                echo        '<img src="' . get_field('institution_logo', $institution->ID )['url'] . '">';
                echo        '<span>' . $institution->post_title . '</span>';
                echo    '</div>';
            };
        };
        echo		'<h1>' . get_sub_field('title') . '</h1>';
        if ( $related_actions ) {
            foreach ( $related_actions as $action ) {
                echo    '<div class="related-action">';
                echo        '<a href="' . get_permalink( $action->ID ) . '">' . $action->post_title . '</a>';
                echo    '</div>';
            };
        };
        if ( get_sub_field('link') ) {
            echo	'<a href="' . get_sub_field('link')['url'] . '" class="button">' . get_sub_field('link')['title'] . '</a>';				
        }
        echo 	'</div>';
        echo '</div>';
        // print_r(get_sub_field('btn_text'));
    } 
};