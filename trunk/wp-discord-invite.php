<?php
/**
 * Plugin Name:       WP Discord Invite
 * Plugin URI:        https://plugins.sarveshmrao.in/wp-discord-invite
 * Description:       Create memorable Discord invite links (yoursite.com/discord) with tracking, webhooks, and social previews
 * Version:           2.6.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sarvesh M Rao
 * Author URI:        https://www.sarveshmrao.in/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-discord-invite
 * Domain Path:       /languages
 */

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

// Plugin activation hook
register_activation_hook(__FILE__, 'smr_discord_activate');

/**
 * Plugin activation callback
 * Sets up default options on first activation
 * 
 * @return void
 */
function smr_discord_activate() {
  // Set default options if they don't exist
  add_option('smr_discord_click_count', '0');
  add_option('smr_discord_click_count_last_reset', 'Never');
  add_option('smr_discord_link_last_click', 'Never');
  add_option('smr_discord_uri', 'discord');
  add_option('smr_discord_invite_link', '');
  add_option('smr_discord_title', 'My Awesome Discord Server');
  add_option('smr_discord_description', 'My server is awesome coz of these');
  add_option('smr_discord_author', 'You have been invited to a server!');
  add_option('smr_discord_image_url', plugin_dir_url(__FILE__) . 'assets/icon-128x128.png');
  add_option('smr_discord_embed_color', '#5865f2');
  add_option('smr_discord_webhook_enable', '0');
  add_option('smr_discord_webhook_url', '');
  
  // Flush rewrite rules
  flush_rewrite_rules();
}

// Plugin deactivation hook
register_deactivation_hook(__FILE__, 'smr_discord_deactivate');

/**
 * Plugin deactivation callback
 * Cleans up rewrite rules
 * 
 * @return void
 */
function smr_discord_deactivate() {
  // Flush rewrite rules on deactivation
  flush_rewrite_rules();
}

// Load plugin text domain for translations
add_action('plugins_loaded', 'smr_discord_load_textdomain');

/**
 * Load plugin text domain for translations
 * 
 * @return void
 */
function smr_discord_load_textdomain() {
  load_plugin_textdomain('wp-discord-invite', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

// Configuring Plugin Row Meta
require_once('includes/pluginRowMeta.php');

// Catching URL defined in settings
require_once('includes/urlCatching.php');

// Inserting color picker for admin menu
require_once('includes/colorPicker.php');

// Registering Admin Menus
require_once('includes/registerMenu.php');

// Registering Settings
require_once('includes/settings.php');

// Settings Config Page
require_once('includes/settingsPage.php');


// Click Count Page
require_once('includes/countPage.php');

// OAuth Handler for Discord webhook integration
require_once('includes/oauthHandler.php');

// Help Page (To be removed in next major release)
// require_once('includes/helpPage.php');

// Important Functions
require_once('includes/utils.php');

?>