<div class='wrap'>
  <h2><?php _e('Cookie-Opt-In Action reference.', 'cookie_opt_in'); ?></h2>
  <div id="cookie">
    <table>
      <tr>
        <th><?php _e('Registered action', 'cookie_opt_in'); ?></th><th><?php _e('Function or method called', 'cookie_opt_in'); ?></th><th><?php _e('Priority', 'cookie_opt_in'); ?></th><th><?php _e('Use this in the settings', 'cookie_opt_in'); ?></th>
      </tr><?php foreach ($actiontable as $row) { ?>
      <tr><?php foreach ($row as $cell) { ?>
        <td><?php print $cell; ?></td>
      <?php } ?></tr>
    <?php } ?></table>
    <p><?php _e('PLEASE NOTE', 'cookie_opt_in'); ?>:</p>
    <p><?php _e('This information mathes the FRONT-end, NOT the back-end. It is refreshed on page load, just before the page is shown.', 'cookie_opt_in'); ?></p>
    <p><?php _e('Removed actions (by settings) are NOT present in this list if you chose not to accept cookies on your front-end.', 'cookie_opt_in'); ?>!</p>
  </div><?php print coia_donate_html('on-bottom'); ?>
</div>