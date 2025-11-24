<?php
/**
 * Custom footer for the Landing Page template.
 *
 * @package Landing_Page
 */

?>
<footer class="landing-page-footer">
	<div class="landing-page-footer__inner">
		<div class="footer__top">
			<div class="footer__brand">
				<?php if ( ! empty( $footer_logo['url'] ) ) : ?>
					<img class="footer__logo" src="<?php echo esc_url( $footer_logo['url'] ); ?>" alt="<?php echo esc_attr( $footer_logo['alt'] ?? '' ); ?>" />
				<?php endif; ?>
				<?php if ( ! empty( $footer_subtitle ) ) : ?>
					<p class="footer__subtitle"><?php echo esc_html( $footer_subtitle ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $footer_links ) ) : ?>
				<nav class="footer__nav" aria-label="<?php esc_attr_e( 'Footer links', 'landing-page' ); ?>">
					<ul class="footer__menu">
						<?php foreach ( $footer_links as $link_row ) : ?>
							<?php if ( empty( $link_row['link']['url'] ) ) : continue; endif; ?>
							<li class="footer__menu-item">
								<a href="<?php echo esc_url( $link_row['link']['url'] ); ?>" target="<?php echo esc_attr( $link_row['link']['target'] ?? '' ); ?>">
									<?php echo esc_html( $link_row['link']['title'] ?? '' ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>

			<div class="footer__contact">
				<?php if ( ! empty( $telephone_link['url'] ) ) : ?>
					<a class="footer__telephone" href="<?php echo esc_url( $telephone_link['url'] ); ?>" target="<?php echo esc_attr( $telephone_link['target'] ?? '' ); ?>">
						<?php echo esc_html( $telephone_link['title'] ?? $telephone_link['url'] ); ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $social_links ) ) : ?>
					<div class="footer__social" aria-label="<?php esc_attr_e( 'Social media', 'landing-page' ); ?>">
						<?php foreach ( $social_links as $social ) : ?>
							<a class="social-link social-link--<?php echo esc_attr( $social['icon'] ); ?>" href="<?php echo esc_url( $social['url'] ); ?>" target="<?php echo esc_attr( $social['target'] ); ?>" rel="<?php echo esc_attr( $social['target'] ? 'noopener noreferrer' : '' ); ?>">
								<span class="screen-reader-text"><?php echo esc_html( $social['label'] ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( ! empty( $micetype_links ) ) : ?>
			<div class="footer__associations">
				<ul class="footer__associations-list">
					<?php foreach ( $micetype_links as $assoc ) : ?>
						<?php if ( empty( $assoc['link']['url'] ) ) : continue; endif; ?>
						<li class="footer__associations-item">
							<a href="<?php echo esc_url( $assoc['link']['url'] ); ?>" target="<?php echo esc_attr( $assoc['link']['target'] ?? '' ); ?>">
								<?php echo esc_html( $assoc['link']['title'] ?? '' ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<div class="footer__meta">
			<p class="footer__copyright">
				<?php
				printf(
					/* translators: 1: site title, 2: year */
					esc_html__( '© %1$s %2$s. All rights reserved.', 'landing-page' ),
					esc_html( get_bloginfo( 'name', 'display' ) ),
					esc_html( gmdate( 'Y' ) )
				);
				?>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
