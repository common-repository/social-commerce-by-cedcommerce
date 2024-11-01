<?php
/**
 * Register to CedCommerce Connector Section
 *
 * @package  Facebook_Marketplace_Connector_For_Woocommerce
 * @version  1.0.0
 * @link     https://cedcommerce.com
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
	$registration_data = get_option('ced_fmcw_registered_with_cedcommerce', array());
	$reg_email         = isset($registration_data['reg_email']) ? $registration_data['reg_email'] : '';
	// $reg_app_id        = isset($registration_data['reg_app_id']) ? $registration_data['reg_app_id'] : '';
	// $reg_public_key    = isset($registration_data['reg_public_key']) ? $registration_data['reg_public_key'] : '';
	// $reg_refresh_token = isset($registration_data['reg_refresh_token']) ? $registration_data['reg_refresh_token'] : '';
	
?>
<div class="ced-fmcw-wrapper">
	<div class="ced-fmcw-registration-wrapper">
		<div class="ced-fmcw-heading-wrapper">
			<h2><?php esc_attr_e( 'Connect to CedCommerce', 'facebook-marketplace-connector-for-woocommerce' ); ?></h2>
		</div>
			<!-- <span>To Connect to CedCommerce, you need to Register <a href="https://apps.cedcommerce.com/api-connect/app/auth/registration" target="_blank">here</a></span>
			<ul>
				<li>- Click <a href="javascript:void(0)" class="ced_copy_to_clipboard" data-url="<?php echo esc_attr(home_url()) . '/wp-admin/admin.php?page=ced_fb'; ?>">here</a> to copy the redirect url used at the time of registration</li>
				<li>- After Registration, fill in the fields below and click on Connect.</li>
			</ul> -->
		<div class="ced-fmcw-registration-field-wrapper">
			<input type="text" class="ced-fmcw-text-fields ced-fmcw-registration-email-field" id="ced-fmcw-registration-reg_email-field" value="<?php echo esc_attr($reg_email); ?>" placeholder="<?php esc_attr_e( 'Enter your email address to Register', 'facebook-marketplace-connector-for-woocommerce' ); ?>">
			<!-- <input type="text" class="ced-fmcw-text-fields ced-fmcw-registration-email-field" id="ced-fmcw-registration-public-key-field" value="<?php echo esc_attr($reg_public_key); ?>" placeholder="<?php esc_attr_e( 'Enter your Secret Key to Register', 'facebook-marketplace-connector-for-woocommerce' ); ?>">
			<input type="text" class="ced-fmcw-text-fields ced-fmcw-registration-email-field" id="ced-fmcw-registration-refresh-token-field" value="<?php echo esc_attr($reg_refresh_token); ?>" placeholder="<?php esc_attr_e( 'Enter your Access Token to Register', 'facebook-marketplace-connector-for-woocommerce' ); ?>"> -->

			<input type="button" class="ced-fmcw-button ced-fmcw-registration-button" id="ced-fmcw-register-to-cedcommerce" value="<?php esc_attr_e( 'Connect', 'facebook-marketplace-connector-for-woocommerce' ); ?>">
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

