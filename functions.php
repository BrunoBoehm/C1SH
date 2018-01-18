<?php
/**
 * COMMEUNSEULHOMME
 *
 * This file adds functions to the C1SH Theme.
 *
 * @package COMMEUNSEULHOMME
 * @author  Lyketil
 * @license GPL-2.0+
 * @link    http://www.lyketil.com
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'c1sh', get_stylesheet_directory() . '/languages' );

//* Add Image upload and Color select to WordPress Theme Customizer
// require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
// include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Include Appel setup
include_once( get_stylesheet_directory() . '/lib/appel-signup.php' );
include_once( get_stylesheet_directory() . '/lib/appel-signatures.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'C1SH' );
define( 'CHILD_THEME_URL', 'http://www.lyketil.com/' );
define( 'CHILD_THEME_VERSION', '1.0.4' );

//* Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'cush_enqueue_scripts_styles' );
function cush_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'c1sh-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	
	wp_register_script( 'c1sh-javascript', get_stylesheet_directory_uri() . '/js/c1sh-javascript.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	if( function_exists('pll_current_language') ) {
		switch ( pll_current_language() ) {
			case 'en':
				$lang_redirect_url = get_permalink( get_page_by_path('and-you')->ID );
				break;
			case 'fr':
				$lang_redirect_url = get_permalink( get_page_by_path('et-vous')->ID );
				break;
		}
	} else {
		$lang_redirect_url = get_permalink( gget_page_by_path('et-vous')->ID );
	};

	$c1sh_javascript_translation_array = array(
		// 'dropdown_text' => __( '', 'c1sh' ),
		'dropdown_default_url' => $lang_redirect_url
	);
	wp_localize_script( 'c1sh-javascript', 'c1sh_dropdown_data', $c1sh_javascript_translation_array );
	wp_enqueue_script( 'c1sh-javascript');

	// Remove sub-menu animation and delay.
	// wp_deregister_script( 'superfish-args' );
	// wp_dequeue_script( 'superfish-args' );

	$output = array(
		'mainMenu' => __( 'Menu', 'c1sh' ),
		'subMenu'  => __( 'Menu', 'c1sh' ),
	);
	wp_localize_script( 'genesis-sample-responsive-menu', 'genesisSampleL10n', $output );

	// Localize responsive menus script.
	// wp_localize_script( 'c1sh', 'genesis_responsive_menu', array(
	// 	'mainMenu'         => __( 'Menu', 'c1sh' ),
	// 	'subMenu'          => __( 'Menu', 'c1sh' ),
	// 	'menuIconClass'    => null,
	// 	'subMenuIconClass' => null,
	// 	'menuClasses'      => array(
	// 		'combine' => array(
	// 			'.nav-primary',
	// 		),
	// 	),
	// ) );

}

// Remove Primary Menu's wrap.
add_theme_support( 'genesis-structural-wraps', array(
    'header',
    // 'menu-primary',
    'menu-secondary',
    'footer-widgets',
    'footer'
) );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 
	'caption', 
	'comment-form', 
	'comment-list', 
	'gallery', 
	'search-form' ) 
);

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 
	'404-page', 
	'drop-down-menu', 
	'headings', 
	'rems', 
	'search-form', 
	'skip-links' ) 
);

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add Image Sizes
add_image_size( 'featured-image', 720, 400, TRUE );

//* Rename primary navigation menus
add_theme_support( 'genesis-menus' , array( 
	'primary' => __( 'Header Menu', 'c1sh' )
) );

// Reposition primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] COMMEUNSEULHOMME';
	return $creds;
}

//* Add ACF Options Page
if ( function_exists('acf_add_options_page') ) {
	
	// Main Settings Page
	$parent = acf_add_options_page( array(
		'page_title' 	=> 'Banners Settings',
		'menu_title'	=> 'Banner Settings',
		'menu_slug' 	=> 'banner-settings',
		'capability'	=> 'edit_posts'
	));

	// Sub Option Pages, NOT Language specific
	// acf_add_options_sub_page( array(
	// 	'page_title' 	=> 'Video CTA Banner',
	// 	'menu_title'	=> 'Video CTA Banner',
	// 	'parent'	=> $parent['menu_slug']
	// ));
	// acf_add_options_sub_page( array(
	// 	'page_title' 	=> 'KPI Banner',
	// 	'menu_title'	=> 'KPI Banner',
	// 	'parent'	=> $parent['menu_slug']
	// ));
	// acf_add_options_sub_page( array(
	// 	'page_title' 	=> 'Join Us Banner',
	// 	'menu_title'	=> 'Join Us Banner',
	// 	'parent'	=> $parent['menu_slug']
	// ));

	// Sub Option Pages, Language specific
	// Each options page has it’s own ID so fields names can be the same.
	// https://support.advancedcustomfields.com/forums/topic/options-page-polylang/
	$languages = array( 'fr', 'en' );

	foreach( $languages as $lang ) {
		acf_add_options_sub_page( array(
			'page_title' 	=> 'Video CTA Banner (' . strtoupper( $lang ) . ')',
			'menu_title'	=> 'Video CTA Banner (' . strtoupper( $lang ) . ')',
			'post_id' 		=> $lang,
			'parent'		=> $parent['menu_slug']
		));
		acf_add_options_sub_page( array(
			'page_title' 	=> 'KPI Banner (' . strtoupper( $lang ) . ')',
			'menu_title'	=> 'KPI Banner (' . strtoupper( $lang ) . ')',
			'post_id' 		=> $lang,
			'parent'		=> $parent['menu_slug']
		));
		acf_add_options_sub_page( array(
			'page_title' 	=> 'Join Us Banner (' . strtoupper( $lang ) . ')',
			'menu_title'	=> 'Join Us Banner (' . strtoupper( $lang ) . ')',
			'post_id' 		=> $lang,
			'parent'		=> $parent['menu_slug']
		));
	}
}

/**
 * Register additional post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function cush_custom_posts_init() {

	// Action
	$action_labels = array(
		'name'               => __( 'Actions', 'c1sh'),
		'singular_name'      => __( 'Action', 'c1sh'),
		'menu_name'          => __( 'Actions', 'c1sh'),
		'name_admin_bar'     => __( 'Action', 'c1sh'),
		'add_new'            => __( 'Ajouter', 'c1sh'),
		'add_new_item'       => __( 'Ajouter une nouvelle action', 'c1sh'),
		'new_item'           => __( 'Nouvelle action', 'c1sh'),
		'edit_item'          => __( 'Editer action', 'c1sh'),
		'view_item'          => __( 'Voir action', 'c1sh'),
		'view_items'         => __( 'Voir les actions', 'c1sh'),
		'all_items'          => __( 'Toutes les actions', 'c1sh'),
		'search_items'       => __( 'Rechercher les actions', 'c1sh')
	);

	$action_args = array(
		'labels'             => $action_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'actions' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-awards', 
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'page-attributes', 'genesis-cpt-archives-settings' ),
		'taxonomies'		 => array('category', 'post_tag')
	);

	register_post_type('action', $action_args);

	// Institution
	$institution_labels = array(
		'name'               => __( 'Institutions', 'c1sh'),
		'singular_name'      => __( 'Institution', 'c1sh'),
		'menu_name'          => __( 'Institutions', 'c1sh'),
		'name_admin_bar'     => __( 'Institution', 'c1sh'),
		'add_new'            => __( 'Ajouter', 'c1sh'),
		'add_new_item'       => __( 'Ajouter une nouvelle institution', 'c1sh'),
		'new_item'           => __( 'Nouvelle institution', 'c1sh'),
		'edit_item'          => __( 'Editer institution', 'c1sh'),
		'view_item'          => __( 'Voir institution', 'c1sh'),
		'view_items'         => __( 'Voir les institutions', 'c1sh'),
		'all_items'          => __( 'Toutes les institutions', 'c1sh'),
		'search_items'       => __( 'Rechercher les institutions', 'c1sh')
	);

	$institution_args = array(
		'labels'              => $institution_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'institutions' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-building', 
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'genesis-cpt-archives-settings' ),
		'taxonomies'		 => array('category', 'post_tag')
	);

	register_post_type('institution', $institution_args);

	// Contagion
	$contagion_labels = array(
		'name'               => __( 'Contagions', 'c1sh'),
		'singular_name'      => __( 'Contagion', 'c1sh'),
		'menu_name'          => __( 'Contagions', 'c1sh'),
		'name_admin_bar'     => __( 'Contagion', 'c1sh'),
		'add_new'            => __( 'Ajouter', 'c1sh'),
		'add_new_item'       => __( 'Ajouter une nouvelle contagion', 'c1sh'),
		'new_item'           => __( 'Nouvelle contagion', 'c1sh'),
		'edit_item'          => __( 'Editer contagion', 'c1sh'),
		'view_item'          => __( 'Voir contagion', 'c1sh'),
		'view_items'         => __( 'Voir les contagions', 'c1sh'),
		'all_items'          => __( 'Toutes les contagions', 'c1sh'),
		'search_items'       => __( 'Rechercher les contagions', 'c1sh')
	);

	$contagion_args = array(
		'labels'              => $contagion_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'contagions' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-megaphone', 
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'genesis-cpt-archives-settings' ),
		'taxonomies'		 => array('category', 'post_tag')
	);

	register_post_type('contagion', $contagion_args);

}
add_action('init', 'cush_custom_posts_init');

/**
 * Custom excerpt length for posts
 *
 */
function cush_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'cush_excerpt_length', 999 );


/**
 * Code to Display Featured Image on top of the post 
 * 
 */
add_action( 'genesis_after_header', 'cush_full_featured_post_image', 15 );
function cush_full_featured_post_image() {
	if ( is_singular( 'post' ) && has_post_thumbnail() ) {
		echo '<div class="hero-section">';
		echo 	'<div class="wp-custom-header">';
		the_post_thumbnail();
		echo 	'</div>';
		echo '</div>';
	}
}

/**
 * Helper function to get user role
 * 
 */
function cush_get_user_role($id) {
    $user = new WP_User($id);
    return array_shift($user->roles);
}

/**
 * Don't show admin author on posts 
 * 
 */
add_filter( 'genesis_post_info', 'cush_post_info_filter' );
function cush_post_info_filter($post_info) {
	$author_role = cush_get_user_role( get_the_author_meta( 'ID' ) );
	// print_r( $author_role );
	if ( is_singular( 'post' ) && $author_role == 'administrator' ) {
		$post_info = '[post_date]';
		return $post_info;
	} else {
		return $post_info;
	}
}

/**
 * Customize Entry Meta Filed Under and Tagged Under
 * https://basicwp.com/edit-filed-under-tagged-with-text-studiopress/
 * 
 */
add_filter( 'genesis_post_meta', 'cush_entry_meta_footer' );
function cush_entry_meta_footer( $post_meta ) {
	$post_meta = '[post_categories before=""] [post_tags before=""]';
	return $post_meta;
}

/**
 * Move post meta after title and date
 * 
 */
// remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
// add_action( 'genesis_entry_header', 'genesis_post_meta', 20 );

/**
 * Add related posts feed on single posts
 * 
 */
add_action( 'genesis_before_footer', 'cush_related_articles_feed', 5 );

function cush_related_articles_feed() {
	if ( ! is_singular ( 'post' ) ) {
		return;
	}

	if ( have_rows('content_blocks', get_option( 'page_on_front' ) ) ) {
		while ( have_rows( 'content_blocks', get_option( 'page_on_front' ) ) ) {
			the_row();
			if( get_row_layout() == 'post_selection' ) {
				$posts = get_sub_field('post_selection');
			}
		  }
	}

	if ($posts) {
		$i = 0;

		echo '<div class="post-selection">';
		echo '<div class="wrap">';

		// variable must NOT be called $post (IMPORTANT) otherwise will conflict with main loop
		// https://www.advancedcustomfields.com/resources/relationship/
		foreach($posts as $p) {
			if ( $i == 0 ){ echo '<div class="one-third first">'; } else { echo '<div class="one-third">'; }
			// print_r($p);
			echo 	'<div class="post blurb">';
			echo 		'<img src="' . wp_get_attachment_url(get_post_thumbnail_id($p->ID)) . '" alt="" title="">';
			echo        '<div class="item-content">';
			echo 		    '<h4><a href="' . get_permalink($p) . '" title"' . $p->post_title . '" >' . $p->post_title . '</a></h4>';
			echo 		    '<p>' . $p->post_excerpt . '</p>';
			echo		    '<a href="' . get_permalink($p) . '" title="' . $p->post_title . '" class="read-more">' . __('Lire Plus', 'c1sh') . '</a>';
			echo 	    '</div>';
			echo 	'</div>';
			echo '</div>';
			$i++;
		}

		echo '<div class="feed-get-more"><a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '" class="button btn-alt">' . __('Voir Plus', 'c1sh') . '</a></div>';	
		echo '</div>';	// end of wrap
		echo '</div>';	// end of post selection
	}	
}

/**
 * Add reponsive container to embeds
 * 
 * http://alxmedia.se/code/2013/10/make-wordpress-default-video-embeds-responsive/
 * 
 */
add_filter( 'embed_oembed_html', 'cush_responsive_embed_html', 10, 3 );
function cush_responsive_embed_html( $embed ) {
    return '<div class="embed-responsive">' . $embed . '</div>';
}


/**
 * Add categories to attachments
 * 
 * https://code.tutsplus.com/articles/applying-categories-tags-and-custom-taxonomies-to-media-attachments--wp-32319
 * 
 */
add_action( 'init' , 'cush_add_categories_to_attachments' );
function cush_add_categories_to_attachments() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}


/**
 * Add footer area for image
 * 
 * https://wpbeaches.com/create-footer-widget-area-genesis-child-theme/
 * 
 */
add_action( 'widgets_init', 'cush_footer_area_widget' );
function cush_footer_area_widget() {
	genesis_register_sidebar( array(
		'id'          	=> 'footercontent',
		'name'        	=> __( 'Footer', 'c1sh' ),
		'description' 	=> __( 'Footer area', 'c1sh' ),
		'before_widget' => '<div class="footer-image">',
		'after_widget' 	=> '</div>',
	));
}

add_action( 'genesis_footer', 'cush_add_image_to_footer', 9 );
function cush_add_image_to_footer() {
	genesis_widget_area ('footercontent', array(
        'before' => '<div class="footer-image-container">',
        'after' => '</div>',
    ));
}