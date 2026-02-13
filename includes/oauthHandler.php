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

/**
 * Check for OAuth callback webhook on count page load
 * Receives webhook URL from middleware via GET parameter
 */
add_action('admin_init', 'smr_discord_check_oauth_callback');

function smr_discord_check_oauth_callback() {
  // Only on the count page
  if (!isset($_GET['page']) || $_GET['page'] !== 'wp-discord-invite-count') {
    return;
  }
  
  // Check if there's an OAuth callback with webhook
  if (!isset($_GET['discord_webhook'])) {
    return;
  }
  
  // Verify user has permission
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.', 'wp-discord-invite'));
  }
  
  // Get the webhook URL
  $webhook = $_GET['discord_webhook'];
  
  // Validate it's a Discord webhook URL
  if (!empty($webhook) && 
      (strpos($webhook, 'https://discord.com/api/webhooks/') === 0 || 
       strpos($webhook, 'https://discordapp.com/api/webhooks/') === 0)) {
    
    // Sanitize the webhook URL
    $webhook = esc_url_raw($webhook);
    
    // Save webhook settings
    update_option('smr_discord_webhook_enable', '1');
    update_option('smr_discord_webhook_url', $webhook);
    
    // Redirect to remove the GET parameter and show success message
    $redirect_url = add_query_arg(
      array(
        'page' => 'wp-discord-invite-count',
        'oauth_success' => '1'
      ),
      admin_url('admin.php')
    );
    
    wp_safe_redirect($redirect_url);
    exit;
  } else {
    // Invalid webhook URL
    add_action('admin_notices', function() {
      ?>
      <div class="notice notice-error is-dismissible">
          <p><?php _e('Invalid Discord webhook URL received. Please try again.', 'wp-discord-invite'); ?></p>
      </div>
      <?php
    });
  }
}

/**
 * Show success message after OAuth
 */
add_action('admin_notices', 'smr_discord_oauth_success_notice');

function smr_discord_oauth_success_notice() {
  if (isset($_GET['oauth_success']) && $_GET['oauth_success'] == '1' && isset($_GET['page']) && $_GET['page'] == 'wp-discord-invite-count') {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e('Discord webhook connected successfully!', 'wp-discord-invite'); ?></p>
    </div>
    <?php
  }
}
