<?php
/**
 * Front-end template override handling.
 *
 * @package Landing_Page
 */

namespace Landing_Page\Front;

/**
 * Replaces the selected landing page's template with the plugin template.
 */
class Template_Override {
	/**
	 * Wire up template filtering.
	 */
	public function __construct() {
		\add_action( 'after_setup_theme', [ $this, 'register_nav_location' ] );
		\add_filter( 'template_include', [ $this, 'maybe_use_plugin_template' ] );
	}

	/**
	 * Registers a dedicated nav location for the landing page header.
	 */
	public function register_nav_location(): void {
		\register_nav_menu(
			'landing-page',
			\__( 'Landing Page Header Menu', 'landing-page' )
		);
	}

	/**
	 * Swap the template for the selected landing page if possible.
	 *
	 * @param string $template Current template path.
	 *
	 * @return string
	 */
	public function maybe_use_plugin_template( string $template ): string {
		$page_id = (int) \get_option( LANDING_PAGE_OPTION_NAME, 0 );

		if ( 0 === $page_id ) {
			return $template;
		}

		if ( ! \is_page( $page_id ) ) {
			return $template;
		}

		if ( ! \file_exists( LANDING_PAGE_TEMPLATE_FILE ) ) {
			return $template;
		}

		return LANDING_PAGE_TEMPLATE_FILE;
	}
}
