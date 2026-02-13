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

add_filter( 'plugin_row_meta', 'smr_discord_row_meta', 10, 4 );

/**
 * Add custom links to plugin row meta
 * 
 * @param array $plugin_meta Array of plugin meta links
 * @param string $plugin_file Plugin file path
 * @param array $plugin_data Plugin data
 * @param string $status Plugin status
 * @return array Modified plugin meta links
 */
function smr_discord_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
 
    if ( strpos( $plugin_file, 'wp-discord-invite.php' ) !== false ) {
        $new_links = array(
                'doc' => '<a href="https://docs.sarveshmrao.in/en/wp-discord-invite?mtm_campaign=WP%20Discord%20Invite&mtm_kwd=plugin-meta" target="_blank">Documentation</a>',
                'support' => '<a href="https://wordpress.org/support/plugin/wp-discord-invite/" target="_blank">Support Forum</a>',
                'changelog' => '<a href="https://wordpress.org/plugins/wp-discord-invite/#developers" target="_blank">Changelog</a>',
                'review' => '<a href="https://wordpress.org/support/plugin/wp-discord-invite/reviews/" target="_blank">Leave a review!</a>',
                'donate' => '<a href="https://buymeacoffee.com/sarveshmrao" target="_blank" style="color: #ff5f5f;">❤️ Donate</a>',
                'github' => '<a href="https://github.com/sarveshmrao/wp-discord-invite" target="_blank">View on GitHub</a>',
                'bugs' => '<a href="https://github.com/sarveshmrao/wp-discord-invite/issues" target="_blank">🐛 Report Bug</a>',
                'translate' => '<a href="https://translate.wordpress.org/projects/wp-plugins/wp-discord-invite/" target="_blank">🌐 Translate</a>'
                );
         
        $plugin_meta = array_merge( $plugin_meta, $new_links );
    }
     
    return $plugin_meta;
}