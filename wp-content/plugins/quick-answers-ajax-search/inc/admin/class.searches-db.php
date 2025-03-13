<?php
/**
 * Searches_DB
 *
 * @package Quick_Answers
 */

namespace QA\Quick_Answers;


class Searches_DB {

	// class instance
	static $instance;

	/** Singleton instance */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/** Class constructor */
	public function __construct() {

		update_option( 'quick_answers_live_ajax_search_version', QA_VER );
		add_action( 'init', array( $this, 'create_table' ) );

	}

	public function create_table() {
		global $wpdb;
		
		if ( get_option( 'quick_answers_live_ajax_search_db_created' ) == 1 ) {
			return false;
		}

		$charset_collate = $wpdb->get_charset_collate();

		$create_table_query = "
				CREATE TABLE {$wpdb->prefix}searches (
				  id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
				  terms TEXT NOT NULL,
				  tags TEXT,
				  date TIMESTAMP NOT NULL
				) $charset_collate;
		";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $create_table_query );
		
		update_option( 'quick_answers_live_ajax_search_db_created', 1 );
	}


	public static function insert_searches( $data = [] ) {
		global $wpdb;

		if ( is_string( $data ) ) {
			$data = [ 'terms' => $data ];
		}

		$defaults = [
			'terms' => '', 
			'tags' => '', 
			'date' => date("Y-m-d H:i:s")
		];

		$data = wp_parse_args( $data, $defaults );
	
		$table_name = $wpdb->prefix . 'searches';
		
		$wpdb->insert( 
			$table_name, 
			array( 
				'terms' => $data['terms'], 
				'tags' => $data['tags'], 
				'date' => $data['date'], 
			) 
		);
	}

	public static function update_searches( $data = [] ) {
		global $wpdb;

		$defaults = [
			'terms' => '', 
			'tags' => '', 
			'date' => date("Y-m-d H:i:s")
		];

		$data = wp_parse_args( $data, $defaults );
	
		$table_name = $wpdb->prefix . 'searches';
		
		$wpdb->query( 
			$wpdb->prepare("UPDATE $table_name 
			SET terms=%s, tags=%s, date=%s 
			WHERE id=%s",
				$data['terms'], 
				$data['tags'], 
				$data['date'], 
				$data['id']
			)
		);
	}

}

Searches_DB::get_instance();
