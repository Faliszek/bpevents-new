<?php
class Mailer
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            'SMTP',
            'manage_options',
            'smtp-email',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'smtp_configuration' );
        ?>
        <div class="wrap">
            <h1>SMTP</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'smtp_configuration_group' );
                do_settings_sections( 'smtp-email' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'smtp_configuration_group', // Option group
            'smtp_configuration', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Konfiguracja poczty', // Title
            array( $this, 'print_section_info' ), // Callback
            'smtp-email' // Page
        );

        add_settings_field(
            'host', // ID
            'Host', // Title
            array( $this, 'host_callback' ), // Callback
            'smtp-email', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'port',
            'Port',
            array( $this, 'port_callback' ),
            'smtp-email',
            'setting_section_id'
        );

        add_settings_field(
            'login',
            'Login',
            array( $this, 'login_callback' ),
            'smtp-email',
            'setting_section_id'
        );

        add_settings_field(
            'password',
            'Hasło',
            array( $this, 'pass_callback' ),
            'smtp-email',
            'setting_section_id'
        );

        add_settings_field(
            'hash',
            'Szyforwanie',
            array( $this, 'hash_callback' ),
            'smtp-email',
            'setting_section_id'
        );

        add_settings_field(
            'name',
            'Imie',
            array( $this, 'name_callback' ),
            'smtp-email',
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['host'] ) )
            $new_input['host'] = sanitize_text_field( $input['host'] );

        if( isset( $input['port'] ) )
            $new_input['port'] = absint( $input['port'] );

        if( isset( $input['login'] ) )
            $new_input['login'] = sanitize_text_field( $input['login'] );

        if( isset( $input['password'] ) ){
            $new_input['password'] = sanitize_text_field($input['password']);
        }

        if( isset( $input['hash'] ) )
            $new_input['hash'] = sanitize_text_field( $input['hash'] );

        if( isset( $input['name'] ) )
            $new_input['name'] = sanitize_text_field( $input['name'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function host_callback()
    {
        printf(
            '<input type="text" id="host" name="smtp_configuration[host]" value="%s" />',
            isset( $this->options['host'] ) ? esc_attr( $this->options['host']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function port_callback()
    {
        printf(
            '<input type="text" id="port" name="smtp_configuration[port]" value="%s" />',
            isset( $this->options['port'] ) ? esc_attr( $this->options['port']) : ''
        );
    }

    public function login_callback()
    {
        printf(
            '<input type="text" id="login" name="smtp_configuration[login]" value="%s" />',
            isset( $this->options['login'] ) ? esc_attr( $this->options['login']) : ''
        );
    }


    public function pass_callback()
    {
        printf(
            '<input type="password" id="password" name="smtp_configuration[password]" />',
            isset( $this->options['password'] ) ? esc_attr( $this->options['password']) : ''
        );
    }

    public function hash_callback()
    {
        printf(
            '<input type="hash" id="hash" name="smtp_configuration[hash]" value="%s"/>',
            isset( $this->options['hash'] ) ? esc_attr( $this->options['hash']) : ''
        );
    }

    public function name_callback()
    {
        printf(
            '<input type="text" id="name" name="smtp_configuration[name]" value="%s"/>',
            isset( $this->options['name'] ) ? esc_attr( $this->options['name']) : ''
        );
    }

    public static function getAdminMail(){
      return get_option('smtp_configuration')['login'];
    }

}

if( is_admin() )
    $my_settings_page = new Mailer();