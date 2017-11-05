<?php
/**
 * @author    Bruno Boehm
 * 
 */

//* Force full width content layout
// add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the post info function
// remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//* Add custom body class to the head
// add_filter( 'body_class', 'cush_add_body_class' );
// function cush_add_body_class( $classes ) {
//    $classes[] = 'custom-archive';
//    return $classes;
// }

//* Remove standard post content output
// remove_action( 'genesis_post_content', 'genesis_do_post_content' );
// remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// add_action( 'genesis_post_content', 'genesis_do_post_image', 18 );

//* Remove the post meta function
// remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

/** Code for custom loop */
function cush_custom_loop() {
    global $post;

    $items_type = get_post_type( $post->ID );
        
    $args = array( 
        'post_type'         => $items_type
    );

    // echo '<pre>';
    // print_r(get_sub_field('post_type'));
    // print_r($cat_array);
    // print_r($tag_array);
    // var_dump($limit_to_milestones);
    // print_r($args);
    // echo '</pre>';

    // The Query
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) {
        echo '<div class="feed feed-timeline">';
        echo '<div class="wrap">';
        $i = 0;
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            // should it be a timeline-item or a column ?

            echo    '<div class="timeline-item">';
            echo        '<div class="blurb clearfix">';    
            
            if ( has_post_thumbnail() ){ the_post_thumbnail( 'medium_large' ); }
            echo            '<div class="item-content">';
            echo                '<span class="item-date">' . get_the_date('M Y') . '</span>';
            echo                '<h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
            echo                '<p>' . get_the_excerpt() . '</p>';
            echo            '</div>'; // end of item-content
            echo        '</div>'; // end of blurb
            echo    '</div>'; // end of timeline-item or one-third
            $i++;
        }
        echo '</div>'; // end of wrap
        echo '</div>'; // end of section
    } else {
        // no posts found
    }
}
 
/** Replace the standard loop with our custom loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'cush_custom_loop' );

add_action( 'genesis_before_footer', 'cush_show_banners', 8 );
function cush_show_banners(){
    get_template_part('templates/kpi-banner-template');
    get_template_part('templates/cta-banner-template');
}

genesis();