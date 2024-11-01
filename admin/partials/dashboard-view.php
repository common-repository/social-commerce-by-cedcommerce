<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
require CED_FMCW_DIRPATH . 'admin/lib/jwt/vendor/autoload.php';
use \Firebase\JWT\JWT;
$fbe_data = get_option('ced_fmcw_fbe_data');
if(empty($fbe_data))
{

	$page_data = get_option('ced_fmcw_auth_post_data','');
	//print_r($page_data);
	$jwt = $page_data['data'];
	$registration_data = get_option('ced_fmcw_registered_with_cedcommerce', array());
	$publicKey    = isset($registration_data['reg_public_key']) ? $registration_data['reg_public_key'] : '';
	$publicKey = base64_decode($publicKey);
	$decoded = JWT::decode($jwt, $publicKey, array('RS256'));
	//print_r($decoded);
	if($decoded->data)
	{
		update_option('ced_fmcw_fbe_data',$decoded);
		$fbe_data = get_option('ced_fmcw_fbe_data');
		$fbe_data = $fbe_data->data->fbe_data;
		foreach ($fbe_data as $key => $value) {
			$authenticated_pages = get_option( 'ced_fmcw_merchant_page_authenticated', array() );
			$catalog_and_page_id = get_option( 'ced_fmcw_catalog_and_page_id', array() );
			if ( empty($authenticated_pages) ) {
				$authenticated_pages = array();
			}

			$authenticated_pages[]                  = $value->business_manager_id;
			$catalog_and_page_id[$value->business_manager_id] = array( 'catalog_id' => $value->catalog_id, 'page_id' => $value->pages[0] );

			update_option( 'ced_fmcw_merchant_page_authenticated', $authenticated_pages );
			update_option( 'ced_fmcw_active_merchant_pages', $authenticated_pages );
			update_option( 'ced_fmcw_catalog_and_page_id', $catalog_and_page_id );
		}
		update_option('ced_fmcw_setup_completed','yes');
	}
	else
	{
		update_option( 'ced_fmcw_fb_account_connected', false );
	}
}
require_once CED_FMCW_DIRPATH . 'admin/partials/ced-fmcw-header.php';
$shop_name                   = 'Facebook Marketplace';
// $total_products1             = get_posts(
// 	array(
// 		'numberposts'  => -1,
// 		'post_type'    => 'product',
// 		)
// 	);
// $total_import_products       = count(wp_list_pluck( $total_products1, 'ID' ));
$total_import_products       = "-";
// $total_products2             = get_posts(
// 	array(
// 		'numberposts'  => -1,
// 		'post_type'    => 'product',
// 		'meta_key'     => 'ced_fmcw_uploaded_on_facebook',
// 		'meta_compare' => 'EXISTS',
// 		)
// 	);
// $total_uploaded_products     = count(wp_list_pluck( $total_products2, 'ID' ));
$total_uploaded_products     = "-";
// $total_products3             = get_posts(
// 	array(
// 		'numberposts'  => -1,
// 		'post_type'    => 'product',
// 		'meta_key'     => 'ced_fmcw_product_errors',
// 		'meta_compare' => 'EXISTS',
// 		)
// 	);
// $total_errored_products      = count(wp_list_pluck( $total_products3, 'ID' ));
$total_errored_products      = "-";
// $total_products4             = get_posts(
// 	array(
// 		'numberposts'  => -1,
// 		'post_type'    => 'product',
// 		'meta_key'     => 'ced_fmcw_uploaded_on_facebook',
// 		'meta_compare' => 'NOT EXISTS',
// 		)
// 	);
// $total_not_uploaded_products = count(wp_list_pluck( $total_products4, 'ID' ));
$total_not_uploaded_products = "-";
?>
	<body>
	<div class="ced_fb_wrap ced_fb_wrap_extn">
			<div class="ced_fb_setting_header manage_labels">
				<b><?php esc_attr_e('Hi, Welcome aboard on Facebook Marketplace Integration Dashboard', 'facebook-marketplace-connector-for-woocommerce'); ?></b>
			</div>
		<div>
		<div class="container">
			<div class="ced-content-wrapper">
				<div class="ced-content-wrap-text">
					<div class="ced-product-wrapper-content">
						<div class="ced-product-width">
							<div class="ced-heading">
								<div class="ced-head-wrap">
									<h2>
										<?php echo esc_attr($shop_name); ?>
									</h2>
									<div class="ced-product-list">
										<ul>
											<li><span class="ced-product-export">
													Product error log <a href="#" id="ced_fb_export_error_log"><i class="fa fa-download" aria-hidden="true"></i>
												</a></span>
											</li>
											<li><span class="ced-product-export">
													Product uploaded list <a href="#" id="ced_fb_export_uploaded_log"><i class="fa fa-download" aria-hidden="true"></i>
												</a></span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="ced-product-width">
							<div class="ced-padding-remove">
								<div class="ced-product-wrap-quantity">
									<div class="ced-store-name-product ced-1">
										<h4>
											Total Products
										</h4>
										<div class="ced-dynamin-number">
											<p><?php echo esc_attr($total_import_products); ?></p>
										</div>
									</div>
								</div>
								<div class="ced-product-wrap-quantity">
									<div class="ced-store-name-product ced-2">
										<h4>
											Product Uploaded
										</h4>
										<div class="ced-dynamin-number">
											<p><?php echo esc_attr($total_uploaded_products); ?></p>
										</div>
									</div>
								</div>
								<div class="ced-product-wrap-quantity">
									<div class="ced-store-name-product ced-3">
										<h4>
											Product Not Uploaded
										</h4>
										<div class="ced-dynamin-number">
											<p><?php echo esc_attr($total_not_uploaded_products); ?></p>
										</div>
									</div>
								</div>
								<div class="ced-product-wrap-quantity">
									<div class="ced-store-name-product ced-4">
										<h4>
											Product with errors
										</h4>
										<div class="ced-dynamin-number">
											<p><?php echo esc_attr($total_errored_products); ?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ced-content-wrapper ced-reccent-activities-log-wrapper">
				<div class="ced_fb_log_header manage_labels">
					<b><?php esc_attr_e('Recent Activities', 'facebook-marketplace-connector-for-woocommerce'); ?></b>
				</div>
				<?php 
				$all_feeds             = get_option( 'ced_fmcw_all_product_feeds', array() );
				$all_products_in_feeds = get_option( 'ced_fmcw_products_in_feed', array() );
				if ( !empty( $all_feeds ) ) {
					foreach ($all_feeds as $page_id => $page_feeds) {
						$page_feeds = array_reverse($page_feeds);
						$count      = 1;
						foreach ( $page_feeds as $key => $feed ) {
							if ( $count <= 10 ) {
								$feed_type   = isset( $feed['type'] ) ? $feed['type'] : '';
								$feed_handle = isset( $feed['handle'] ) ? $feed['handle'] : '';
								$date        = isset( $feed['date'] ) ? $feed['date'] : gmdate('Y-m-d h:i:s');
								
								if ( 'upload' == $feed_type ) {
									$class = 'ced-fmcw-feed-upload-log';
								} elseif ( 'update' == $feed_type ) {
									$class = 'ced-fmcw-feed-update-log';
								} elseif ( 'remove' == $feed_type ) {
									$class = 'ced-fmcw-feed-remove-log';
								}
								
								if ( !empty( $feed_handle ) ) {
									$number_of_products = isset($all_products_in_feeds[$feed['handle']]) ? count($all_products_in_feeds[$feed['handle']]) : 0;
									?>
									<div class="ced-fmcw-feed-log-row">
										<label><?php echo esc_attr(ucfirst($feed_type)) . ' Feed'; ?></label>
										<span class="ced-fmcw-feed-log-row-log"><?php echo esc_attr($number_of_products) . ' Number of Products'; ?></span><br>
										<span><?php echo esc_attr($date); ?></span>
									</div>
									<?php
								}
								
								$count++ ;
							}
						}
					}
				} else {
					?>
					<div class="ced-fmcw-feed-log-row">
						<label>No Feed to Show.</label>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
</body>
</html>
