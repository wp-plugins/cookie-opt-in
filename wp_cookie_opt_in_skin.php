<?php
/*
Plugin Name: Cookie-Opt-In - Example skin
Plugin URI: http://wordpress.clearsite.nl
Description: Example skin for the Cookie_opt_in plugin
Version: 1.1.0
Author: Clearsite Webdesigners | Remon Pel
Author URI: http://clearsite.nl/author/rmpel
*/
if (!class_exists('CookieOptIn')) {
  require_once ('wp_cookie_opt_in.php');
}

add_filter('do_not_load_cookie_opt_in_visual_effects', 'wp_cookie_opt_in_cls_no_visuals');
function wp_cookie_opt_in_cls_no_visuals() {
  return true;
}

add_filter('init', 'wp_cookie_opt_in_cls_init');
function wp_cookie_opt_in_cls_init() {
  if (!is_admin()) {
    wp_enqueue_script('cookie-opt-in-if', plugins_url('js/cls-cookie-opt-in-if.js', __FILE__), array('jquery', 'cookie-opt-in'), $ver = 1, $in_footer = true);
    wp_enqueue_style('cookie-opt-in', plugins_url('css/cls-style.css', __FILE__));
  }
}

add_filter('cookie_opt_in_settings', 'wp_cookie_opt_in_settings');
function wp_cookie_opt_in_settings($settings) {
  $settings['view_details'] = __('View details');
  return $settings;
}