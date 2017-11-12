<?php
/**
 * AppelPourLaDifférence - Signatures
 *
 * Registers, displays signatures
 *
 */


 /**
 * Modify archive query for Signature CPT
 *
 */
add_action( 'pre_get_posts', 'modify_archive_signature_main_query' );

function modify_archive_signature_main_query( $query ) {
    if ( !is_admin() && is_post_type_archive('signature') && is_main_query() ) {
        $query->set( 'order', 'DESC' );
        $query->set( 'post_status', array('publish') );
        $query->set( 'posts_per_page', '12' );
        $query->set( 'meta_key', '_thumbnail_id' );
    }
}



/**
 * Register CPT for signature
 *
 */
add_action( 'init', 'cush_register_cpt_signatures' );
function cush_register_cpt_signatures() {
	$signature_labels = array(
		"name" 					=> __( 'Signatures', '' ),
		"singular_name" 		=> __( 'Signature', '' ),
		"menu_name" 			=> __( 'Signatures', '' ),
		"all_items" 			=> __( 'Toutes les signatures', '' ),
		"add_new" 				=> __( 'Ajouter', '' ),
		"add_new_item" 			=> __( 'Ajouter', '' ),
		"edit_item" 			=> __( 'Editer', '' ),
		"new_item" 				=> __( 'Nouvelle signature manuelle', '' ),
		"view_item" 			=> __( 'Voir', '' ),
		"search_items" 			=> __( 'Rechercher', '' ),
		"not_found" 			=> __( 'Aucune signature trouvée', '' ),
		"not_found_in_trash" 	=> __( 'Aucune signature dans la corbeille', '' ),
		"featured_image" 		=> __( 'Photo associée', '' ),
		"set_featured_image" 	=> __( 'Définir comme photo associée', '' ),
		"remove_featured_image" => __( 'Supprimer la photo associée', '' ),
		"use_featured_image" 	=> __( 'Utiliser comme photo associée', '' ),
		"archives" 				=> __( 'Archive des signatures', '' ),
		"insert_into_item" 		=> __( 'Insérer dans la signature', '' ),
		"uploaded_to_this_item" => __( 'Uploader dans la signature', '' ),
	);

	$signature_args = array(
		"label" 				=> __( 'Signatures', '' ),
		"labels" 				=> $signature_labels,
		"description" 			=> "",
		"public" 				=> true,
		"publicly_queryable" 	=> true,
		"show_ui" 				=> true,
		/*"show_in_rest" 		=> false,*/
		/*"rest_base" 			=> "",*/
		"has_archive" 			=> true,
		"show_in_menu" 			=> true,
		/*"exclude_from_search" => true,*/
		"capability_type" 		=> "post",
		"map_meta_cap" 			=> true,
		"hierarchical" 			=> false,
		"rewrite" 				=> array( 'slug' => 'signatures' ),
		"query_var" 			=> true,
		"menu_position" 		=> null,
		'menu_icon'			 	=> 'dashicons-tickets-alt', 	
		"supports" 				=> array( "editor", "thumbnail", "custom-fields", "author", "genesis-cpt-archives-settings" ),				
    );
    
	register_post_type( "signature", $signature_args );
}


/**
 * Query for signatures by number of posts
 *
 */
function cush_get_signatures($order, $limit, $only_with_photo = false, $paged = null) {
	$args = array(
		'orderby'          => $order,
		'order'            => 'DESC',
		'post_type'        => 'signature',
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
    $signatures = array();
    
	foreach ( $temp as $post ) {
		$post->url_featured_img_small = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small-size' )[0];
		$post->url_featured_img_small_test = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small-size-test' )[0];
		$post->url_featured_img_small_test1 = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small-size-test1' )[0];
		$post->url_featured_img_big = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'big-size' )[0];
		$post->first = get_post_meta($post->ID, 'txt_first_name', true);
		$post->last = get_post_meta($post->ID, 'txt_last_name', true);
		$post->author = $post->first . ' ' . $post->last;
		array_push($signatures, $post);
	}
	return $signatures;
}


/**
 * Query for signatures by A-Z
 *
 */
function cush_get_signatures_by_author($starting_letter="", $ending_letter="") {
	$args = array(
		'posts_per_page'	=> '-1',
		'post_type'        => 'signature',
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


/**
 * Improve vizualization of signatures in backend (edit column and add content to new columns)
 *
 */
add_filter( 'manage_edit-signature_columns', 'cush_signature_columns_edit' ) ;
function cush_signature_columns_edit( $columns ) {	
		$columns['last_name'] = __( 'Nom' );
		$columns['first_name'] = __( 'Prénom' );
		$columns['email'] = __( 'Email' );
		$columns['featured_preview'] = __( 'Image principale' );
	
		return $columns;
}

add_action( 'manage_signature_posts_custom_column', 'cush_signature_column_content', 10, 2 );
function cush_signature_column_content( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'featured_preview' :
			echo get_the_post_thumbnail( $post_id, 'thumbnail' );
			break;
		case 'last_name' :
			echo get_post_meta( $post_id, 'txt_last_name', true );
			break;
		case 'first_name' :
			echo get_post_meta( $post_id, 'txt_first_name', true );
			break;
		case 'email' :
			echo get_post_meta( $post_id, 'txt_email', true );
			break;
		default :
			break;
	}
}