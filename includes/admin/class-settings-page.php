<?php
/**
 * Admin settings page for selecting the landing page.
 *
 * @package Landing_Page
 */

namespace Landing_Page\Admin;

/**
 * Registers a Settings > Landing Page screen.
 */
class Settings_Page {
	public const OPTION_NAME = LANDING_PAGE_OPTION_NAME;

	/**
	 * Slug for the settings page.
	 *
	 * @var string
	 */
	private $page_slug = 'landing-page-settings';

	/**
	 * Hooks registration callbacks.
	 */
	public function __construct() {
		\add_action( 'admin_menu', [ $this, 'register_settings_page' ] );
		\add_action( 'admin_init', [ $this, 'register_settings' ] );
		\add_filter( 'display_post_states', [ $this, 'add_landing_page_state' ], 10, 2 );
		\add_filter( 'page_row_actions', [ $this, 'add_landing_page_row_action' ], 10, 2 );
	}

	/**
	 * Adds the option page under Settings.
	 */
	public function register_settings_page(): void {
		\add_options_page(
			\__( 'Landing Page', 'landing-page' ),
			\__( 'Landing Page', 'landing-page' ),
			'manage_options',
			$this->page_slug,
			[ $this, 'render_settings_page' ]
		);
	}

	/**
	 * Register the option, section, and field.
	 */
	public function register_settings(): void {
		\register_setting(
			$this->page_slug,
			self::OPTION_NAME,
			[
				'type'              => 'integer',
				'sanitize_callback' => [ $this, 'sanitize_page_id' ],
				'description'       => \__( 'Selected landing page ID.', 'landing-page' ),
				'default'           => 0,
			]
		);

		\register_setting(
			$this->page_slug,
			LANDING_PAGE_STRIP_CSS_MODE_OPTION,
			[
				'type'              => 'string',
				'sanitize_callback' => [ $this, 'sanitize_strip_mode' ],
				'description'       => \__( 'Landing page CSS stripping mode.', 'landing-page' ),
				'default'           => 'none',
			]
		);

		\register_setting(
			$this->page_slug,
			LANDING_PAGE_STRIP_CSS_HANDLES_OPTION,
			[
				'type'              => 'string',
				'sanitize_callback' => [ $this, 'sanitize_handles' ],
				'description'       => \__( 'CSS handles list for stripping or exceptions.', 'landing-page' ),
				'default'           => '',
			]
		);

		\register_setting(
			$this->page_slug,
			LANDING_PAGE_STRIP_JS_MODE_OPTION,
			[
				'type'              => 'string',
				'sanitize_callback' => [ $this, 'sanitize_strip_mode' ],
				'description'       => \__( 'Landing page JS stripping mode.', 'landing-page' ),
				'default'           => 'none',
			]
		);

		\register_setting(
			$this->page_slug,
			LANDING_PAGE_STRIP_JS_HANDLES_OPTION,
			[
				'type'              => 'string',
				'sanitize_callback' => [ $this, 'sanitize_handles' ],
				'description'       => \__( 'JS handles list for stripping or exceptions.', 'landing-page' ),
				'default'           => '',
			]
		);

		\add_settings_section(
			'landing_page_section',
			\__( 'Configuration', 'landing-page' ),
			function () {
				echo '<p>' . \esc_html__( 'Choose which page should be treated as the landing page.', 'landing-page' ) . '</p>';
			},
			$this->page_slug
		);

		\add_settings_field(
			'landing_page_page_selector',
			\__( 'Landing Page', 'landing-page' ),
			[ $this, 'render_page_selector' ],
			$this->page_slug,
			'landing_page_section'
		);

		\add_settings_field(
			'landing_page_css_stripping',
			\__( 'CSS Stripping', 'landing-page' ),
			[ $this, 'render_css_strip_field' ],
			$this->page_slug,
			'landing_page_section'
		);

		\add_settings_field(
			'landing_page_js_stripping',
			\__( 'JS Stripping', 'landing-page' ),
			[ $this, 'render_js_strip_field' ],
			$this->page_slug,
			'landing_page_section'
		);
	}

	/**
	 * Sanitize the selected page ID.
	 *
	 * @param mixed $value Raw submitted value.
	 *
	 * @return int
	 */
	public function sanitize_page_id( $value ): int {
		$page_id = absint( $value );

		if ( 0 === $page_id ) {
			return 0;
		}

		return \get_post( $page_id ) instanceof \WP_Post ? $page_id : 0;
	}

	/**
	 * Sanitize strip mode string.
	 *
	 * @param mixed $value Raw value.
	 *
	 * @return string
	 */
	public function sanitize_strip_mode( $value ): string {
		$allowed = [ 'none', 'all', 'selected' ];
		$value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';

		return \in_array( $value, $allowed, true ) ? $value : 'none';
	}

	/**
	 * Sanitize comma-separated handles.
	 *
	 * @param mixed $value Raw value.
	 *
	 * @return string
	 */
	public function sanitize_handles( $value ): string {
		if ( ! is_string( $value ) ) {
			return '';
		}

		$parts = array_filter(
			array_map(
				static function ( string $handle ): string {
					$handle = \preg_replace( '/[^a-z0-9_-]/i', '', $handle );
					return trim( (string) $handle );
				},
				array_map( 'trim', explode( ',', $value ) )
			)
		);

		return implode( ',', $parts );
	}

	/**
	 * Output the dropdown field.
	 */
	public function render_page_selector(): void {
		\wp_dropdown_pages(
			[
				'name'              => self::OPTION_NAME,
				'selected'          => (int) \get_option( self::OPTION_NAME, 0 ),
				'show_option_none'  => \__( '-- Select --', 'landing-page' ),
				'option_none_value' => 0,
			]
		);
	}

	/**
	 * Render CSS stripping control.
	 */
	public function render_css_strip_field(): void {
		$mode    = \get_option( LANDING_PAGE_STRIP_CSS_MODE_OPTION, 'none' );
		$handles = \get_option( LANDING_PAGE_STRIP_CSS_HANDLES_OPTION, '' );
		?>
		<select name="<?php echo \esc_attr( LANDING_PAGE_STRIP_CSS_MODE_OPTION ); ?>">
			<option value="none" <?php \selected( $mode, 'none' ); ?>><?php \esc_html_e( 'Do not strip CSS', 'landing-page' ); ?></option>
			<option value="all" <?php \selected( $mode, 'all' ); ?>><?php \esc_html_e( 'Strip all theme CSS (allow exceptions below)', 'landing-page' ); ?></option>
			<option value="selected" <?php \selected( $mode, 'selected' ); ?>><?php \esc_html_e( 'Strip only selected theme CSS handles', 'landing-page' ); ?></option>
		</select>
		<p>
			<label for="landing-page-css-handles">
				<?php \esc_html_e( 'CSS handles (comma separated). When stripping all, this list is kept. When stripping selected, only these handles are removed.', 'landing-page' ); ?>
			</label>
		</p>
		<textarea
			type="text"
			id="landing-page-css-handles"
			name="<?php echo \esc_attr( LANDING_PAGE_STRIP_CSS_HANDLES_OPTION ); ?>"
			class="regular-text"
		><?php echo \esc_html( $handles ); ?></textarea>
		<?php
	}

	/**
	 * Render JS stripping control.
	 */
	public function render_js_strip_field(): void {
		$mode    = \get_option( LANDING_PAGE_STRIP_JS_MODE_OPTION, 'none' );
		$handles = \get_option( LANDING_PAGE_STRIP_JS_HANDLES_OPTION, '' );
		?>
		<select name="<?php echo \esc_attr( LANDING_PAGE_STRIP_JS_MODE_OPTION ); ?>">
			<option value="none" <?php \selected( $mode, 'none' ); ?>><?php \esc_html_e( 'Do not strip JS', 'landing-page' ); ?></option>
			<option value="all" <?php \selected( $mode, 'all' ); ?>><?php \esc_html_e( 'Strip all theme JS (allow exceptions below)', 'landing-page' ); ?></option>
			<option value="selected" <?php \selected( $mode, 'selected' ); ?>><?php \esc_html_e( 'Strip only selected theme JS handles', 'landing-page' ); ?></option>
		</select>
		<p>
			<label for="landing-page-js-handles">
				<?php \esc_html_e( 'JS handles (comma separated). When stripping all, this list is kept. When stripping selected, only these handles are removed.', 'landing-page' ); ?>
			</label>
		</p>
		<textarea
			type="text"
			id="landing-page-js-handles"
			name="<?php echo \esc_attr( LANDING_PAGE_STRIP_JS_HANDLES_OPTION ); ?>"
			class="regular-text"
		><?php echo \esc_html( $handles ); ?></textarea>
		<?php
	}

	/**
	 * Render the settings page view.
	 */
	public function render_settings_page(): void {
		if ( ! \current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php \esc_html_e( 'Landing Page', 'landing-page' ); ?></h1>
			<form action="options.php" method="post">
				<?php
				\settings_fields( $this->page_slug );
				\do_settings_sections( $this->page_slug );
				\submit_button( \__( 'Save Landing Page', 'landing-page' ) );
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Add a post state label to the selected landing page in the Pages list.
	 *
	 * @param array    $states Existing states.
	 * @param \WP_Post $post   Current post object.
	 *
	 * @return array
	 */
	public function add_landing_page_state( array $states, \WP_Post $post ): array {
		$landing_page_id = (int) \get_option( self::OPTION_NAME, 0 );

		if ( 0 === $landing_page_id ) {
			return $states;
		}

		if ( 'page' !== $post->post_type ) {
			return $states;
		}

		$translated_page_id = (int) \apply_filters( 'wpml_object_id', $landing_page_id, 'page' );
		if ( 0 !== $translated_page_id ) {
			$landing_page_id = $translated_page_id;
		}

		if ( (int) $post->ID !== $landing_page_id ) {
			return $states;
		}

		$states['landing_page'] = \__( 'Landing Page', 'landing-page' );

		return $states;
	}

	/**
	 * Add a quick row action to jump to the landing page option content.
	 *
	 * @param array    $actions Existing row actions.
	 * @param \WP_Post $post    Current post object.
	 *
	 * @return array
	 */
	public function add_landing_page_row_action( array $actions, \WP_Post $post ): array {
		$landing_page_id = (int) \get_option( self::OPTION_NAME, 0 );

		$translated_page_id = (int) \apply_filters( 'wpml_object_id', $landing_page_id, 'page' );
		if ( 0 !== $translated_page_id ) {
			$landing_page_id = $translated_page_id;
		}

		if ( 0 === $landing_page_id || (int) $post->ID !== $landing_page_id || ! \current_user_can( 'manage_options' ) ) {
			return $actions;
		}

		$url = \add_query_arg(
			[
				'page' => 'landing-page-acf-settings',
			],
			\admin_url( 'edit.php?post_type=page' )
		);

		$actions['edit_landing_content'] = sprintf(
			'<a href="%s">%s</a>',
			\esc_url( $url ),
			\esc_html__( 'Edit Landing Page Content', 'landing-page' )
		);

		return $actions;
	}
}
