<div class='wrap'>
  <h2><?php _e('Cookie-Opt-In Settings', 'cookie_opt_in'); ?></h2>
  <div id="cookie">
    <form method="post">
      <input type="hidden" name="is_cookie_opt_in" value="<?php print wp_create_nonce('is_cookie_opt_in'); ?>" />
      <table cellspacing="0">
        <tr>
          <th id="col1" class="h lefth">
            <?php _e('General settings', 'cookie_opt_in'); ?>
          </th>
          <th id="col2" class="h middleh">&nbsp;</th>
          <th id="col3" class="h middleh">&nbsp;</th>
          <th id="col4" class="h righth">&nbsp;</th>
        </tr>
        <tr>
          <th class="left">
            <?php _e('Form Title', 'cookie_opt_in'); ?>
          </th>
          <td>
            <input type="text" name="settings[form_title]" value="<?php print esc_attr($settings['form_title']); ?>" />
          </td>
          <td colspan="2" class="right">
            <?php _e('This is the title above the form that asks the user to choose what is and is not allowed', 'cookie_opt_in'); ?>
          </td>
        </tr>
        <tr>
          <th class="left">
            <?php _e('Anchor Title', 'cookie_opt_in'); ?>
          </th>
          <td>
            <input type="text" name="settings[anchor_title]" value="<?php print esc_attr($settings['anchor_title']); ?>" />
          </td>
          <td colspan="2" class="right">
            <?php _e('This is the title of the preferences link', 'cookie_opt_in'); ?>
          </td>
        </tr>
        <tr>
          <th class="left">
            <?php _e('Consent mode.', 'cookie_opt_in'); ?>
          </th>
          <td>
            <select name="settings[all_or_nothing]">
              <option value="1"<?php if ($settings['all_or_nothing']) print ' selected="selected"'; ?>><?php _e('Allow/Deny all cookies', 'cookie_opt_in'); ?></option>
              <option value="0"<?php if (!$settings['all_or_nothing']) print ' selected="selected"'; ?>><?php _e('Pick individual', 'cookie_opt_in'); ?></option>
            </select>
          </td>
          <td colspan="2" class="right">
            <?php _e('You can either have the visitor pick individual functionalities or just Allow/Deny.', 'cookie_opt_in'); ?>
          </td>
        </tr>
        <tr>
          <th class="left">
            <?php _e('More info link text.', 'cookie_opt_in'); ?>
          </th>
          <td>
            <input type="text" name="settings[more_info_text]" value="<?php print esc_attr($settings['more_info_text']); ?>" />
          </td>
          <th>
            <?php _e('Generic more-info link url.', 'cookie_opt_in'); ?>
          </th>
          <td class="right">
            <input type="text" name="settings[more_info_url]" value="<?php print esc_attr($settings['more_info_url']); ?>" />
          </td>
        </tr>
        <tr>
          <th class="left">
            <?php _e('The name of the cookie.', 'cookie_opt_in'); ?>
          </th>
          <td>
            <input type="text" name="settings[preference_cookie_name]" value="<?php print esc_attr($settings['preference_cookie_name']); ?>" />
          </td>
          <td colspan="2" class="right">
            <?php _e('Usually this does not have to be changed.', 'cookie_opt_in'); ?>
          </td>
        </tr>
        <tr>
          <th class="left">
            <?php _e('Inform-only remark.', 'cookie_opt_in'); ?>
          </th>
          <td>
            <textarea name="settings[always_on_remark]"><?php print $settings['always_on_remark']; ?></textarea>
          </td>
          <td colspan="2" class="right">
            <?php _e('Remark for cookie-types that do not require permission but they do require the visitor to be informed.', 'cookie_opt_in'); ?>
          </td>
        </tr>
        <tr>
          <th class="left">
            <?php _e('The TTL of the cookie. The cookie expires...', 'cookie_opt_in'); ?>
          </th>
          <td>
            <select id="expiry" name="settings[preference_cookie_expires]">
              <option value="never"><?php _e('never', 'cookie_opt_in'); ?></option>
              <option value="session_end"><?php _e('at browser close', 'cookie_opt_in'); ?></option>
              <option value="<?php print      5*365.24*24*60*60; ?>"><?php _e('in 5 years', 'cookie_opt_in'); ?></option>
              <option value="<?php print      1*365.24*24*60*60; ?>"><?php _e('in 1 year', 'cookie_opt_in'); ?></option>
              <option value="<?php print    0.5*365.24*24*60*60; ?>"><?php _e('in 6 months', 'cookie_opt_in'); ?></option>
              <option value="<?php print (1/12)*365.24*24*60*60; ?>"><?php _e('in 1 month', 'cookie_opt_in'); ?></option>
              <option value="<?php print (1/52)*365.24*24*60*60; ?>"><?php _e('in 1 week', 'cookie_opt_in'); ?></option>
              <option value="<?php print               24*60*60; ?>"><?php _e('in 1 day', 'cookie_opt_in'); ?></option>
              <option value="<?php print               12*60*60; ?>"><?php _e('in 12 hours', 'cookie_opt_in'); ?></option>
              <option value="<?php print                6*60*60; ?>"><?php _e('in 6 hours', 'cookie_opt_in'); ?></option>
              <option value="<?php print                3*60*60; ?>"><?php _e('in 3 hours', 'cookie_opt_in'); ?></option>
              <option value="<?php print                1*60*60; ?>"><?php _e('in 1 hour', 'cookie_opt_in'); ?></option>
              <option value="<?php print                  30*60; ?>"><?php _e('in 30 minutes', 'cookie_opt_in'); ?></option>
              <option value="<?php print                  15*60; ?>"><?php _e('in 15 minutes', 'cookie_opt_in'); ?></option>
            </select>
            <script>jQuery("#expiry option[value=<?php print $settings['preference_cookie_expires']; ?>]").attr('selected',true)</script>
          </td>
          <td colspan="2" class="right">
            <?php _e('When does the preference expire?', 'cookie_opt_in'); ?><br />
            <?php _e("Selecting 'at browser close', a user must set his preference every new visit. Closing the browser will dismiss the preferences.", 'cookie_opt_in'); ?><br />
            <?php _e("With 'never', a user sets his preference once for a hundred years (or the time the cookies are reset).", 'cookie_opt_in'); ?><br />
            <?php _e("With an expiry time selected, the preference remains for that amount of time.", 'cookie_opt_in'); ?>
          </td>
        </tr><?php foreach (array('site_has_functional_cookies', 'site_has_advertisement_cookies', /*'site_has_ecommerce_cookies', */'site_has_tracking_cookies', 'site_has_social_cookies') as $i) { ?>
        <tr class="closer">
          <td class="left">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
        <tr class="spacer">
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <th colspan="4" class="h"><?php _e('Section', 'cookie_opt_in'); ?>: <?php print $section = __(ucwords(str_replace('_', ' ', substr($i, 9)))); $_section = str_replace(array('site_has_', '_cookies'), '', $i); ?></th>
        </tr>
        <tr>
          <th class="left"><?php print sprintf(__('Site has %s?', 'cookie_opt_in'), $section); ?></th>
          <td>
            <select name="settings[<?php print $i; ?>]">
              <option value="1"<?php if ($settings[$i]) print ' selected="selected"'; ?>><?php _e('Yes', 'cookie_opt_in'); ?></option>
              <option value="0"<?php if (!$settings[$i]) print ' selected="selected"'; ?>><?php _e('No', 'cookie_opt_in'); ?></option>
            </select>
          </td>
          <td colspan="2" class="right">
            <?php _e('If Yes, set the following options.', 'cookie_opt_in'); ?>
          </td>
        </tr>
        <tr>
          <th class="left"><?php _e('Default value for new visitors.', 'cookie_opt_in'); ?><br /><?php _e('Remember the rules!!!', 'cookie_opt_in'); ?></th>
          <td>
            <select name="settings[<?php print $j = str_replace('site_has_', 'default_value_', $i); ?>]">
              <option value="1"<?php if ($settings[$j]) print ' selected="selected"'; ?>><?php _e('Yes', 'cookie_opt_in'); ?></option>
              <option value="0"<?php if (!$settings[$j]) print ' selected="selected"'; ?>><?php _e('No', 'cookie_opt_in'); ?></option>
            </select>
          </td>
          <th><?php _e('Indicative label', 'cookie_opt_in'); ?></th>
          <td class="right">
            <input type="text" name="settings[<?php print $j = str_replace('site_has_', 'label_', $i); ?>]" value="<?php print esc_attr($settings[$j]); ?>" />
          </td>
        </tr>
        <tr>
          <th class="left"><?php _e('Long description', 'cookie_opt_in'); ?></th>
          <td colspan="3" class="right">
            <textarea name="settings[<?php print $j = str_replace('site_has_', 'brief_info_on_', $i); ?>]"><?php print $settings[$j]; ?></textarea>
          </td>
        </tr>
        <tr>
          <th class="left"><?php _e('Page for more info', 'cookie_opt_in'); ?></th>
          <td colspan="3" class="right">
            <input type="text" name="settings[<?php print $j = str_replace('site_has_', 'more_info_', $i); ?>]" value="<?php print esc_attr($settings[$j]); ?>" />
          </td>
        </tr>
        <tr>
          <th class="left"><?php _e('If denied by visitor, try to un-register the following actions. Please be careful.', 'cookie_opt_in'); ?><br />
            <?php _e('Format', 'cookie_opt_in'); ?>: <code><?php _e('action_name', 'cookie_opt_in'); ?></code>:<code><?php _e('function', 'cookie_opt_in'); ?></code>:<code><?php _e('PRIO', 'cookie_opt_in'); ?></code>.<br />
            <?php _e('For a class method', 'cookie_opt_in'); ?>: <code><?php _e('action_name', 'cookie_opt_in'); ?></code>:<code><?php _e('classname', 'cookie_opt_in'); ?></code>,<code><?php _e('method', 'cookie_opt_in'); ?></code>:<code><?php _e('PRIO', 'cookie_opt_in'); ?></code>.<br />
            <?php _e('Example', 'cookie_opt_in'); ?>: <code>wp_head:my_head_function:10</code>.
          </th>
          <td colspan="2">
            <textarea name="settings[un_action][<?php print $j = $_section ?>]"><?php print implode("\n", (array)$settings['un_action'][$j]); ?></textarea>
          </td><?php
            $s = coi_urlencode(sprintf(__('Found working action removal for CookieOptIn section %s', 'cookie_opt_in'), $section));
            $b = coi_urlencode(sprintf(__("For section: %s", 'cookie_opt_in'), $section) .";\n\n". implode("\n", (array)$settings['un_action'][$_section]) . "\n\n". get_bloginfo('url'));
          ?>
          <td class="right">
            <?php _e('FOUND A WORKING REMOVAL??', 'cookie_opt_in'); ?>
            <?php print sprintf(__('Please <a href="%s">MAIL us</a>.', 'cookie_opt_in'), 'mailto:support@clearsite.nl?subject='. $s .'&amp;body='. $b); ?>
            <?php _e('We thank you in advance.', 'cookie_opt_in'); ?>
          </td>
        </tr><?php if ($settings['un_action_unchangeable'][$_section]) { ?>
        <tr>
          <th class="left"><?php _e('The following actions are known to us and ability to remove these actions is verified.', 'cookie_opt_in'); ?></th><?php
            $count = count($settings['un_action_unchangeable'][$_section]);
            $slice = array();
            foreach ($settings['un_action_unchangeable'][$_section] as $k => $item) $slice[ $k%3 ][] = $item; ?>
          <td><code><?php print implode('</code><br /><code>', (array)$slice[0]); ?></code></td>
          <td><code><?php print implode('</code><br /><code>', (array)$slice[1]); ?></code></td>
          <td class="right"><code><?php print implode('</code><br /><code>', (array)$slice[2]); ?></code></td>
        </tr><?php } ?><?php     /* cookie destroyer does not work on google cookies. so I doubt it will ever
        <tr>
          <th class="left">If denied by visitor, try to destroy the following cookies (regular expressions each on a line)</th>
          <td colspan="3" class="right">
            <textarea name="settings[cookies_to_destroy][<?php print $j = $_section ?>]"><?php print implode("\n", (array)$settings['cookies_to_destroy'][$j]); ?></textarea>
          </td>
        </tr><?php */ } ?>
        <tr class="closer">
          <td class="left">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
        <tr class="spacer">
          <td colspan="4">&nbsp;</td>
        </tr>
      </table>
      <input type="submit" value="<?php _e('Save settings', 'cookie_opt_in'); ?>" class="button-primary action" />
    </form>
  </div><?php print coia_donate_html('on-bottom'); ?>
</div>