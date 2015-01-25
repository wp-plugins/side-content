<?php
/*
Plugin Name: Side Content qTranslate Integration
Plugin URI: http://figure-w.co.uk/wordpress-side-content-plugin
Description: Extends the Side Content plugin to perform translation using qTranslate
Author: Matteo Plebani, Comunicrea snc

Version: 1.0
Author URI: http://comunicrea.com
*/
if(!is_admin() && function_exists('qtrans_useCurrentLanguageIfNotFoundShowAvailable')) {
 add_filter('side_content', 'qtrans_useCurrentLanguageIfNotFoundShowAvailable');
}