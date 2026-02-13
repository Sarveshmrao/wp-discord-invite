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

if (get_option("smr_discord_invite_link") == "") {
  wp_die(__('Invite link not set', 'wp-discord-invite'));
}

// Update click counter atomically using WordPress database
global $wpdb;
$option_name = 'smr_discord_click_count';
$wpdb->query(
  $wpdb->prepare(
    "UPDATE {$wpdb->options} 
     SET option_value = option_value + 1 
     WHERE option_name = %s",
    $option_name
  )
);

update_option("smr_discord_link_last_click", current_time("Y-m-d h:i:sa"));

/**
 * Send webhook notification to Discord
 * 
 * @param string $invite The invite URL
 * @param string $invite_link Discord invite link
 * @param int $clicks Number of clicks
 * @param string $color Embed color
 * @param string $webhook Webhook URL
 * @param string $file Icon file URL
 * @return void
 */
function discordmsg($invite, $invite_link, $clicks, $color, $webhook, $file)
{
  $msg = json_decode(
    '{   "content": "New Invite Link Click!", "embeds": [ { "title": "New Invite Link Click", "description": "A new click has been detected in your **WP Discord Invite Link** (' .
      $invite .
      '). \n Having Discord Invite Link ' .
      $invite_link .
      '.\n The link currently has ' .
      $clicks .
      ' clicks.",
                    "color": 65280, "footer": { "text": "This was given by the automatic system of WP Discord Invite Plugin" } } ], "username": "WP Dsc Invite",
                    "avatar_url": "https://i.imgur.com/LzO5Aw5.png" } ',
    true
  );

  if ($webhook != "") {
    $response = wp_remote_post($webhook, [
      "body" => "payload_json=" . urlencode(json_encode($msg)),
    ]);

    if (is_wp_error($response)) {
      $error_message = $response->get_error_message();
      error_log('WP Discord Invite: Webhook failed - ' . $error_message);
    }
  }
}
if (get_option("smr_discord_webhook_enable") == 1) {
  discordmsg(
    get_option("siteurl") . '/' . get_option("smr_discord_uri"),
    "https://discord.gg/" . get_option("smr_discord_invite_link"),
    get_option("smr_discord_click_count"),
    get_option("smr_discord_embed_color"),
    get_option("smr_discord_webhook_url"),
    plugin_dir_url(__FILE__) . "assets/icon-128x128.png"
  );
}

// Build Discord redirect URL
$discord_invite_link = get_option('smr_discord_invite_link');
$redirect_url = 'https://discord.com/invite/' . $discord_invite_link;

// Output HTML with OpenGraph meta tags for rich embeds on Discord/social media
// This MUST be HTML output - wp_redirect() would prevent crawlers from seeing these tags
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_html(get_option("smr_discord_title", "Discord Invite")); ?></title>

<!-- OpenGraph meta tags for rich embeds -->
<meta property="og:type" content="website"/>
<meta property="og:site_name" content="<?php echo esc_attr(get_option("smr_discord_author")); ?>"/>
<meta property="og:title" content="<?php echo esc_attr(get_option("smr_discord_title")); ?>"/>
<meta property="og:description" content="<?php echo esc_attr(get_option("smr_discord_description")); ?>"/>
<meta property="og:image" content="<?php echo esc_url(get_option("smr_discord_image_url")); ?>"/>
<meta name="theme-color" content="<?php echo esc_attr(get_option("smr_discord_embed_color")); ?>"/>
<meta property="og:url" content="<?php echo esc_url(get_option("siteurl") . '/' . get_option("smr_discord_uri")); ?>"/>

<!-- Meta refresh as fallback redirect (works without JavaScript) -->
<meta http-equiv="refresh" content="0; URL=<?php echo esc_url($redirect_url); ?>" />

<!-- Faster JavaScript redirect for users with JS enabled -->
<script type="text/javascript">
  window.location.href = "<?php echo esc_js($redirect_url); ?>";
</script>
</head>
<body>
<noscript>
  <p><?php _e('Redirecting to Discord...', 'wp-discord-invite'); ?></p>
  <p><a href="<?php echo esc_url($redirect_url); ?>"><?php _e('Click here if you are not redirected automatically', 'wp-discord-invite'); ?></a></p>
</noscript>
</body>
</html>