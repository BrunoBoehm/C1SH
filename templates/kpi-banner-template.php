<?php

if (function_exists('pll_current_language')) {
    $kpi_banner = get_field('kpi_banner', pll_current_language()); 
}

if ( $kpi_banner ) {
    // var_dump($kpi_banner);
    // $true_members_count = count_users()['avail_roles']['contributor'] + wp_count_posts('signature')->publish;
    $true_actions_count = wp_count_posts('action')->publish;
    $true_stories_count = wp_count_posts('contagion')->publish;

    echo '<div class="kpi-banner" style="background-image: url(' . $kpi_banner['bg_img']['url'] . '); background-color: ' . $kpi_banner['bg_color'] . ';">';
    echo '<div class="wrap">';
    // echo 	'<h3>' . $kpi_banner['title'] . '</h3>';
    echo 	'<div class="one-fourth first">';
    echo 		'<span class="kpi-count">' . $kpi_banner['employees_count'] . '</span>';
    echo 		'<p class="kpi-text">' . $kpi_banner['employees_text'] . '</p>';
    echo 	'</div>';
    echo 	'<div class="one-fourth">';
    echo 		'<span class="kpi-count">' . $kpi_banner['students_count']  . '</span>';
    echo 		'<p class="kpi-text">' . $kpi_banner['students_text'] . '</p>';
    echo 	'</div>';    
    echo 	'<div class="one-fourth">';
    echo 		'<span class="kpi-count">' . ( $kpi_banner['actions_count'] ?: $true_actions_count ) . '</span>';
    echo 		'<p class="kpi-text">' . $kpi_banner['actions_text'] . '</p>';
    echo 	'</div>';
    echo 	'<div class="one-fourth">';
    echo 		'<span class="kpi-count">' . ( $kpi_banner['stories_count'] ?: $true_stories_count ) . '</span>';
    echo 		'<p class="kpi-text">' . $kpi_banner['stories_text'] . '</p>';
    echo 	'</div>';
    echo 	'<div class="clearfix"></div>';
    echo '</div>';
    echo '</div>';
}