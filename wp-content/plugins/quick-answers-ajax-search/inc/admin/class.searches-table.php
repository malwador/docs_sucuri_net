<?php
/**
 * Searches_List
 *
 * @package Quick_Answers
 */

namespace QA\Quick_Answers;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Searches_List extends \WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct(
			array(
				'singular' => __( 'Search', 'qa' ), // singular name of the listed records
				'plural'   => __( 'Searches', 'qa' ), // plural name of the listed records
				'ajax'     => false, // does this table support ajax?
			)
		);

	}


	/**
	 * Retrieve searches data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public static function get_searches( $per_page = 50, $page_number = 1 ) {

		global $wpdb;

		$sql = "SELECT * FROM {$wpdb->prefix}searches";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}

		if( ! empty( $_REQUEST['s'] ) ){
			$search = esc_sql( $_REQUEST['s'] );
			$sql .= " WHERE terms LIKE '%{$search}%' OR tags LIKE '%{$search}%'";
		}

		if( ! empty( $_REQUEST['qa_start_date'] ) &&  ! empty( $_REQUEST['qa_end_date'] ) ){
			$start_date = esc_sql( $_REQUEST['qa_start_date'] );
			$end_date = esc_sql( $_REQUEST['qa_end_date'] );
			$sql .= " WHERE date >= '$start_date' AND date <= '$end_date'";
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}


	/**
	 * Delete a customer record.
	 *
	 * @param int $id customer ID
	 */
	public static function delete_search_term( $id ) {
		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}searches",
			array( 'id' => $id ),
			array( '%d' )
		);
	}


	/**
	 * Returns the count of all items in database.
	 *
	 * @return null|string
	 */
	public static function all_items_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}searches";

		return $wpdb->get_var( $sql );
	}

	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}searches";

		if( ! empty( $_REQUEST['s'] ) ){
            $search = esc_sql( $_REQUEST['s'] );
            $sql .= " WHERE terms LIKE '%{$search}%' OR tags LIKE '%{$search}%'";
        }

		if( ! empty( $_REQUEST['qa_start_date'] ) &&  ! empty( $_REQUEST['qa_end_date'] ) ){
			$start_date = esc_sql( $_REQUEST['qa_start_date'] );
			$end_date = esc_sql( $_REQUEST['qa_end_date'] );
			$sql .= " WHERE date >= '$start_date' AND date <= '$end_date'";
		}

		return $wpdb->get_var( $sql );
	}


	/** Text displayed when no customer data is available */
	public function no_items() {
		_e( 'No searches avaliable.', 'qa' );
	}


	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array  $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'terms':
			case 'tags':
			case 'date':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ); // Show the whole array for troubleshooting purposes
		}
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />',
			$item['id']
		);
	}

	/**
	 * Searches item
	 *
	 * @param array $post
	 * @param int   $level
	 */
	public function single_row( $item, $level = 0 ) {
		?>
		<tr id="post-<?php echo $item['id']; ?>">
			<?php $this->single_row_columns( $item ); ?>
		</tr>
		<?php
	}

	/**
	 *
	 * @param array $item
	 * @param string  $classes
	 * @param string  $data
	 * @param string  $primary
	 */
	protected function _column_terms( $item, $classes, $data, $primary ) {
		echo '<td class="' . $classes . ' searches-title" ', $data, '>';
			echo $this->column_terms( $item );
			echo $this->handle_row_actions( $item, 'terms', $primary );
		echo '</td>';
	}


	/**
	 * Handles the searches / terms column output.
	 *
	 * @param object $item
	 */
	public function column_terms( $item ) {
		
		echo '<strong>';
			printf( '<span>%s</span>', $item['terms'] );
		echo '</strong>';
		
		$this->get_edit_data( $item );
	}


	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = array(
			'cb'       => '<input type="checkbox" />',
			'terms' => __( 'Searches', 'qa' ),
			'tags'     => __( 'Tags', 'qa' ),
			'date'     => __( 'Date', 'qa' ),
		);

		return $columns;
	}


	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'terms' => array( 'terms', true ),
			'tags' => array( 'tags', false ),
			'date' => array( 'date', false ),
		);

		return $sortable_columns;
	}

	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = array(
			'bulk-delete' => 'Delete',
		);

		return $actions;
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {
		
		$this->_column_headers = $this->get_column_info();

		/** Process bulk action */
		$this->process_bulk_action();


		$per_page     = $this->get_items_per_page( 'searches_per_page', 50 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args(
			array(
				'total_items' => $total_items, // WE have to calculate the total number of items
				'per_page'    => $per_page, // WE have to determine how many items to show on a page
			)
		);

		$this->items = self::get_searches( $per_page, $current_page );
	}

	/**
	 * Handles bulk and trash actions.
	 */
	public function process_bulk_action() {

		// If the delete bulk action is triggered
		if ( ( isset( $_GET['action'] ) && $_GET['action'] == 'bulk-delete' ) ) {

			$delete_ids = esc_sql( $_GET['bulk-delete'] );

			foreach ( $delete_ids as $id ) {
				self::delete_search_term( $id );
			}
	
			//wp_redirect( esc_url_raw( add_query_arg( NULL, NULL ) ) );
			$paged = isset( $_GET['paged'] ) && absint( $_GET['paged'] ) > 1 ? '&paged=' . $_GET['paged'] : '';
			wp_redirect( admin_url( 'admin.php?page=quick-answers-search-table' . $paged ) );
			
			exit;
		}


		if ( ( isset( $_GET['action'] ) && $_GET['action'] == 'trash' ) ) {
			
			$delete_id = esc_sql( $_GET['searches'] );
			self::delete_search_term( $delete_id );

			$paged = isset( $_GET['paged'] ) && absint( $_GET['paged'] ) > 1  ? '&paged=' . $_GET['paged'] : '';
			wp_redirect( admin_url( 'admin.php?page=quick-answers-search-table' . $paged ) );

			exit;
		}
		
	}

	/**
	 * Generates and displays row action links.
	 *
	 * @since 4.3.0
	 *
	 * @param WP_Post $post        Post being acted upon.
	 * @param string  $column_name Current column name.
	 * @param string  $primary     Primary column name.
	 * @return string Row actions output for posts, or an empty string
	 *                if the current column is not the primary column.
	 */
	protected function handle_row_actions( $item, $column_name, $primary ) {
		
		if ( $primary !== $column_name ) {
			return '';
		}

		$can_edit_post    = current_user_can( 'manage_options' );
		$actions          = array();
		$title 			  = _draft_or_post_title();

		
		$actions['inline hide-if-no-js'] = sprintf(
			'<button type="button" class="button-link editinline" aria-label="%s" aria-expanded="false">%s</button>',
			/* translators: %s: Post title. */
			esc_attr( sprintf( __( 'Quick Edit &#8220;%s&#8221; inline' ), $title ) ),
			__( 'Quick Edit' )
		);
	

		$delete_nonce = wp_create_nonce( 'qa_delete_search_term' );

		if ( current_user_can( 'manage_options' ) ) {

			$paged = '';
			if ( ( isset( $_GET['paged'] ) && $_GET['paged'] > 1 ) ) {
				$paged = '&paged='.absint( $_GET['paged'] );
			}
			
			$actions['trash'] = sprintf( '<a href="?page=%s%s&action=%s&searches=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), $paged, 'trash', absint( $item['id'] ), $delete_nonce );
			
		}

		
		$actions = apply_filters( 'qa_row_actions', $actions, $item );
		
		return $this->row_actions( $actions );
	}

	/**
	 * Extra controls to be displayed between bulk actions and pagination.
	 *
	 *
	 * @param string $which
	 */
	protected function extra_tablenav( $which ) {

		if ( count($this->items) < 1 ) {
			return;
		}

		if ( $which != 'top' ) {
			return;
		}


		?>	
			<input id="qa-start-date" class="qa-date-field" name="qa_start_date" size="12" type="text" value="" placeholder="Start Date"  autocomplete="off" aria-expanded="false"/>
			<input id="qa-end-date" class="qa-date-field" name="qa_end_date" size="12" type="text" value="" placeholder="End Date" autocomplete="off" aria-expanded="false"/>
			<input type="submit" id="date-action" class="button date-action" value="Filter by Date">
		<?php
		
	}

	/**
	 * Adds hidden fields with the data for use in the inline editor.
	 *
	 * @param object $item
	 */
	public function get_edit_data( $item ) {
		
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		echo '
		<div class="hidden" id="inline_' . $item['id'] . '">
			<div class="post_title">' . $item['terms'] . '</div>
			<div class="jj">' . mysql2date( 'd', $item['date'], false ) . '</div>
			<div class="mm">' . mysql2date( 'm', $item['date'], false ) . '</div>
			<div class="aa">' . mysql2date( 'Y', $item['date'], false ) . '</div>
			<div class="hh">' . mysql2date( 'H', $item['date'], false ) . '</div>
			<div class="mn">' . mysql2date( 'i', $item['date'], false ) . '</div>
			<div class="ss">' . mysql2date( 's', $item['date'], false ) . '</div>
			<div class="tags_input" id="post_tag_'.$item['id'] .'">'. $item['tags'] . '</div>';
		echo '</div>';
	}

	/**
	 * Outputs the hidden row displayed when inline editing
	 *
	 * @since 3.1.0
	 *
	 * @global string $mode List table view mode.
	 */
	public function inline_edit() {
		global $mode;

		$screen = $this->screen;

		$core_columns = array(
			'cb'         => true,
			'terms'       => true,
			'tags'      => true,
			'date' => true,
		);

		?>

		<form method="get">
			<table style="display: none"><tbody id="inlineedit">

				<?php
				$inline_edit_classes = "inline-edit-row inline-edit-row-post";
				$bulk_edit_classes   = "bulk-edit-row bulk-edit-row-post bulk-edit-post";
				$quick_edit_classes  = "quick-edit-row quick-edit-row-post inline-edit-searches";

				$bulk = 0;
				while ( $bulk < 2 ) :
					$classes  = $inline_edit_classes . ' ';
					$classes .= $bulk ? $bulk_edit_classes : $quick_edit_classes;
					?>
					<tr id="<?php echo $bulk ? 'bulk-edit' : 'inline-edit'; ?>" class="<?php echo $classes; ?>" style="display: none">
					<td colspan="<?php echo $this->get_column_count(); ?>" class="colspanchange">

					<fieldset class="inline-edit-col-left">
						<legend class="inline-edit-legend"><?php echo $bulk ? __( 'Bulk Edit' ) : __( 'Quick Edit' ); ?></legend>
						<div class="inline-edit-col">

							<label>
								<span class="title"><?php _e( 'Searches' ); ?></span>
								<span class="input-text-wrap"><input type="text" name="post_title" class="ptitle" value="" /></span>
							</label>

						
							<fieldset class="inline-edit-date">
								<br>
								<legend><span class="title"><?php _e( 'Date' ); ?></span></legend>
								<?php $this->qa_touch_time( 1, 1, 0, 1 ); ?>
							</fieldset>
							<br class="clear" />

						</div>
					</fieldset>

					
					<fieldset class="inline-edit-col-right">
						<div class="inline-edit-col">

							<label class="inline-edit-tags">
								<span class="title">Tags</span>
								<!-- <textarea data-wp-taxonomy="post_tag" cols="22" rows="1" name="tax_input[post_tag]" class="tags tax_input_post_tag" aria-expanded="false"></textarea> -->
								<textarea data-wp-taxonomy="post_tag" cols="22" rows="1" name="tax_input[post_tag]" class="tax_input_post_tag ui-autocomplete-input" autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false"></textarea>
							</label>

						</div>
					</fieldset>


					<div class="submit inline-edit-save">
						<button type="button" class="button cancel alignleft"><?php _e( 'Cancel' ); ?></button>

						<?php if ( ! $bulk ) : ?>
							<?php //wp_nonce_field( 'inlineeditnonce', '_inline_edit', false ); ?>
							<button type="button" class="button button-primary update alignright"><?php _e( 'Update' ); ?></button>
							<span class="spinner"></span>
						<?php else : ?>
							<?php submit_button( __( 'Update' ), 'primary alignright', 'bulk_edit', false ); ?>
						<?php endif; ?>

						<br class="clear" />

						<div class="notice notice-error notice-alt inline hidden">
							<p class="error"></p>
						</div>
					</div>

					</td></tr>

					<?php

					$bulk++;
				endwhile;

				?>
			</tbody></table>
		</form>
		<?php
	}


	/**
	 * Print out HTML form date elements for editing post or comment publish date.
	 *
	 * @since 0.71
	 * @since 4.4.0 Converted to use get_comment() instead of the global `$comment`.
	 *
	 * @global WP_Locale $wp_locale WordPress date and time locale object.
	 *
	 * @param int|bool $edit      Accepts 1|true for editing the date, 0|false for adding the date.
	 * @param int|bool $for_post  Accepts 1|true for applying the date to a post, 0|false for a comment.
	 * @param int      $tab_index The tabindex attribute to add. Default 0.
	 * @param int|bool $multi     Optional. Whether the additional fields and buttons should be added.
	 *                            Default 0|false.
	 */
	public function qa_touch_time( $edit = 1, $for_post = 1, $tab_index = 0, $multi = 0 ) {
		global $wp_locale;
	
		$jj        =  current_time( 'd' );
		$mm        =  current_time( 'm' );
		$aa        = current_time( 'Y' );
		$hh        =  current_time( 'H' );
		$mn        =  current_time( 'i' );
		$ss        =  current_time( 's' );

		$cur_jj = current_time( 'd' );
		$cur_mm = current_time( 'm' );
		$cur_aa = current_time( 'Y' );
		$cur_hh = current_time( 'H' );
		$cur_mn = current_time( 'i' );

		$tab_index_attribute = '';

		$month = '<label><span class="screen-reader-text">' . __( 'Month' ) . '</span><select class="form-required" ' . ( $multi ? '' : 'id="mm" ' ) . 'name="mm"' . $tab_index_attribute . ">\n";

		for ( $i = 1; $i < 13; $i = $i + 1 ) {
			$monthnum  = zeroise( $i, 2 );
			$monthtext = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
			$month    .= "\t\t\t" . '<option value="' . $monthnum . '" data-text="' . $monthtext . '" ' . selected( $monthnum, $mm, false ) . '>';
			/* translators: 1: Month number (01, 02, etc.), 2: Month abbreviation. */
			$month .= sprintf( __( '%1$s-%2$s' ), $monthnum, $monthtext ) . "</option>\n";
		}
		$month .= '</select></label>';

		$day    = '<label><span class="screen-reader-text">' . __( 'Day' ) . '</span><input type="text" ' . ( $multi ? '' : 'id="jj" ' ) . 'name="jj" value="' . $jj . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" class="form-required" /></label>';
		$year   = '<label><span class="screen-reader-text">' . __( 'Year' ) . '</span><input type="text" ' . ( $multi ? '' : 'id="aa" ' ) . 'name="aa" value="' . $aa . '" size="4" maxlength="4"' . $tab_index_attribute . ' autocomplete="off" class="form-required" /></label>';
		$hour   = '<label><span class="screen-reader-text">' . __( 'Hour' ) . '</span><input type="text" ' . ( $multi ? '' : 'id="hh" ' ) . 'name="hh" value="' . $hh . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" class="form-required" /></label>';
		$minute = '<label><span class="screen-reader-text">' . __( 'Minute' ) . '</span><input type="text" ' . ( $multi ? '' : 'id="mn" ' ) . 'name="mn" value="' . $mn . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" class="form-required" /></label>';

		echo '<div class="timestamp-wrap">';
		/* translators: 1: Month, 2: Day, 3: Year, 4: Hour, 5: Minute. */
		printf( __( '%1$s %2$s, %3$s at %4$s:%5$s' ), $month, $day, $year, $hour, $minute );

		echo '</div><input type="hidden" id="ss" name="ss" value="' . $ss . '" />';

		if ( $multi ) {
			return;
		}

		echo "\n\n";

		$map = array(
			'mm' => array( $mm, $cur_mm ),
			'jj' => array( $jj, $cur_jj ),
			'aa' => array( $aa, $cur_aa ),
			'hh' => array( $hh, $cur_hh ),
			'mn' => array( $mn, $cur_mn ),
		);

		foreach ( $map as $timeunit => $value ) {
			list( $unit, $curr ) = $value;

			echo '<input type="hidden" id="hidden_' . $timeunit . '" name="hidden_' . $timeunit . '" value="' . $unit . '" />' . "\n";
			$cur_timeunit = 'cur_' . $timeunit;
			echo '<input type="hidden" id="' . $cur_timeunit . '" name="' . $cur_timeunit . '" value="' . $curr . '" />' . "\n";
		}
		?>

	<p>
	<a href="#edit_timestamp" class="save-timestamp hide-if-no-js button"><?php _e( 'OK' ); ?></a>
	<a href="#edit_timestamp" class="cancel-timestamp hide-if-no-js button-cancel"><?php _e( 'Cancel' ); ?></a>
	</p>
		<?php
	}

}
