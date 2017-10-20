<?php

add_action('single_action_template', 'single_action');
function single_action() {

};

get_header();
do_action( 'single_action_template' );
get_footer();