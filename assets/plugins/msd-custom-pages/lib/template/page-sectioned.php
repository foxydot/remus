<?php
/*
Template Name: Sectioned Page
*/
if(function_exists('genesis')){
    //this is a genesis themed site\
    add_action('genesis_before_footer',array('MSDSectionedPage','sectioned_page_output'), 2);
    genesis();
} else {
    //not genesis. Do things kind of the old fashioend way.
}
