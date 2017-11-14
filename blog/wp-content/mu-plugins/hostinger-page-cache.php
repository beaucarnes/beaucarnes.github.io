<?php
/*
Plugin Name: Hostinger Page Cache
Description: Static file caching.
Version: 0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Do not access file directly!
if (!defined('WPINC')) {
    die;
}

define('HPC_VERSION', 0.2);

if (!class_exists('Hostinger_Page_Cache')) {
    class Hostinger_Page_Cache
    {
        function __construct()
        {
            $this->hooks();
            $this->cache_dir = WP_CONTENT_DIR . '/hostinger-page-cache';
            $this->cache_exempt = array('wp-admin', '.', 'checkout', 'cart', 'wp-json');
            if (!wp_next_scheduled('hpc_purge')) {
                wp_schedule_event(time() + (HOUR_IN_SECONDS * 2), 'hpc_weekly', 'hpc_purge');
            }
        }

        function hooks()
        {
            if ($this->is_enabled()) {
                add_action('init', array($this, 'start'));
                add_action('shutdown', array($this, 'finish'));

                add_filter('style_loader_src', array($this, 'remove_wp_ver_css_js'), 9999);
                add_filter('script_loader_src', array($this, 'remove_wp_ver_css_js'), 9999);

                add_filter('mod_rewrite_rules', array($this, 'htaccess_contents'));

                add_action('save_post', array($this, 'save_post'));
                add_action('edit_terms', array($this, 'edit_terms'), 10, 2);

                add_action('comment_post', array($this, 'comment'), 10, 2);

                add_action('updated_option', array($this, 'option_handler'), 10, 3);

                add_action('activated_plugin', array($this, 'purge_all'));
                add_action('deactivated_plugin', array($this, 'purge_all'));
                add_action('switch_theme', array($this, 'purge_all'));

                add_action('update_option_mm_coming_soon', array($this, 'purge_all'));

                add_action('hpc_purge', array($this, 'purge_all'));

                add_action('wp_update_nav_menu', array($this, 'purge_all'));

                add_action('admin_init', array($this, 'do_purge_all'));
            }

            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'status_link'));
        }

        function purge_cron($schedules)
        {
            $schedules['hpc_weekly'] = array(
                'interval' => WEEK_IN_SECONDS,
                'display' => esc_html__('Weekly'),
            );
            return $schedules;
        }

        function option_handler($option, $old_value, $new_value)
        {
            if (false !== strpos($option, 'widget') && $old_value !== $new_value) {
                $this->purge_all();
            }
        }

        function comment($comment_id, $comment_approved)
        {
            $comment = get_comment($comment_id);
            if (property_exists($comment, 'comment_post_ID')) {
                $post_url = get_permalink($comment->comment_post_ID);
                $this->purge_single($post_url);
            }
        }

        function save_post($post_id)
        {
            $url = get_permalink($post_id);
            $this->purge_single($url);

            $taxonomies = get_post_taxonomies($post_id);
            foreach ($taxonomies as $taxonomy) {
                $terms = get_the_terms($post_id, $taxonomy);
                if (is_array($terms)) {
                    foreach ($terms as $term) {
                        $term_link = get_term_link($term);
                        $this->purge_single($term_link);
                    }
                }
            }

            if ($post_type_archive = get_post_type_archive_link(get_post_type($post_id))) {
                $this->purge_single($post_type_archive);
            }

            $post_date = (array)json_decode(get_the_date('{"\y":"Y","\m":"m","\d":"d"}', $post_id));
            if (!empty($post_date)) {
                $this->purge_all($this->uri_to_cache(get_year_link($post_date['y'])));
            }
        }

        function edit_terms($term_id, $taxonomy)
        {
            $url = get_term_link($term_id);
            $this->purge_single($url);
        }

        function write($page)
        {
            $base = parse_url(trailingslashit(get_option('home')), PHP_URL_PATH);

            if ($this->is_cachable() && false === strpos($page, 'nonce') && !empty($page)) {
                $this->path = WP_CONTENT_DIR . '/hostinger-page-cache' . str_replace(get_option('home'), '',
                        esc_url($_SERVER['REQUEST_URI']));
                $this->path = str_replace('/hostinger-page-cache' . $base, '/hostinger-page-cache/', $this->path);
                $this->path = str_replace('//', '/', $this->path);

                if (file_exists($this->path . '_index.html') && filemtime($this->path . '_index.html') > time() - HOUR_IN_SECONDS) {
                    return $page;
                }

                if (!is_dir($this->path)) {
                    mkdir($this->path, 0755, true);
                }

                if (false !== strpos($page, '</body>')) {
                    $page = substr_replace($page, "\n<!--Generated by Hostinger Page Cache-->\n",
                        strpos($page, '</body>'), 0);
                }

                file_put_contents($this->path . '_index.html', str_replace(array('http://', 'https://'), '//', $page),
                    LOCK_EX);
            } else {
                $nocache = get_transient('hpc_nocache_pages', array());
                $nocache[] = $_SERVER['REQUEST_URI'];
                delete_transient('hpc_nocache_pages');
                set_transient('hpc_nocache_pages', $nocache, DAY_IN_SECONDS);
            }
            return $page;
        }

        function purge_all($dir = null)
        {
            if (is_null($dir) || 'true' == $dir) {
                $dir = WP_CONTENT_DIR . '/hostinger-page-cache';
            }
            $dir = str_replace('_index.html', '', $dir);
            if (is_dir($dir)) {
                $files = scandir($dir);
                if (is_array($files)) {
                    $files = array_diff($files, array('.', '..'));
                }

                if (is_array($files)) {
                    foreach ($files as $file) {
                        if (is_dir($dir . '/' . $file)) {
                            $this->purge_all($dir . '/' . $file);
                        } else {
                            unlink($dir . '/' . $file);
                        }
                    }
                    rmdir($dir);
                }
            }
        }

        function purge_single($uri)
        {
            $cache_file = $this->uri_to_cache($uri);
            if (file_exists($cache_file)) {
                unlink($cache_file);
            }
            if (file_exists($this->cache_dir . '/_index.html')) {
                unlink($this->cache_dir . '/_index.html');
            }
        }

        function minify($content)
        {
            $content = str_replace("\r", '', $content);
            $content = str_replace("\n", '', $content);
            $content = str_replace("\t", '', $content);
            $content = str_replace('  ', ' ', $content);
            $content = trim($content);
            return $content;
        }

        function uri_to_cache($uri)
        {
            $path = str_replace(get_site_url(), '', $uri);
            return $this->cache_dir . $path . '_index.html';
        }

        function is_cachable()
        {

            $return = true;

            $nocache = get_transient('hpc_nocache_pages', array());

            if (defined('DONOTCACHEPAGE') && DONOTCACHEPAGE == true) {
                $return = false;
            }

            if (is_array($nocache) && in_array($_SERVER['REQUEST_URI'], $nocache)) {
                $return = false;
            }

            if (is_404()) {
                $return = false;
            }

            if (is_admin()) {
                $return = false;
            }

            if (!get_option('permalink_structure')) {
                $return = false;
            }

            if (is_user_logged_in()) {
                $return = false;
            }

            if (isset($_GET) && !empty($_GET)) {
                $return = false;
            }

            if (isset($_POST) && !empty($_POST)) {
                $return = false;
            }

            if (is_feed()) {
                $return = false;
            }

            if (empty($_SERVER['REQUEST_URI'])) {
                $return = false;
            } else {
                $cache_exempt = apply_filters('hpc_exempt_uri_contains', $this->cache_exempt);
                foreach ($cache_exempt as $exclude) {
                    if (false !== strpos($_SERVER['REQUEST_URI'], $exclude)) {
                        $return = false;
                    }
                }
            }

            return apply_filters('hpc_is_cachable', $return);
        }

        function start()
        {
            if ($this->is_cachable()) {
                ob_start(array($this, 'write'));
            }
        }

        function finish()
        {
            if ($this->is_cachable()) {
                if (ob_get_contents()) {
                    ob_end_clean();
                }
            }
        }

        function remove_wp_ver_css_js($src)
        {
            if (strpos($src, 'ver=')) {
                $src = remove_query_arg('ver', $src);
            }
            return $src;
        }

        function htaccess_contents($rules)
        {
            $base = parse_url(trailingslashit(get_option('home')), PHP_URL_PATH);
            $cache_url = $base . str_replace(get_option('home'), '', WP_CONTENT_URL . '/hostinger-page-cache');
            $cache_url = str_replace('//', '/', $cache_url);
            $additions = '<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteBase ' . $base . '
	RewriteRule ^' . $cache_url . '/ - [L]
	RewriteCond %{REQUEST_METHOD} !POST
	RewriteCond %{QUERY_STRING} !.*=.*
	RewriteCond %{HTTP_COOKIE} !(wordpress_test_cookie|comment_author|wp\-postpass|wordpress_logged_in|wptouch_switch_toggle|wp_woocommerce_session_) [NC]
	RewriteCond %{DOCUMENT_ROOT}' . $cache_url . '/$1/_index.html -f
	RewriteRule ^(.*)$ ' . $cache_url . '/$1/_index.html [L]
</IfModule>' . "\n";
            return $additions . $rules;
        }

        function is_enabled()
        {

            $plugins = implode(' ', get_option('active_plugins'));
            if (strpos($plugins, 'cach') || strpos($plugins, 'wp-rocket')) {
                return false;
            }

            $cache_settings = get_option('mm_cache_settings');
            if (isset($_GET['hpc_toggle'])) {
                $valid_values = array('enabled', 'disabled');
                if (in_array($_GET['hpc_toggle'], $valid_values)) {
                    $cache_settings['page'] = $_GET['hpc_toggle'];
                    update_option('mm_cache_settings', $cache_settings);
                    header('Location: ' . admin_url('plugins.php?plugin_status=mustuse'));
                }
            }
            if (isset($cache_settings['page']) && 'disabled' == $cache_settings['page']) {
                return false;
            } else {
                return true;
            }
        }

        function status_link($links)
        {
            if ($this->is_enabled()) {
                $links[] = '<a href="' . add_query_arg(array('hpc_toggle' => 'disabled')) . '">Disable</a>';
                $links[] = '<a href="' . add_query_arg(array('hpc_purge_all' => 'true')) . '">Purge Cache</a>';
            } else {
                $links[] = '<a href="' . add_query_arg(array('hpc_toggle' => 'enabled')) . '">Enable</a>';
            }
            return $links;
        }

        function do_purge_all()
        {
            if (isset($_GET['hpc_purge_all'])) {
                $this->purge_all();
                header('Location: ' . admin_url('plugins.php?plugin_status=mustuse'));
            }
        }
    }

    $hpc = new Hostinger_Page_Cache;
}