<?php
/*
Plugin Name: Hostinger Change URL
Description: This plugin <strong>updates all urls in your wordpress website</strong> by replacing old urls with new urls.
Author: Hostinger.com
Author URI: https://www.hostinger.com/
Author Email: info@hostinger.com
Version: 1.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Do not access file directly!
if (!defined('WPINC')) {
    die;
}

function register_management_page()
{
    add_management_page("Change URL", "Change URL", "manage_options", basename(__FILE__), "plugin_management_page");
}

function plugin_management_page()
{
    global $wpdb;

    $siteUrl = $wpdb->get_var("SELECT option_value FROM wp_options where option_name='siteurl'");
    $updated = false;
    if (isset($_POST['newurl']) && $_POST['newurl'] != '') {
        $newUrl = $_POST['newurl'];

        $wpdb->query($wpdb->prepare('UPDATE wp_posts SET post_content = replace(post_content, %s, %s)', $siteUrl, $newUrl));
        $wpdb->query($wpdb->prepare('UPDATE wp_posts SET post_excerpt = replace(post_excerpt, %s, %s)', $siteUrl, $newUrl));
        $wpdb->query($wpdb->prepare("UPDATE wp_posts SET guid = replace(guid, %s, %s)", $siteUrl, $newUrl));
        $wpdb->query($wpdb->prepare("UPDATE wp_links SET link_url = replace(link_url, %s, %s)", $siteUrl, $newUrl));
        $wpdb->query($wpdb->prepare('UPDATE wp_postmeta SET meta_value = replace(meta_value, %s, %s)', $siteUrl, $newUrl));
        $wpdb->query($wpdb->prepare('UPDATE wp_options SET option_value = replace(option_value, %s, %s)', $siteUrl, $newUrl));

        $siteUrl = $wpdb->get_var("SELECT option_value FROM wp_options where option_name='siteurl'");
        $updated = true;
    }
    ?>

    <div class="wrap">
        <?php if ($updated) : ?>
            <div id="message" class="updated notice is-dismissible"><p>Url was changed.</p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
            </div>
        <?php else: ?>
            <div style="color:red; font-weight:700;">
                WE RECOMMEND TO BACKUP YOUR WORDPRESS DATABASE BEFORE URL CHANGE !
            </div>
        <?php endif; ?>


        <h2>Change URL</h2>
        <form method="post" action="tools.php?page=<?php echo basename(__FILE__); ?>">
            <table style="width:100%">
                <tr>
                    <td style="width:100px;">Old url</td>
                    <td><input type="text" name="oldurl" style="width:50%;" value="<?php echo $siteUrl ?>" disabled></td>
                </tr>
                <tr>
                    <td>New url</td>
                    <td><input style="width:50%;" type="text" name="newurl"></td>
                </tr>
                <tr>
                    <td colspan="2"><br><input class="button button-primary" type="submit" value="Change URL"></td>
                </tr>
            </table>
        </form>
    </div>
    <?php
}

add_action('admin_menu', 'register_management_page');
?>
