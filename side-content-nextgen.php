<?php
/*
Plugin Name: Side Content NextGEN Integration
Plugin URI: http://likemind.co.uk/wordpress-side-content-plugin
Description: Extends the Side Content plugin to recognise nextgen shortcodes
Author: Alfred Armstrong, Likemind Web Services

Version: 0.8
Author URI: http://likemind.co.uk
*/
if(!is_admin() && function_exists('searchnggallerytags')) {
  add_filter('side_content', 'searchnggallerytags');
}