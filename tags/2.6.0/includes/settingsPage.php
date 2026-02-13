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
 * Display the main settings page
 * 
 * @return void
 */
function smr_discord_settings_page()
{
  // Enqueue admin styles
  wp_enqueue_style(
    'wp-discord-admin-styles',
    plugin_dir_url(__FILE__) . './../assets/admin-styles.css',
    array(),
    ' 2.6.0'
  );
  wp_enqueue_style(
    'wp-discord-embed-styles',
    plugin_dir_url(__FILE__) . './../assets/styles.css',
    array(),
    '2.6.0'
  );
  
  // Enqueue WordPress media uploader
  wp_enqueue_media();
  ?>
<div class="wrap wp-discord-wrap">
  <!-- Header -->
  <div class="wp-discord-header">
    <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . './../assets/icon-128x128.png'); ?>" alt="<?php esc_attr_e('WP Discord Invite', 'wp-discord-invite'); ?>">
    <div class="wp-discord-header-content">
      <h1><?php _e('WP Discord Invite Settings', 'wp-discord-invite'); ?></h1>
      <p><?php _e('Configure your Discord server invite link and embed appearance', 'wp-discord-invite'); ?></p>
    </div>
  </div>

  <form method="post" action="options.php">
    <?php settings_fields('smr-discord-settings-group'); ?>
    <script type="text/javascript">var $j = jQuery.noConflict();</script>

    <!-- Discord Configuration Card -->
    <div class="wp-discord-card">
      <div class="wp-discord-card-header">
        <h2><span class="dashicons dashicons-admin-links"></span><?php _e('Discord Configuration', 'wp-discord-invite'); ?></h2>
      </div>
      <div class="wp-discord-card-body">
        
        <!-- Invite Link -->
        <div class="wp-discord-field">
          <label class="wp-discord-field-label">
            <?php _e('Discord Invite Link', 'wp-discord-invite'); ?> <span class="required">*</span>
            <a href="#" class="wp-discord-help-toggle" onclick="$j('#help-invite-link').toggleClass('hidden'); return false;">
              <span class="dashicons dashicons-editor-help"></span>
            </a>
          </label>
          <div class="wp-discord-field-input">
            <span class="input-prefix">https://discord.gg/</span><input type="text" name="smr_discord_invite_link" value="<?php echo esc_attr(get_option('smr_discord_invite_link', 'abCxYz')); ?>" placeholder="abCxYz" required>
          </div>
          <div id="help-invite-link" class="wp-discord-help-content hidden">
            <p><?php _e('Enter your permanent Discord invite code (the part after discord.gg/). You can create one in your Discord server settings.', 'wp-discord-invite'); ?></p>
            <p><a href="https://docs.sarveshmrao.in/en/wp-discord-invite?mtm_campaign=WP%20Discord%20Invite&mtm_kwd=settings-page" target="_blank"><?php _e('Learn how to create a permanent invite →', 'wp-discord-invite'); ?></a></p>
          </div>
        </div>

        <!-- Vanity URL -->
        <div class="wp-discord-field">
          <label class="wp-discord-field-label">
            <?php _e('Vanity URL Path', 'wp-discord-invite'); ?> <span class="required">*</span>
            <a href="#" class="wp-discord-help-toggle" onclick="$j('#help-vanity-url').toggleClass('hidden'); return false;">
              <span class="dashicons dashicons-editor-help"></span>
            </a>
          </label>
          <div class="wp-discord-field-input">
            <span class="input-prefix"><?php echo esc_html(get_option('siteurl')); ?>/</span><input type="text" name="smr_discord_uri" value="<?php echo esc_attr(get_option('smr_discord_uri')); ?>" placeholder="discord" required>
          </div>
          <div id="help-vanity-url" class="wp-discord-help-content hidden">
            <p><?php _e('Choose a short, memorable path for your Discord invite (e.g., "discord", "community", or "support"). Don\'t include the forward slash.', 'wp-discord-invite'); ?></p>
            <p><strong><?php _e('Your invite URL:', 'wp-discord-invite'); ?></strong> <code><?php echo esc_html(get_option('siteurl') . '/' . get_option('smr_discord_uri')); ?></code></p>
          </div>
        </div>

      </div>
    </div>

    <!-- Embed Appearance Card -->
    <div class="wp-discord-card">
      <div class="wp-discord-card-header">
        <h2><span class="dashicons dashicons-admin-appearance"></span><?php _e('Embed Appearance', 'wp-discord-invite'); ?></h2>
      </div>
      <div class="wp-discord-card-body">
        <p class="description"><?php _e('Customize how your invite link appears when shared on Discord, Twitter, Facebook, etc.', 'wp-discord-invite'); ?></p>

        <!-- Author -->
        <div class="wp-discord-field">
          <label class="wp-discord-field-label">
            <?php _e('Author / Invitation Text', 'wp-discord-invite'); ?>
            <a href="#" class="wp-discord-help-toggle" onclick="$j('#help-author').toggleClass('hidden'); return false;">
              <span class="dashicons dashicons-editor-help"></span>
            </a>
          </label>
          <div class="wp-discord-field-input">
            <input type="text" name="smr_discord_author" value="<?php echo esc_attr(get_option('smr_discord_author', 'You have been invited to a server!')); ?>" placeholder="<?php esc_attr_e('You have been invited to a server!', 'wp-discord-invite'); ?>">
          </div>
          <div id="help-author" class="wp-discord-help-content hidden">
            <p><?php _e('This text appears at the top of the embed card as the author/invitation message.', 'wp-discord-invite'); ?></p>
          </div>
        </div>

        <!-- Title -->
        <div class="wp-discord-field">
          <label class="wp-discord-field-label">
            <?php _e('Server Name / Title', 'wp-discord-invite'); ?>
            <a href="#" class="wp-discord-help-toggle" onclick="$j('#help-title').toggleClass('hidden'); return false;">
              <span class="dashicons dashicons-editor-help"></span>
            </a>
          </label>
          <div class="wp-discord-field-input">
            <input type="text" name="smr_discord_title" value="<?php echo esc_attr(get_option('smr_discord_title', 'My Awesome Discord Server')); ?>" placeholder="<?php esc_attr_e('My Awesome Discord Server', 'wp-discord-invite'); ?>">
          </div>
          <div id="help-title" class="wp-discord-help-content hidden">
            <p><?php _e('The main title/name of your Discord server that appears in the embed card.', 'wp-discord-invite'); ?></p>
          </div>
        </div>

        <!-- Description -->
        <div class="wp-discord-field">
          <label class="wp-discord-field-label">
            <?php _e('Server Description', 'wp-discord-invite'); ?>
            <a href="#" class="wp-discord-help-toggle" onclick="$j('#help-description').toggleClass('hidden'); return false;">
              <span class="dashicons dashicons-editor-help"></span>
            </a>
          </label>
          <div class="wp-discord-field-input">
            <input type="text" name="smr_discord_description" value="<?php echo esc_attr(get_option('smr_discord_description', 'My server is awesome coz of these')); ?>" placeholder="<?php esc_attr_e('Join our community!', 'wp-discord-invite'); ?>">
          </div>
          <div id="help-description" class="wp-discord-help-content hidden">
            <p><?php _e('A short description of your Discord server that appears below the title.', 'wp-discord-invite'); ?></p>
          </div>
        </div>

        <!-- Image URL -->
        <div class="wp-discord-field">
          <label class="wp-discord-field-label">
            <?php _e('Server Icon / Thumbnail', 'wp-discord-invite'); ?>
            <a href="#" class="wp-discord-help-toggle" onclick="$j('#help-image').toggleClass('hidden'); return false;">
              <span class="dashicons dashicons-editor-help"></span>
            </a>
          </label>
          <div class="wp-discord-field-input">
            <div class="wp-discord-media-upload">
              <?php $image_url = get_option('smr_discord_image_url', plugin_dir_url(__FILE__) . './../assets/icon-128x128.png'); ?>
              <div class="wp-discord-image-preview">
                <img id="smr_discord_image_preview" src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('Server icon preview', 'wp-discord-invite'); ?>">
              </div>
              <input type="hidden" id="smr_discord_image_url" name="smr_discord_image_url" value="<?php echo esc_url($image_url); ?>">
              <div class="wp-discord-media-buttons">
                <button type="button" class="button button-secondary" id="smr_discord_upload_image_button">
                  <span class="dashicons dashicons-images-alt2"></span>
                  <?php _e('Choose Image', 'wp-discord-invite'); ?>
                </button>
                <button type="button" class="button button-secondary" id="smr_discord_remove_image_button">
                  <span class="dashicons dashicons-no"></span>
                  <?php _e('Remove', 'wp-discord-invite'); ?>
                </button>
              </div>
            </div>
          </div>
          <div id="help-image" class="wp-discord-help-content hidden">
            <p><?php _e('The image/thumbnail that appears on the right side of the embed card. Upload your server icon or logo from your WordPress media library.', 'wp-discord-invite'); ?></p>
          </div>
        </div>
        
        <script type="text/javascript">
        jQuery(document).ready(function($) {
          var mediaUploader;
          
          // Upload button click
          $('#smr_discord_upload_image_button').on('click', function(e) {
            e.preventDefault();
            
            // If the uploader object has already been created, reopen the dialog
            if (mediaUploader) {
              mediaUploader.open();
              return;
            }
            
            // Create the media uploader
            mediaUploader = wp.media({
              title: '<?php _e('Choose Server Icon', 'wp-discord-invite'); ?>',
              button: {
                text: '<?php _e('Use this image', 'wp-discord-invite'); ?>'
              },
              multiple: false,
              library: {
                type: 'image'
              }
            });
            
            // When an image is selected, run a callback
            mediaUploader.on('select', function() {
              var attachment = mediaUploader.state().get('selection').first().toJSON();
              $('#smr_discord_image_url').val(attachment.url);
              $('#smr_discord_image_preview').attr('src', attachment.url);
            });
            
            // Open the uploader dialog
            mediaUploader.open();
          });
          
          // Remove button click
          $('#smr_discord_remove_image_button').on('click', function(e) {
            e.preventDefault();
            var defaultImage = '<?php echo esc_js(plugin_dir_url(__FILE__) . './../assets/icon-128x128.png'); ?>';
            $('#smr_discord_image_url').val(defaultImage);
            $('#smr_discord_image_preview').attr('src', defaultImage);
          });
        });
        </script>

        <!-- Embed Color -->
        <div class="wp-discord-field">
          <label class="wp-discord-field-label">
            <?php _e('Embed Accent Color', 'wp-discord-invite'); ?>
            <a href="#" class="wp-discord-help-toggle" onclick="$j('#help-color').toggleClass('hidden'); return false;">
              <span class="dashicons dashicons-editor-help"></span>
            </a>
          </label>
          <div class="wp-discord-field-input">
            <input type="text" name="smr_discord_embed_color" value="<?php echo esc_attr(get_option('smr_discord_embed_color', '#5865f2')); ?>" class="smr-discord-embed-color-picker">
          </div>
          <div id="help-color" class="wp-discord-help-content hidden">
            <p><?php _e('The color of the vertical bar on the left side of the embed card. Choose a color that matches your brand.', 'wp-discord-invite'); ?></p>
          </div>
        </div>

      </div>
      <div class="wp-discord-card-footer">
        <p class="description">
          <span class="dashicons dashicons-info"></span>
          <?php _e('Note: Discord caches embed previews for approximately 2 hours. Changes may not appear immediately.', 'wp-discord-invite'); ?>
        </p>
      </div>
    </div>

    <!-- Live Preview Card -->
    <div class="wp-discord-card">
      <div class="wp-discord-card-header">
        <h2><span class="dashicons dashicons-visibility"></span><?php _e('Live Preview', 'wp-discord-invite'); ?></h2>
      </div>
      <div class="wp-discord-card-body">
        <p class="description" style="margin-bottom: 15px;"><?php _e('Click "Save Changes" below to see your embed preview update.', 'wp-discord-invite'); ?></p>
        
        <div class="wp-discord-preview">
          <div class="wp-discord-preview-label"><?php _e('HOW IT LOOKS IN DISCORD', 'wp-discord-invite'); ?></div>
          <div class="embed-wrapper">
            <div class="embed-color-pill" style="background-color:<?php echo esc_attr(get_option('smr_discord_embed_color', '#5865f2')); ?>"></div>
            <div class="embed-rich">
              <div class="embed-content" style="display: flex; align-items: flex-start;">
                <div style="flex: 1;">
                  <div class="_author">
                    <span class="embed-author-name"><?php echo esc_html(get_option('smr_discord_author', 'You have been invited to a server!')); ?></span>
                  </div>
                  <div class="_title">
                    <a class="embed-title"><?php echo esc_html(get_option('smr_discord_title', 'My Awesome Discord Server')); ?></a>
                  </div>
                  <div class="embed-description">
                    <p><?php echo esc_html(get_option('smr_discord_description', 'My server is awesome coz of these')); ?></p>
                  </div>
                </div>
                <img src="<?php echo esc_url(get_option('smr_discord_image_url', plugin_dir_url(__FILE__) . './../assets/icon-128x128.png')); ?>" class="embed-rich-thumb" style="max-width: 80px; max-height: 80px;" alt="<?php esc_attr_e('Server icon', 'wp-discord-invite'); ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Save Button -->
    <p class="submit">
      <input type="submit" class="button-primary button-large" value="<?php esc_attr_e('Save Changes', 'wp-discord-invite'); ?>">
    </p>
  </form>

  <!-- Footer -->
  <div class="wp-discord-footer">
    <p><?php _e('If you enjoy using this plugin, please', 'wp-discord-invite'); ?> <a href="https://wordpress.org/support/plugin/wp-discord-invite/reviews/" target="_blank"><?php _e('leave a review', 'wp-discord-invite'); ?></a>. <?php _e('That would motivate me a lot!', 'wp-discord-invite'); ?></p>
    <p><?php _e('Created with', 'wp-discord-invite'); ?> <span class="dashicons dashicons-heart"></span> <?php _e('by', 'wp-discord-invite'); ?> <a href="https://sarveshmrao.in" target="_blank">Sarvesh M Rao</a></p>
  </div>
</div>
<?php
}
//MAIN PAGE END

?>
