<?php
/**
 * Admin Options
 *
 * @package AF
 */

namespace AF\Article_Feedback;


class AF_Admin_Options {

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
    private $settings_key = 'af_settings';

    /**
     * Slug of the page, also used as identifier for hooks
     *
     * @var string
     */
    private $slug = 'article-feedback';

    /**
     * Options group id, will be used as identifier for adding fields to options page
     *
     * @var string
     */
    private $options_group_id = 'af-settings-group-id';

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
            self::$instance = new AF_Admin_Options();
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
            'post_types' => array(
                'id' => 'post_types',
                'title' => esc_html__( 'Display in post types', 'article-feedback' ),
                'sanitize' => 'checkbox',
                'default' => array()
            ),
            'position' => array(
                'id' => 'position',
                'title' => esc_html__( 'Display position', 'article-feedback' ),
                'sanitize' => 'radio',
                'default' => 'bellow'
            ),
            'title' => array(
                'id' => 'title',
                'title' => esc_html__( 'Title', 'article-feedback' ),
                'sanitize' => 'text',
                'default' => 'Was this article helpful?'
            ),
            'type' => array(
                'id' => 'type',
                'title' => esc_html__( 'Type', 'article-feedback' ),
                'sanitize' => 'radio',
                'default' => 'button'
            ),
            'button_yes' => array(
                'id' => 'button_yes',
                'title' => esc_html__( 'Label Yes', 'article-feedback' ),
                'sanitize' => 'text',
                'default' => 'Yes'
            ),
            'button_no' => array(
                'id' => 'button_no',
                'title' => esc_html__( 'Label No', 'article-feedback' ),
                'sanitize' => 'text',
                'default' => 'No'
            ),
            'icon_type' => array(
                'id' => 'icon_type',
                'title' => esc_html__( 'Icon Type', 'article-feedback' ),
                'sanitize' => 'radio',
                'default' => 'smiley'
            ),
            'hide_yes' => array(
                'id' => 'hide_yes',
                'title' => esc_html__( 'Hide Yes Label', 'article-feedback' ),
                'sanitize' => 'text',
                'default' => '0'
            ),
            'hide_no' => array(
                'id' => 'hide_no',
                'title' => esc_html__( 'Hide No Label', 'article-feedback' ),
                'sanitize' => 'text',
                'default' => '0'
            ),
            'thank_you' => array(
                'id' => 'thank_you',
                'title' => esc_html__( 'Thank You Message', 'article-feedback' ),
                'sanitize' => 'text',
                'default' => '<p>Thank you for your feedback.</p>'
            ),
            'not_satisfied' => array(
                'id' => 'not_satisfied',
                'title' => esc_html__( 'Not Satisfied Message', 'article-feedback' ),
                'sanitize' => 'text',
                'default' => '<strong>Yikes!</strong> <span>Could you please let us know how we can help?&nbsp;</span> <a class="af-response-button" href="#">Contact us</a>'
            ),
           
           

        );

        $fields = apply_filters( 'af_modify_options_fields', $fields );

        return $fields;

    }

    /* Add the plugin settings link */
    public function plugin_settings_link( $actions, $file ) {

        if ( $file != AF_BASE ) {
            return $actions;
        }

        $actions['af_settings'] = '<a href="' . esc_url( admin_url( 'options-general.php?page='.$this->slug ) ) . '" aria-label="settings"> '. __( 'Settings', 'article-feedback' ) . '</a>';

        return $actions;
    }


    /**
     * Add options page
     */
    public function add_plugin_page() {

        // This page will be under "Settings"
        add_options_page(
            esc_html__( 'Article Feedback', 'article-feedback' ),
            esc_html__( 'Article Feedback', 'article-feedback' ),
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

        $defaults = apply_filters( 'af_modify_defaults', $defaults );

        $options = get_option( $this->settings_key );

        $options = \wp_parse_args( $options, $defaults );

        $options = apply_filters( 'af_modify_options', $options );

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

        $section_id = 'af_section';

        add_settings_section( $section_id, '', '', $this->slug );

        foreach ( $this->fields as $field ) {

            if ( empty( $field['id'] ) ) {
                continue;
            }

            $action = 'print_' . $field['id'] . '_field';
            $callback = method_exists( $this, $action ) ? array( $this, $action ) : $field['action'];

            add_settings_field(
                'af_' . $field['id'] . '_id',
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
            // TODO: escape with wp_kses()
            if ( in_array( $field['id'], array( 'thank_you', 'not_satisfied' ) ) ) {
                $new_input[$field['id']] = $input[$field['id']];
                continue;
            }
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

            case "textarea":
                return $value;
                break;

            default:
                break;
        }
    }



    /**
     * Print post_types field
     */
    public function print_post_types_field( $args ) {

        $post_types = get_post_types(
			array(
				'public' => true, 
			), 
			'objects'
		);

        foreach ( $post_types as $slug => $type ) {

            if ( in_array( $type->name,  array( 'page', 'attachment' ) ) ) {
				continue;
			}

            $checked =  in_array( $slug, $args ) ? $slug : '';

            printf(
                '<label><input type="checkbox" name="%s[post_types][]" value="%s" %s/> %s</label><br>',
                $this->settings_key,
                $slug,
                checked( $checked, $slug, false ),
                $type->label
            );
        }

    }
        
    /**
     * Print position field
     */
    public function print_position_field( $position ) {

        printf(
            '<label><input type="radio" id="af-position-above" name="%s[position]" value="above" %s/>%s</label><br>',
            $this->settings_key,
            checked( $position, 'above', false ),
            __( 'Above' , 'article-feedback' )
        );
        printf(
            '<label><input type="radio" id="af-position-bellow" name="%s[position]" value="bellow" %s/>%s</label><br>',
            $this->settings_key,
            checked( $position, 'bellow', false ),
            __( 'Bellow' , 'article-feedback' )
        );
      
        printf(
            '<label><input type="radio" id="af-position-above_bellow" name="%s[position]" value="above_bellow" %s/>%s</label><br>',
            $this->settings_key,
            checked( $position, 'above_bellow', false ),
            __( 'Above and Bellow' , 'article-feedback' )
        );

    }

    /**
     * Print title field
     */
    public function print_title_field( $value ) {

        printf(
            '<input type="text" id="af-title" name="%s[title]" value="%s" />',
            $this->settings_key,
            $value
        );

    }

    /**
     * Print type field
     */
    public function print_type_field( $type ) {

        printf(
            '<label><input type="radio" id="af-type-button" name="%s[type]" value="button" %s/>%s</label><br>',
            $this->settings_key,
            checked( $type, 'button', false ),
            __( 'Button' , 'article-feedback' )
        );
        printf(
            '<label><input type="radio" id="af-type-icon" name="%s[type]" value="icon" %s/>%s</label><br>',
            $this->settings_key,
            checked( $type, 'icon', false ),
            __( 'Icon' , 'article-feedback' )
        );

    }

    /**
     * Print button yes field
     */
    public function print_button_yes_field( $value ) {

        printf(
            '<input type="text" id="af-button-label-yes" name="%s[button_yes]" value="%s" />',
            $this->settings_key,
            $value
        );

    }

    /**
     * Print button no field
     */
    public function print_button_no_field( $value ) {

        printf(
            '<input type="text" id="af-button-label-no" name="%s[button_no]" value="%s" />',
            $this->settings_key,
            $value
        );

    }

    /**
     * Print hide yes field
     */
    public function print_hide_yes_field( $value ) {

        printf(
            '<label>
                <input type="hidden" id="af-button-yes-hidden" name="%s[hide_yes]" value="0" />
                <input type="checkbox" id="af-button-yes" name="%s[hide_yes]" value="1" %s />
            </label>',
            $this->settings_key,
            $this->settings_key,
            checked( $value, '1', false )
        );

    }

    /**
     * Print hide no field
     */
    public function print_hide_no_field( $value ) {

        printf(
            '<label>
                <input type="hidden" id="af-button-no-hidden" name="%s[hide_no]" value="0" />
                <input type="checkbox" id="af-button-no" name="%s[hide_no]" value="1" %s />
            </label>',
            $this->settings_key,
            $this->settings_key,
            checked( $value, '1', false )
        );

    }

    /**
     * Print icon_type field
     */
    public function print_icon_type_field( $icon_type ) {

        printf(
            '<label class="af-icon-smiley"><input type="radio" id="af-type-smiley" name="%s[icon_type]" value="smiley" %s/>%s %s</label>',
            $this->settings_key,
            checked( $icon_type, 'smiley', false ),
            __( 'Smiley', 'article-feedback' ),
            file_get_contents( AF_URL . 'assets/image/smiley-happy.svg' )
        );
        printf(
            '<label class="af-icon-thumbs"><input type="radio" id="af-type-thumbs" name="%s[icon_type]" value="thumbs" %s/>%s %s</label>',
            $this->settings_key,
            checked( $icon_type, 'thumbs', false ),
            __( 'Thumbs', 'article-feedback' ),
            file_get_contents( AF_URL . 'assets/image/thumbs-up.svg' )
        );

    }

    /**
     * Print thank you field
     */
    public function print_thank_you_field( $value ) {

        printf(
            '<textarea type="text" id="af-thank-you-message" rows="3" style="width:%s" name="%s[thank_you]">%s</textarea><br>',
            '60%',
            $this->settings_key,
            $value
        );

    }

    /**
     * Print not_satisfied field
     */
    public function print_not_satisfied_field( $value ) {

        printf(
            '<textarea type="text" id="af-not-satisfied-message" rows="3" style="width:%s" name="%s[not_satisfied]">%s</textarea><br>',
            '60%',
            $this->settings_key,
            $value
        );

    }

}

AF_Admin_Options::get_instance();
