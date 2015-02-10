<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Personalized_Products
 * @subpackage Woocommerce_Personalized_Products/includes
 * @author     Anirudh Parui <alwaysanirudh@gmail.com>
 */
class Woocommerce_Personalized_Products_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

                $new_page_title = 'Pattern Generator';
                $new_page_content = '[wc-personalized-products-pattern]';
                $new_page_template = ''; //ex. template-custom.php. Leave blank if you don't want a custom page template.

                //don't change the code bellow, unless you know what you're doing

                $page_check = get_page_by_title($new_page_title);
                $new_page = array(
                        'post_type' => 'page',
                        'post_title' => $new_page_title,
                        'post_content' => $new_page_content,
                        'post_status' => 'publish',
                        'post_author' => 1,
                        'ping_status'    => 'closed',
                        'comment_status' =>  'closed'   
                );
                
                if(!isset($page_check->ID)){
                        $new_page_id = wp_insert_post($new_page);
                        if(!empty($new_page_template)){
                                update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
                        }
                }

	}

}
