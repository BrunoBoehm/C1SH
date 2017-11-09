<?php

$banner = get_field('video_cta_banner', 'option');
if ($banner) {
    $menu_items = wp_get_nav_menu_items( 'et-vous' );
    echo '<div class="video-cta-banner" id="cta-banner">';
    echo '<div class="wrap">';
    echo 	'<div class="video-cta-banner-video">' . $banner['video_link'] . '</div>';
    echo 	'<h3>' . $banner['title'] . '</h3>';
    echo 	'<div class="video-cta-banner-video-html">' . $banner['html'] . '</div>';
    // echo    '<form onsubmit="c1shRedirectToPath(this);" class="join-us-form">';
    // echo        '<select id="join-us-select">';
    // echo                '<option value="" selected disabled hidden>' . __("Vous êtes...", "C1SH") . '</option>';
    // foreach ($menu_items as $menu_item) {
    //     echo            '<option value="' . get_permalink($menu_item) . '" label="' . $menu_item->title . '" />';
    // }
    // echo        '</select>';
    // echo        '<button>' . $banner['btn_link']['title'] . '</button>';
    // echo    '</form>';
    echo 	'<a href="' . $banner['btn_link']['url'] . '" title="' . $banner['btn_link']['title'] . '" class="button">' . $banner['btn_link']['title'] . '</a>';
    echo '</div>';
    echo '</div>';
}