<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the Woocommerce Personalized Products, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/admin
 * @author     Anirudh Parui <alwaysanirudh@gmail.com>
 */
class Woocommerce_Personalized_Products_Public {

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
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Personalized_Products_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Personalized_Products_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-personalized-products-public.css', array(), $this->version, 'all' );
		global $post;
		$wc_personalized_product = get_post_meta( $post->ID, 'wc_personalized_product', true );

		if(!empty($wc_personalized_product) && $wc_personalized_product != 'none'){
			wp_enqueue_style( $this->name.'_bootstrap', plugin_dir_url( __FILE__ ) . '/../../assets/css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->name.'_'.$wc_personalized_product, plugin_dir_url( __FILE__ ) . '/../../assets/css/'.$wc_personalized_product.'.css', array(), $this->version, 'all' );
		}


	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Personalized_Products_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Personalized_Products_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $post;
		$wc_personalized_product = get_post_meta( $post->ID, 'wc_personalized_product', true );

		if(!empty($wc_personalized_product) && $wc_personalized_product != 'none'){
			wp_enqueue_script( $this->name.'_angular', plugin_dir_url( __FILE__ ) . '/../../assets/js/angular.min.js',  array(),$this->version, FALSE );
			wp_enqueue_script( $this->name.'_'.$wc_personalized_product, plugin_dir_url( __FILE__ ) . '/../../assets/js/'.$wc_personalized_product.'.js', array() , $this->version, FALSE );
			wp_enqueue_script( $this->name, plugin_dir_url(__FILE__) . '/js/woocommerce-personalized-products-public.js', array( 'jquery' ), $this->version, FALSE );
		}
	}


	public function wc_personalized_product_tab( $tabs ) {
		global $post;
		$wc_personalized_product = get_post_meta( $post->ID, 'wc_personalized_product', true );

		// Adds the new tab
		if(!empty($wc_personalized_product) && $wc_personalized_product != 'none'){
			$tabs['wc_personalized_product_tab'] = array(
				'title' => __( 'Add your Name', 'woocommerce' ),
				'priority' => 5,
				'callback' => array($this, 'wc_personalized_product_content')
			);
		}

		return $tabs;
	}

	public function wc_personalized_product_content() {

		global $post;
		$wc_personalized_product = get_post_meta( $post->ID, 'wc_personalized_product', true );
		echo "<script>
				var dirName = '".plugin_dir_url( __FILE__ )."';
				var patternOnly = false;
			 </script>";
		switch ($wc_personalized_product) {
			case 'breaking-bad':
			   echo "<div ng-app='breakingBad'>
					<div class='im-centered' ng-controller='bbCtrl'>
			        <div class='input-group'>
			            <input class='form-control' style='text-align: center' autofocus type='text' ng-model='name'>
			            <span class='input-group-btn'>
			                <button class='btn btn-default' ng-disabled='disabled' ng-click='tryAgain()'>Try Again!!</button>
			            </span>
			        </div>
			        <div class='row'>
			            <ng-breaking-bad></ng-breaking-bad>
			        </div>
			        </div>
			        </div>
			        <div class='im-centered' style='padding: 10px'>
			        	<button id='save-generator' class='btn btn-default'>Save This</button>
			        </div>";

				break;
			case 'friends-white':
			   echo "<div ng-app='friends'>
					<div class='im-centered' ng-controller='friendsCtrl'>
			        <div class='input'>
			            <input class='form-control' style='text-align: center' autofocus type='text' ng-model='name'>
			        </div>
			        <div class='row'>
			            <ng-friends></ng-friends>
			        </div>
			        </div>
			        </div>
			        <div class='im-centered' style='padding: 10px'>
			        	<button id='save-generator' class='btn btn-default'>Save This</button>
			        </div>";
				break;
			case 'friends-black':
			   echo "<div ng-app='friends'>
					<div class='im-centered' ng-controller='friendsCtrl'>
			        <div class='input'>
			            <input class='form-control' style='text-align: center' autofocus type='text' ng-model='name'>
			        </div>
			        <div class='row'>
			            <ng-friends></ng-friends>
			        </div>
			        </div>
			        </div>
			        <div class='im-centered' style='padding: 10px'>
			        	<button id='save-generator' class='btn btn-default'>Save This</button>
			        </div>";
				break;
			default:
				# code...
				break;
		}
	}

	/**
	 * The following hook will add a input field right before "add to cart button"
	 * will be used for getting Name on t-shirt
	 */
	function wc_personalized_product_cart_field() {
		global $post;
		$wc_personalized_product = get_post_meta( $post->ID, 'wc_personalized_product', true );

		if(!empty($wc_personalized_product) && $wc_personalized_product != 'none'){
			echo '<input id="personalize" type="hidden" name="personalize" value="" />';
		}

	}

	function wc_personalized_product_cart_field_validation() {
		//global $post;
		if (array_key_exists('personalize', $_REQUEST) && empty( $_REQUEST['personalize'] ) ) {
			wc_add_notice( __( 'Please enter a Name for Printing…', 'woocommerce' ), 'error' );
			return false;
		}

		return true;
	}

	function wc_personalized_product_cart_field_save( $cart_item_key, $product_id = null, $quantity= null, $variation_id= null, $variation= null ) {

		if ( array_key_exists('personalize', $_REQUEST)){
			WC()->session->set( $cart_item_key.'_personalize', base64_encode($_REQUEST['personalize']) );
		}
	}


	function render_meta_on_cart_item( $title = null, $cart_item = null, $cart_item_key = null ) {
		$generator = WC()->session->get( $cart_item_key.'_personalize');
		if( $cart_item_key && is_cart() && $generator != '') {
			$page = get_page_by_title('Pattern Generator');
			$permalink = get_permalink($page->ID);
			echo $title. '<dl class="">
					 <dt class=""><a target="_blank" href="'.$permalink.'?key='.$generator.'" >View Pattern</a></dt>
				  </dl>';
		}else {
			echo $title;
		}
	}


	function render_meta_on_checkout_order_review_item( $quantity = null, $cart_item = null, $cart_item_key = null ) {
		$generator = WC()->session->get( $cart_item_key.'_personalize');
		if( $cart_item_key && $generator != '') {
			$page = get_page_by_title('Pattern Generator');
			$permalink = get_permalink($page->ID);
			echo $quantity. '<dl class="">
					  <dt class=""><a target="_blank" href="'.$permalink.'?key='.$generator.'" >View Pattern</a></dt>
				  </dl>';
		}
	}

	function tshirt_order_meta_handler( $item_id, $values, $cart_item_key ) {
		$generator = WC()->session->get( $cart_item_key.'_personalize');
		if($generator != ''){
			wc_add_order_item_meta( $item_id, "pattern", $generator);
		}
	}

	function tshirt_force_individual_cart_items($cart_item_data, $product_id)
	{
		$unique_cart_item_key = md5( microtime().rand() );
		$cart_item_data['unique_key'] = $unique_cart_item_key;

		return $cart_item_data;
	}


	function render_meta_on_order_item( $meta ) {
		if(base64_encode(base64_decode($meta, true)) !== $meta){
			return $meta;
		}
		$page = get_page_by_title('Pattern Generator');
		$permalink = get_permalink($page->ID);
		return '<a target="_blank" href="'.$permalink.'?key='.$meta.'" >View Pattern</a>';
	}


	function wc_personalized_products_pattern($atts, $content=null){

	    $key = $_GET['key'];
	    $r = 'Invalid Pattern';
	    if(isset($key)){
	    	$key = base64_decode($key);
	    	$key = explode(':', $key);
	    	if(count($key) == 3){
	    		$r = "<script>
						var dirName = '".plugin_dir_url( __FILE__ )."';
						var patternOnly = true;
						var name = '".$key[1]."';
						var count = '".$key[2]."';
					  </script>";

				wp_enqueue_style( $this->name.'_bootstrap', plugin_dir_url( __FILE__ ) . '/../../assets/css/bootstrap.min.css', array(), $this->version, 'all' );
				wp_enqueue_style( $this->name.'_'.$wc_personalized_product, plugin_dir_url( __FILE__ ) . '/../../assets/css/'.$key[0].'.css', array(), $this->version, 'all' );

				wp_enqueue_script( $this->name.'_angular', plugin_dir_url( __FILE__ ) . '/../../assets/js/angular.min.js',  array(),$this->version, FALSE );
				wp_enqueue_script( $this->name.'_'.$key[0], plugin_dir_url( __FILE__ ) . '/../../assets/js/'.$key[0].'.js', array() , $this->version, FALSE );

				switch ($key[0]) {
					case 'breaking-bad':
					   $r .= 	"<div ng-app='breakingBad'>
								<div class='im-centered' ng-controller='bbCtrl'>
						        <div class='row'>
						            <ng-breaking-bad></ng-breaking-bad>
						        </div>
						        </div>
						        </div>";

						break;
					case 'friends-white':
					   $r .= 	"<div ng-app='friends'>
								<div class='im-centered' ng-controller='friendsCtrl'>
						        <div class='row'>
						            <ng-friends></ng-friends>
						        </div>
						        </div>
						        </div>";
						break;
					case 'friends-black':
					   $r .= 	"<div ng-app='friends'>
								<div class='im-centered' ng-controller='friendsCtrl'>
						        <div class='row'>
						            <ng-friends></ng-friends>
						        </div>
						        </div>
						        </div>";
						break;
					default:
						# code...
						break;
	    		}
	    	}
		}

		return $r;
	}

}
