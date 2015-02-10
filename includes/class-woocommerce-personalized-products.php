<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/includes
 * @author     Anirudh Parui <alwaysanirudh@gmail.com>
 */
class Woocommerce_Personalized_Products {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woocommerce_Personalized_Products_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the Woocommerce Personalized Products and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'woocommerce-personalized-products';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woocommerce_Personalized_Products_Loader. Orchestrates the hooks of the plugin.
	 * - Woocommerce_Personalized_Products_i18n. Defines internationalization functionality.
	 * - Woocommerce_Personalized_Products_Admin. Defines all hooks for the dashboard.
	 * - Woocommerce_Personalized_Products_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-personalized-products-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-personalized-products-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-personalized-products-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-personalized-products-public.php';

		$this->loader = new Woocommerce_Personalized_Products_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_Personalized_Products_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woocommerce_Personalized_Products_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woocommerce_Personalized_Products_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_product_options_general_product_data', $plugin_admin, 'wc_personalized_product_select' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'wc_personalized_product_save' );
		$this->loader->add_action( 'woocommerce_after_order_itemmeta', $plugin_admin, 'render_meta_on_order_item' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		
		$plugin_public = new Woocommerce_Personalized_Products_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'woocommerce_product_tabs', $plugin_public, 'wc_personalized_product_tab');
		$this->loader->add_action( 'woocommerce_before_add_to_cart_button', $plugin_public, 'wc_personalized_product_cart_field' );
		$this->loader->add_action( 'woocommerce_add_to_cart_validation', $plugin_public, 'wc_personalized_product_cart_field_validation', 1, 5 );
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_public, 'tshirt_force_individual_cart_items', 10, 2);
		$this->loader->add_action( 'woocommerce_add_to_cart', $plugin_public, 'wc_personalized_product_cart_field_save', 1, 5 );
		$this->loader->add_action( 'woocommerce_cart_item_name', $plugin_public, 'render_meta_on_cart_item', 1, 3 );
		$this->loader->add_filter( 'woocommerce_checkout_cart_item_quantity', $plugin_public, 'render_meta_on_checkout_order_review_item', 1, 3);
		$this->loader->add_action( 'woocommerce_add_order_item_meta', $plugin_public, 'tshirt_order_meta_handler', 1, 3 );
		$this->loader->add_shortcode('wc-personalized-products-pattern', $plugin_public, 'wc_personalized_products_pattern');
		$this->loader->add_filter( 'woocommerce_order_item_display_meta_value', $plugin_public, 'render_meta_on_order_item');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woocommerce_Personalized_Products_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
