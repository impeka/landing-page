<?php
/**
 * Main plugin bootstrap.
 *
 * @package Landing_Page
 */

namespace Landing_Page;

use Landing_Page\Admin\Acf_Options_Page;
use Landing_Page\Admin\Settings_Page;
use Landing_Page\Front\Template_Override;

/**
 * Coordinates plugin initialization.
 */
class Plugin {
	/**
	 * Singleton instance.
	 *
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Loaded admin components.
	 *
	 * @var array<class-string,object>
	 */
	private $components = [];

	/**
	 * Get singleton instance.
	 *
	 * @return Plugin
	 */
	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Wire up hooks.
	 */
	private function __construct() {
		\add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );
		\add_action( 'admin_notices', [ $this, 'maybe_render_acf_notice' ] );
		$this->includes();
		$this->boot_frontend();
		$this->boot_admin();
	}

	/**
	 * Load translation files.
	 */
	public function load_textdomain(): void {
		\load_plugin_textdomain(
			'landing-page',
			false,
			\dirname( \plugin_basename( LANDING_PAGE_PLUGIN_FILE ) ) . '/languages'
		);
	}

	/**
	 * Include PHP files required for admin functionality.
	 */
	private function includes(): void {
		require_once LANDING_PAGE_PLUGIN_DIR . '/includes/admin/class-settings-page.php';
		require_once LANDING_PAGE_PLUGIN_DIR . '/includes/admin/class-acf-options-page.php';
		require_once LANDING_PAGE_PLUGIN_DIR . '/includes/frontend/class-social-links.php';
		require_once LANDING_PAGE_PLUGIN_DIR . '/includes/frontend/class-video-thumbnails.php';
		require_once LANDING_PAGE_PLUGIN_DIR . '/includes/frontend/class-video-item.php';
		require_once LANDING_PAGE_PLUGIN_DIR . '/includes/frontend/class-style-stripper.php';
		require_once LANDING_PAGE_PLUGIN_DIR . '/includes/frontend/class-script-stripper.php';
		require_once LANDING_PAGE_PLUGIN_DIR . '/includes/frontend/class-template-override.php';
	}

	/**
	 * Instantiate admin components.
	 */
	private function boot_admin(): void {
		$this->components['settings'] = new Settings_Page();
		$this->components['acf_options'] = new Acf_Options_Page();
	}

	/**
	 * Instantiate front-end components.
	 */
	private function boot_frontend(): void {
		$this->components['template_override'] = new Template_Override();
		$this->components['style_stripper']    = new \Landing_Page\Front\Style_Stripper();
		$this->components['script_stripper']   = new \Landing_Page\Front\Script_Stripper();
	}

	/**
	 * Display an admin notice if ACF is not present.
	 */
	public function maybe_render_acf_notice(): void {
		if ( \function_exists( 'acf_add_options_sub_page' ) ) {
			return;
		}

		if ( ! \current_user_can( 'manage_options' ) ) {
			return;
		}

		echo '<div class="notice notice-warning"><p>';
		echo \esc_html__( 'Landing Page requires Advanced Custom Fields Pro to be installed and active for its landing page options.', 'landing-page' );
		echo '</p></div>';
	}
}
