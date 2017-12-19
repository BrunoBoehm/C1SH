<?php

$banner = get_field('video_cta_banner', 'option');
if ($banner) {

    // Switch menu according to current language
    // https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/
    if( function_exists('pll_current_language') ) {
        $lang = pll_current_language();
        switch($lang){
            case 'en':
                $menu_items = wp_get_nav_menu_items( 'and-you' );
                break;
            case 'fr':
                $menu_items = wp_get_nav_menu_items( 'et-vous' );
                break;    
        }
    };

    echo '<div class="video-cta-banner" id="cta-banner">';
    echo '<div class="wrap">';
    echo 	'<div class="video-cta-banner-video">' . $banner['video_link'] . '</div>';
    echo 	'<h3>' . $banner['title'] . '</h3>';
    echo 	'<div class="video-cta-banner-video-html">' . $banner['html'] . '</div>';
    echo    '<form class="join-us-form">';
    echo        '<select id="join-us-select">';
    echo                '<option value="" selected disabled hidden>' . __("Vous êtes...", "c1sh") . '</option>';
    foreach ($menu_items as $menu_item) {
        echo            '<option value="' . $menu_item->url . '" label="' . $menu_item->title . '" />';
    }
    echo        '</select>';
    echo        '<input type="button" id="submit" value="' . $banner['btn_link']['title'] . '" onClick="c1shRedirectToPath()">';
    echo    '</form>';
    // echo 	'<a href="' . $banner['btn_link']['url'] . '" title="' . $banner['btn_link']['title'] . '" class="button">' . $banner['btn_link']['title'] . '</a>';
    echo '</div>';
    echo '</div>';
}