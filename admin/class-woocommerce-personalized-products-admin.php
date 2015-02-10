<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/includes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the Woocommerce Personalized Products, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/admin
 * @author     Anirudh Parui <alwaysanirudh@gmail.com>
 */
class Woocommerce_Personalized_Products_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Personalized_Products_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Personalized_Products_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-personalized-products-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Personalized_Products_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Personalized_Products_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-personalized-products-admin.js', array( 'jquery' ), $this->version, FALSE );

	}


	//add_action( 'woocommerce_product_options_pricing', 'wc_rrp_product_field' );
	public function wc_personalized_product_select() {
		//woocommerce_wp_text_input( array( 'id' => 'rrp_price', 'class' => 'wc_input_price short', 'label' => __( 'RRP', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')' ) );
		woocommerce_wp_select(
			array(
				'id' => 'wc_personalized_product',
				'label' => __( 'Personalize', 'woocommerce' ),
				'options' => array(
								'none'		  => __( 'None', 'woocommerce' ),
								'breaking-bad' => __( 'Breaking Bad', 'woocommerce' ),
								'friends-black' => __( 'Friends Black', 'woocommerce' ),
								'friends-white' => __( 'Friends White', 'woocommerce' )
							)
				 )
		); 



	}
	//woocommerce_admin_order_item_values
	function render_meta_on_order_item( $item_id = null, $item= null, $_product = null) {
		$page = get_page_by_title('Pattern Generator');
		$permalink = get_permalink($page->ID);
		
		$order = new WC_Order( $item );;
		$metadata = $order->has_meta( $item_id );
		foreach ($metadata as $meta) {
			if($meta['meta_key'] == 'pattern'){
				echo '<a target="_blank" href="'.$permalink.'?key='.$meta['meta_value'].'" >View Pattern</a>';
			}
		}
		
	}

	function wc_personalized_product_save( $product_id ) {
		// If this is a auto save do nothing, we only save when update button is clicked
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
		if ( isset( $_POST['wc_personalized_product'] ) ) {
			update_post_meta( $product_id, 'wc_personalized_product', $_POST['wc_personalized_product'] );
		} else delete_post_meta( $product_id, 'wc_personalized_product' );
	}

}
