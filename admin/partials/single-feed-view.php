<?php
$feed_handle = isset($_GET['feedID']) ? sanitize_text_field( wp_unslash( $_GET['feedID'] ) ) : '';
$auth_page   = isset($_GET['auth_page']) ? sanitize_text_field( wp_unslash( $_GET['auth_page'] ) ) : '';

if (!empty($auth_page)) {
	$catalog_and_page_id = get_option( 'ced_fmcw_catalog_and_page_id', array() );
	$catalog_id          = $catalog_and_page_id[$auth_page]['catalog_id'];
	$page_id             = $catalog_and_page_id[$auth_page]['page_id'];
}
print_r($page_id);
if (!empty($feed_handle)) {
	$feed_action  = 'webapi/rest/v1/product/batch/status';
	$parameters   = array(
		'catalog_id' => $catalog_id,
		'page_id' => $page_id,
		'handle' => $feed_handle
	);
		$fileNmae = CED_FMCW_DIRPATH . 'admin/lib/class-ced-fmcw-sendHttpRequest.php';
		include_once $fileNmae;
		$ced_fmcw_send_request = new Class_Ced_Fmcw_Send_Http_Request();

		$feed_response = $ced_fmcw_send_request->get_request($feed_action, $parameters);
		// print_r($feed_response);
		// die("111231");
	if ( is_array( $feed_response ) && !empty( $feed_response ) ) {
		if ( isset( $feed_response['success'] ) && $feed_response['success'] ) {
			if ( isset( $feed_response['data'][0] ) ) {
				?>
						<div class="ced_fmcw_single_feed_content">
							<div class="ced_fmcw_single_feed_header">
								<h5><?php esc_html_e( 'Feed Response', 'facebook-marketplace-connector-for-woocommerce' ); ?></h5>
						</div>
					<?php
					foreach ( $feed_response['data'] as $key => $feed_data ) {
						?>
							<div class="ced_fmcw_single_feed_status_heading">
								<h6 class="ced_fmcw_single_feed_heading_status_title">Feed Status : <?php echo esc_attr($feed_data['status']); ?></h6>
								<dl>
								<dt class="ced_fmcw_send_request_heading">
									Product Errors
								</dt>
								<?php 
								if (is_array($feed_data['errors']) && !empty($feed_data['errors'])) {
									foreach ($feed_data['errors'] as $error_key => $error_value) {
										echo '<dd>' . esc_attr(get_the_title($error_value['id'])) . '</dd>
											<dd>' . esc_attr($error_value['message']) . '</dd>';
									}
								} else {
									echo '<dd>No Errors to show</dd>';
								}
								?>
								<dt class="ced_fmcw_send_request_heading-wraning">
									Product Warnings
								</dt>
								<?php 
								if (is_array($feed_data['warnings']) && !empty($feed_data['warnings'])) {
									foreach ($feed_data['warnings'] as $warning_key => $warning_value) {
										echo '<dd>' . esc_attr(get_the_title($warning_value['id'])) . '</dd>
												<dd>' . esc_attr($warning_value['message']) . '</dd>';
									}
								} else {
									echo '<dd>No Errors to show</dd>';
								}
								?>
							</dl>
							</div>
						<?php
					}
					echo '</div>';
			}
		}
	}
}
