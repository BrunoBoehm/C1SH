<?php

if ( get_field('kpi_banner', 'option') ) {
    // var_dump(get_field('kpi_banner', 'option'));
    $kpi_banner = get_field('kpi_banner', 'option');
    echo '<section class="kpi-banner">';
    echo 	'<h3>' . $kpi_banner['title'] . '</h3>';
    echo 	'<div class="one-third first">';
    echo 		'<span class="kpi-count">' . $kpi_banner['members_count'] . '</span>';
    echo 		'<p class="kpi-text">' . $kpi_banner['members_text'] . '</p>';
    echo 	'</div>';
    echo 	'<div class="one-third">';
    echo 		'<span class="kpi-count">' . $kpi_banner['actions_count'] . '</span>';
    echo 		'<p class="kpi-text">' . $kpi_banner['actions_text'] . '</p>';
    echo 	'</div>';
    echo 	'<div class="one-third">';
    echo 		'<span class="kpi-count">' . $kpi_banner['stories_count'] . '</span>';
    echo 		'<p class="kpi-text">' . $kpi_banner['stories_text'] . '</p>';
    echo 	'</div>';
    echo 	'<div class="clearfix"></div>';				
    echo '</section>';
}

$main_cta_banner = get_field('main_cta_banner', 'option');
if ( $main_cta_banner ) {
    echo '<section class="main-cta-banner">';
    echo 	'<h3>' . $main_cta_banner['title'] . '</h3>';
    echo 	'<a href="' . $main_cta_banner['btn_link']['url'] . '">' . $main_cta_banner['btn_text'] . '</a>';
    echo '</section>';
}