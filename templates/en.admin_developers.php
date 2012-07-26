<div class='wrap'><?php print coia_donate_html(); ?>
  <h2>Cookie-Opt-In Information for Developers</h2>
  <div id="cookie">
    <p>To adapt your code to respect the wishes of the visitor, as handled by this plugin, do one of the following;</p>
    <p>(Remember; you need to do this ONLY if you script or code uses cookies that are not a must-have to operate! See <a href="<?php print admin_url('admin.php?page=cookie-opt-in'); ?>">'Info'</a>).</p>
    <ol>
      <li>Make the inclusion or printing of script conditional. You can use either the short-cut function <code>coia</code> or the WordPress <code>filter</code> approach;</li>
      <li><code>&lt;?php if (function_exists('coia') &amp;&amp; coia('tracking')) {
  // include google analytics
}?&gt;</code></li>
      <li><code>&lt;?php if (apply_filters('eu_cookie_consent', 'tracking') != 'denied') {
  // do your thing here
  //
}?&gt;</code></li>
    </ol>
    <p>Allowed keywords are 'tracking', 'social', 'advertisement' and 'functional', however, conditionalising 'functional' makes no sense; these cookies are never blocked.</p>
    <p>( coia stands for cookie-opt-in-accepted )</p>
    <p>Alternatively, you can mail us the add_action-calls that call the code that places the cookies, we'll include it in the next release. (see <a href="<?php print admin_url('admin.php?page=cookie-opt-in-actions'); ?>">Actions overview</a>)</p>
    <p>You will have to have consent for these types of cookies;</p>
    <ol>
      <li>'tracking' ; Scripts and code that use cookies to track the users actions, like Google Analytics</li>
      <li>'advertisement' ; Scripts and code that use cookies to determine what ads to show, like Adlantic</li>
      <li>'social' ; Scripts and code that use cookies to track your social life, like Facebook and Google+</li>
    </ol>
    <p>You don't need consent for these, but they help keep the visitor informed;</p>
    <ol>
      <li>'functional' ; the final very generic one; for cookies that are required for the iste to function properly, like session-management.</li>
    </ol>
    <p>Again, this plugin will inform the visitor on the last type, but will not provide a way to deny them; they are required for your site and without those, your site cannot function.</p>
    <h2>Notes</h2>
    <ol>
      <li>A default WordPress site does NOT use cookies in the front-end, only in the back-end. The back-end is NOT a public part of the website, therefore exempt. For a WordPress site out-of-the-box, you do NOT need consent.</li>
      <li>Laws change every day and although we do our best to keep ourselves informed, we might miss something. We're only human (or are we dancers?). If you find any of this information in error, please contact us!</li>
    </ol>
    <h2>Need help?</h2>
    <p>We can help you! If you need help adapting your code, send us an e-mail <a href="mailto:support@clearsite.nl">support@clearsite.nl</a>. (Please note: no promisses on response times, but we'll try our best.)</p>
  </div>
  <h2>Interface alterations.</h2>
  <p>You can block the plugin stylesheet and interface javascript by the following code;</p>
  <code>
    add_filter('do_not_load_cookie_opt_in_visual_effects', 'my_plugin_of_theme_namespace_no_coia_visuals');
    function my_plugin_of_theme_namespace_no_coia_visuals() {
      return true;
    }
  </code>
  <p>After that you can completely style the interface yourself and/or use jQuery to alter the DOM for it.</p>
  <p>In your javascript, define methods on the cookie_opt_in object to hook in the processes;</p>
  <p>Example:</p>
  <code>
    cookie_opt_in.hide_after = function () {
      // some action that happens after the interface is hidden.
    };
  </code>
  <p>The following hooks are available;</p>
  <table>
    <tr>
      <th>init_before, init_after</th><td>Triggered before/after the interface elements are created</td>
    </tr>
    <tr>
      <th>activate_before, activate_after</th><td>Triggered before/after events are attached to the interface elements (like bind('click') )</td>
    </tr>
    <tr>
      <th>action_before, action_after (*1)</th><td>Triggered before/after a button is clicked (must be an <code>input</code> with class <code>button</code>)</td>
    </tr>
    <tr>
      <th>show_before, show_after (*2)</th><td>Triggered before/after the interface is shown</td>
    </tr>
    <tr>
      <th>hide_before, hide_after</th><td>Triggered before/after the interface is hidden</td>
    </tr>
  </table>
  <p>Notes;</p>
  <ol>
    <li>Method receives <code>this</code> as parameter</li>
    <li>Method receives <code>boolean</code> as parameter, true indicating the cookie is new (first time visitor)</li>
  </ol>
</div>
