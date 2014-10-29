<?php
/*
 * My Photon Settings
 */

class My_Photon_Settings {
	public $options_capability = 'manage_options';
	protected static $options = null;
	protected static $defaults = array(
		'active'   => false,
		'base-url' => '',
	);

	const SLUG = 'my-photon';

	protected static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new My_Photon_Settings;
			self::$instance->setup_actions();
		}
		return self::$instance;
	}

	protected function __construct() {
		/** Don't do anything **/
	}

	public static function get( $key = null, $default = null ) {
		if ( ! isset( self::$options ) ) {
			self::$options = get_option( self::SLUG, array() );
			self::$options = wp_parse_args( self::$options, self::$defaults );
		}

		if ( isset( $key ) ) {
			return ! empty( self::$options[ $key ] ) ? self::$options[ $key ] : $default;
		} else {
			return self::$options;
		}
	}

	protected function setup_actions() {
		add_action( 'admin_init', array( self::$instance, 'action_admin_init' ) );
		add_action( 'admin_menu', array( self::$instance, 'action_admin_menu' ) );
	}

	public function action_admin_init() {
		register_setting( self::SLUG, self::SLUG, array( self::$instance, 'sanitize_options' ) );
		add_settings_section( 'general', false, '__return_false', self::SLUG );
		add_settings_field( 'active', __( 'Activate My Photon', 'my-photon' ), array( self::$instance, 'field' ), self::SLUG, 'general', array( 'name' => 'active', 'type' => 'checkbox', 'label' => __( 'Active', 'my-photon' ) ) );
		add_settings_field( 'base-url', __( 'Base URL', 'my-photon' ), array( self::$instance, 'field' ), self::SLUG, 'general', array( 'name' => 'base-url' ) );
	}

	public function action_admin_menu() {
		add_options_page( __( 'My Photon Settings', 'my-photon' ), __( 'My Photon Settings', 'my-photon' ), $this->options_capability, self::SLUG, array( self::$instance, 'view_settings_page' ) );
	}

	public function field( $args ) {
		$args = wp_parse_args( $args, array(
			'name' => '',
			'type' => 'text',
			'label' => null,
		) );
		switch ( $args['type'] ) {
			case 'checkbox' :
				printf(
					'<label><input type="hidden" name="%1$s[%2$s]" value="0" /><input type="checkbox" name="%1$s[%2$s]" value="1" %3$s /> %4$s</label>',
					self::SLUG,
					esc_attr( $args['name'] ),
					checked( $this->get( $args['name'] ), true, false ),
					$args['label']
				);
				break;

			default :
				printf( '<input type="text" name="%s[%s]" value="%s" />', self::SLUG, esc_attr( $args['name'] ), esc_attr( $this->get( $args['name'] ) ) );
				break;
		}
	}

	public function sanitize_options( $in ) {
		$in = wp_parse_args( $in, self::$defaults );

		// Validate base-url
		$out['active'] = ( '1' == $in['active'] );
		$out['base-url'] = esc_url_raw( $in['base-url'] );
		return $out;
	}

	public function view_settings_page() {
	?><div class="wrap">
		<h2><?php esc_html_e( 'My Photon Settings', 'my-photon' ); ?></h2>
		<form action="options.php" method="POST">
			<?php settings_fields( self::SLUG ); ?>
			<?php do_settings_sections( self::SLUG ); ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
	}

}

function My_Photon_Settings() {
	return My_Photon_Settings::instance();
}
add_action( 'plugins_loaded', 'My_Photon_Settings' );
