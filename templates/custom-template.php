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
            echo	'<a href="' . get_sub_field('link')['url'] . '">' . get_sub_field('link')['title'] . '</a>';				
        }
        echo 	'</div>';
        echo '</div>';
        // print_r(get_sub_field('btn_text'));
    } 
};

/*
*
* Content Blocks : ACF Flexible Content (content_blocks)
* 
*/
if( have_rows('content_blocks') ){

    //* Debugger
    // if( get_field('content_blocks') ){
    //     echo '<pre>';
    //         print_r( 'value exists' );
    //     echo '</pre>';
    //     $i = 0;
    //     while( has_sub_field( 'content_blocks' ) ){
    //         $i++;
    //         echo '<pre>';
    //             print_r( 'Within loop: ' . $i . ', layout: ' . get_row_layout() );
    //         echo '</pre>';
    //     }
    // }

    while ( has_sub_field('content_blocks') ){
        // Could also be a while loop
        // have_rows(): the_row();

        switch( get_row_layout() ){
            
            /*
            *
            * Text Block (text_block)
            * 
            */
            case 'text_block':
                echo '<section class="text-block">';
                if( get_sub_field('icon') ) {
                    echo '<img src="' . get_sub_field('icon')['url'] . '">';
                    echo '<h3>' . get_sub_field('title') . '</h3>';
                } else {
                    echo '<h2>' . get_sub_field('title') . '</h2>';
                }
                echo '<p>' . get_sub_field('text') . '</p>';
                echo '</section>';
                break;

            /*
            *
            * Quote Block (quote_block)
            * 
            */
            case 'quote_block':
                echo '<section class"quote-block">';
                echo 	'<img src="' . get_sub_field('image')['url'] . '">';
                echo 	'<p>' . get_sub_field('text');
                echo	'<span>' . get_sub_field('autho') . '</span></p>';
                echo '</section>';
                break;

            /*
            *
            * 3 Blurbs (3_blurbs) repeater of 3_blurbs
            * 
            */            
            case '3_blurbs':
                echo '<section class="3-blurbs">';
                    $i = 0;
                    while( have_rows('3_blurbs') ) {
                        the_row();
                        if ( $i == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
                        echo 	'<div class="blurb">';
                        echo 		'<img src="' . get_sub_field('image')['url'] . '">';
                        echo 		'<h4>' . get_sub_field('title') . '</h4>';
                        echo 		'<p>' . get_sub_field('text') . '</p>';
                        if ( get_sub_field('link') ) {
                            echo		'<a href="' . get_sub_field('link')['url'] . '" title="' . get_sub_field('link')['title'] . '">' . get_sub_field('link')['title'] . '</a>';                            
                        }
                        echo 	'</div>';
                        echo '</div>';
                        $i++;
                    }
                echo '<div class="clearfix"></div>';	
                echo '</section>';
                break;

            /*
            *
            * Post Selection (post_selection) "relation" with subfield: post_selection
            * 
            */              
            case 'post_selection':
                echo '<section class="post-selection">';
                    $posts = get_sub_field('post_selection');
                    if ($posts) {
                        $i = 0;
                        // variable must NOT be called $post (IMPORTANT) otherwise will conflict with main loop
                        // https://www.advancedcustomfields.com/resources/relationship/
                        foreach($posts as $p) {
                            if ( $i == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
                            echo 	'<div class="post">';
                            echo 		'<img src="' . wp_get_attachment_url(get_post_thumbnail_id($p->ID)) . '" alt="" title="">';
                            echo 		'<h4>' . $p->post_title . '</h4>';
                            echo 	'</div>';
                            echo '</div>';
                            $i++;
                        }
                    }
                    echo '<div class="clearfix"></div>';	
                echo '</section>';	
                break;

            /*
            *
            * Dual Blocks (2_blocks) "repeater" with subfield: dual_blocks_item
            * 
            */                
            case 'dual_blocks':
                echo '<section class="2-blocks">';
                    $i = 0;
                    while ( have_rows('dual_block_item') ) {
                        the_row();
                        if ( $i == 0 ){ echo '<div class="one-half first">'; } else { echo '<div class="one-half">'; }
                        echo 	'<div class="cta-block">';
                        echo		'<div class="cta-block-img">';
                        echo			'<img src="' . get_sub_field('image')['url'] . '" alt="' . get_sub_field('image')['alt'] . '" title="' . get_sub_field('image')['description'] . '">';
                        echo		'</div>';
                        echo		'<div class="cta-block-content">';
                        echo			'<h4>' . get_sub_field('title') . '</h4>';
                        echo			'<p>' . get_sub_field('text') . '</p>';
                        if ( get_sub_field('btn_link') && get_sub_field('btn_text') ) {
                            echo			'<a href="' . get_sub_field('btn_link')['url'] . '">' . get_sub_field('btn_text') . '</a>';
                        }
                        echo		'</div>';
                        echo 	'</div>';
                        echo '</div>';
                        $i++;
                    }
                echo '<div class="clearfix"></div>';	
                echo '</section>';
                break;

            /*
            *
            * Video CTA Banner Slug (video_cta_banner) with subfield: banner_slug
            * 
            */             
            case 'custom_banner':
                $video_cta_banner_code = get_sub_field('custom_banner_slug');
                $video_cta_banner = get_field($video_cta_banner_code, 'option');
                // print_r($video_cta_banner_code);
                echo '<section class="video-cta-banner">';
                echo 	'<div class="video-cta-banner-video">' . $video_cta_banner['video_link'] . '</div>';
                echo 	'<h3>' . $video_cta_banner['title'] . '</h3>';
                echo 	'<div class="video-cta-banner-video-html">' . $video_cta_banner['html'] . '</div>';
                echo 	'<a href="' . $video_cta_banner['btn_link']['url'] . '" title="' . $video_cta_banner['btn_link']['title'] . '">' . $video_cta_banner['btn_text'] . '</a>';
                echo '</section>';
                break;

            case 'list':
                echo '<section class="list">';
                while( have_rows('list_item') ) {
                    the_row();
                    echo '<div class="list-item">';
                    echo	'<img src="' . get_sub_field('image')['url'] . '">';
                    echo	'<h5>' . get_sub_field('title') . '</h5>';
                    echo	'<p>' . get_sub_field('text') . '</p>';
                    if ( get_sub_field('link') ) {
                        echo	'<a href="' . get_sub_field('link')['url'] . '">' . get_sub_field('link')['title'] . '</a>';	
                    }
                    echo '</div>';
                }
                echo '</section>';
                break;

        }   // end Switch
    }   // end while
};