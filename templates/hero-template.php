<?php

/*
*
* Hero Slider : ACF Repeater (hero_slider)
* 
*/
if( have_rows('hero_slider') ) {
    while( have_rows('hero_slider') ) {
        the_row();

        if ( is_page() &&  ! get_sub_field('title') ) {
            echo '<div class="hero-section">';
        } else {
            echo '<div class="hero-section overlay">';
        }
        echo 	'<div class="wp-custom-header">';
        echo		'<img src="' . get_sub_field('image')['url'] . '">';			
        echo 	'</div>';

        echo 	'<div class="wrap">';

        if ( ! is_page() ) {
            $related_institutions = get_field('related_institution');
            $related_actions = get_field('related_action');
            $institution_logo = get_field('institution_logo');
            // print_r($related_institution);

            // In case there is/are related institution, show logo(s) 
            if ( $related_institutions ) {
                echo    '<div class="brand-logos">';
                foreach ( $related_institutions as $institution ) {
                echo        '<div class="brand-logo"><a href="' . get_permalink( $institution->ID ) . '" title="' . $institution->post_title . '"><img src="' . get_field('institution_logo', $institution->ID )['url'] . '"></a></div>';
                };
                echo    '</div>';
            } elseif ( $institution_logo ) {
                echo    '<div class="brand-logos">';
                echo        '<div class="brand-logo"><img src="' . $institution_logo['url'] . '"></div>';
                echo    '</div>';
            };
        }    

        if ( get_sub_field('title') ) {
            echo		'<h1>' . get_sub_field('title') . '</h1>';
        }

        if ( ! is_page() ) {    
            // In case there are related actions, list them
            if ( $related_actions ) {
                echo    '<div class="related-actions">';
                foreach ( $related_actions as $action ) {
                echo        '<a href="' . get_permalink( $action->ID ) . '">' . $action->post_title . '</a>';
                };
                echo    '</div>';
            };
        }

        // Optional CTA button
        if ( get_sub_field('link') ) {
            echo	'<a href="' . get_sub_field('link')['url'] . '" class="button">' . get_sub_field('link')['title'] . '</a>';				
        }

        // If Contagion post type, list categories
        if ( get_post_type( get_the_ID() ) == 'contagion' ) {
            $categories = get_the_category();
            echo    '<div class="post-categories">';
            foreach ($categories as $category) {
            echo        '<a href="' . get_category_link( $category->term_id ) . '" title="' . __( "Principe d'action", 'C1SH' ) . ' : ' . $category->name . '">' . $category->name . '</a>';
            }
            echo    '</div>';
        }

        echo 	'</div>'; // end of wrap
        echo '</div>'; // end of hero section
        // print_r(get_sub_field('btn_text'));
    } 
};