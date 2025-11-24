<?php
/**
 * Custom header for the Landing Page template.
 *
 * @package Landing_Page
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'landing-page-body' ); ?>>
<?php wp_body_open(); ?>

<header class="landing-page-header">
	<div class="landing-page-header__inner">
		<a class="landing-page-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>
		<?php if ( has_nav_menu( 'landing-page' ) ) : ?>
			<nav class="landing-page-header__nav" aria-label="<?php esc_attr_e( 'Landing Page menu', 'landing-page' ); ?>">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'landing-page',
						'fallback_cb'    => false,
					]
				);
				?>
			</nav>
		<?php endif; ?>
	</div>
</header>
