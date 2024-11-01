<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cedcommerce.com
 * @since             1.0.0
 * @package           Social_Commerce_by_CedCommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Social Commerce by CedCommerce
 * Plugin URI:        https://cedcommerce.com
 * Description:       Instagram Shopping for WooCommerce connects the woocommerce store with the Instagram marketplace by synchronizing the inventory, price, and other product details for the product creation.
 * Version:           1.0.2
 * Author:            CedCommerce
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       facebook-marketplace-connector-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Check if WooCommerce is active
 **/
$activated = true;
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	$activated = false;
}

if ( $activated ) {

	/**
	 * Currently plugin version.
	 * Start at version 1.0.0 and use SemVer - https://semver.org
	 * Rename this for your plugin and update it as you release new versions.
	 */
	define( 'FACEBOOK_MARKETPLACE_CONNECTOR_FOR_WOOCOMMERCE_VERSION', '1.0.0' );
	
	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-facebook-marketplace-connector-for-woocommerce-activator.php
	 */
	function activate_facebook_marketplace_connector_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-facebook-marketplace-connector-for-woocommerce-activator.php';
		Facebook_Marketplace_Connector_For_Woocommerce_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-facebook-marketplace-connector-for-woocommerce-deactivator.php
	 */
	function deactivate_facebook_marketplace_connector_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-facebook-marketplace-connector-for-woocommerce-deactivator.php';
		Facebook_Marketplace_Connector_For_Woocommerce_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_facebook_marketplace_connector_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'deactivate_facebook_marketplace_connector_for_woocommerce' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-facebook-marketplace-connector-for-woocommerce.php';

	/**
	 * The core function file that is been used for common functions throughout the plugin.
	 */
	require_once plugin_dir_path( __FILE__ ) . 'includes/ced-facebook-marketplace-connector-for-woocommerce-core-functions.php';
	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_facebook_marketplace_connector_for_woocommerce() {

		$plugin = new Facebook_Marketplace_Connector_For_Woocommerce();
		$plugin->run();

	}
	run_facebook_marketplace_connector_for_woocommerce();
} else {
	//Woocommerece is not activated
	//uninstall your plugin
	add_action( 'admin_init', 'ced_fmcw_basic_plugin_activation_failure' );
	function ced_fmcw_basic_plugin_activation_failure() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	add_action( 'admin_notices', 'ced_fmcw_basic_plugin_activation_failure_admin_notice' );

	/**
	 * This function is used to display failure message if WooCommerce is deactivated.
	 * 
	 * @name ced_fmcw_basic_plugin_activation_failure_admin_notice()
	 * @author CedCommerce<plugins@cedcommerce.com>
	 * @link http://cedcommerce.com/
	 */
	function ced_fmcw_basic_plugin_activation_failure_admin_notice() {
		?>
		<div class="notice notice-error is-dismissible">
			<p><?php esc_attr_e( 'Activate WooCommerce to use Facebook Marketplace Connector For Woocommerce', 'facebook-marketplace-connector-for-woocommerce' ); ?></p>
		</div>
		<style>div#message.updated{ display: none; }</style>
		<?php
	}
}
