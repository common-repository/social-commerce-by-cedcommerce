<?php
/**
 * Display list of feeds
 *
 * @package  Woocommerce_Facebook_Integration
 * @version  1.0.0
 * @link     https://cedcommerce.com
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

$file = CED_FMCW_DIRPATH . 'admin/partials/ced-fmcw-header.php';
if ( file_exists( $file ) ) {
	include_once $file;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	include_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Ced_Facebook_Feed_Table
 *
 * @since 1.0.0
 */
class Ced_Facebook_Feed_Table extends WP_List_Table {

	/**
	 * Ced_Facebook_Feed_Table construct
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => __( 'Facebook Feed', 'woocommerce-fb-integration' ),
				'plural'   => __( 'Facebook Feeds', 'woocommerce-fb-integration' ),
				'ajax'     => false,
			)
		);

	}

	/**
	 * Function for preparing feed data to be displayed column
	 *
	 * @since 1.0.0
	 */
	public function prepareItems() {
		global $wpdb;

		$per_page = apply_filters( 'ced_fb_feed_list_per_page', 10 );
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->getSortableColumns();

		$this->_column_headers = array( $columns, $hidden, $sortable );

		$current_page = $this->get_pagenum();
		if ( 1 < $current_page ) {
			$offset = $per_page * ( $current_page - 1 );
		} else {
			$offset = 0;
		}

		$this->items = self::cedFacebookGetFeeds( $per_page, $current_page );
		$count       = self::getCount();

		$this->set_pagination_args(
			array(
				'total_items' => $count,
				'per_page'    => $per_page,
				'total_pages' => ceil( $count / $per_page ),
			)
		);

		if ( ! $this->current_action() ) {
			$this->items = self::cedFacebookGetFeeds( $per_page, $current_page );
			$this->renderHTML();
		} else {
			$this->process_bulk_action();
		}
	}

	/**
	 * Function for status column
	 *
	 * @since 1.0.0
	 * @param      int $per_page    Results per page.
	 * @param      int $page_number   Page number.
	 */
	public function cedFacebookGetFeeds( $per_page = 10, $page_number = 1 ) {
		global $wpdb;
		$offset       = ( $page_number - 1 ) * $per_page;
		$result       = get_option( 'ced_fmcw_all_product_feeds', array() );
		$return_value = array();
		foreach ($result as $key => $value) {
			foreach ($value as $k => $v) {
				$return_value[] = array('id' => $k,'type'=>$v['type'],'handle'=>$v['handle'],'date'=>$v['date'],'auth_page' =>$key);
			}
		}
		return $return_value;
	}

	/**
	 * Function to count number of responses in result
	 *
	 * @since 1.0.0
	 */
	public function getCount() {
		$result       = get_option( 'ced_fmcw_all_product_feeds', array() );
		$return_value = array();
		foreach ($result as $key => $value) {
			$return_value[] = $value;
		}
		return count($return_value);
	}

	/**
	 * Text displayed when no customer data is available
	 *
	 * @since 1.0.0
	 */
	public function no_items() {
		esc_html_e( 'No Feeds Created.', 'woocommerce-fb-integration' );
	}

	/**
	 * Function for name column
	 *
	 * @since 1.0.0
	 * @param array $item Feed Data.
	 */
	public function column_feed_name( $item ) {
		//print_r($item);
		$title        = '<strong>' . $item['handle'] . '</strong>';
		$request_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
		$actions      = array(
			'edit'   => sprintf( '<a href="?page=%s&section=%s&feedID=%s&auth_page=%s&panel=edit">Edit</a>', $request_page, 'feed-view', $item['handle'], $item['auth_page'] ),
			// 'delete' => sprintf( '<a href="?page=%s&section=%s&feedID=%s&panel=delete">Delete</a>', $request_page, 'feed-view', $item['handle'], 'bulk-delete' ),
		);
		return $title . $this->row_actions( $actions );
		//return $title;
	}

	/**
	 * Function for category column
	 *
	 * @since 1.0.0
	 * @param array $item Feed Data.
	 */
	public function column_woo_categories( $item ) {
		$woo_categories = json_decode( $item['woo_categories'], true );

		if ( ! empty( $woo_categories ) ) {
			foreach ( $woo_categories as $key => $value ) {
				$term = get_term_by( 'id', $value, 'product_cat' );
				if ( $term ) {
					echo '<p>' . esc_attr( $term->name ) . '</p>';
				}
			}
		}
	}

	/**
	 * Associative array of columns
	 *
	 * @since 1.0.0
	 */
	public function get_columns() {
		$columns = array(
			'feed_name'   => __( 'Feed Id', 'woocommerce-fb-integration' ),
		);
		$columns = apply_filters( 'ced_fb_alter_feeds_table_columns', $columns );
		return $columns;
	}


	/**
	 * Columns to make sortable.
	 *
	 * @since 1.0.0
	 */
	public function getSortableColumns() {
		 $sortable_columns = array();
		 return $sortable_columns;
	}

	/**
	 * Function to get changes in html
	 *
	 * @since 1.0.0
	 */
	public function renderHTML() {
		$shop_id = isset( $_GET['shop_id'] ) ? sanitize_text_field( wp_unslash( $_GET['shop_id'] ) ) : '';
		?>
		<div class="ced_fb_wrap ced_fb_wrap_extn">
				<div class="ced_fb_setting_header ">
					<b class="manage_labels"><?php esc_html_e( 'FACEBOOK FEEDS', 'woocommerce-fb-integration' ); ?></b>
				</div>          
			<div>

				<div id="post-body" class="metabox-holder columns-2">
					<div id="">
						<div class="meta-box-sortables ui-sortable">
							<form method="post">

								<?php
								wp_nonce_field( 'fb_feeds', 'fb_feeds_actions' );
								$this->display();
								?>
							</form>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<br class="clear">
			</div>
		</div>
		<?php
	}

	/**
	 * Function for getting current status
	 *
	 * @since 1.0.0
	 */
	public function current_action() {
		if ( isset( $_GET['panel'] ) ) {
			$action = isset( $_GET['panel'] ) ? sanitize_text_field( wp_unslash( $_GET['panel'] ) ) : '';
			return $action;
		} elseif ( isset( $_POST['action'] ) ) {

			if ( ! isset( $_POST['fb_feeds_actions'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fb_feeds_actions'] ) ), 'fb_feeds' ) ) {
				return;
			}

			$action = isset( $_POST['action'] ) ? sanitize_text_field( wp_unslash( $_POST['action'] ) ) : '';
			return $action;
		} elseif ( isset( $_POST['action2'] ) ) {

			if ( ! isset( $_POST['fb_feeds_actions'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fb_feeds_actions'] ) ), 'fb_feeds' ) ) {
				return;
			}

			$action = isset( $_POST['action2'] ) ? sanitize_text_field( wp_unslash( $_POST['action2'] ) ) : '';
			return $action;
		}
	}

	/**
	 * Function for processing bulk actions
	 *
	 * @since 1.0.0
	 */
	public function process_bulk_action() {
		if ( isset( $_GET['panel'] ) && 'edit' == $_GET['panel'] ) {
			$file = CED_FMCW_DIRPATH . 'admin/partials/single-feed-view.php';
			if ( file_exists( $file ) ) {
				include_once $file;
			}
		}
	}
}

$ced_fb_feed_obj = new Ced_Facebook_Feed_Table();
$ced_fb_feed_obj->prepareItems();
