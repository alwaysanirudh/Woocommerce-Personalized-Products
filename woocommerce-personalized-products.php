<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Woocommerce_Personalized_Products
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Personalized Products
 * Plugin URI:        http://dconsultor.com/
 * Description:       This is a plugin to enable personalization of Woocommerce products.
 * Version:           1.0.0
 * Author:            Anirudh Parui
 * Author URI:        http://dconsultor.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-personalized-products
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// If woocommerce is not active plugin, abort.
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    die;
}

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-personalized-products-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-personalized-products-deactivator.php';

/** This action is documented in includes/class-woocommerce-personalized-products-activator.php */
register_activation_hook( __FILE__, array( 'Woocommerce_Personalized_Products_Activator', 'activate' ) );

/** This action is documented in includes/class-woocommerce-personalized-products-deactivator.php */
register_deactivation_hook( __FILE__, array( 'Woocommerce_Personalized_Products_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-personalized-products.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_personalized_products() {
  if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  	$plugin = new Woocommerce_Personalized_Products();
  	$plugin->run();
  }
}
run_woocommerce_personalized_products();
