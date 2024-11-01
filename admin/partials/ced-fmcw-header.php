<?php
/**
 * Header of the extensiom
 *
 * @package  Facebook_Marketplace_Connector_For_Woocommerce
 * @version  1.0.0
 * @link     https://cedcommerce.com
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
/*
$shop_id = isset( $_GET['shop_id'] ) ? sanitize_text_field( wp_unslash( $_GET['shop_id'] ) ) : '';

global $wpdb;
$shop_details = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM wp_ced_shopee_accounts WHERE `shop_id` = %d ', $shop_id ), 'ARRAY_A' );
$shop_details = $shop_details[0];
$countries    = ced_shopee_countries();

if ( isset( $_GET['section'] ) ) {
	$section = sanitize_text_field( wp_unslash( $_GET['section'] ) );
}*/

?>
<div class="ced_fmcw_loader">
	<img src="<?php echo esc_url( CED_FMCW_URL . 'admin/images/loading.gif' ); ?>" width="50px" height="50px" class="ced_fmcw_loading_img" >
</div>
<div class="success-admin-notices is-dismissible"></div>
<div class="ced-fmcw-navigation-wrapper">
	<ul class="ced-fmcw-navigation">
		<li>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ced_fb&section=dashboard-view' ) ); ?>" class="
								<?php
								if ( 'dashboard-view' == $section ) {
									echo 'active';
								}
								?>
			"><?php esc_html_e( 'Dashboard', 'facebook-marketplace-connector-for-woocommerce' ); ?></a>
		</li>
		<li>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ced_fb&section=settings-view' ) ); ?>" class="
								<?php
								if ( 'settings-view' == $section ) {
									echo 'active';
								}
								?>
			"><?php esc_html_e( 'Settings', 'facebook-marketplace-connector-for-woocommerce' ); ?></a>
		</li>
		<li>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ced_fb&section=category-mapping-view' ) ); ?>" class="
								<?php
								if ( 'category-mapping-view' == $section ) {
									echo 'active';
								}
								?>
			"><?php esc_html_e( 'Category Mapping', 'facebook-marketplace-connector-for-woocommerce' ); ?></a>
		</li>
		<!-- <li>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ced_fb&section=profile-view' ) ); ?>" class="
								<?php
								if ( 'profile-view' == $section ) {
									echo 'active';
								}
								?>
			"><?php esc_html_e( 'Profile', 'facebook-marketplace-connector-for-woocommerce' ); ?></a>
		</li> -->
		<li>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ced_fb&section=order-view' ) ); ?>" class="
								<?php
								if ( 'order-view' == $section ) {
									echo 'active';
								}
								?>
			"><?php esc_html_e( 'Orders', 'facebook-marketplace-connector-for-woocommerce' ); ?></a>
		</li>
		<li>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ced_fb&section=feed-view' ) ); ?>" class="
								<?php
								if ( 'feed-view' == $section ) {
									echo 'active';
								}
								?>
			"><?php esc_html_e( 'Feeds', 'facebook-marketplace-connector-for-woocommerce' ); ?></a>
		</li>
		<li>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ced_fb&section=configuration-view' ) ); ?>" class="
								<?php
								if ( 'configuration-view' == $section ) {
									echo 'active';
								}
								?>
			"><?php esc_html_e( 'Configuration', 'facebook-marketplace-connector-for-woocommerce' ); ?></a>
		</li>
	</ul>
</div>
<div class="ced_contact_menu_wrap">
		<input type="checkbox" href="#" class="ced_menu_open" name="menu-open" id="menu-open" />
		<label class="ced_menu_button" for="menu-open">
			<img src="<?php echo esc_url( CED_FMCW_URL . 'admin/images/icon.png' ); ?>" alt="" title="Click to Chat">
		</label>
		<a href="https://join.skype.com/WTZXhkd22Pgl" class="ced_menu_content ced_skype" target="_blank"> <i class="fa fa-skype" aria-hidden="true"></i> </a>
		<a href="https://chat.whatsapp.com/KYYqT7SjiUk8Z4DgMO9FoP" class="ced_menu_content ced_whatsapp" target="_blank"> <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
	</div>
