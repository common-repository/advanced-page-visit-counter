<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pagevisitcounter.com
 * @since             3.0.0
 * @package           Advanced_Visit_Counter
 *
 * @wordpress-plugin
 * Plugin Name: Advanced Page Visit Counter
 * Plugin URI:        https://pagevisitcounter.com
 * Description:       This plugin will count the total visits of your website or ecommerce store.
 * Version:           3.0.9
 * Author:            Page Visit Counter
 * Author URI:        https://pagevisitcounter.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       apvc
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( function_exists( 'apvc_fs' ) ) {
    apvc_fs()->set_basename( false, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    if ( !function_exists( 'apvc_fs' ) ) {
        
        if ( !function_exists( 'apvc_fs' ) ) {
            // Create a helper function for easy SDK access.
            function apvc_fs()
            {
                global  $apvc_fs ;
                
                if ( !isset( $apvc_fs ) ) {
                    // Include Freemius SDK.
                    require_once dirname( __FILE__ ) . '/includes/freemius/start.php';
                    $apvc_fs = fs_dynamic_init( array(
                        'id'             => '5937',
                        'slug'           => 'advanced-page-visit-counter',
                        'type'           => 'plugin',
                        'public_key'     => 'pk_6ffe7478cb9ec6a6bfcf3496b571b',
                        'is_premium'     => false,
                        'premium_suffix' => 'Premium',
                        'has_addons'     => false,
                        'has_paid_plans' => true,
                        'menu'           => array(
                        'slug'       => 'apvc-dashboard-page',
                        'first-path' => 'admin.php?page=apvc-dashboard-page',
                        'support'    => false,
                        'network'    => true,
                    ),
                        'is_live'        => true,
                    ) );
                }
                
                return $apvc_fs;
            }
            
            // Init Freemius.
            apvc_fs();
            // Signal that SDK was initiated.
            do_action( 'apvc_fs_loaded' );
        }
    
    }
    error_reporting( 0 );
    /**
     * Currently plugin version.
     * Start at version 3.0.1 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-advanced-page-visit-counter-activator.php
     */
    function activate_advanced_visit_counter()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-page-visit-counter-activator.php';
        Advanced_Visit_Counter_Activator::activate();
    }
    
    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-advanced-page-visit-counter-deactivator.php
     */
    function deactivate_advanced_visit_counter()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-page-visit-counter-deactivator.php';
        Advanced_Visit_Counter_Deactivator::deactivate();
    }
    
    register_activation_hook( __FILE__, 'activate_advanced_visit_counter' );
    register_deactivation_hook( __FILE__, 'deactivate_advanced_visit_counter' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-page-visit-counter.php';
    require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-page-visit-counter-widget.php';
    require plugin_dir_path( __FILE__ ) . 'admin/partials/file-advanced-page-visit-counter-metaboxes.php';
    define( 'ADVANCED_PAGE_VISIT_COUNTER', '3.0.9' );
    define( 'APVC_DATA_TABLE', $wpdb->prefix . "avc_page_visit_history" );
    define( 'SECONDS_PER_DAY', 86400 );
    define( 'HOURLY_REFRESH', 10800 );
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    3.0.1
     */
    function run_advanced_visit_counter()
    {
        $plugin = new Advanced_Visit_Counter();
        $plugin->run();
    }
    
    run_advanced_visit_counter();
}
