<?php
/*
Plugin Name: Cookie-Opt-In
Plugin URI: http://wordpress.clearsite.nl
Description: In the EU you must have explicit permission to place cookies other than functionally required and you must provide information on every cookie you place.
Version: 1.1.5
Author: Clearsite Webdesigners | Remon Pel
Author URI: http://clearsite.nl/author/rmpel
*/

// init hooks
add_action('init', array('CookieOptIn', 'init'));
add_action('admin_init', array('CookieOptIn', 'admin_init'));
add_action('wp_head', array('CookieOptIn', 'wp_head'));
add_action('admin_menu', array('CookieOptIn', 'admin_menu'));
add_action('login_head', array('CookieOptIn', 'login_head'));
add_action('admin_head', array('CookieOptIn', 'admin_head'));

add_action('init', array('CookieOptIn', 'just_in_time_init'), 100000000000);

add_filter('eu_cookie_consent', array('CookieOptIn', 'eu_cookie_consent'));

if (function_exists('is_admin') && is_admin() && $_POST && $_POST['is_cookie_opt_in'])
{
  add_action('init', array('CookieOptIn', 'admin_post'));
}
else
{
  add_action('init', array('CookieOptIn', 'front_post'));
}

class CookieOptIn {
  public static function init() {
    load_plugin_textdomain('cookie_opt_in', false, dirname( plugin_basename( __FILE__ ) ) .'/lang/' );
    // wp init
    wp_enqueue_script('cookie-opt-in', plugins_url('js/cookie-opt-in.js', __FILE__), array('jquery'), $ver = 1, $in_footer = true);
    $return = apply_filters('do_not_load_cookie_opt_in_visual_effects', false);
    if (!$return) {
      wp_enqueue_script('cookie-opt-in-if', plugins_url('js/cookie-opt-in-if.js', __FILE__), array('jquery', 'cookie-opt-in'), $ver = 1, $in_footer = true);
      wp_enqueue_style('cookie-opt-in', plugins_url('css/style.css', __FILE__));
    }
  }

  public static function admin_init() {
    // admin init
    if (in_array($_GET['page'], array('cookie-opt-in', 'cookie-opt-in-admin', 'cookie-opt-in-settings', 'cookie-opt-in-dev', 'cookie-opt-in-actions'))) {
      wp_enqueue_style('cookie-opt-in-admin', plugins_url('css/admin.css', __FILE__));
    }
  }

  public static function admin_menu() {
    // admin menu
    add_menu_page(__('Cookie-Opt-In', 'cookie_opt_in'), __('Cookie-Opt-In', 'cookie_opt_in'), 'manage_options', 'cookie-opt-in', array('CookieOptIn', 'admin_info'), plugins_url('css/clearsite-icon.png', __FILE__));
    add_submenu_page('cookie-opt-in', __('Cookie-Opt-In Info', 'cookie_opt_in'), __('Information', 'cookie_opt_in'), 'manage_options', 'cookie-opt-in', array('CookieOptIn', 'admin_info'));
    add_submenu_page('cookie-opt-in', __('Cookie-Opt-In Developers Info', 'cookie_opt_in'), __('Developers info', 'cookie_opt_in'), 'manage_options', 'cookie-opt-in-dev', array('CookieOptIn', 'admin_info_dev'));
    add_submenu_page('cookie-opt-in', __('Cookie-Opt-In Settings', 'cookie_opt_in'), __('Settings', 'cookie_opt_in'), 'manage_options', 'cookie-opt-in-settings', array('CookieOptIn', 'admin_page'));
    add_submenu_page('cookie-opt-in', __('Cookie-Opt-In Actions Overview', 'cookie_opt_in'), __('Actions overview', 'cookie_opt_in'), 'manage_options', 'cookie-opt-in-actions', array('CookieOptIn', 'admin_actions'));
  }

  function admin_info() {
    $settings = self::settings();
    require (dirname(__FILE__) .'/templates/admin_info.php');
  }

  function admin_info_dev() {
    $settings = self::settings();
    require (dirname(__FILE__) .'/templates/admin_developers.php');
  }

  function admin_actions() {
    $_actiontable = get_option('wp_cookie_opt_in_action_table', false);
    if (!$_actiontable) {
      $actiontable = array(array(__('No actions have been cached. Please visit your website and return here.', 'cookie_opt_in')));
    }
    else {
      $actiontable = array();
      $sort = array();
      foreach ($_actiontable as $action => $_level1) {
        foreach ($_level1 as $priority => $_level2) {
          foreach ($_level2 as $idx => $function) {
            $function = $function['function'];
            $row = array();
            $row[] = $action;
            $row[] = is_array($function) ? ( is_object($function[0]) ? '[OBJECT]' : implode('::', $function)) : $function;
            $row[] = $priority;
            $row[] = '<code>'. $action .':' . (is_array($function) ? ( is_object($function[0]) ? 'IDX#'. $idx : implode(',', $function) ) : $function) .':'. $priority .'</code>';
            $sort[] = implode(',', $row);
            $actiontable[] = $row;
          }
        }
      }
    }
    if ($sort) array_multisort($sort, $actiontable);

    require (dirname(__FILE__) .'/templates/admin_actions.php');
  }

  function admin_page() {
    $settings = self::settings();
    require (dirname(__FILE__) .'/templates/admin_page.php');
  }

  public static function admin_post() {
    // admin post
    if (wp_verify_nonce($_POST['is_cookie_opt_in'], 'is_cookie_opt_in')) {
			if (!empty($_POST['settings']['cookies_to_destroy'])) {
				foreach ($_POST['settings']['cookies_to_destroy'] as $key => $value) {
					$_POST['settings']['cookies_to_destroy'][$key] = array_values(array_filter(explode("\n", str_replace("\r", "\n", $value))));
				}
			}
      foreach ($_POST['settings']['un_action'] as $key => $value) {
        $_POST['settings']['un_action'][$key] = array_values(array_filter(explode("\n", str_replace("\r", "\n", $value))));
      }
      update_option('cookie_opt_in_settings', $_POST['settings']);
    }
    wp_redirect(remove_query_arg('bla'));
    exit;
  }

  public static function front_post() {
    // front post
  }

  public static function admin_head() {
    // admin head
    print '<script type="text/javascript">var cookie_opt_in_settings = false;</script>';
  }

  public static function login_head() {
    // admin head
    return self::wp_head();
  }

  public static function wp_head() {
    // front head
    $settings = self::settings();
    $settings['default_cookie'] = '';
    $settings['destroy'] = array();
    $settings['cookie_types'] = array();
    foreach (array('site_has_functional_cookies' /*, 'site_has_ecommerce_cookies' */, 'site_has_advertisement_cookies', 'site_has_tracking_cookies', 'site_has_social_cookies') as $i) {
      if ($settings[$i]) {
        $settings['default_cookie'] .= substr($i,9,1) . $settings[str_replace('site_has_', 'default_value_', $i)];
        $settings['cookie_types'][] = $i;
      }
      if (!self::visitor_accepts($shorttag = substr($i,9,-8))) {
        $settings['destroy'] = array_merge($settings['destroy'], (array)$settings['cookies_to_destroy'][$shorttag]);
      }
    }

    unset($settings['cookies_to_destroy']);
    unset($settings['un_action']);
    unset($settings['un_action_unchangeable']);

    if ($settings['preference_cookie_expires'] == 'never') {
      $settings['preference_cookie_expires'] = strtotime('31 december 2149');
      if (!$settings['preference_cookie_expires']) $settings['preference_cookie_expires'] = strtotime('31 december 2037');
    }
    elseif ($settings['preference_cookie_expires'] == 'session_end') {
      $settings['preference_cookie_expires'] = false;
    }
    elseif ($settings['preference_cookie_expires'] <= 315576000) { // <= ten years ? assume ttl
      $settings['preference_cookie_expires'] += current_time('timestamp');
    }
    elseif ($settings['preference_cookie_expires'] > 315576000) { // > ten years ? assume timestamp or date
      $settings['preference_cookie_expires'] = is_int($settings['preference_cookie_expires']) ? $settings['preference_cookie_expires'] : strtotime($settings['preference_cookie_expires']);
    }

    if ($settings['preference_cookie_expires']) {
      $settings['preference_cookie_expires'] = date('r', $settings['preference_cookie_expires']);
    }

    $settings['label_ok'] = __('Ok', 'cookie_opt_in');
    $settings['label_deny'] = __('Deny', 'cookie_opt_in');
    $settings['label_allow'] = __('Allow', 'cookie_opt_in');

    $settings = array_filter($settings);

    $settings['baseurl'] = plugins_url('', __FILE__);

    $settings = apply_filters('cookie_opt_in_settings', $settings);
    print '<script type="text/javascript">var cookie_opt_in_settings = '. json_encode($settings) .';</script>';
  }

  public static function settings() {
    $settings = get_option('cookie_opt_in_settings', array());
    foreach (array(
      'all_or_nothing' => 0,
      'anchor_title' => __('Cookie preferences', 'cookie_opt_in'),
      'require_permission_to_access_site' => 0,
      'site_has_advertisement_cookies' => 0,
      // 'site_has_ecommerce_cookies' => 0,
      'site_has_tracking_cookies' => 0,
      'site_has_social_cookies' => 0,
      'site_has_functional_cookies' => 1,
      'default_value_advertisement_cookies' => 0,
      // 'default_value_ecommerce_cookies' => 1,
      'default_value_tracking_cookies' => 0,
      'default_value_social_cookies' => 0,
      'default_value_functional_cookies' => 1,
      'preference_cookie_name' => 'ClearsiteCookieLawObidingCookiePreferencesCookie',
      'preference_cookie_expires' => 'never', // can be never, session_end, timestamp or ttl.
      'label_advertisement_cookies' => __('Allow advertisement cookies', 'cookie_opt_in'),
      // 'label_ecommerce_cookies' => __('Allow ecommerce cookies', 'cookie_opt_in'),
      'label_tracking_cookies' => __('Allow tracking cookies', 'cookie_opt_in'),
      'label_social_cookies' => __('Allow social cookies', 'cookie_opt_in'),
      'label_functional_cookies' => __('Allow functional cookies', 'cookie_opt_in'),
      'brief_info_on_advertisement_cookies' => __('This website uses cookies for advertisement purposes, for example: to give you offers specifically suited to your wishes.', 'cookie_opt_in'),
      // 'brief_info_on_ecommerce_cookies' => __('This website uses cookies for e-commerce like the contents of your shopping cart and your preferred postal address.', 'cookie_opt_in'),
      'brief_info_on_tracking_cookies' => __('This website uses cookies for tracking purposes like Google Analytics.', 'cookie_opt_in'),
      'brief_info_on_social_cookies' => __('This website uses cookies for tracking purposes on social networks like Facebook, Google+ etc.', 'cookie_opt_in'),
      'brief_info_on_functional_cookies' => __('This website uses cookies for storing session information. These cookies will self-destruct when you close your browser. The cookies are required for the website to function.', 'cookie_opt_in'),
      'more_info_url_advertisement_cookies' => '',
      // 'more_info_url_ecommerce_cookies' => '',
      'more_info_url_tracking_cookies' => '',
      'more_info_url_social_cookies' => '',
      'more_info_url_functional_cookies' => '',
      'more_info_url' => '',
      'more_info_text' => __('More info', 'cookie_opt_in'),
      'form_title' => 'We need your permission',
      'always_on' => array('site_has_functional_cookies' => true/* , 'site_has_ecommerce_cookies' => true, */ ),
      'always_on_remark' => __('This website cannot operate without these cookies. By law, these cookies are permitted.', 'cookie_opt_in'),
    /* cookie destroyer does not work on google cookies. so I doubt it will ever
      'cookies_to_destroy' => array(
        'tracking' => array('__utma', '__utmb', '__utmc', '__utmx', '__utmxx', '__utmz', '__utmz_.+'),
      ),*/
      'un_action' => array(),
      'un_action_unchangeable' => array(
        'tracking' => array(
          'wp_head:GA_Filter,spool_analytics:10',
          'wp_head:GA_Filter,spool_analytics:2',
          'login_head:GA_Filter,spool_analytics:20',
          'wp_footer:AGA_Filter,spool_analytics_async_foot:99',
          'wp_head:AGA_Filter,spool_analytics_async_head:1',
          'wp_head:AGA_Filter,spool_analytics:20',
          'login_head:AGA_Filter,spool_analytics:20',
          'wp_head:AGA_Filter,XFN_Head:2',

        ),
        'advertisement' => array(
          'wp_head:GA_Filter,spool_adsense,1',
        ),
      ),
    ) as $key => $value) {
      if (!array_key_exists($key, $settings)) $settings[$key] = $value;
    }
    /* for translation purposes */
    $for_tx = array(
      __('advertisement', 'cookie_opt_in'),
      __('ecommerce', 'cookie_opt_in'),
      __('tracking', 'cookie_opt_in'),
      __('social', 'cookie_opt_in'),
      __('functional', 'cookie_opt_in'),
      __('Advertisement Cookies', 'cookie_opt_in'),
      __('Ecommerce Cookies', 'cookie_opt_in'),
      __('Tracking Cookies', 'cookie_opt_in'),
      __('Social Cookies', 'cookie_opt_in'),
      __('Functional Cookies', 'cookie_opt_in'),
      __('View details', 'cookie_opt_in'),
    );
    return $settings;
  }

  public static function visitor_accepts($type) {
    $settings = self::settings();
    $cookie = $_COOKIE[ $settings['preference_cookie_name'] ];
    $reg = '/'. substr($type, 0, 1) . '([01])' .'/';
    preg_match($reg, $cookie, $match);
    return $match[1] == '1';
  }

  public static function eu_cookie_consent($type) {
    $settings = self::settings();
    $active_tag = "site_has_{$type}_cookies";
    if (!$settings[$active_tag]) {
      // configuration says no,
      // plugin requesting access says yes
      // update configuration
      $settings[$active_tag] = 1;
      update_option('cookie_opt_in_settings', $settings);
    }
    if (!CookieOptIn::visitor_accepts($type)) return 'denied';
  }

  public static function just_in_time_init() {
    global $wp_filter;
    if (!is_admin()) update_option('wp_cookie_opt_in_action_table', $wp_filter);
    // attempt removal of known plugins
    $settings = self::settings();
    foreach ($settings['un_action_unchangeable'] as $key => $values) {
      if (!is_array($settings['un_action'][$key])) $settings['un_action'][$key] = array();
      $settings['un_action'][$key] = array_merge($settings['un_action'][$key], $values);
    }
    foreach ($settings['un_action'] as $key => $values) {
      if (!self::visitor_accepts($key)) {
        foreach ((array)$values as $value) {
          // var_dump($value);
          list($action, $function, $priority) = explode(':', trim($value));
          list($class,$method) = explode(',', $function);
          list($_idx, $idx) = explode('IDX#', $function);
          if ($idx) {
            // OOOOH, we need to hack this away - NOT THE PREFERRED WAY
            unset($wp_filter[$action][$priority][$idx]);
          }
          elseif ($method) {
            // print "\nremoving method $action - $class :: $method";
            remove_action($action, array($class, $method), $priority);
          }
          else {
            // print "\nremoving function $action - $function";
            remove_action($action, $function, $priority);
          }
        }
      }
    }
    // attempt removal of admin input
    //
  }
}

function coia($type) {
  return CookieOptIn::eu_cookie_consent($type) != 'denied';
}

function coi_urlencode($unencoded) {
  return urlencode($unencoded);
}
#add_action('init', function() { var_DumP(coia('tracking')); });

function coia_donate_html($class='') {
  if (!$lang = WPLANG) $lang = 'en_US';
  $lang = explode('_', $lang);
  if ($lang[0] == 'nl') {
    $lang = 'nl_NL';
  }
  else {
    $lang = 'en_US';
  }
  return apply_filters('coia_donate_html', coia_donate_html_wrap('
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
'. ($lang == 'nl_NL' ? '<input type="image" src="https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal, de veilige en complete manier van online betalen.">
' : '<input type="image" src="https://www.paypalobjects.com/en_US/NL/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
') .'<img alt="" border="0" src="https://www.paypalobjects.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
  </form>', $class));
}

function coia_donate_html_wrap($html, $class='') {
  return '
<div id="coia-donations" class="'. $class .'">
  <h2>'. __('Donations', 'cookie_opt_in') .'</h2>
  <p>'. __('Although Clearsite Webdesigners are webdesigners by trade, this plugin is presented to the community free of charge. To keep this plugin up to date, funds are needed. If you like this plugin and continue to use it, please consider donating.', 'cookie_opt_in') .'</p>
  <p>'. __('Thank you very much for your support.', 'cookie_opt_in') .'</p>'. $html .'
  <p style="text-align: right;"><a href="http://www.clearsite.nl/" target="_blank"><img src="'. plugins_url('css/clearsite.png', __FILE__) .'" alt="Clearsite.nl" width="300" /></a></p>
</div>';
}

add_filter('body_class', 'coia_body_class');
function coia_body_class($body_classes) {
  if (defined('WPLANG')) $body_classes[] = 'lang-'. WPLANG;
  return $body_classes;
}
