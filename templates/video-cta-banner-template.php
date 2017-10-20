<?php

$banner = get_field('video_cta_banner', 'option');
if ($banner) {
    echo '<section class="video-cta-banner">';
    echo 	'<div class="video-cta-banner-video">' . $banner['video_link'] . '</div>';
    echo 	'<h3>' . $banner['title'] . '</h3>';
    echo 	'<div class="video-cta-banner-video-html">' . $banner['html'] . '</div>';
    echo 	'<a href="' . $banner['btn_link']['url'] . '" title="' . $banner['btn_link']['title'] . '">' . $banner['btn_text'] . '</a>';
    echo '</section>';
}