<?php
class FacebookPlugin
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
			'Facebook',
			'manage_options',
			'facebook-plugin',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option( 'facebook-plugin' );
		?>
		<div class="wrap">
			<h1>Facebook Plugin</h1>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'facebook-plugin_configuration_group' );
				do_settings_sections( 'facebook-plugin-page' );
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
			'facebook-plugin_configuration_group', // Option group
			'facebook-plugin', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'facebook_setting_section', // ID
			'Konfiguracja Facebooka', // Title
			array( $this, 'print_section_info' ), // Callback
			'facebook-plugin-page' // Page
		);

		add_settings_field(
			'app_id', // ID
			'App ID', // Title
			array( $this, 'app_id_callback' ), // Callback
			'facebook-plugin-page', // Page
			'facebook_setting_section' // Section
		);

		add_settings_field(
			'url',
			'Url',
			array( $this, 'url_callback' ),
			'facebook-plugin-page',
			'facebook_setting_section'
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
		if( isset( $input['app_id'] ) )
			$new_input['app_id'] = sanitize_text_field( $input['app_id'] );

		if( isset( $input['url'] ) )
			$new_input['url'] = sanitize_text_field( $input['url'] );

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
	public function app_id_callback()
	{
		printf(
			'<input type="text" id="app_id" name="facebook-plugin[app_id]" value="%s" />',
			isset( $this->options['app_id'] ) ? esc_attr( $this->options['app_id']) : ''
		);
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function url_callback()
	{
		printf(
			'<input type="text" id="url" name="facebook-plugin[url]" value="%s" />',
			isset( $this->options['url'] ) ? esc_attr( $this->options['url']) : ''
		);
	}

}

if( is_admin() )
	$my_facebook_page = new FacebookPlugin();