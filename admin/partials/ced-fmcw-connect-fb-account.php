<?php
/**
 * Connect your Facebook Account
 *
 * @package  Facebook_Marketplace_Connector_For_Woocommerce
 * @version  1.0.0
 * @link     https://cedcommerce.com
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
$registration_data = get_option( 'ced_fmcw_registered_with_cedcommerce', array() );
$sAppId            = isset( $registration_data['reg_app_id'] ) ? $registration_data['reg_app_id'] : '';
?>
<div class="ced-fmcw-wrapper">
	<div class="ced-fmcw-fb-account-connect-wrapper">
		<div class="ced-fmcw-heading-wrapper">
			<h2><?php esc_attr_e( 'Connect to Facebook', 'facebook-marketplace-connector-for-woocommerce' ); ?></h2>
		</div>
		<div class="ced-fmcw-wrap-text">
		<div class="ced-fmcw-fb-account-connect-field-wrapper-wrap">
			<div class="ced-fmcw-fb-account-connect-field-text">
				<h3>Account not connected</h3>
			</div>
			<div class="ced-fmcw-fb-account-connect-field-wrapper">
				<input type="button" data-sAppId="<?php echo esc_attr($sAppId); ?>" data-currency="<?php echo esc_attr(get_woocommerce_currency()); ?>"data-timezone="<?php echo esc_attr(wp_timezone()->timezone); ?>" data-identifier="<?php echo 'woo-'.home_url()?>" class="ced-fmcw-button ced-fmcw-fb-account-connect-button" id="ced-fmcw-fb-account-connect" value="<?php esc_attr_e( 'Connect', 'facebook-marketplace-connector-for-woocommerce' ); ?>">
			</div>
		</div>
		<p>By clicking <b>Connect</b>, you agree to all <a href="#">terms and conditions</a></p>
		</div>
	</div>
</div>
<div class="ced_contact_menu_wrap">
		<input type="checkbox" href="#" class="ced_menu_open" name="menu-open" id="menu-open" />
		<label class="ced_menu_button" for="menu-open">
			<img src="<?php echo esc_url( CED_FMCW_URL . 'admin/images/icon.png' ); ?>" alt="" title="Click to Chat">
		</label>
		<a href="https://join.skype.com/WTZXhkd22Pgl" class="ced_menu_content ced_skype" target="_blank"> <i class="fa fa-skype" aria-hidden="true"></i> </a>
		<a href="https://chat.whatsapp.com/KYYqT7SjiUk8Z4DgMO9FoP" class="ced_menu_content ced_whatsapp" target="_blank"> <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
	</div>
