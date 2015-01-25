<?php
/*
Plugin Name: Side Content NextGEN Integration
Plugin URI: http://figure-w.co.uk/wordpress-side-content-plugin
Description: Extends the Side Content plugin to recognise nextgen shortcodes
Author: Alfred Armstrong, Figure W

Version: 1.0
Author URI: http://figure-w.co.uk
*/
if(!is_admin() && function_exists('searchnggallerytags')) {
  add_filter('side_content', 'searchnggallerytags');
}