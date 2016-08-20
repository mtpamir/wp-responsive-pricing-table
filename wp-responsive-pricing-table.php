<?php
/**
 * Plugin Name:  Responsive Pricing Table
 * Plugin URI:   https://wordpress.org/plugins/wp-responsive-pricing-table/
 * Description:  WP Responsive Pricing Table for WordPress
 * Version:      1.0.0
 * Author:       MT Pamir
 * Author URI:   https://mtpamir.com/
 * License:      GPLv2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Text Domain:  wp-responsive-pricing-table
 * Domain Path:  /languages/
 */

defined('ABSPATH') or die('Keep Quit');

if (!class_exists('WP_Responsive_Pricing_Table')):
    Class WP_Responsive_Pricing_Table
    {
        public function __construct()
        {
            $this->constants();
            $this->includes();
            $this->hooks();
            do_action('wp-responsive-pricing-table', $this);
        }

        public function constants()
        {
            define('WP_RPT_PLUGIN_URL', plugin_dir_url(__FILE__));
            define('WP_RPT_PLUGIN_DIR', plugin_dir_path(__FILE__));
            define('WP_RPT_PLUGIN_DIRNAME', dirname(plugin_basename(__FILE__)));
            define('WP_RPT_PLUGIN_BASENAME', plugin_basename(__FILE__));
            define('WP_RPT_PLUGIN_FILE', __FILE__);
        }

        public function includes()
        {
            include_once('includes/class-wp-rpt-cpt.php');
            include_once('includes/class-wp-rpt-meta-box.php');
            include_once('includes/short-codes-functions.php');

        }

        public function hooks()
        {
            add_action('wp_enqueue_scripts', array($this, 'wp_rpt_scripts'));
        }

        function wp_rpt_scripts()
        {
            wp_enqueue_style('wp_rpt_grid', plugins_url('/assets/css/grid.css', __FILE__), array(), '20160816');
            wp_enqueue_style('wp_rpt_style', plugins_url('/assets/css/style.css', __FILE__), array(), '20160816');
        }
    }

    new WP_Responsive_Pricing_Table();
endif;