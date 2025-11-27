<?php
/**
 * Plugin Name: Landing Page
 * Description: Provides landing page functionality that is theme agnostic.
 * Version: 0.9.1
 * Author: Impeka
 * Text Domain: landing-page
 * Domain Path: /languages
 *
 * @package Landing_Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LANDING_PAGE_PLUGIN_VERSION', '0.9.1' );
define( 'LANDING_PAGE_PLUGIN_FILE', __FILE__ );
define( 'LANDING_PAGE_PLUGIN_DIR', __DIR__ );
define( 'LANDING_PAGE_OPTION_NAME', 'landing_page_target_page' );
define( 'LANDING_PAGE_TEMPLATE_FILE', LANDING_PAGE_PLUGIN_DIR . '/templates/landing-page.php' );

require LANDING_PAGE_PLUGIN_DIR . '/includes/class-plugin.php';

\Landing_Page\Plugin::instance();
