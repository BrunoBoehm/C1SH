<?php

$main_cta_banner = get_field('main_cta_banner', 'option');
if ( $main_cta_banner ) {
    echo '<div class="main-cta-banner">';
    echo '<div class="wrap">';
    echo 	'<h3>' . $main_cta_banner['title'] . '</h3>';
    echo 	'<a href="' . $main_cta_banner['btn_link']['url'] . '">' . $main_cta_banner['btn_text'] . '</a>';
    echo '</div>';
    echo '</div>';
}