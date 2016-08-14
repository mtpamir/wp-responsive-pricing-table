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

defined( 'ABSPATH' ) or die( 'Keep Quit' );

if(!class_exists('WP_Responsive_Pricing_Table')):
    Class WP_Responsive_Pricing_Table{
        public function __construct() {
            $this->constants();
            $this->includes();
            //$this->hooks();

            do_action( 'wp-responsive-pricing-table', $this );
        }

        public function constants() {
            define( 'WP_RPT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            define( 'WP_RPT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            define( 'WP_RPT_PLUGIN_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
            define( 'WP_RPT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
            define( 'WP_RPT_PLUGIN_FILE', __FILE__ );
        }

        public function includes() {
            //include_once( 'includes/template-functions.php' );
            include_once( 'includes/class-wp-rpt-cpt.php' );
            include_once( 'includes/class-wp-rpt-meta-box.php' );
            include_once( 'includes/short-codes-functions.php' );

        }
/*
        public function hooks() {
            add_action( 'after_setup_theme', array( $this, 'setup_environment' ) );
            add_action( 'init', array( $this, 'init' ), 0 );
            add_action( 'widgets_init', array( $this, 'register_widgets' ) );
        }
*/
    }

    new WP_Responsive_Pricing_Table();
endif;