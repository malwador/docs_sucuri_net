<?php
/**
 * Admin Options
 *
 * @package Quick_Answers
 */

namespace QA\Quick_Answers;


class QA_Admin_Options {

    /**
     *  Hold the class instance.
     */
    private static $instance = null;

    /**
     * Holds the values to be used in the fields callbacks
     */
    public $options;

    /**
     * Settings key in database, used in get_option() as first parameter
     *
     * @var string
     */
    private $settings_key = 'qa_settings';

    /**
     * Slug of the page, also used as identifier for hooks
     *
     * @var string
     */
    private $slug = 'quick-answers-ajax-search';

    /**
     * Options group id, will be used as identifier for adding fields to options page
     *
     * @var string
     */
    private $options_group_id = 'qa-settings-group-id';

    /**
     * Array of all fields that will be printed on the settings page
     *
     * @var array
     */

    public $fields;



    /**
     * Start up
     */
    public function __construct() {

        add_action( 'init', array( $this, 'set_fields_and_options' ) );
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        
        add_filter( 'plugin_action_links', array( $this, 'plugin_settings_link' ), 10, 2 );

    }

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new QA_Admin_Options();
        }
        return self::$instance;
    }

    public function set_fields_and_options() {
        $this->fields = $this->get_fields();
        $this->options = $this->get_options();
    }

    /* Load translation file */
    

    /* Get fields data */
    public function get_fields() {

        $fields = array(
            'search_characters' => array(
                'id' => 'search_characters',
                'title' => esc_html__( 'Initialize search after (number of characters)', 'qa' ),
                'sanitize' => 'text',
                'default' => '3'
            ),
            'description' => array(
                'id' => 'description',
                'title' => esc_html__( 'Display description in search results', 'qa' ),
                'sanitize' => 'text',
                'default' => 0
            ),
            'description_limit' => array(
                'id' => 'description_limit',
                'title' => esc_html__( 'Description limit', 'qa' ),
                'sanitize' => 'text',
                'default' => '180'
            ),
            'no_results' => array(
                'id' => 'no_results',
                'title' => esc_html__( 'No results found', 'qa' ),
                'sanitize' => 'text',
                'default' => 'No results found. Please try again with a different search term.'
            ),
            'include_types' => array(
                'id' => 'include_types',
                'title' => esc_html__( 'Include in search results', 'qa' ),
                'sanitize' => 'checkbox',
                'default' => array( 'post', 'page' )
            )

        );

        $fields = apply_filters( 'qa_modify_options_fields', $fields );

        return $fields;

    }

    /* Add the plugin settings link */
    public function plugin_settings_link( $actions, $file ) {

        if ( $file != QA_BASE ) {
            return $actions;
        }

        $actions['qa_settings'] = '<a href="' . esc_url( admin_url( 'options-general.php?page='.$this->slug ) ) . '" aria-label="settings"> '. __( 'Settings', 'qa' ) . '</a>';

        return $actions;
    }


    /**
     * Add options page
     */
    public function add_plugin_page() {

       // add_menu_page( 'Quick Answers - Live Ajax Search', 'Quick Answers - Live Ajax Search', $menu_slug, false );
        add_menu_page(
            esc_html__( 'Quick Answers - Live Ajax Search', 'qa' ),
            esc_html__( 'Live Ajax Search', 'qa' ),
            'manage_options',
            $this->slug,
            false
        );
        add_submenu_page(
            $this->slug,
            esc_html__( 'Quick Answers - Live Ajax Search', 'qa' ),
            esc_html__( 'Settings', 'qa' ),
            'manage_options',
            $this->slug,
            array( $this, 'print_settings_page' )
        );
    }

    /**
     * Get options from database
     */
    private function get_options() {

        $defaults = array();

        foreach ( $this->fields as $field => $args ) {
            $defaults[$field] = $args['default'];
        }

        $defaults = apply_filters( 'qa_modify_defaults', $defaults );

        $options = get_option( $this->settings_key );

        $options = \wp_parse_args( $options, $defaults );

        $options = apply_filters( 'qa_modify_options', $options );

        //print_r( $options );

        return $options;

    }

    /**
     * Options page callback
     */
    public function print_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form method="post" action="options.php"> 
                <?php
                settings_fields( $this->options_group_id );
                do_settings_sections( $this->slug );
                submit_button(); 
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {

        register_setting(
            $this->options_group_id, // Option group
            $this->settings_key, // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        if ( empty( $this->fields ) ) {
            return false;
        }

        $section_id = 'qa_section';

        add_settings_section( $section_id, '', '', $this->slug );

        foreach ( $this->fields as $field ) {

            if ( empty( $field['id'] ) ) {
                continue;
            }

            $action = 'print_' . $field['id'] . '_field';
            $callback = method_exists( $this, $action ) ? array( $this, $action ) : $field['action'];

            add_settings_field(
                'qa_' . $field['id'] . '_id',
                $field['title'],
                $callback,
                $this->slug,
                $section_id,
                $this->options[$field['id']]
            );
        }

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param unknown $input array $input Contains all settings fields as array keys
     * @return mixed
     */
    public function sanitize( $input ) {

        if ( empty( $this->fields ) || empty( $input ) ) {
            return false;
        }

        $new_input = array();
        foreach ( $this->fields as $field ) {
            if ( isset( $input[$field['id']] ) ) {
                $new_input[$field['id']] = $this->sanitize_field( $input[$field['id']], $field['sanitize'] );
            }
        }

        return $new_input;
    }

    /**
     * Dynamically sanitize field values
     *
     * @param unknown $value
     * @param unknown $sensitization_type
     * @return int|string
     */
    private function sanitize_field( $value, $sensitization_type ) {
        switch ( $sensitization_type ) {

        case "checkbox":
            $sanitized_array = [];
            foreach ( $value as $key => $val ) {
                $sanitized_array[$key] = ( isset( $value[$key] ) ) ?
                    sanitize_text_field( $val ) :
                    '';
            }
            return $sanitized_array;
            break;

        case "radio":
            return sanitize_text_field( $value );
            break;

        case "text":
            return sanitize_text_field( $value );
            break;

        default:
            break;
        }
    }


    /**
     * Print search characters field
     */
    public function print_search_characters_field( $search_characters ) {

        printf(
            '<label><input type="number" id="qa-search-characters" name="%s[search_characters]" value="%s"/></label><br>',
            $this->settings_key,
            absint( $search_characters )
        );

    }


    /**
     * Print description field
     */
    public function print_description_field( $description ) {

            printf(
                '<label>
                    <input type="hidden" id="qa-description-hidden" name="%s[description]" value="0" />
                    <input type="checkbox" id="qa-description" name="%s[description]" value="1" %s/>
                </label>',
                $this->settings_key,
                $this->settings_key,
                checked( $description, '1', false )
            );

    }

    /**
     * Print description limit field
     */
    public function print_description_limit_field( $description_limit ) {

            printf(
                '<label><input type="number" id="qa-description-limit" name="%s[description_limit]" value="%s"/></label><br>',
                $this->settings_key,
                absint( $description_limit )
            );

    }

    /**
     * Print no results field
     */
    public function print_no_results_field( $value ) {

            printf(
                '<textarea type="text" id="qa-no-results-found" rows="3" style="width:%s" name="%s[no_results]">%s</textarea><br>',
                '60%',
                $this->settings_key,
                $value
            );

    }

     /**
     * Print description field
     */
    public function print_include_types_field( $include_types ) {

        $post_types = get_post_types(
			array(
				'public' => true, 
				'exclude_from_search' => false
			), 
			'objects'
		);

        foreach ( $post_types as $slug => $type ) {

            if ( $type->name === 'attachment' ) {
				continue;
			}

            $checked =  in_array( $slug, $include_types ) ? $slug : '';

            printf(
                '<label><input type="checkbox" name="%s[include_types][]" value="%s" %s/> %s</label><br>',
                $this->settings_key,
                $slug,
                checked( $checked, $slug, false ),
                $type->label
            );
        }

}

}

QA_Admin_Options::get_instance();
