<?php

$kpi_banner = get_field('kpi_banner', 'option');
if ( $kpi_banner ) {
    // var_dump($kpi_banner);
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