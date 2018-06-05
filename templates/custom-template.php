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
                    if ( get_sub_field('title') ) { 
                        echo '<h3>' . get_sub_field('title') . '</h3>';
                     }
                } elseif ( get_sub_field('title') ) {
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
                $quote_image = get_sub_field('image');
                // print_r($quote_image);
                echo '<div class="quote-block">';
                echo '<div class="wrap">';
                echo 	'<img src="' . $quote_image['url'] . '" title="' . $quote_image['title'] . '" alt="' . $quote_image['alt'] . '">';
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
                if ( get_sub_field('blurbs_layout') == 'indented' ){
                    echo '<div class="three-blurbs--storyboard">';
                } elseif ( get_sub_field('blurbs_layout') == 'underwater' ) {
                    echo '<div class="three-blurbs--texture">';   
                } else {
                    echo '<div class="three-blurbs">'; 
                }

                if ( get_sub_field('multiple_links_inside') ) {
                    echo '<div class="wrap">';
                    $i = 0;
                    while( have_rows('3_blurbs') ) {
                        the_row();
                        if ( $i == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
                        echo 	'<div class="blurb tile-shadow">';
                        echo 		'<img src="' . get_sub_field('image')['url'] . '" alt="' . get_sub_field('image')['alt'] . '" title="' . get_sub_field('image')['title'] . '">';
                        echo        '<div class="item-content">';
                        echo 		    '<p>' . get_sub_field('text') . '</p>';
                        echo            '<div class="item-content__multiple-links clearfix">';
                        if ( get_sub_field('multiple_links_image') ) {
                            echo 		    '<img src="' . get_sub_field('multiple_links_image')['url'] . '" alt="' . get_sub_field('multiple_links_image')['alt'] . '" title="' . get_sub_field('multiple_links_image')['title'] . '">';
                        }
                        echo                get_sub_field('multiple_links');
                        echo            '</div>';
                        echo 	    '</div>';
                        echo 	'</div>';
                        echo '</div>';
                        $i++;
                    }
                    // echo '<div class="clearfix"></div>';
                    echo '</div>';
                } else {
                    echo '<div class="wrap">';
                    $i = 0;
                    while( have_rows('3_blurbs') ) {
                        the_row();
                        if ( $i == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
                        echo 	'<div class="blurb tile-shadow">';
                        echo 		'<img src="' . get_sub_field('image')['url'] . '" alt="' . get_sub_field('image')['alt'] . '" title="' . get_sub_field('image')['title'] . '">';
                        echo        '<div class="item-content">';
                        if ( get_sub_field('link') ) {
                            echo 		'<h4><a href="' . get_sub_field('link')['url'] . '" title="' . get_sub_field('link')['title'] . '">' . get_sub_field('title') . '</a></h4>';
                        } else {
                            echo 		'<h4>' . get_sub_field('title') . '</h4>';
                        }
                        echo 		    '<p>' . get_sub_field('text') . '</p>';
                        if ( get_sub_field('link') ) {
                            echo		'<a href="' . get_sub_field('link')['url'] . '" title="' . get_sub_field('link')['title'] . '" class="read-more">' . get_sub_field('link')['title'] . '</a>';                            
                        }
                        echo 	    '</div>';
                        echo 	'</div>';
                        echo '</div>';
                        $i++;
                    }
                    // echo '<div class="clearfix"></div>';
                    echo '</div>';	
                }
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
                            // print_r(wp_get_attachment_image(get_post_thumbnail_id($p->ID)));
                            echo 	'<div class="post blurb">';
                            echo 		'<img src="' . wp_get_attachment_url(get_post_thumbnail_id($p->ID)) . '" alt="' . $p->post_excerpt . '" title="' . get_post( get_post_thumbnail_id($p->ID) )->post_title . '">';
                            echo        '<div class="item-content">';
                            echo 		    '<h4><a href="' . get_permalink($p) . '" title"' . $p->post_title . '" >' . $p->post_title . '</a></h4>';
                            echo 		    '<p>' . $p->post_excerpt . '</p>';
                            echo		    '<a href="' . get_permalink($p) . '" title="' . $p->post_title . '" class="read-more">' . __('Lire Plus', 'c1sh') . '</a>';
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
                        echo			'<img src="' . get_sub_field('image')['url'] . '" alt="' . get_sub_field('image')['alt'] . '" title="' . get_sub_field('image')['title'] . '">';
                        echo		    '<div class="cta-block-content">';
                        echo			    '<h3>' . get_sub_field('title') . '</h3>';
                        echo			    '<p>' . get_sub_field('text') . '</p>';
                        if ( get_sub_field('link') ) {
                            echo			'<a href="' . get_sub_field('link')['url'] . '" title=' . get_sub_field('link')['title'] . ' class="button">' . get_sub_field('link')['title'] . '</a>';
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
                    if ( get_sub_field('layout') == 'callout' ) {
                        echo    '<div class="banner-layout--callout">';
                        get_template_part('templates/kpi-banner-template');
                        echo    '</div>';
                    } else {
                        get_template_part('templates/kpi-banner-template');
                    }
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
                    echo	'<img src="' . get_sub_field('image')['url'] . '" alt="' . get_sub_field('image')['alt'] . '">';
                    echo	'<h4>' . get_sub_field('title') . '</h4>';
                    echo	'<p>' . get_sub_field('text') . '</p>';
                    if ( get_sub_field('link') ) {
                        echo	'<a href="' . get_sub_field('link')['url'] . '" title="' . get_sub_field('link')['title'] . '">' . get_sub_field('link')['title'] . '</a>';	
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
                    if ( $i == 0 || $i % 6 == 0 ){ echo '<div class="one-sixth first">'; } else { echo '<div class="one-sixth">'; }
                    the_row();
                    $user_id = get_sub_field('single_user')['ID'];
                    $company = get_field('institution', "user_{$user_id}" )[0];
                    $position = get_field('position', "user_{$user_id}" );
                    $show_company = get_field('show_company', "user_{$user_id}" );

                    echo    '<div class="list-single-user">';
                    echo        '<div class="single-user-avatar"><img src="' . get_field('profile_picture', "user_{$user_id}" )['url'] . '" alt="' . get_field('profile_picture', "user_{$user_id}" )['alt'] . '" title="' . get_field('profile_picture', "user_{$user_id}" )['title'] . '"></div>';
                    echo        '<div class="single-user-meta">';
                    echo            '<h5>' . get_sub_field('single_user')['user_firstname'] . ' ' . get_sub_field('single_user')['user_lastname'] . '</h5>';
                    if ( $company && $show_company ) {
                    echo            '<h6><a href="' . get_permalink($company) . '" title="' . $company->post_title . '">' . $company->post_title . '</a></h6>';
                    }
                    if ( $position ) {
                    echo            '<span>' . $position . '</span>';
                    }
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
            * Contagion List
            * 
            */                        
            case 'contagion_list':
                echo '<div class="feed feed-blurbs">';
                echo '<div class="wrap">';
                $i = 0;
                while ( have_rows('contagion_list') ) {
                    if ( $i == 0 || $i % 3 == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
                    the_row();
                    $single_contagion = get_sub_field('single_contagion');
                    $related_institutions = get_field('related_institution', $single_contagion->ID);
                    $thumbnail = get_the_post_thumbnail($single_contagion->ID, 'medium_large' );

                    echo        '<div class="blurb clearfix">'; 
                    if ( $thumbnail )
                        echo $thumbnail ;
                    echo            '<div class="item-content">';
                    if ( $related_institutions ) {
                        echo            '<h6>';
                        foreach( $related_institutions as $related_institution ){
                        echo                '<a href="' . get_the_permalink($related_institution->ID) . '">' . get_the_title($related_institution->ID) . '</a>';
                        }
                        echo            '</h6>';
                    }
                    echo                '<h4><a href="' . get_the_permalink($single_contagion->ID) . '">' . $single_contagion->post_title . '</a></h4>';
                    echo                '<p>' . $single_contagion->post_excerpt . '</p>';        
                    echo		    '<a href="' . get_the_permalink($single_contagion->ID) . '" title="' . $single_contagion->post_title . '" class="read-more">' . __('Voir Plus', 'c1sh') . '</a>';
                    echo            '</div>'; // end of item-content
                    echo        '</div>'; // end of blurb
                    echo '</div>'; // end of columns
                    $i++;
                }  // end of has_rows
                echo '<div class="feed-get-more"><a href="' . get_post_type_archive_link( 'contagion' ) . '" class="button btn-alt">' . __('Voir Plus', 'c1sh') . '</a></div>';
                echo '</div>'; // end of wrap
                echo '</div>'; // end of feed
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
                $show_read_more = get_sub_field('show_read_more');

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
                            if ( $i == 0 || $i % 3 == 0 ){ 
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
                            $time_range = get_field('time_range');
                            if ( $time_range ) {
                        echo                '<span class="item-date">' . $time_range . '</span>';
                            } else {
                        echo                '<span class="item-date">' . get_the_date('M Y') . '</span>';
                            }
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
                            echo		    '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '" class="read-more">' . __('Voir Plus', 'c1sh') . '</a>';
                        }
                        echo            '</div>'; // end of item-content
                        echo        '</div>'; // end of blurb
                        echo    '</div>'; // end of timeline-item or one-third
                        $i++;
                    }
                    if ( $show_read_more == true ) {
                    echo '<div class="feed-get-more"><a href="' . get_post_type_archive_link( $items_type ) . '" class="button btn-alt">' . __('Voir Plus', 'c1sh') . '</a></div>';
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

                echo '<div class="video-block" id="video-block">';
                echo '<div class="wrap">';
                echo        '<div class="embed-responsive">' . $embed_code . '</div>';
                echo        '<p class="media-caption">' . $video_caption . '</p>';
                echo '</div>';
                echo '</div>';
                break;

            /*
            *
            * Image Block as image array
            * 
            */                        
            case 'image_block':
                $image_object = get_sub_field('image_file');
                $image_caption = get_sub_field('image_caption');

                echo '<div class="image-block">';
                echo        '<img src="' . $image_object['url'] . '" alt="' . $image_object['alt'] . '" title="' . $image_object['title'] . '">';
                echo        '<p class="media-caption">' . $image_caption . '</p>';
                echo '</div>';
                break;                

            /*
            *
            * Institution List as relation with Institutions
            * 
            */                        
            case 'institution_list':
                echo '<div class="institution-list">';
                echo    '<div class="wrap">';
                $institutions = get_sub_field('institution_list');
                $i = 0;
                foreach ($institutions as $institution){
                    if ( $i == 0 || $i % 6 == 0 ){ echo '<div class="one-sixth first">'; } else { echo '<div class="one-sixth">'; }
                    echo    '<div class="list-single-institution">';
                    echo        '<div class="single-institution-logo"><a href="' . get_permalink($institution) . '" title="' . $institution->post_title . '"><img src="' . get_field('institution_logo', $institution->ID )['url'] . '" alt="' . get_field('institution_logo', $institution->ID )['alt'] . '"></a></div>';
                    if ( get_sub_field('show_company_names') ) {
                        echo        '<div class="single-institution-meta">';
                        echo            '<h6><a href="' . get_permalink($institution) . '" title="' . $institution->post_title . '">' . $institution->post_title . '</a></h6>';
                        echo        '</div>';
                    }
                    echo    '</div>'; // end of .list-single-institution
                    echo '</div>'; // end of one-sixth
                    $i++;
                }
                // print_r( get_sub_field('institution_list') );
                echo    '</div>';
                echo '</div>';
                break; 

            /*
            *
            * Form Block
            * 
            */                        
            case 'form_block':
                echo '<div class="form-block">';
                echo    '<div class="wrap">';
                echo do_shortcode('[gravityform id="' . get_sub_field('form_block') . '" title="false" description="false"]');    
                echo    '</div>';
                echo '</div>';
                break;

            /*
            *
            * Signatures List
            * 
            */       
            case 'signatures_list':
                $signatures_number = get_sub_field('signatures_number');
                $signatures = cush_get_signatures('rand', $signatures_number, true);

                // adds ajax script to the page's footer (header wont't work) if this template part is called
                add_action('wp_footer', 'add_ajax_scripts');
                add_action('admin_enqueue_scripts', 'add_ajax_url', 11 );
                function add_ajax_scripts() {
                    echo "<script>var ajax_request_url = '".admin_url( 'admin-ajax.php' )."'</script>";
                    echo '<script>jQuery(function(){ c1shRefreshSignatures() });</script>';
                }

                echo '<div class="signatures-list">';
                echo    '<div class="wrap">';
                $i = 0;
                foreach ( $signatures as $signature ) {
                    setup_postdata( $signature );
                    if ( $i == 0 || $i % 6 == 0 ){ echo '<div class="one-sixth first">'; } else { echo '<div class="one-sixth">'; }
                    echo    '<div class="list-single-signature">';
                    echo        '<div class="single-user-avatar"><img src="' . $signature->url_featured_img_small . '" alt=""></div>';
                    echo        '<div class="single-user-meta">';
                    echo            '<h5>' . $signature->author . '</h5>';
                    echo        '</div>';
                    echo    '</div>'; // end of .list-single-signature
                    echo '</div>'; // end of column
                    $i++;
                }
                wp_reset_postdata();
                echo    '<div class="clearfix"></div>';
                echo    '<div class="feed-get-more"><a href="' . get_post_type_archive_link( 'signature' ) . '" class="button btn-alt">' . __('Voir Plus', 'c1sh') . '</a></div>';
                echo    '</div>'; // end of .wrap
                echo '</div>'; // end of .signatures-list
                break;

            
            /*
            *
            * Custom HTML Tag
            * 
            */
            case 'custom_html_tag':
                echo    get_sub_field('custom_html_tag');
                break;     

            default:
                break;

        }   // end Switch
    }   // end while
};