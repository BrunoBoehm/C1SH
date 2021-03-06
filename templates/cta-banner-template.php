<?php

if (function_exists('pll_current_language')) {
    $main_cta_banner = get_field('main_cta_banner', pll_current_language()); 
}

if ( $main_cta_banner ) {
    echo '<div class="main-cta-banner" style="background-image: url(' . $main_cta_banner['bg_img']['url'] . ');">';
    echo '<div class="wrap">';
    echo 	'<h3>' . $main_cta_banner['title'] . '</h3>';
    echo 	'<a href="' . $main_cta_banner['btn_link']['url'] . '" class="button" title="' . $main_cta_banner['btn_link']['title'] . '">' . $main_cta_banner['btn_link']['title'] . '</a>';
    echo '</div>';
    echo '</div>';
}