<?php
/**
 * Default Landing Page template provided by the plugin.
 *
 * @package Landing_Page
 */

$options_post_id = 'landing_page_options';

$cca_logo        = function_exists( 'get_field' ) ? get_field( 'cca_logo', $options_post_id ) : null;
$move_it_logo    = function_exists( 'get_field' ) ? get_field( 'move_it_logo', $options_post_id ) : null;
$move_it_tagline = function_exists( 'get_field' ) ? get_field( 'move_it_tagline', $options_post_id ) : '';
$lead            = function_exists( 'get_field' ) ? get_field( 'lead', $options_post_id ) : '';
$header_button   = function_exists( 'get_field' ) ? get_field( 'header_button', $options_post_id ) : null;

$footer_logo      = function_exists( 'get_field' ) ? get_field( 'acc_logo_footer', $options_post_id ) : null;
$footer_subtitle  = function_exists( 'get_field' ) ? get_field( 'footer_subtitle', $options_post_id ) : '';
$footer_links     = function_exists( 'get_field' ) ? get_field( 'footer_links', $options_post_id ) : [];
$telephone_link   = function_exists( 'get_field' ) ? get_field( 'telephone', $options_post_id ) : null;
$micetype_links   = function_exists( 'get_field' ) ? get_field( 'micetype_links', $options_post_id ) : [];
$social_links     = class_exists( '\Landing_Page\Front\Social_Links' ) ? ( new \Landing_Page\Front\Social_Links() )->all() : [];

$downloads_title    = function_exists( 'get_field' ) ? get_field( 'downloads_title', $options_post_id ) : '';
$downloads_subtitle = function_exists( 'get_field' ) ? get_field( 'downloads_subtitle', $options_post_id ) : '';
$downloads_lead     = function_exists( 'get_field' ) ? get_field( 'downloads_lead', $options_post_id ) : '';
$downloads          = function_exists( 'get_field' ) ? get_field( 'downloads', $options_post_id ) : [];

$habits_title    = function_exists( 'get_field' ) ? get_field( 'title', $options_post_id ) : '';
$habits_list     = function_exists( 'get_field' ) ? get_field( 'habits_list', $options_post_id ) : [];
$habits_footnote = function_exists( 'get_field' ) ? get_field( 'habits_footnote', $options_post_id ) : '';

require LANDING_PAGE_PLUGIN_DIR . '/templates/partials/header-landing.php';
?>

<main id="primary" class="site-main landing-page-template" role="main">
	<section class="hero">
		<div class="hero__inner">
			<div class="hero__logos">
				<?php if ( $cca_logo ) : ?>
					<img class="hero__logo hero__logo--cca" src="<?php echo esc_url( $cca_logo['url'] ); ?>" alt="<?php echo esc_attr( $cca_logo['alt'] ?? '' ); ?>" />
				<?php endif; ?>

				<?php if ( $move_it_logo ) : ?>
					<img class="hero__logo hero__logo--move-it" src="<?php echo esc_url( $move_it_logo['url'] ); ?>" alt="<?php echo esc_attr( $move_it_logo['alt'] ?? '' ); ?>" />
				<?php endif; ?>
			</div>

			<?php if ( $move_it_tagline ) : ?>
				<p class="hero__eyebrow"><?php echo esc_html( $move_it_tagline ); ?></p>
			<?php endif; ?>

			<?php if ( $lead ) : ?>
				<div class="hero__lead">
					<?php echo wp_kses_post( $lead ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $header_button ) : ?>
				<a class="button hero__cta" href="<?php echo esc_url( $header_button['url'] ); ?>" target="<?php echo esc_attr( $header_button['target'] ?? '' ); ?>">
					<?php echo esc_html( $header_button['title'] ); ?>
				</a>
			<?php endif; ?>
		</div>
	</section>

	<section class="benefits" id="benefits">
		<div class="benefits__inner">
			<header class="section-heading">
				<h2 class="section-heading__title"><?php esc_html_e( 'Small movement Habits Have Big Benefits', 'landing-page' ); ?></h2>
			</header>
			<div class="benefits__list">
				<article class="benefit">
					<div class="benefit__number">01</div>
					<h3 class="benefit__title"><?php esc_html_e( 'Mental Wellbeing', 'landing-page' ); ?></h3>
					<p class="benefit__copy"><?php esc_html_e( 'Movement improves mood, reduces stress, and boosts energy.', 'landing-page' ); ?></p>
				</article>
				<article class="benefit">
					<div class="benefit__number">02</div>
					<h3 class="benefit__title"><?php esc_html_e( 'Physical Health', 'landing-page' ); ?></h3>
					<p class="benefit__copy"><?php esc_html_e( 'Regular motion supports your joints, spine, and overall function.', 'landing-page' ); ?></p>
				</article>
				<article class="benefit">
					<div class="benefit__number">03</div>
					<h3 class="benefit__title"><?php esc_html_e( 'Healthy Aging', 'landing-page' ); ?></h3>
					<p class="benefit__copy"><?php esc_html_e( 'Staying active helps preserve independence and quality of life.', 'landing-page' ); ?></p>
				</article>
			</div>
			<div class="benefits__note">
				<p><?php esc_html_e( 'Canadian chiropractors know movement isn\'t just about fitness. It’s about how you live better every day. From getting up in the morning to moving at work or play, small, simple movements that become a habit lead to healthy long-lasting benefits.', 'landing-page' ); ?></p>
			</div>
		</div>
	</section>

	<section class="downloads" id="downloads">
		<div class="downloads__inner">
			<header class="section-heading section-heading--center">
				<p class="section-heading__eyebrow"><?php esc_html_e( 'Free Downloads', 'landing-page' ); ?></p>
				<h2 class="section-heading__title"><?php echo esc_html( $downloads_title ?? '' ); ?></h2>
				<?php if ( ! empty( $downloads_subtitle ) ) : ?>
					<p class="section-heading__subtitle"><?php echo esc_html( $downloads_subtitle ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $downloads_lead ) ) : ?>
					<div class="section-heading__lead"><?php echo wp_kses_post( $downloads_lead ); ?></div>
				<?php endif; ?>
			</header>

			<?php if ( ! empty( $downloads ) ) : ?>
				<div class="downloads__grid">
					<?php foreach ( $downloads as $download ) : ?>
						<article class="download-card">
							<?php if ( ! empty( $download['thumbnail']['url'] ) ) : ?>
								<img class="download-card__thumb" src="<?php echo esc_url( $download['thumbnail']['url'] ); ?>" alt="<?php echo esc_attr( $download['thumbnail']['alt'] ?? '' ); ?>" />
							<?php endif; ?>
							<div class="download-card__body">
								<h3 class="download-card__title"><?php echo esc_html( $download['title'] ?? '' ); ?></h3>
								<?php if ( ! empty( $download['download_file']['url'] ) ) : ?>
									<a class="button button--small download-card__cta" href="<?php echo esc_url( $download['download_file']['url'] ); ?>">
										<?php esc_html_e( 'Download', 'landing-page' ); ?>
									</a>
								<?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="partners" id="partners">
		<div class="partners__inner">
			<header class="section-heading">
				<h2 class="section-heading__title"><?php esc_html_e( 'Trusted Partners in Healthy Living', 'landing-page' ); ?></h2>
			</header>
			<div class="partners__content">
				<p><?php esc_html_e( 'Canada’s 9,000 chiropractors support people of all ages in maintaining mobility, resilience, and enhancing quality of life. As their role goes beyond treatment, chiropractors are your partners in your overall proactive health.', 'landing-page' ); ?></p>
			</div>
		</div>
	</section>

	<section class="help" id="help">
		<div class="help__inner">
			<header class="section-heading section-heading--center">
				<h2 class="section-heading__title">
					<?php echo esc_html( $habits_title ?: __( 'Where Chiropractors Help', 'landing-page' ) ); ?>
				</h2>
			</header>

			<div class="help__grid">
				<?php if ( ! empty( $habits_list ) ) : ?>
					<?php foreach ( $habits_list as $habit ) : ?>
						<article class="help-card">
							<h3 class="help-card__title"><?php echo esc_html( $habit['habit'] ?? '' ); ?></h3>
							<p class="help-card__copy"><?php echo esc_html( $habit['habit'] ?? '' ); ?></p>
						</article>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $habits_footnote ) ) : ?>
				<div class="help__note">
					<?php echo wp_kses_post( $habits_footnote ); ?>
				</div>
			<?php endif; ?>

			<a class="button help__cta" href="#find-a-chiro"><?php esc_html_e( 'Find a Chiropractor', 'landing-page' ); ?></a>
		</div>
	</section>
</main>

<?php
require LANDING_PAGE_PLUGIN_DIR . '/templates/partials/footer-landing.php';
