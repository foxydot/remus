<?php
/*
Template Name: Simple Sectioned Page
*/
if(function_exists('genesis')){
    //this is a genesis themed site
    add_action('genesis_loop',array('MSDSimpleSectionedPage','sectioned_page_output'),30);
    add_action('wp_print_footer_scripts',array('MSDSimpleSectionedPage','sectioned_page_floating_nav'));
    genesis();
} else {
    //not genesis. Do things kind of the old fashioend way.
}
