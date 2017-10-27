<?php

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
                echo '<div class="text-block">';
                echo '<div class="wrap">';
                if( get_sub_field('icon') ) {
                    echo '<img src="' . get_sub_field('icon')['url'] . '">';
                    echo '<h3>' . get_sub_field('title') . '</h3>';
                } else {
                    echo '<h2>' . get_sub_field('title') . '</h2>';
                }
                echo        get_sub_field('text');
                echo '</div>';
                echo '</div>';
                break;

            /*
            *
            * Quote Block (quote_block)
            * 
            */
            case 'quote_block':
                echo '<div class="quote-block">';
                echo '<div class="wrap">';
                echo 	'<img src="' . get_sub_field('image')['url'] . '">';
                echo 	get_sub_field('text') . '<span>' . get_sub_field('author') . '</span>';
                echo '</div>';
                echo '</div>';
                break;

            /*
            *
            * 3 Blurbs (3_blurbs) repeater of 3_blurbs
            * 
            */            
            case '3_blurbs':
                echo '<div class="three-blurbs">';
                echo '<div class="wrap">';
                    $i = 0;
                    while( have_rows('3_blurbs') ) {
                        the_row();
                        if ( $i == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
                        echo 	'<div class="blurb tile-shadow">';
                        echo 		'<img src="' . get_sub_field('image')['url'] . '">';
                        echo        '<div class="item-content">';
                        echo 		    '<h4>' . get_sub_field('title') . '</h4>';
                        echo 		    '<p>' . get_sub_field('text') . '</p>';
                        if ( get_sub_field('link') ) {
                            echo		'<a href="' . get_sub_field('link')['url'] . '" title="' . get_sub_field('link')['title'] . '" class="read-more">' . get_sub_field('link')['title'] . '</a>';                            
                        }
                        echo 	    '</div>';
                        echo 	'</div>';
                        echo '</div>';
                        $i++;
                    }
                echo '<div class="clearfix"></div>';
                echo '</div>';	
                echo '</div>';
                break;

            /*
            *
            * Post Selection (post_selection) "relation" with subfield: post_selection
            * 
            */              
            case 'post_selection':
                echo '<div class="post-selection">';
                echo '<div class="wrap">';
                    $posts = get_sub_field('post_selection');
                    if ($posts) {
                        $i = 0;
                        // variable must NOT be called $post (IMPORTANT) otherwise will conflict with main loop
                        // https://www.advancedcustomfields.com/resources/relationship/
                        foreach($posts as $p) {
                            if ( $i == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
                            // print_r($p);
                            echo 	'<div class="post blurb">';
                            echo 		'<img src="' . wp_get_attachment_url(get_post_thumbnail_id($p->ID)) . '" alt="" title="">';
                            echo        '<div class="item-content">';
                            echo 		    '<h4>' . $p->post_title . '</h4>';
                            echo 		    '<p>' . $p->post_excerpt . '</p>';
                            echo		    '<a href="' . get_permalink($p) . '" title="' . $p->post_title . '" class="read-more">Voir</a>';
                            echo 	    '</div>';
                            echo 	'</div>';
                            echo '</div>';
                            $i++;
                        }
                    }
                    echo '<div class="clearfix"></div>';	
                echo '</div>';	
                echo '</div>';	
                break;

            /*
            *
            * Dual Blocks (2_blocks) "repeater" with subfield: dual_blocks_item
            * 
            */                
            case 'dual_blocks':
                echo '<div class="two-blocks">';
                echo '<div class="wrap">';
                    $i = 0;
                    while ( have_rows('dual_block_item') ) {
                        the_row();
                        if ( $i == 0 ){ echo '<div class="one-half first">'; } else { echo '<div class="one-half">'; }
                        echo 	'<div class="cta-block">';
                        echo		'<div class="cta-block-item">';
                        echo			'<img src="' . get_sub_field('image')['url'] . '" alt="' . get_sub_field('image')['alt'] . '" title="' . get_sub_field('image')['description'] . '">';
                        echo		    '<div class="cta-block-content">';
                        echo			    '<h3>' . get_sub_field('title') . '</h3>';
                        echo			    '<p>' . get_sub_field('text') . '</p>';
                        if ( get_sub_field('link') ) {
                            echo			'<a href="' . get_sub_field('link')['url'] . '" class="button">' . get_sub_field('link')['title'] . '</a>';
                        }
                        echo		    '</div>';
                        echo		'</div>';
                        echo 	'</div>';
                        echo '</div>';
                        $i++;
                    }
                echo '<div class="clearfix"></div>';	
                echo '</div>';
                echo '</div>';
                break;

            /*
            *
            * Video CTA Banner Slug (custom_banner) with subfield: custom_banner_slug
            * 
            */             
            case 'custom_banner':
                $banner_code = get_sub_field('custom_banner_slug');
                if ( $banner_code == 'kpi_banner' ) {
                    get_template_part('templates/kpi-banner-template');
                } elseif( $banner_code == 'main_cta_banner' ) {
                    get_template_part('templates/cta-banner-template');
                } elseif( $banner_code == 'video_cta_banner' ) {
                    get_template_part('templates/video-cta-banner-template');
                }
                break;

            /*
            *
            * List as repeater of "list_item"
            * 
            */                        
            case 'list':
                echo '<div class="list">';
                echo '<div class="wrap">';
                while( have_rows('list_item') ) {
                    the_row();
                    echo '<div class="list-item">';
                    echo	'<img src="' . get_sub_field('image')['url'] . '">';
                    echo	'<h4>' . get_sub_field('title') . '</h4>';
                    echo	'<p>' . get_sub_field('text') . '</p>';
                    if ( get_sub_field('link') ) {
                        echo	'<a href="' . get_sub_field('link')['url'] . '">' . get_sub_field('link')['title'] . '</a>';	
                    }
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
                break;

            /*
            *
            * User list
            * 
            */                        
            case 'user_list':
                echo '<div class="user-list">';
                echo '<div class="wrap">';
                $i = 0;
                while ( have_rows('user_list') ) {
                    if ( $i == 0 ){ echo '<div class="one-sixth first">'; } else { echo '<div class="one-sixth">'; }
                    the_row();
                    echo    '<div class="list-single-user">';
                    echo        '<div class="single-user-avatar">' . get_sub_field('single_user')['user_avatar'] . '</div>';
                    echo        '<div class="single-user-meta">';
                    echo            '<h5>' . get_sub_field('single_user')['user_firstname'] . ' ' . get_sub_field('single_user')['user_lastname'] . '</h5>';
                    echo        '</div>';
                    echo    '</div>'; // end of .list-single-user
                    echo '</div>'; // end of columns
                    $i++;
                }
                echo '<div class="clearfix"></div>';
                echo '</div>';
                echo '</div>';
                break;

            /*
            *
            * Feed as selection between action/contagion/institution
            * 
            */                        
            case 'feed':
                $items_type = get_sub_field('post_type');
                $feed_length = get_sub_field('feed_length');
                $layout_type = strtolower(get_sub_field('layout_type'));
                $cat_array = get_sub_field('feed_cat_filter');
                $tag_array = get_sub_field('feed_tag_filter');
                $limit_to_milestones = get_sub_field('limit_to_milestones');

                // Query Args
                if ( $items_type == 'action' && $limit_to_milestones == true ) {
                    $args = array( 
                        'post_type'         => $items_type,
                        'posts_per_page'    => $feed_length,
                        'category__and'     => $cat_array,
                        'tag__and'          => $tag_array,
                        'meta_query'	    => array(
                            'relation'		=> 'AND',
                            array(
                                'key'	 	=> 'milestone_level',
                                'value'	  	=> array('primary', 'secondary'),
                                'compare' 	=> 'IN',
                            )
                        )
                    );              
                } else {
                    $args = array( 
                        'post_type'         => $items_type,
                        'posts_per_page'    => $feed_length,
                        'category__and'     => $cat_array,
                        'tag__and'          => $tag_array
                    );
                };

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
                    echo '<div class="feed feed-' . $layout_type . '">';
                    echo '<div class="wrap">';
                    $i = 0;
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();

                        // should it be a timeline-item or a column ?
                        if ( $layout_type == 'timeline' ) {
                        echo    '<div class="timeline-item">';
                        } else {  
                            if ( $i == 0 ){ 
                            echo '<div class="one-third first">'; 
                            } else { 
                            echo '<div class="one-third">'; 
                            }
                        }

                        if ( $items_type == 'action' ) {
                            $milestone_level = get_field('milestone_level');
                            if ( $milestone_level == 'primary' ) {
                            echo    '<div class="blurb primary-feed-item clearfix">';
                            } elseif ( $milestone_level == 'secondary' ) {
                            echo    '<div class="blurb secondary-feed-item clearfix">';
                            } else {
                            echo    '<div class="blurb clearfix">'; 
                            }
                        } else {
                        echo        '<div class="blurb clearfix">';    
                        }
                        
                        if ( has_post_thumbnail() ){ 
                                        the_post_thumbnail( 'medium_large' ); 
                        }
                        echo            '<div class="item-content">';
                        $related_institutions = get_field('related_institution');
                        if ( $items_type == 'action' or $items_type == 'post' ) {
                        echo                '<span class="item-date">' . get_the_date('Y') . '</span>';
                        }
                        if ( $related_institutions ) {
                            echo            '<h6>';
                            foreach( $related_institutions as $related_institution ){
                            echo                '<a href="' . get_the_permalink($related_institution->ID) . '">' . get_the_title($related_institution->ID) . '</a>';
                            }
                            echo            '</h6>';
                        }
                        echo                '<h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
                        echo                '<p>' . get_the_excerpt() . '</p>';
                        if ( $items_type == 'action' ) {
                        echo                '<ul class="tags">';
                                              the_tags( '<li>', '</li><li>', '</li>' );
                        echo                '</ul>';
                        }
                        if ( $layout_type == 'blurbs' ) {
                            echo		    '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '" class="read-more">Voir</a>';
                        }
                        echo            '</div>'; // end of item-content
                        echo        '</div>'; // end of blurb
                        echo '<div class="clearfix"></div>';
                        echo    '</div>'; // end of timeline-item or one-third
                        $i++;
                    }
                    echo '</div>'; // end of wrap
                    echo '</div>'; // end of section
                } else {
                    // no posts found
                }
                /* Restore original Post Data */
                wp_reset_postdata();
                break;

            /*
            *
            * Video Embed as embed code
            * 
            */                        
            case 'video_embed':
                $embed_code = get_sub_field('video_link');
                $video_caption = get_sub_field('video_caption');

                echo '<div class="video-block">';
                echo '<div class="wrap">';
                echo        '<div class="video-embed-responsive">' . $embed_code . '</div>';
                echo        '<p>' . $video_caption . '</p>';
                echo '</div>';
                echo '</div>';
                break;


        }   // end Switch
    }   // end while
};