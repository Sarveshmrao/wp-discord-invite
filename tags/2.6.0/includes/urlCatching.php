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

//Start Catching URLS
add_action("parse_request", "smr_discord_url_handler");

/**
 * Handle custom Discord URL routing
 * 
 * @param object $wp WordPress environment object
 * @return void
 */
function smr_discord_url_handler($wp)
{
  // Debug logging
  error_log("========== WP Discord Invite Debug ==========");
  error_log("PHP REQUEST_URI: " . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'NOT SET'));
  error_log("WP request: " . (isset($wp->request) ? $wp->request : 'NOT SET'));
  error_log("WP query_string: " . (isset($wp->query_string) ? $wp->query_string : 'NOT SET'));
  error_log("WP matched_rule: " . (isset($wp->matched_rule) ? $wp->matched_rule : 'NOT SET'));
  
  $uri = get_option("smr_discord_uri", "discord");
  error_log("URI from database: " . $uri);
  
  // Use preg_quote to prevent regex injection
  // Match the URI anywhere in the request (like original behavior)
  $regex = "/" . preg_quote($uri, '/') . "/";
  error_log("Regex pattern: " . $regex);
  
  if (preg_match($regex, $wp->request, $matches)) {
    error_log("MATCH FOUND! Including discord.php");
    error_log("Matches: " . print_r($matches, true));
    include_once plugin_dir_path(__FILE__) . "discord.php";
    exit();
  } else {
    error_log("NO MATCH - request was: '" . $wp->request . "'");
  }
  error_log("========== End Debug ==========");
}

?>