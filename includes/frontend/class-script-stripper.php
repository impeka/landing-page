<?php
/**
 * Front-end helper to strip theme scripts.
 *
 * @package Landing_Page
 */

namespace Landing_Page\Front;

/**
 * Removes theme-enqueued scripts so the landing page can control its JS.
 */
class Script_Stripper {
	/**
	 * Hook into enqueue pipeline.
	 */
	public function __construct() {
		\add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_theme_scripts' ], 999 );
	}

	/**
	 * Dequeue and deregister scripts that originate from the theme.
	 *
	 * Keeps plugin and core scripts intact.
	 */
	public function dequeue_theme_scripts(): void {
		$page_id = (int) \get_option( LANDING_PAGE_OPTION_NAME, 0 );

		$translated_page_id = (int) \apply_filters( 'wpml_object_id', $page_id, 'page' );
		if ( 0 !== $translated_page_id ) {
			$page_id = $translated_page_id;
		}

		// Only strip scripts when rendering the configured landing page.
		if ( 0 === $page_id || ! \is_page( $page_id ) ) {
			return;
		}

		$mode = \get_option( LANDING_PAGE_STRIP_JS_MODE_OPTION, 'none' );

		if ( 'none' === $mode ) {
			return;
		}

		$handles = $this->parse_handles( \get_option( LANDING_PAGE_STRIP_JS_HANDLES_OPTION, '' ) );

		$scripts = \wp_scripts();

		if ( empty( $scripts->queue ) || ! isset( $scripts->registered ) ) {
			return;
		}

		$plugins_base    = \trailingslashit( \dirname( \plugins_url( '/', LANDING_PAGE_PLUGIN_FILE ) ) );
		$mu_plugins_base = defined( 'WPMU_PLUGIN_URL' ) ? \trailingslashit( WPMU_PLUGIN_URL ) : '';
		$stylesheet_dir  = \trailingslashit( \get_stylesheet_directory_uri() );
		$template_dir    = \trailingslashit( \get_template_directory_uri() );

		foreach ( $scripts->queue as $handle ) {
			if ( empty( $scripts->registered[ $handle ] ) ) {
				continue;
			}

			$src = (string) $scripts->registered[ $handle ]->src;

			$is_plugin = ( $plugins_base && false !== \strpos( $src, $plugins_base ) )
				|| ( $mu_plugins_base && false !== \strpos( $src, $mu_plugins_base ) );
			$is_theme = ( $stylesheet_dir && false !== \strpos( $src, $stylesheet_dir ) )
				|| ( $template_dir && false !== \strpos( $src, $template_dir ) );

			// Only dequeue theme-origin scripts; leave plugin/core intact.
			if ( ! $is_theme || $is_plugin ) {
				continue;
			}

			$should_strip = false;

			if ( 'all' === $mode ) {
				$should_strip = ! \in_array( $handle, $handles, true );
			} elseif ( 'selected' === $mode ) {
				$should_strip = \in_array( $handle, $handles, true );
			}

			if ( ! $should_strip ) {
				continue;
			}

			\wp_dequeue_script( $handle );
			\wp_deregister_script( $handle );
		}
	}

	/**
	 * Turn a comma-separated string into an array of handles.
	 *
	 * @param string $value Raw handles string.
	 *
	 * @return array<string>
	 */
	private function parse_handles( string $value ): array {
		$parts = array_filter(
			array_map(
				static function ( string $handle ): string {
					$handle = \preg_replace( '/[^a-z0-9_-]/i', '', $handle );
					return strtolower( trim( (string) $handle ) );
				},
				array_map( 'trim', explode( ',', $value ) )
			)
		);

		return array_values( array_unique( $parts ) );
	}
}
