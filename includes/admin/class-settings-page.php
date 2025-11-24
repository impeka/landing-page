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
}
