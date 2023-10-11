<?php
/**
 * Plugin Name:       WP Discord Invite
 * Plugin URI:        https://plugins.sarveshmrao.in/wp-discord-invite
 * Description:       Easily add vanity URL in your WP Site
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sarvesh M Rao
 * Author URI:        https://www.sarveshmrao.in/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */


if ( ! defined( 'ABSPATH' ) ) exit;

register_activation_hook(__FILE__, 'smr_discord_activate'); 
function smr_discord_activate () {
  create_custom_page_for_smr_discord('discord');
}

function create_custom_page_for_smr_discord($page_name) {
  $pageExists = false;
  $pages = get_pages();     
  foreach ($pages as $page) { 
    if ($page->post_name == $page_name) {
      $pageExists = true;
      break;
    }
  }
  if (!$pageExists) {
    wp_insert_post ([
        'post_type' =>'page',
	'post_title' => '<<Don\'t Delete>> WP Discord Invite',        
        'post_name' => $page_name,
        'post_status' => 'publish',
    ]);
  }
}
// End Plugin Activation


//Start Catching URL
add_filter( 'page_template', 'catch_smr_discord_path' );
function catch_smr_discord_path( $page_template ) {
    if ( is_page( 'discord' ) ) {
        $page_template = __DIR__.'/discord.php';
    }
    return $page_template;
}


add_action( 'admin_enqueue_scripts', 'smr_discord_enqueue_color_picker' );
function smr_discord_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}


// create custom plugin settings menu
add_action('admin_menu', 'smr_discord_create_menu');

function smr_discord_create_menu() {

	//create new top-level menu
	
add_menu_page('WP Discord Invite', 'WP Discord Invite', 'administrator', 'wp-discord-invite', 'smr_discord_settings_page','dashicons-admin-links'); //plugin_dir_url( __FILE__ ) . 'assets/discord.svg'
	

add_submenu_page( 'wp-discord-invite', 'Click Count', 'Click Count', 'administrator' , 'wp-discord-invite-count', 'smr_discord_count_page');
	
add_submenu_page( 'wp-discord-invite', 'Help', 'Help', 'administrator' , 'wp-discord-invite-help', 'smr_discord_help_page');
	//call register settings function
	
add_action( 'admin_init', 'smr_discord_settings' );

}


function smr_discord_settings() {
	//register our settings
	register_setting( 'smr-discord-settings-group', 'smr_discord_invite_link' );
	register_setting( 'smr-discord-settings-group', 'smr_discord_title' );
	register_setting( 'smr-discord-settings-group', 'smr_discord_description' );
	register_setting( 'smr-discord-settings-group', 'smr_discord_image_url' );
	register_setting( 'smr-discord-settings-group', 'smr_discord_embed_color' );
	register_setting( 'smr-discord-settings-group', 'smr_discord_author' );
	register_setting( 'smr-discord-count-group', 'smr_discord_click_count' );
	register_setting( 'smr-discord-count-group', 'smr_discord_click_count_last_reset' );
	register_setting( 'smr-discord-count-group', 'smr_discord_link_last_click' );
	register_setting( 'smr-discord-webhook-group', 'smr_discord_webhook_enable' );
	register_setting( 'smr-discord-webhook-group', 'smr_discord_webhook_url' );

	add_option( 'smr_discord_click_count', '0' );
	add_option( 'smr_discord_click_count_last_reset', 'Never' );
	add_option( 'smr_discord_link_last_click', 'Never' );
}


function smr_discord_settings_page() {
?>
<div class="wrap">
<img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/icon-128x128.png'?>"></img>
<h2>WP Discord Invite</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'smr-discord-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Invite Link <a href="<?php echo admin_url('admin.php?page=discord-invite-help'); ?>">(HELP)</a></th>
        <td><p>https://discord.gg/<input type="text" name="smr_discord_invite_link" value="<?php echo get_option('smr_discord_invite_link', 'https://discord.gg/'); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Title <a href="<?php echo admin_url('admin.php?page=discord-invite-help'); ?>">(HELP)</a></th>
        <td><input type="text" name="smr_discord_title" value="<?php echo get_option('smr_discord_title', 'My Awesome Discord Server'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Description <a href="<?php echo admin_url('admin.php?page=discord-invite-help'); ?>">(HELP)</a></th>
        <td><input type="text" name="smr_discord_description" value="<?php echo get_option('smr_discord_description'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Author <a href="<?php echo admin_url('admin.php?page=discord-invite-help'); ?>">(HELP)</a></th>
        <td><input type="text" name="smr_discord_author" value="<?php echo get_option('smr_discord_author'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Image URL <a href="<?php echo admin_url('admin.php?page=discord-invite-help'); ?>">(HELP)</a></th>
        <td><input type="text" name="smr_discord_image_url" value="<?php echo get_option('smr_discord_image_url'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Embed color <a href="<?php echo admin_url('admin.php?page=discord-invite-help'); ?>">(HELP)</a></th>
        <td><input type="text" name="smr_discord_embed_color" value="<?php echo get_option('smr_discord_embed_color'); ?>" class="smr-discord-embed-color-picker" /></td>
        </tr>

	<p>You can visit <a href="<?php echo get_option('siteurl'); ?>/discord"><?php echo get_option('siteurl'); ?>/discord</a>. Don't use '/' at the end if you want to display the author.</p>
	<p>Please note that Discord Caches the URL for approx. 2 hours so changes won't get reflected immediately.(<?php echo get_option('smr_discord_click_count'); ?>)</p>
	</table>


    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
<?php wp_enqueue_style('CssForEmbed', plugin_dir_url( __FILE__ ) . 'assets/styles.css')?>

<?php //EMBED PREVIEW START ?>
	<div><h2>Embed Preview</h2><p>(Click save changes for changes to get previewed)</p></div>
	<div class="embed-wrapper mb-2" style="max-width:200px;margin-top:50px">
	<div class="embed-color-pill" id="embedPreviewPlace" style="background-color:<?php echo get_option('smr_discord_embed_color'); ?>"></div>
	<div class="embed embed-rich bg-none" style="background-color:#2C2F33;border-color:#16171a">
	<div class="embed-content" style="padding:5px;">
	<div class="embed-content-inner">
	<div class="_author">
	<a class="embed-author-name"><span style="color:white;font-size:0.8em"><span id="embedSayingPlace"><?php echo get_option('smr_discord_author'); ?></span></span></a>
	</div>
	<div class="_title"><a class="embed-title"><span id="embedTitlePlace"></span><?php echo get_option('smr_discord_title'); ?></a></div>
	<div class="embed-description" style="color:#797a7a;width:300px;"><p><span id="embedInvitedByPlace" style="overflow-wrap: break-word;"><?php echo get_option('smr_discord_description'); ?></span></p>
	</div>
	</div>
	<img id="embedImage" src="<?php echo get_option('smr_discord_image_url'); ?>" role="presentation" class="embed-rich-thumb" style="max-width: 80px; max-height: 80px;">
	</div>
	</div>
	</div>
<?php //EMBED PREVIEW END ?>

</form>

<div><p>Created with <span class="dashicons dashicons-heart"></span> by <a href="https://sarveshmrao.in">Sarvesh M Rao</a>.</p></div>
</div>
<?php 
}
//MAIN PAGE END


//COUNT PAGE START
function smr_discord_count_page() {
?>
<div class="wrap">
<img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/icon-128x128.png'?>"></img>
<h2>WP Discord Invite Link Click Count</h2>
<table class="form-table">


        <tr valign="top">
        <th scope="row">Link: </th>
        <td><p><?php echo get_option('siteurl'). '/discord' ?></p></td>
        </tr>

        <tr valign="top">
        <th scope="row">Click Count</th>
        <td><p><?php echo get_option('smr_discord_click_count') ?></p></td>
        </tr>
        
	<tr valign="top">
        <th scope="row">Last Click</th>
        <td><p><?php echo time_elapsed_string(get_option('smr_discord_link_last_click')).' ('.get_option('smr_discord_link_last_click').')' ?></p></td>
        </tr>
        <tr valign="top">
        <th scope="row">Last Reset</th>
        <td><p><?php echo time_elapsed_string(get_option('smr_discord_click_count_last_reset')).' ('.get_option('smr_discord_click_count_last_reset').')' ?></p></td>
        </tr>
    </table>
<div>
<form method="post" action="options.php">
    <?php settings_fields( 'smr-discord-count-group' ); ?>
<input type="hidden" name="smr_discord_click_count" value="0" />
<input type="hidden" name="smr_discord_click_count_last_reset" value="<?php echo current_time('Y-m-d h:i:sa'); ?>" />

    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Reset Click Count (Irreversible)') ?>" />
    </p>
</form>
</div>

<form method="post" action="options.php">
    <?php settings_fields( 'smr-discord-webhook-group' ); ?>
<h2>WP Discord Invite Link Click Webhook</h2>
<p>Sends a webhook to Discord when the invite link is clicked</p>
<table class="form-table">


        <tr valign="top">
        <th scope="row">Enable Webhook </th>
        <td><input type="checkbox" name="smr_discord_webhook_enable" value="1"<?php checked( 1 == get_option('smr_discord_webhook_enable') ); ?> /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Discord Webhook URL <a href="<?php echo admin_url('admin.php?page=discord-invite-help'); ?>">(HELP)</a></th>
        <td><input type="text" name="smr_discord_webhook_url" value="<?php echo get_option('smr_discord_webhook_url'); ?>" /></td>
        </tr>

</table>
<p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>




<div><p>Created with <span class="dashicons dashicons-heart"></span> by <a href="https://sarveshmrao.in">Sarvesh M Rao</a>.</p></div>
</div>
<?php
 } 
//COUNT PAGE END


//HELP PAGE START
function smr_discord_help_page() {
?>
<div class="wrap">
<img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/icon-128x128.png'?>"></img>
<h2>WP Discord Invite Help Page</h2>
<table class="form-table">


        <tr valign="top">
        <th scope="row">Invite Link</th>
        <td><p>A permenant invite link to your server.</p></td>
        </tr>

        <tr valign="top">
        <th scope="row">Title</th>
        <td><p>Title will be displayed above description and below author.</p></td>
        </tr>

        <tr valign="top">
        <th scope="row">Description</th>
        <td><p>Description will be displayed below title.</p></td>
        </tr>

        <tr valign="top">
        <th scope="row">Author</th>
        <td><p>Author will be displayed above the title.</p></td>
        </tr>

        <tr valign="top">
        <th scope="row">Image URL</th>
        <td><p>It's the URL of the image to be displayed at the right end of the embed.</p></td>
        </tr>

        <tr valign="top">
        <th scope="row">Embed color</th>
        <td><p>Hex code of the color in the left side of the embed.</p></td>
        </tr>
	<tr valign="top">
	</tr>
    </table>

<div><h1>Disclaimer</h1><p>This plugin or this plugin's developer does not have any kind of affiliation with <a href="https://discord.com">Discord Inc.</a><br/>The word Discord and it's respective logo's are registered trademarks of <a href="https://discord.com">Discord Inc.</a>
<div><p>Created with <span class="dashicons dashicons-heart"></span> by <a href="https://sarveshmrao.in">Sarvesh M Rao</a>.</p></div>
</div>
<?php
 } 
//HELP PAGE END

//SOME IMPORTANT FUNCTIONS

function time_elapsed_string($datetime, $full = false) {
if($datetime == "Never"){
 return $datetime;
}
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}








?>