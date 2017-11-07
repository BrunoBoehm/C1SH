<?php
/**
 * AppelPourLaDifférence - Inscriptions
 *
 * Registers, displays inscriptions
 *
 */


 /**
 * Modify archive query for inscription CPT
 *
 */
add_action( 'pre_get_posts', 'modify_archive_inscription_main_query' );

function modify_archive_inscription_main_query( $query ) {
    if ( !is_admin() && is_post_type_archive('inscription') && is_main_query() ) {
        $query->set( 'order', 'DESC' );
        $query->set( 'post_status', array('publish') );
        $query->set( 'posts_per_page', '12' );
        $query->set( 'meta_key', '_thumbnail_id' );
    }
}



/**
 * Register CPT for inscrption
 *
 */
add_action( 'init', 'c1sh_register_cpt_inscriptions' );
function c1sh_register_cpt_inscriptions() {
	$inscription_labels = array(
		"name" => __( 'Inscriptions', '' ),
		"singular_name" => __( 'Inscription', '' ),
		"menu_name" => __( 'Inscriptions', '' ),
		"all_items" => __( 'Toutes les inscriptions', '' ),
		"add_new" => __( 'Ajouter', '' ),
		"add_new_item" => __( 'Ajouter', '' ),
		"edit_item" => __( 'Editer', '' ),
		"new_item" => __( 'Nouvel inscription manuelle', '' ),
		"view_item" => __( 'Voir', '' ),
		"search_items" => __( 'Rechercher', '' ),
		"not_found" => __( 'Aucune inscription trouvée', '' ),
		"not_found_in_trash" => __( 'Aucune inscription dans la corbeille', '' ),
		"featured_image" => __( 'Photo associée', '' ),
		"set_featured_image" => __( 'Définir comme photo associée', '' ),
		"remove_featured_image" => __( 'Supprimer la photo associée', '' ),
		"use_featured_image" => __( 'Utiliser comme photo associée', '' ),
		"archives" => __( 'Archive des inscriptions', '' ),
		"insert_into_item" => __( 'Insérer dans l\'inscription', '' ),
		"uploaded_to_this_item" => __( 'Uploader dans l\'inscription', '' ),
	);

	$inscription_args = array(
		"label" => __( 'Inscriptions', '' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		/*"show_in_rest" => false,*/
		/*"rest_base" => "",*/
		"has_archive" => true,
		"show_in_menu" => true,
		/*"exclude_from_search" => true,*/
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( 'slug' => 'galerie' ),
		"query_var" => true,
		"menu_position" => 20,		
		"supports" => array( "editor", "thumbnail", "genesis-cpt-archives-settings" ),				
    );
    
	register_post_type( "inscription", $args );
}


/**
 * Query for inscriptions by number of posts
 *
 */
function get_inscriptions($order, $limit, $only_with_photo = false, $paged = null) {
	$args = array(
		'orderby'          => $order,
		'order'            => 'DESC',
		'post_type'        => 'inscription',
		'post_status'      => array('publish'),
		'posts_per_page'    => $limit
    );
    
	$additionnal_args = array();
	if ($only_with_photo) {
		$additionnal_args['meta_key'] = '_thumbnail_id';
	}
	if ($paged) {
		$additionnal_args['paged'] = $paged;
    }
    
    $temp = get_posts( $args + $additionnal_args );
    $inscriptions = array();
    
	foreach ( $temp as $post ) {
		$post->url_featured_img_small = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small-size' )[0];
		$post->url_featured_img_small_test = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small-size-test' )[0];
		$post->url_featured_img_small_test1 = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small-size-test1' )[0];
		$post->url_featured_img_big = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'big-size' )[0];
		$post->first = get_post_meta($post->ID, 'txt_first_name', true);
		$post->last = get_post_meta($post->ID, 'txt_last_name', true);
		$post->author = $post->first . ' ' . $post->last;
		array_push($inscriptions, $post);
	}
	return $inscriptions;
}


/**
 * Query for inscriptions by A-Z
 *
 */
function get_inscriptions_author($starting_letter="", $ending_letter="") {
	$args = array(
		'posts_per_page'	=> '-1',
		'post_type'        => 'inscription',
		'post_status'      => array('publish'),
		'orderby' => 'meta_value',
		'meta_key' => 'txt_last_name',
		'meta_type' => 'CHAR',
		'order' => 'ASC',
    );

    $additionnal_args = array();
    
	if ($starting_letter!="") {
		if ($starting_letter=="Z") {
			$additionnal_args = array(
				'meta_query' => array(
			        array(
			            'key'       => 'txt_last_name',
			            'value' => 'Z',
	            		'compare' => '>'
			        )
	    		)
			);
		} else {
			$additionnal_args = array(
				'meta_query' => array(
			        array(
			            'key'       => 'txt_last_name',
			            'value' => array( $starting_letter, $ending_letter),
	            		'compare' => 'BETWEEN'
			        )
	    		)
			);
		}
		
	}

	return get_posts( $args + $additionnal_args );
}