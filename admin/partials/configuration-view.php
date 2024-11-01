<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

$cms_settings = get_option( 'ced_fmcw_fb_cms_settings', array() );

$authenticated_pages  = get_option( 'ced_fmcw_merchant_page_authenticated', array() );
$alreadyAuthenticated = 0;
if ( empty( $authenticated_pages ) ) {
	$authenticated_pages = array();
}
$page_name = array();
?>
<div class="ced-fmcw-wrapper">
	<div class="ced-fmcw-configuration-page-settings-wrapper">
		<div class="ced-fmcw-heading-wrapper">
			<h2><?php esc_attr_e( 'Account Configuration', 'facebook-marketplace-connector-for-woocommerce' ); ?></h2>
			<a href="javascript:void();" class="ced-fmcw-button ced-fmcw-resync-page-button" id="ced-fmcw-fb-account-connect"><?php esc_attr_e('Re-Connect Facebook', 'facebook-marketplace-connector-for-woocommerce'); ?></a>
		</div>
		<div class="ced-fmcw-commerce-pages-wrapper">
			<div class="ced-fmcw-create-commerce-page-wrapper">
				<label>
					<?php esc_attr_e( 'Create your CMS Page from here', 'facebook-marketplace-connector-for-woocommerce' ); ?>
				</label>
				<a href="https://facebook.com/commerce_manager" target="_blank" class="ced-fmcw-button ced-fmcw-create-cms-page-button" id="ced-fmcw-create-cms-page" ><?php esc_attr_e( 'Open Facebook CMS Page', 'facebook-marketplace-connector-for-woocommerce' ); ?></a>
			</div>
			<?php 
			if ( !empty( $cms_settings['data'] ) ) {
				?>
				<div class="ced-fmcw-configure-commerce-page-wrapper">
					<?php
					foreach ( $cms_settings['data'] as $key => $data ) {
						$page_name[$data['id']] = $data['merchant_page']['name'];
						$found_error            = 0;
						$merchant_page_errors   = isset( $data['errors'] ) ? $data['errors'] : array();
						?>
						<div class="ced-fmcw-fb-page-wrapper">
							<div class="ced-fmcw-fb-page-wrapper-wrap">
								<label><?php echo esc_attr($data['merchant_page']['name']); ?></label>
								<?php 
								if ( isset( $data['order_management_apps'] )  && 'CedCommerce' == $data['order_management_apps'][0]['name'] ) {
									$alreadyAuthenticated = 1;
									?>
									<em class="ced-fmcw-authenticated-success-msg"><?php esc_attr_e( 'The Page is Authenticated by: CedCommerce', 'facebook-marketplace-connector-for-wocommerce' ); ?></em>
									<?php
								}
								if ( !empty($merchant_page_errors)  && isset( $merchant_page_errors[0] ) ) {
									foreach ( $merchant_page_errors as $key => $page_error ) {
										if ( isset( $page_error['action'] ) && 'setup_shop' == $page_error['action'] ) {
											$found_error = 1;
											?>
											<em class="ced-fmcw-cms-page-error-msg"><?php echo esc_attr( $page_error['display_message'] ); ?> </em>
											<?php
											break;
										}
									}
								}
								?>
							</div>
							<input type="hidden" value="<?php echo esc_attr($data['merchant_page']['id']); ?>">
							<?php
							if ( in_array( $data['id'], $authenticated_pages ) || ( isset( $data['order_management_apps'] )  && 'CedCommerce' == $data['order_management_apps'][0]['name'] ) ) {
								if ( !$found_error ) {
									$authenticated_pages[]            = $data['id'];
									$catalog_and_page_id              = get_option( 'ced_fmcw_catalog_and_page_id', array() );
									$catalog_and_page_id[$data['id']] = array('page_id' => $data['merchant_page']['id'], 'catalog_id' => $data['product_catalogs'][0]['id']);
									update_option( 'ced_fmcw_catalog_and_page_id', $catalog_and_page_id );
									update_option( 'ced_fmcw_merchant_page_authenticated', array_unique($authenticated_pages) );
								}
									
								?>
								<input type="button" disabled value="<?php esc_attr_e( 'Authenticated', 'facebook-marketplace-connector-for-woocommerce' ); ?>" class="ced-fmcw-button ced-fmcw-fb-authenticate-button" data-page_id="<?php echo esc_attr($data['merchant_page']['id']); ?>" data-catalog_id="<?php echo esc_attr($data['product_catalogs'][0]['id']); ?>" data-merchant_page_id="<?php echo esc_attr($data['id']); ?>">
								<?php
							} else {
								if ( empty( $merchant_page_errors ) ) {
									?>
									<input type="button" value="<?php esc_attr_e( 'Authenticate', 'facebook-marketplace-connector-for-woocommerce' ); ?>" class="ced-fmcw-button ced-fmcw-fb-authenticate-button" data-page_id="<?php echo esc_attr($data['merchant_page']['id']); ?>" data-catalog_id="<?php echo esc_attr($data['product_catalogs'][0]['id']); ?>" data-merchant_page_id="<?php echo esc_attr($data['id']); ?>">
									<?php
								} else {
									?>
									<a href="https://www.facebook.com/commerce_manager/onboarding/" class="ced-fmcw-button ced-fmcw-fb-configure-button" data-merchant_page_id="<?php echo esc_attr($data['id']); ?>"><?php esc_attr_e( 'Configure', 'facebook-marketplace-connector-for-woocommerce' ); ?></a>
									<?php
								}   
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			/*if( !empty( $authenticated_pages ) || $alreadyAuthenticated )
			{
				?>
				<div class="ced-fmcw-fb-page-wrapper ced-fmcw-move-to-next-step-wrapper">
					<input type="button" class="ced-fmcw-button ced-fmcw-next-step-button" id="ced-fmcw-next-step-button" value="<?php esc_attr_e( 'Next Step', 'facebook-marketplace-connector-for-woocommerce' ); ?>">
				</div>
				<?php
			}
			else
			{
				?>
				<div class="ced-fmcw-fb-page-wrapper ced-fmcw-move-to-next-step-wrapper ced-fmcw-hidden-div">
					<input type="button" class="ced-fmcw-button ced-fmcw-next-step-button" id="ced-fmcw-next-step-button" value="<?php esc_attr_e( 'Next Step', 'facebook-marketplace-connector-for-woocommerce' ); ?>">
				</div>
				<?php
			}*/
			?>
		</div>
		<?php

		$active_pages = get_option( 'ced_fmcw_active_merchant_pages', array() );
		if ( empty( $active_pages ) ) {
			$active_pages = array();
		}

			$authenticated_pages = get_option( 'ced_fmcw_merchant_page_authenticated', array() );
		if ( empty( $authenticated_pages ) ) {
			$authenticated_pages = array();
		}
		if (!empty($authenticated_pages)) {
			?>
		<div class="ced-fmcw-active-pages-wrapper">
			<div class="ced-fmcw-heading-wrappers">
				<h2><?php esc_attr_e( 'Active Merchant Pages', 'facebook-marketplace-connector-for-woocommerce' ); ?></h2>
				<em><?php esc_attr_e( 'The selected Facebook pages will be used for syncing the products and orders ', 'facebook-marketplace-connector-for-woocommerce' ); ?></em>
			</div>
			<?php 
			
			$authenticated_pages = get_option( 'ced_fmcw_merchant_page_authenticated', array() );
			if ( empty( $authenticated_pages ) ) {
				$authenticated_pages = array();
			}
			foreach ( $authenticated_pages as $key => $authenticated_page ) {
				$checked = '';
				if ( in_array( $authenticated_page, $active_pages ) ) {
					$checked = 'checked';
				}
				?>
				<div class="ced-fmcw-active-page">
					<label for="<?php echo esc_attr($page_name[$authenticated_page]); ?>"><?php echo esc_attr($page_name[$authenticated_page]); ?></label>
					<input type="checkbox" <?php echo esc_attr($checked); ?> name="ced_fmcw_active_pages" class="ced-fmcw-checkbox ced-fmcw-active-page-checkbox" value="<?php echo esc_attr($authenticated_page); ?>">
					
				</div>
				<?php
			}
			?>
			<div class="ced-fmcw-save-active-pages">
				<input type="button" class="ced-fmcw-button ced-fmcw-save-active-pages-button" id="ced-fmcw-save-active-pages" value="<?php echo 'Save Pages'; ?>">
			</div>
		</div>
	<?php } ?>
	</div>
</div>
		<a href="<?php echo esc_attr(home_url()); ?>/wp-admin/admin.php?page=ced_fb&section=registration-view">Back to Registration Page</a>
