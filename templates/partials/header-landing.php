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