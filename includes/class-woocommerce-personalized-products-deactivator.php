<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/includes
 * @author     Anirudh Parui <alwaysanirudh@gmail.com>
 */
class Woocommerce_Personalized_Products_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$page_check = get_page_by_title('Pattern Generator');
		wp_delete_post( $page_check->ID, true );
	}

}
