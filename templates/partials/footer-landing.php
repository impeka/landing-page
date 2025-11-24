<?php
/**
 * Custom footer for the Landing Page template.
 *
 * @package Landing_Page
 */

?>
<footer class="landing-page-footer">
	<div class="landing-page-footer__inner">
		<p>
			<?php
			printf(
				/* translators: 1: site title, 2: year */
				esc_html__( '(c) %1$s %2$s. All rights reserved.', 'landing-page' ),
				wp_kses_post( get_bloginfo( 'name', 'display' ) ),
				wp_kses_post( gmdate( 'Y' ) )
			);
			?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
