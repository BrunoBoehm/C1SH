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
load_child_theme_textdomain( 'c1sh', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'c1sh' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
// require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
// include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'C1SH' );
define( 'CHILD_THEME_URL', 'http://www.lyketil.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'cush_enqueue_scripts_styles' );
function cush_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'c1sh-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

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
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Banners Settings',
		'menu_title'	=> 'Banner Settings',
		'menu_slug' 	=> 'banner-settings',
		'capability'	=> 'edit_posts'
	));;
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Video CTA Banner',
		'menu_title'	=> 'Video CTA Banner',
		'parent_slug'	=> 'banner-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'KPI Banner',
		'menu_title'	=> 'KPI Banner',
		'parent_slug'	=> 'banner-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Join Us Banner',
		'menu_title'	=> 'Join Us Banner',
		'parent_slug'	=> 'banner-settings',
	));
}

/**
 * Register additional post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function cush_custom_posts_init() {

	// Action
	$action_labels = array(
		'name'               => __( 'Actions'),
		'singular_name'      => __( 'Action'),
		'menu_name'          => __( 'Actions'),
		'name_admin_bar'     => __( 'Action'),
		'add_new'            => __( 'Ajouter'),
		'add_new_item'       => __( 'Ajouter une nouvelle action'),
		'new_item'           => __( 'Nouvelle action'),
		'edit_item'          => __( 'Editer action'),
		'view_item'          => __( 'Voir action'),
		'view_items'         => __( 'Voir les actions'),
		'all_items'          => __( 'Toutes les actions'),
		'search_items'       => __( 'Rechercher les actions')
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
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		'taxonomies'		 => array('category', 'post_tag')
	);

	register_post_type('action', $action_args);

	// Institution
	$institution_labels = array(
		'name'               => __( 'Institutions'),
		'singular_name'      => __( 'Institution'),
		'menu_name'          => __( 'Institutions'),
		'name_admin_bar'     => __( 'Institution'),
		'add_new'            => __( 'Ajouter'),
		'add_new_item'       => __( 'Ajouter une nouvelle institution'),
		'new_item'           => __( 'Nouvelle institution'),
		'edit_item'          => __( 'Editer institution'),
		'view_item'          => __( 'Voir institution'),
		'view_items'         => __( 'Voir les institutions'),
		'all_items'          => __( 'Toutes les institutions'),
		'search_items'       => __( 'Rechercher les institutions')
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
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		'taxonomies'		 => array('category', 'post_tag')
	);

	register_post_type('institution', $institution_args);

	// Contagion
	$contagion_labels = array(
		'name'               => __( 'Contagions'),
		'singular_name'      => __( 'Contagion'),
		'menu_name'          => __( 'Contagions'),
		'name_admin_bar'     => __( 'Contagion'),
		'add_new'            => __( 'Ajouter'),
		'add_new_item'       => __( 'Ajouter une nouvelle contagion'),
		'new_item'           => __( 'Nouvelle contagion'),
		'edit_item'          => __( 'Editer contagion'),
		'view_item'          => __( 'Voir contagion'),
		'view_items'         => __( 'Voir les contagions'),
		'all_items'          => __( 'Toutes les contagions'),
		'search_items'       => __( 'Rechercher les contagions')
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
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		'taxonomies'		 => array('category', 'post_tag')
	);

	register_post_type('contagion', $contagion_args);

}
add_action('init', 'cush_custom_posts_init');