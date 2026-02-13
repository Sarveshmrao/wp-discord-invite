<?php

/**
 * This file is included with WP Discord Invite WordPress Plugin (https://wordpress.com/plugins/wp-discord-invite), Developed by Sarvesh M Rao (https://sarveshmrao.in/).
 * This file is licensed under Generl Public License v2 (GPLv2)  or later.
 * Using the code on whole or in part against the license can lead to legal prosecution.
 * 
 * Sarvesh M Rao
 * https://sarveshmrao.in/
 */

if (!defined("ABSPATH")) {
  exit();
}

//COUNT PAGE START
/**
 * Display the click count and webhook settings page
 * 
 * @return void
 */
function smr_discord_count_page()
{
  // Capability check for admin access
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  }

  // Enqueue admin styles
  wp_enqueue_style(
    'wp-discord-admin-styles',
    plugin_dir_url(__FILE__) . './../assets/admin-styles.css',
    array(),
    '2.6.0'
  );
  wp_enqueue_style(
    'CssForDscOAuth',
    plugin_dir_url(__FILE__) . './../assets/dsc-oauth.css',
    array(),
    '2.6.0'
  );
  
  ?>
<div class="wrap wp-discord-wrap">
  <!-- Header -->
  <div class="wp-discord-header">
    <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . './../assets/icon-128x128.png'); ?>" alt="<?php esc_attr_e('WP Discord Invite', 'wp-discord-invite'); ?>">
    <div class="wp-discord-header-content">
      <h1><?php _e('Click Analytics & Webhooks', 'wp-discord-invite'); ?></h1>
      <p><?php _e('Monitor your Discord invite link performance and configure Discord notifications', 'wp-discord-invite'); ?></p>
    </div>
  </div>

  <script type="text/javascript">var $j = jQuery.noConflict();</script>

  <!-- Stats Overview Card -->
  <div class="wp-discord-card">
    <div class="wp-discord-card-header">
      <h2><span class="dashicons dashicons-chart-line"></span><?php _e('Performance Statistics', 'wp-discord-invite'); ?></h2>
    </div>
    <div class="wp-discord-card-body">
      <div class="wp-discord-stats-grid">
        
        <!-- Your Link -->
        <div class="wp-discord-stat-card">
          <div class="wp-discord-stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <span class="dashicons dashicons-admin-links"></span>
          </div>
          <div class="wp-discord-stat-content">
            <div class="wp-discord-stat-label"><?php _e('Your Invite Link', 'wp-discord-invite'); ?></div>
            <div class="wp-discord-stat-value" style="font-size: 14px; word-break: break-all;">
              <?php echo esc_html(get_option('siteurl') . '/' . get_option('smr_discord_uri')); ?>
            </div>
          </div>
        </div>

        <!-- Total Clicks -->
        <div class="wp-discord-stat-card">
          <div class="wp-discord-stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <span class="dashicons dashicons-analytics"></span>
          </div>
          <div class="wp-discord-stat-content">
            <div class="wp-discord-stat-label"><?php _e('Total Clicks', 'wp-discord-invite'); ?></div>
            <div class="wp-discord-stat-value"><?php echo esc_html(get_option('smr_discord_click_count')); ?></div>
          </div>
        </div>

        <!-- Last Click -->
        <div class="wp-discord-stat-card">
          <div class="wp-discord-stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <span class="dashicons dashicons-clock"></span>
          </div>
          <div class="wp-discord-stat-content">
            <div class="wp-discord-stat-label"><?php _e('Last Click', 'wp-discord-invite'); ?></div>
            <div class="wp-discord-stat-value" style="font-size: 16px;">
              <?php echo esc_html(time_elapsed_string(get_option('smr_discord_link_last_click'))); ?>
            </div>
            <div class="wp-discord-stat-sublabel"><?php echo esc_html(get_option('smr_discord_link_last_click')); ?></div>
          </div>
        </div>

        <!-- Last Reset -->
        <div class="wp-discord-stat-card">
          <div class="wp-discord-stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <span class="dashicons dashicons-update"></span>
          </div>
          <div class="wp-discord-stat-content">
            <div class="wp-discord-stat-label"><?php _e('Last Reset', 'wp-discord-invite'); ?></div>
            <div class="wp-discord-stat-value" style="font-size: 16px;">
              <?php echo esc_html(time_elapsed_string(get_option('smr_discord_click_count_last_reset'))); ?>
            </div>
            <div class="wp-discord-stat-sublabel"><?php echo esc_html(get_option('smr_discord_click_count_last_reset')); ?></div>
          </div>
        </div>

      </div>
    </div>
    <div class="wp-discord-card-footer">
      <form method="post" action="options.php" style="margin: 0;">
        <?php settings_fields('smr-discord-count-group'); ?>
        <input type="hidden" name="smr_discord_click_count" value="0" />
        <input type="hidden" name="smr_discord_click_count_last_reset" value="<?php echo esc_attr(current_time('Y-m-d h:i:sa')); ?>" />
        <button type="submit" class="button button-secondary" onclick="return confirm('<?php esc_attr_e('Are you sure you want to reset the click count? This action cannot be undone.', 'wp-discord-invite'); ?>');">
          <span class="dashicons dashicons-image-rotate" style="margin-top: 3px;"></span>
          <?php _e('Reset Click Count', 'wp-discord-invite'); ?>
        </button>
        <span class="description" style="margin-left: 10px;">
          <?php _e('This will set the click counter back to zero (irreversible)', 'wp-discord-invite'); ?>
        </span>
      </form>
    </div>
  </div>

  <!-- Webhook Configuration Card -->
  <div class="wp-discord-card">
    <div class="wp-discord-card-header">
      <h2><span class="dashicons dashicons-megaphone"></span><?php _e('Discord Webhook Notifications', 'wp-discord-invite'); ?></h2>
    </div>
    <div class="wp-discord-card-body">
      <p class="description" style="margin-bottom: 20px;">
        <?php _e('Get notified in your Discord server whenever someone clicks your invite link. Perfect for tracking engagement in real-time.', 'wp-discord-invite'); ?>
      </p>

      <form method="post" action="options.php">
        <?php 
        settings_fields('smr-discord-webhook-group'); 
        $webhook = null;
        if(isset($_POST['wp-discord-invite-oauth']) && isset($_POST['webhook'])) {
            $webhook = sanitize_url($_POST['webhook'], array('https'));
        }
        $is_oauth_callback = !empty($webhook);
        ?>

        <!-- Enable Webhook -->
        <div class="wp-discord-field">
          <label class="wp-discord-field-label">
            <?php _e('Enable Webhook Notifications', 'wp-discord-invite'); ?>
            <a href="#" class="wp-discord-help-toggle" onclick="$j('#help-webhook-enable').toggleClass('hidden'); return false;">
              <span class="dashicons dashicons-editor-help"></span>
            </a>
          </label>
          <div class="wp-discord-field-input">
            <label class="wp-discord-toggle">
              <input type="checkbox" name="smr_discord_webhook_enable" value="1"<?php if($is_oauth_callback) {
                echo ' checked="checked"';
              } else { checked(1 == get_option('smr_discord_webhook_enable')); } ?> />
              <span class="wp-discord-toggle-slider"></span>
            </label>
            <span class="description" style="margin-left: 10px;">
              <?php _e('Send a notification to Discord when your invite link is clicked', 'wp-discord-invite'); ?>
            </span>
          </div>
          <div id="help-webhook-enable" class="wp-discord-help-content hidden">
            <p><?php _e('When enabled, each click on your invite link will send a notification to your Discord channel via webhook.', 'wp-discord-invite'); ?></p>
            <p><a href="https://docs.sarveshmrao.in/en/wp-discord-invite#webhook" target="_blank"><?php _e('Learn more about webhooks →', 'wp-discord-invite'); ?></a></p>
          </div>
        </div>

        <!-- Webhook URL -->
        <div class="wp-discord-field">
          <label class="wp-discord-field-label">
            <?php _e('Discord Webhook URL', 'wp-discord-invite'); ?>
            <a href="#" class="wp-discord-help-toggle" onclick="$j('#help-webhook-url').toggleClass('hidden'); return false;">
              <span class="dashicons dashicons-editor-help"></span>
            </a>
          </label>
          <div class="wp-discord-field-input">
            <input type="text" name="smr_discord_webhook_url" value="<?php if($is_oauth_callback) {
               echo esc_attr($webhook);
            } else { echo esc_attr(get_option('smr_discord_webhook_url'));} ?>" placeholder="https://discord.com/api/webhooks/..." style="width: 100%; max-width: 600px;">
          </div>
          <div id="help-webhook-url" class="wp-discord-help-content hidden">
            <p><?php _e('Paste your Discord webhook URL here. You can create one in your Discord server settings under Integrations > Webhooks.', 'wp-discord-invite'); ?></p>
            <p><?php _e('Alternatively, use the "Login with Discord" button below to authenticate and select a channel automatically.', 'wp-discord-invite'); ?></p>
            <p><a href="https://docs.sarveshmrao.in/en/wp-discord-invite#webhook" target="_blank"><?php _e('How to create a webhook →', 'wp-discord-invite'); ?></a></p>
          </div>
        </div>

        <!-- OAuth Login Button -->
        <div class="wp-discord-field" style="margin-top: 20px;">
          <div class="wp-discord-oauth-section">
            <div class="wp-discord-oauth-divider">
              <span><?php _e('OR', 'wp-discord-invite'); ?></span>
            </div>
            <a class="dsc-btn" rel="nofollow" href="https://utils.sarveshmrao.in/wp-discord-invite-oauth/?redirect=<?php echo esc_url(admin_url()); ?>" title="<?php esc_attr_e('Login with Discord', 'wp-discord-invite'); ?>">
              <span class="dsc-btn-icon"></span>
              <span class="dsc-btn-text"><?php _e('Login with Discord', 'wp-discord-invite'); ?></span>
            </a>
            <p class="description" style="margin-top: 10px;">
              <?php _e('Authenticate with Discord to automatically select a webhook channel from your servers.', 'wp-discord-invite'); ?>
            </p>
          </div>
        </div>

        <p class="submit">
          <input type="submit" class="button-primary button-large" id="count_save_changes" value="<?php esc_attr_e('Save Changes', 'wp-discord-invite'); ?>" />
        </p>

        <?php
        if($is_oauth_callback) {
          echo('<body onload="redirFunction()"></body>');
          echo('<script> function redirFunction() {
document.getElementById("count_save_changes").click();
} </script>');
        }
        ?>
      </form>
    </div>
    <div class="wp-discord-card-footer">
      <p>
        <span class="dashicons dashicons-info"></span>
        <?php _e('Webhook notifications are sent instantly when a user clicks your invite link and gets redirected to Discord.', 'wp-discord-invite'); ?>
      </p>
    </div>
  </div>

  <!-- Footer -->
  <div class="wp-discord-footer">
    <p><?php _e('If you enjoy using this plugin, please', 'wp-discord-invite'); ?> <a href="https://wordpress.org/support/plugin/wp-discord-invite/reviews/" target="_blank"><?php _e('leave a review', 'wp-discord-invite'); ?></a>. <?php _e('That would motivate me a lot!', 'wp-discord-invite'); ?></p>
    <p><?php _e('Created with', 'wp-discord-invite'); ?> <span class="dashicons dashicons-heart"></span> <?php _e('by', 'wp-discord-invite'); ?> <a href="https://sarveshmrao.in" target="_blank">Sarvesh M Rao</a></p>
  </div>
</div>
<?php
}
//COUNT PAGE END

?>
