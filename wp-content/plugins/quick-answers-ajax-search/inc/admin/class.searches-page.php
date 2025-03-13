<?php
/**
 * SearchesPage
 *
 * @package Quick_Answers
 */

namespace QA\Quick_Answers;

class Searches_Page {

	// class instance
	static $instance;

	// customer WP_List_Table object
	public $searches_obj;

	// class constructor
	public function __construct() {
		add_filter( 'set-screen-option', array( __CLASS__, 'set_screen' ), 10, 3 );
		add_action( 'admin_menu', array( $this, 'plugin_menu' ) );
	}


	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	public function plugin_menu() {

		$hook = add_submenu_page(
            'quick-answers-ajax-search',//$this->slug,
            esc_html__( 'Failed Searches', 'qa' ),
            esc_html__( 'Failed Searches', 'qa' ),
            'manage_options',
            'quick-answers-search-table',
            array( $this, 'settings_page' )
        );

		add_action( "load-$hook", array( $this, 'screen_option' ) );

	}


	/**
	 * Plugin settings page
	 */
	public function settings_page() {

		?>
		<div class="wrap">
			<h2>Quick Answers - Live Ajax Search Table</h2>
			<h2>Failed Searches</h2>

			<?php 
			
				if ( isset( $_REQUEST['s'] ) && strlen( $_REQUEST['s'] ) ) {
					echo '<span>';
					printf(
						/* translators: %s: Search query. */
						__( 'Search results for: %s' ),
						'<strong>' . $_REQUEST['s'] . '</strong>'
					);
					echo '</span>';
				}

			?>

			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">

							<?php if ( $this->searches_obj->all_items_count() > 0  ) : ?>
								<ul class="subsubsub">
									<li class="all"><a href="<?php echo admin_url( 'admin.php?page=quick-answers-search-table' ) ?>" class="qa-link" aria-current="page">All Searches <span class="count">(<?php echo \esc_attr( $this->searches_obj->all_items_count() ); ?>)</span></a></li>
								</ul>
							<?php endif; ?>

							<form id="searches-filter" method="get">
								
								<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
								<?php $this->searches_obj->prepare_items(); ?>

								<?php wp_enqueue_script( 'inline-edit-post' ); ?>
								<?php wp_enqueue_script( 'heartbeat' ); ?>

								<?php $this->searches_obj->search_box('Search', 'search'); ?>
								
								<?php $this->searches_obj->display(); ?>

							</form>

							<?php
							if ( $this->searches_obj->has_items() ) {
								$this->searches_obj->inline_edit();
							}
							?>

							<div id="ajax-response"></div>
							<div class="clear" /></div>
							
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>
		<?php
	}

	/**
	 * Screen options
	 */
	public function screen_option() {

		$option = 'per_page';
		$args   = array(
			'label'   => 'Failed Searches',
			'default' => 50,
			'option'  => 'searches_per_page',
		);

		add_screen_option( $option, $args );

		$this->searches_obj = new Searches_List();
	}


	/** Singleton instance */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}


add_action(
	'plugins_loaded',
	function () {
		Searches_Page::get_instance();
	}
);
