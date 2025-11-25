<?php
/**
 * Front-end helper to strip theme CSS, keeping plugin/core styles.
 *
 * @package Landing_Page
 */

namespace Landing_Page\Front;

/**
 * Removes theme-enqueued styles so the landing page can control its own CSS.
 */
class Style_Stripper {
	/**
	 * Hook into enqueue pipeline.
	 */
	public function __construct() {
		\add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_theme_styles' ], 999 );
	}

	/**
	 * Dequeue and deregister styles that originate from the theme.
	 *
	 * Keeps plugin and select core styles intact.
	 */
	public function dequeue_theme_styles(): void {
		$styles = \wp_styles();

		if ( empty( $styles->queue ) || ! isset( $styles->registered ) ) {
			return;
		}

		$plugins_base     = \trailingslashit( \dirname( \plugins_url( '/', LANDING_PAGE_PLUGIN_FILE ) ) );
		$mu_plugins_base  = defined( 'WPMU_PLUGIN_URL' ) ? \trailingslashit( WPMU_PLUGIN_URL ) : '';
		$stylesheet_dir   = \trailingslashit( \get_stylesheet_directory_uri() );
		$template_dir     = \trailingslashit( \get_template_directory_uri() );
		$core_allowlist   = [ 'wp-block-library', 'dashicons' ];

		foreach ( $styles->queue as $handle ) {
			if ( empty( $styles->registered[ $handle ] ) ) {
				continue;
			}

			$src = (string) $styles->registered[ $handle ]->src;

			$is_plugin = ( $plugins_base && false !== \strpos( $src, $plugins_base ) )
				|| ( $mu_plugins_base && false !== \strpos( $src, $mu_plugins_base ) );
			$is_core  = \in_array( $handle, $core_allowlist, true );
			$is_theme = ( $stylesheet_dir && false !== \strpos( $src, $stylesheet_dir ) )
				|| ( $template_dir && false !== \strpos( $src, $template_dir ) );

			// Only dequeue theme-origin styles; leave plugin/core intact.
			if ( ! $is_theme || $is_plugin || $is_core ) {
				continue;
			}

			\wp_dequeue_style( $handle );
			\wp_deregister_style( $handle );
		}
	}
}
