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

function smr_discord_settings()
{
  //register our settings
  register_setting("smr-discord-settings-group", "smr_discord_invite_link");
  register_setting("smr-discord-settings-group", "smr_discord_title");
  register_setting("smr-discord-settings-group", "smr_discord_description");
  register_setting("smr-discord-settings-group", "smr_discord_image_url");
  register_setting("smr-discord-settings-group", "smr_discord_embed_color");
  register_setting("smr-discord-settings-group", "smr_discord_author");
  register_setting("smr-discord-settings-group", "smr_discord_uri");

  register_setting("smr-discord-count-group", "smr_discord_click_count");
  register_setting(
    "smr-discord-count-group",
    "smr_discord_click_count_last_reset"
  );
  register_setting("smr-discord-count-group", "smr_discord_link_last_click");
  register_setting("smr-discord-webhook-group", "smr_discord_webhook_enable");
  register_setting("smr-discord-webhook-group", "smr_discord_webhook_url");

  add_option("smr_discord_click_count", "0");
  add_option("smr_discord_click_count_last_reset", "Never");
  add_option("smr_discord_link_last_click", "Never");
  add_option("smr_discord_uri", "discord");
}


?>