<?php

$main_cta_banner = get_field('main_cta_banner', 'option');
if ( $main_cta_banner ) {
    echo '<section class="main-cta-banner">';
    echo 	'<h3>' . $main_cta_banner['title'] . '</h3>';
    echo 	'<a href="' . $main_cta_banner['btn_link']['url'] . '">' . $main_cta_banner['btn_text'] . '</a>';
    echo '</section>';
}