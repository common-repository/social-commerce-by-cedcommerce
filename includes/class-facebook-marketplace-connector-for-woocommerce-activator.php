<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cedcommerce.com
 * @since      1.0.0
 *
 * @package    Facebook_Marketplace_Connector_For_Woocommerce
 * @subpackage Facebook_Marketplace_Connector_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Facebook_Marketplace_Connector_For_Woocommerce
 * @subpackage Facebook_Marketplace_Connector_For_Woocommerce/includes
 * @author     CedCommerce <plugins@cedcommerce.com>
 */
class Facebook_Marketplace_Connector_For_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		
		$table_name = 'wp_ced_fb_profiles';

		$create_profile_table =
			"CREATE TABLE $table_name (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			profile_name VARCHAR(255) NOT NULL,
			profile_status VARCHAR(255) NOT NULL,
			profile_data TEXT DEFAULT NULL,
			woo_categories TEXT DEFAULT NULL,
			PRIMARY KEY (id)
		);";
		dbDelta( $create_profile_table );

	}

}
