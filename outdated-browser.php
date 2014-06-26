<?php
/*
Plugin Name: Outdated Browser
Plugin URI: http://tareq.wedevs.com
Description: Detects outdated browsers and advises users to upgrade to a new version
Version: 0.1
Author: Tareq Hasan
Author URI: http://tareq.wedevs.com/
License: GPL2
*/

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * WeDevs_Outdated_Browser class
 *
 * @class WeDevs_Outdated_Browser The class that holds the entire WeDevs_Outdated_Browser plugin
 */
class WeDevs_Outdated_Browser {

    /**
     * Constructor for the WeDevs_Outdated_Browser class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @uses add_action()
     */
    public function __construct() {

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );

        // Loads frontend scripts and styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        // print the markup
        add_action( 'wp_footer', array( $this, 'print_markup' ), 99 );
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'outdated-browser', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Enqueue admin scripts
     *
     * Allows plugin assets to be loaded.
     *
     * @uses wp_enqueue_script()
     * @uses wp_enqueue_style
     */
    public function enqueue_scripts() {
        $assets = plugins_url( 'assets/', __FILE__ );

        wp_enqueue_style( 'outdated-styles', $assets . 'css/outdatedBrowser.min.css', false, date( 'Ymd' ) );

        wp_enqueue_script( 'outdated-scripts', $assets . 'js/outdatedBrowser.min.js', array( 'jquery' ), false, true );
    }

    /**
     * Print the required HTML and JS snippets
     *
     * @return void
     */
    function print_markup() {
        ?>
        <div id="outdated">
             <h6><?php _e( 'Your browser is out-of-date!', 'outdated-browser' ); ?></h6>
             <p><?php _e( 'Update your browser to view this website correctly.', 'outdated-browser' ); ?> <a id="btnUpdateBrowser" href="http://outdatedbrowser.com/"><?php _e( 'Update my browser now', 'outdated-browser' ); ?></a></p>
             <p class="last"><a href="#" id="btnCloseUpdateBrowser" title="Close">&times;</a></p>
        </div>

        <script type="text/javascript">
            jQuery(function($) {
                outdatedBrowser({
                    bgColor: '#f25648',
                    color: '#ffffff',
                    lowerThan: 'transform'
                });
            });
        </script>
        <?php
    }

} // WeDevs_Outdated_Browser

new WeDevs_Outdated_Browser();