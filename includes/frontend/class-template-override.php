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
		\add_filter( 'template_include', [ $this, 'maybe_use_plugin_template' ] );
		\add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
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

	/**
	 * Enqueue plugin front-end assets.
	 */
	public function enqueue_assets(): void {
		$css_path = LANDING_PAGE_PLUGIN_DIR . '/assets/css/landing-page.css';
		$css_url  = LANDING_PAGE_PLUGIN_DIR . '/assets/css/landing-page.css';

		if ( \file_exists( $css_path ) ) {
			\wp_enqueue_style(
				'landing-page-styles',
				plugins_url( 'assets/css/landing-page.css', LANDING_PAGE_PLUGIN_FILE.'.'.time() ),
				[],
				LANDING_PAGE_PLUGIN_VERSION
			);
		}

		\wp_enqueue_style(
			'fontawesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css',
			[],
			'7.0.1'
		);
	}
}
