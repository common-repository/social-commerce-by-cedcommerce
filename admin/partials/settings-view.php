<?php
$attributes   = wc_get_attribute_taxonomies();
$attr_options = array();
$attr_options['_sku'] = "_sku";
if ( ! empty( $attributes ) ) {
	foreach ( $attributes as $attributes_object ) {
		$attr_options[ 'umb_pattr_' . $attributes_object->attribute_name ] = $attributes_object->attribute_label;
	}
}
if (isset($_POST['ced_facebook_settings_save_button'])) {

	if ( ! isset( $_POST['facebook_settings_actions'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['facebook_settings_actions'] ) ), 'facebook_settings' ) ) {
				return;
	}

	$global_settings_data = isset($_POST['ced_fmcw_profile_data']) ? $_POST['ced_fmcw_profile_data'] : array();
	update_option('ced_fmcw_global_settings', $global_settings_data);
	if (isset($_POST['ced_fmcw_profile_data']['ced_fmcw_product_sync']['value']) && '0' != $_POST['ced_fmcw_profile_data']['ced_fmcw_product_sync']['value']) {
		wp_clear_scheduled_hook( 'ced_fmcw_product_sync_scheduler_job' );
		wp_schedule_event( time(), sanitize_text_field( $_POST['ced_fmcw_profile_data']['ced_fmcw_product_sync']['value'] ), 'ced_fmcw_product_sync_scheduler_job');
	} else {
		wp_clear_scheduled_hook( 'ced_fmcw_product_sync_scheduler_job' );
	}
	if (isset($_POST['ced_fmcw_profile_data']['ced_fmcw_order_sync']['value']) && '0' != $_POST['ced_fmcw_profile_data']['ced_fmcw_order_sync']['value'] ) {
		wp_clear_scheduled_hook( 'ced_fmcw_order_sync_scheduler_job' );
		wp_schedule_event( time(), sanitize_text_field( $_POST['ced_fmcw_profile_data']['ced_fmcw_order_sync']['value'] ), 'ced_fmcw_order_sync_scheduler_job');
	} else {
		wp_clear_scheduled_hook( 'ced_fmcw_order_sync_scheduler_job' );
	}
}
$global_settings_data =  get_option('ced_fmcw_global_settings', array());
?>
<div class="ced_fmcw_loader">
	<img src="<?php echo esc_attr(CED_FMCW_URL) . 'admin/images/loading.gif'; ?>" width="50px" height="50px" class="ced_fmcw_category_loading_img" id="<?php echo 'ced_fmcw_category_loading_img_' . esc_attr($value->term_id); ?>">
</div>
<div class="ced-fmcw-wrapper-wrap">
	<div class="ced-fmcw-category-mapping-main-wrapper">
		<div class="ced_fmcw_configuration_heading_wrapper ced-fmcw-heading-wrapper">
			<h2 class="ced_fmcw_heading ced_fmcw_configuration_heading"> <?php esc_attr_e( 'Global Settings', 'facebook-marketplace-connector-for-woocommerce' ); ?> </h2>
		</div>
		<form method="post">
			<div id="ced_fmcw_accordians">
				<div class="ced_fmcw_facebook_panel">
					<div class="ced_fmcw_facebook_panel_heading">
						<h4><?php esc_attr_e('Product Availability Fields', 'facebook-marketplace-connector-for-woocommerce'); ?></h4>
					</div>
					<div class="ced_fmcw_facebook_collapse" style="display:block;">                       
						<div class="options_group ced_fmcw_facebook_label_data">
							<div  class="form-field ced_fmcw_availability_field ">
							 <?php $ced_fmcw_availability = isset($global_settings_data['ced_fmcw_availability']['value']) ? $global_settings_data['ced_fmcw_availability']['value'] : ''; ?>
							 <div class="ced_wmcw_leaf_node"><label><span><?php esc_attr_e( 'Availability', 'facebook-marketplace-connector-for-woocommerce' ); ?></span></label></div>
							 <div class="ced_wmcw_leaf_node"><select name=ced_fmcw_profile_data[ced_fmcw_availability][value] class="ced_fmcw_data_fields">
								<option value=""><?php esc_attr_e( '--Select--', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="in stock" 
								<?php 
								if ( 'in stock' == $ced_fmcw_availability ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'In Stock', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="out of stock" 
								<?php 
								if ( 'out of stock' == $ced_fmcw_availability ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Out of Stock', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="preorder" 
								<?php 
								if ( 'preorder' == $ced_fmcw_availability ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Pre Order', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="available for order" 
								<?php 
								if ( 'available for order' == $ced_fmcw_availability ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Available for Order', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="discontinued" 
								<?php 
								if ( 'discontinued' == $ced_fmcw_availability ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Discontinued', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="pending" 
								<?php 
								if ( 'pending' == $ced_fmcw_availability ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Pending', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
							</select></div>
						</div >
						<?php $ced_fmcw_agegrp = ''; ?>
						<?php $ced_fmcw_agegrp = isset($global_settings_data['ced_fmcw_agegrp']['value']) ? $global_settings_data['ced_fmcw_agegrp']['value'] : ''; ?>
						<div  class="ced_fmcw_agegrp_field form-field">
							<div class="ced_wmcw_leaf_node"><label><span><?php esc_attr_e( 'Preferred Age Group', 'facebook-marketplace-connector-for-woocommerce' ); ?></span></label></div>
							<div class="ced_wmcw_leaf_node"><select name=ced_fmcw_profile_data[ced_fmcw_agegrp][value] class="ced_fmcw_data_fields">
								<option value=""><?php esc_attr_e( '--Select--', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="newborn" 
								<?php 
								if ( 'newborn' == $ced_fmcw_agegrp ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'New Born', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="infant" 
								<?php 
								if ( 'infant' == $ced_fmcw_agegrp ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'infant', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="toddler" 
								<?php 
								if ( 'toddler' == $ced_fmcw_agegrp ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Toddler', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="kids" 
								<?php 
								if ( 'kids' == $ced_fmcw_agegrp ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Kids', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="adult" 
								<?php 
								if ( 'adult' == $ced_fmcw_agegrp ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Adult', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="all ages" 
								<?php 
								if ( 'all ages' == $ced_fmcw_agegrp ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'All Ages', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="teen" 
								<?php 
								if ( 'teen' == $ced_fmcw_agegrp ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Teen', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
							</select></div>
						</div >
						<?php $ced_fmcw_gender = ''; ?>
						<?php $ced_fmcw_gender = isset($global_settings_data['ced_fmcw_gender']['value']) ? $global_settings_data['ced_fmcw_gender']['value'] : ''; ?>
						<div  class="ced_fmcw_gender_field form-field">
							<div class="ced_wmcw_leaf_node"><label><span><?php esc_attr_e( 'Select Preferred Audience', 'facebook-marketplace-connector-for-woocommerce' ); ?></span></label></div>
							<div class="ced_wmcw_leaf_node"><select name=ced_fmcw_profile_data[ced_fmcw_gender][value] class="ced_fmcw_data_fields">
								<option value=""><?php esc_attr_e( '--Select--', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="male" 
								<?php 
								if ( 'male' == $ced_fmcw_gender ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Male', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="female" 
								<?php 
								if ( 'female' == $ced_fmcw_gender ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Female', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
								<option value="unisex" 
								<?php 
								if ( 'unisex' == $ced_fmcw_gender ) {
									echo 'selected';} 
								?>
								><?php esc_attr_e( 'Unisex', 'facebook-marketplace-connector-for-woocommerce' ); ?></option>
							</select></div>
						</div >
						<?php $ced_fmcw_brand = ''; ?>
						<?php $ced_fmcw_brand = isset($global_settings_data['ced_fmcw_brand']['value']) ? $global_settings_data['ced_fmcw_brand']['value'] : ''; ?>
						<div  class="ced_fmcw_color_field form-field">
							<div class="ced_wmcw_leaf_node"><label><span><?php esc_attr_e( 'Brand', 'facebook-marketplace-connector-for-woocommerce' ); ?></span></label></div>
							<div class="ced_wmcw_parent_leaf_node"><div class="ced_wmcw_leaf_node"><input type="text" class="ced_fmcw_data_fields" name=ced_fmcw_profile_data[ced_fmcw_brand][value] value="<?php echo esc_attr($ced_fmcw_brand); ?>"></input></div>
							<div class="ced_wmcw_leaf_node"><select id="ced_fmcw_profile_data[ced_fmcw_brand][metakey]" name="ced_fmcw_profile_data[ced_fmcw_brand][metakey]">
								<option value="null" selected> -- select -- </option>
								<?php
								$previous_selected_value = isset($global_settings_data['ced_fmcw_brand']['metakey']) ? $global_settings_data['ced_fmcw_brand']['metakey'] : '';
								if ( is_array( $attr_options ) ) {
									foreach ( $attr_options as $attr_key => $attr_name ) :
										if ( trim( $previous_selected_value == $attr_key ) ) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										?>
										<option value="<?php echo esc_attr( $attr_key ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_attr( $attr_name ); ?></option>
										<?php
									endforeach;
								}
								?>
							</select></div></div>
						</div >
						<?php $ced_fmcw_mpn = ''; ?>
						<?php $ced_fmcw_mpn = isset($global_settings_data['ced_fmcw_mpn']['value']) ? $global_settings_data['ced_fmcw_mpn']['value'] : ''; ?>
						<div  class="ced_fmcw_material_field form-field">
							<div class="ced_wmcw_leaf_node"><label><span><?php esc_attr_e( 'MPN', 'facebook-marketplace-connector-for-woocommerce' ); ?></span></label></div>
							<div class="ced_wmcw_parent_leaf_node"><div class="ced_wmcw_leaf_node"><input type="text" class="ced_fmcw_data_fields" name=ced_fmcw_profile_data[ced_fmcw_mpn][value] value="<?php echo esc_attr($ced_fmcw_mpn); ?>"></input></div>
							<div class="ced_wmcw_leaf_node"><select id="ced_fmcw_profile_data[ced_fmcw_mpn][metakey]" name="ced_fmcw_profile_data[ced_fmcw_mpn][metakey]">
								<option value="null" selected> -- select -- </option>
								<?php
								$previous_selected_value = isset($global_settings_data['ced_fmcw_mpn']['metakey']) ? $global_settings_data['ced_fmcw_mpn']['metakey'] : '';
								if ( is_array( $attr_options ) ) {
									foreach ( $attr_options as $attr_key => $attr_name ) :
										if ( trim( $previous_selected_value == $attr_key ) ) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										?>
										<option value="<?php echo esc_attr( $attr_key ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_attr( $attr_name ); ?></option>
										<?php
									endforeach;
								}
								?>
							</select></div></div>
						</div >
					</div>
				</div>
			</div>
			<div class="ced_fmcw_facebook_panel">
				<div class="ced_fmcw_facebook_panel_heading">
					<h4><?php esc_attr_e('Order Settings', 'facebook-marketplace-connector-for-woocommerce'); ?></h4>
				</div>
				<div class="ced_fmcw_facebook_collapse">
					<?php $ced_fmcw_product_sync = ''; ?>
					<?php $ced_fmcw_product_sync = isset($global_settings_data['ced_fmcw_product_sync']['value']) ? $global_settings_data['ced_fmcw_product_sync']['value'] : ''; ?>
					<div  class="ced_fmcw_gender_field form-field">
						<div class="ced_wmcw_leaf_node"><label><span><?php esc_attr_e( 'Select Product Sync frequency', 'facebook-marketplace-connector-for-woocommerce' ); ?></span></label></div>
						<div class="ced_wmcw_leaf_node"><select name=ced_fmcw_profile_data[ced_fmcw_product_sync][value] class="ced_fmcw_data_fields">
							<option <?php echo ( '0' == $ced_fmcw_product_sync ) ? 'selected' : ''; ?>  value="0"><?php esc_html_e( 'Disabled', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'daily' == $ced_fmcw_product_sync ) ? 'selected' : ''; ?>  value="daily"><?php esc_html_e( 'Daily', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'twicedaily' == $ced_fmcw_product_sync ) ? 'selected' : ''; ?>  value="twicedaily"><?php esc_html_e( 'Twice Daily', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'ced_fb_6min' == $ced_fmcw_product_sync ) ? 'selected' : ''; ?> value="ced_fb_6min"><?php esc_html_e( 'Every 6 Minutes', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'ced_fb_10min' == $ced_fmcw_product_sync ) ? 'selected' : ''; ?>  value="ced_fb_10min"><?php esc_html_e( 'Every 10 Minutes', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'ced_fb_15min' == $ced_fmcw_product_sync ) ? 'selected' : ''; ?>  value="ced_fb_15min"><?php esc_html_e( 'Every 15 Minutes', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'ced_fb_30min' == $ced_fmcw_product_sync ) ? 'selected' : ''; ?>  value="ced_fb_30min"><?php esc_html_e( 'Every 30 Minutes', 'ced-umb-fb' ); ?></option>
						</select></div>
					</div >

					<?php $ced_fmcw_order_sync = ''; ?>
					<?php $ced_fmcw_order_sync = isset($global_settings_data['ced_fmcw_order_sync']['value']) ? $global_settings_data['ced_fmcw_order_sync']['value'] : ''; ?>
					<div  class="ced_fmcw_gender_field form-field">
						<div class="ced_wmcw_leaf_node"><label><span><?php esc_attr_e( 'Select Order Sync frequency', 'facebook-marketplace-connector-for-woocommerce' ); ?></span></label></div>
						<div class="ced_wmcw_leaf_node"><select name=ced_fmcw_profile_data[ced_fmcw_order_sync][value] class="ced_fmcw_data_fields">
							<option <?php echo ( '0' == $ced_fmcw_order_sync ) ? 'selected' : ''; ?>  value="0"><?php esc_html_e( 'Disabled', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'daily' == $ced_fmcw_order_sync ) ? 'selected' : ''; ?>  value="daily"><?php esc_html_e( 'Daily', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'twicedaily' == $ced_fmcw_order_sync ) ? 'selected' : ''; ?>  value="twicedaily"><?php esc_html_e( 'Twice Daily', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'ced_fb_6min' == $ced_fmcw_order_sync ) ? 'selected' : ''; ?> value="ced_fb_6min"><?php esc_html_e( 'Every 6 Minutes', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'ced_fb_10min' == $ced_fmcw_order_sync ) ? 'selected' : ''; ?>  value="ced_fb_10min"><?php esc_html_e( 'Every 10 Minutes', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'ced_fb_15min' == $ced_fmcw_order_sync ) ? 'selected' : ''; ?>  value="ced_fb_15min"><?php esc_html_e( 'Every 15 Minutes', 'ced-umb-fb' ); ?></option>
							<option <?php echo ( 'ced_fb_30min' == $ced_fmcw_order_sync ) ? 'selected' : ''; ?>  value="ced_fb_30min"><?php esc_html_e( 'Every 30 Minutes', 'ced-umb-fb' ); ?></option>
						</select></div>
					</div >
				</div>
			</div>
		</div>
		<?php
			wp_nonce_field( 'facebook_settings', 'facebook_settings_actions' );
		?>
		<?php do_action( 'ced_fmcw_add_more_data_field_section' ); ?>
		<input type="submit" class="ced_fb_custom_button save_profile_button" name="ced_facebook_settings_save_button" value="Save Settings"></input>
	</form>
</div>
</div>
