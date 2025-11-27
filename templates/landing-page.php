<?php
/**
 * Default Landing Page template.
 *
 * @package Landing_Page
 */

$options_post_id = 'landing_page_options';

$video           = function_exists( 'get_field' ) ? get_field( 'background_video', $options_post_id ) : null;
$move_it_logo    = function_exists( 'get_field' ) ? get_field( 'move_it_logo', $options_post_id ) : null;
$move_it_tagline = function_exists( 'get_field' ) ? get_field( 'move_it_tagline', $options_post_id ) : '';
$lead            = function_exists( 'get_field' ) ? get_field( 'lead', $options_post_id ) : '';
$header_button   = function_exists( 'get_field' ) ? get_field( 'header_button', $options_post_id ) : null;

$footer_logo      = function_exists( 'get_field' ) ? get_field( 'acc_logo_footer', $options_post_id ) : null;
$footer_subtitle  = function_exists( 'get_field' ) ? get_field( 'footer_subtitle', $options_post_id ) : '';
$footer_links     = function_exists( 'get_field' ) ? get_field( 'footer_links', $options_post_id ) : [];
$micetype_links   = function_exists( 'get_field' ) ? get_field( 'micetype_links', $options_post_id ) : [];
$social_links     = class_exists( '\Landing_Page\Front\Social_Links' ) ? ( new \Landing_Page\Front\Social_Links() )->all() : [];

$downloads_title    = function_exists( 'get_field' ) ? get_field( 'downloads_title', $options_post_id ) : '';
$downloads_subtitle = function_exists( 'get_field' ) ? get_field( 'downloads_subtitle', $options_post_id ) : '';
$downloads_lead     = function_exists( 'get_field' ) ? get_field( 'downloads_lead', $options_post_id ) : '';
$downloads          = function_exists( 'get_field' ) ? get_field( 'downloads', $options_post_id ) : [];

$habits_title    = function_exists( 'get_field' ) ? get_field( 'title', $options_post_id ) : '';
$habits_image    = function_exists( 'get_field' ) ? get_field( 'habits_image', $options_post_id ) : null;
$habits_list     = function_exists( 'get_field' ) ? get_field( 'habits_list', $options_post_id ) : [];
$habits_footnote = function_exists( 'get_field' ) ? get_field( 'habits_footnote', $options_post_id ) : '';

$videos_title = function_exists( 'get_field' ) ? get_field( 'videos_title', $options_post_id ) : '';
$videos       = function_exists( 'get_field' ) ? get_field( 'videos', $options_post_id ) : [];

$partners_title   = function_exists( 'get_field' ) ? get_field( 'partners_title', $options_post_id ) : '';
$partners_content = function_exists( 'get_field' ) ? get_field( 'partners_content', $options_post_id ) : '';
$partners_image   = function_exists( 'get_field' ) ? get_field( 'partners_image', $options_post_id ) : null;

$where_title    = function_exists( 'get_field' ) ? get_field( 'where_title', $options_post_id ) : '';
$where_buckets  = function_exists( 'get_field' ) ? get_field( 'buckets', $options_post_id ) : [];
$where_subtitle = function_exists( 'get_field' ) ? get_field( 'where_subtitle', $options_post_id ) : '';
$where_link     = function_exists( 'get_field' ) ? get_field( 'where_link', $options_post_id ) : null;

require LANDING_PAGE_PLUGIN_DIR . '/templates/partials/header-landing.php';
?>

<main id="primary" class="site-main landing-page-template" role="main">
	<section class="hero">
		<div class="hero__inner">
			<div class="hero__logos">
				<?php if( $cca_logo = get_field( 'cca_logo', $options_post_id ) ): ?>
					<div class="cca-logo-row">
						<a class="landing-page-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo $cca_logo['url']; ?>" alt="<?php bloginfo( 'name' ); ?>" />
						</a>
					</div>
				<?php endif; ?>
			</div>
			<div class="hero__content">
				<div class="inner">
					<?php if ( $move_it_logo ) : ?>
						<img class="hero__logo hero__logo--move-it" src="<?php echo esc_url( $move_it_logo['url'] ); ?>" alt="<?php echo esc_attr( $move_it_logo['alt'] ?? '' ); ?>" />
					<?php endif; ?>

					<?php if ( $move_it_tagline ) : ?>
						<p class="hero__eyebrow"><span class="hero__eyebrow__inner"><?php echo esc_html( $move_it_tagline ); ?></span></p>
					<?php endif; ?>

					<?php if ( $lead ) : ?>
						<div class="hero__lead">
							<?php echo wp_kses_post( $lead ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $header_button ) : ?>
						<div class="hero__cta">
							<a class="button" href="<?php echo esc_url( $header_button['url'] ); ?>" target="<?php echo esc_attr( $header_button['target'] ?? '' ); ?>">
								<?php echo esc_html( $header_button['title'] ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php if( ! empty( $video ) ): ?>
			<div class="hero__background-video">
				<video class="video-frame" autoplay loop>
					<source src="<?php echo $video['url']; ?>" type="video/mp4" />
				</video>
			</div>
		<?php endif; ?>
	</section>

	<section class="benefits" id="benefits">
		<div class="benefits__inner">
			<header class="section-heading">
				<h2 class="section-heading__title">
					<?php echo esc_html( $habits_title ?: __( 'Small movement habits have big benefits', 'landing-page' ) ); ?>
				</h2>
			</header>
			<div class="benefits__body">
				<?php if ( ! empty( $habits_image['url'] ) ) : ?>
					<div class="benefits__media">
						<img src="<?php echo esc_url( $habits_image['url'] ); ?>" alt="<?php echo esc_attr( $habits_image['alt'] ?? '' ); ?>" />
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $habits_list ) ) : ?>
					<div class="benefits__list">
						<?php foreach ( $habits_list as $index => $habit ) : ?>
							<article class="benefit">
								<div class="benefit__number">
									<?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?>
								</div>
								<div class="benefit__content">
									<h3 class="benefit__title"><?php echo esc_html( $habit['habit'] ?? '' ); ?></h3>
									<?php if( ! empty( $habit['description'] ) ): ?>
										<div class="benefit__description">
											<?php echo $habit['description']; ?>
										</div>
									<?php endif; ?>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $habits_footnote ) ) : ?>
				<div class="benefits__note">
					<?php echo wp_kses_post( $habits_footnote ); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="downloads" id="downloads">
		<div class="downloads__inner">
			<header class="section-heading section-heading--center">
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
										<?php echo esc_html( $download['download_file']['title'] ?? __( 'Download', 'landing-page' ) ); ?>
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
			<div class="partners__content">
				<header class="section-heading">
					<h2 class="section-heading__title">
						<?php echo esc_html( $partners_title ?: __( 'Trusted Partners in Healthy Living', 'landing-page' ) ); ?>
					</h2>
				</header>
				<div class="partners__copy">
					<?php echo wp_kses_post( $partners_content ); ?>
				</div>
			</div>
			<?php if ( ! empty( $partners_image['url'] ) ) : ?>
				<div class="partners__media">
					<img src="<?php echo esc_url( $partners_image['url'] ); ?>" alt="<?php echo esc_attr( $partners_image['alt'] ?? '' ); ?>" />
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="where-help" id="help">
		<?php if ( $move_it_logo ) : ?>
			<img class="floating__logo--move-it" src="<?php echo esc_url( $move_it_logo['url'] ); ?>" alt="<?php echo esc_attr( $move_it_logo['alt'] ?? '' ); ?>" />
		<?php endif; ?>
		<div class="where-help__inner">
			<header class="section-heading section-heading--center">
				<h2 class="section-heading__title">
					<?php echo esc_html( $where_title ?: __( 'Where Chiropractors Help', 'landing-page' ) ); ?>
				</h2>
			</header>

			<div class="where-help__grid">
				<?php if ( ! empty( $where_buckets ) ) : ?>
					<?php foreach ( $where_buckets as $bucket ) : ?>
						<article class="where-card">
							<?php if ( ! empty( $bucket['title'] ) ) : ?>
								<h3 class="where-card__title"><?php echo esc_html( $bucket['title'] ); ?></h3>
							<?php endif; ?>
							<?php if ( ! empty( $bucket['content'] ) ) : ?>
								<div class="where-card__copy">
									<?php echo wp_kses_post( $bucket['content'] ); ?>
								</div>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $where_subtitle ) ) : ?>
				<h4 class="where-help__subtitle"><?php echo esc_html( $where_subtitle ); ?></h4>
			<?php endif; ?>

			<?php if ( ! empty( $where_link['url'] ) ) : ?>
				<div class="where-help__cta">
					<a class="button" href="<?php echo esc_url( $where_link['url'] ); ?>" target="<?php echo esc_attr( $where_link['target'] ?? '' ); ?>">
						<?php echo esc_html( $where_link['title'] ?? '' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="videos" id="videos">
		<div class="videos__inner">
			<header class="section-heading section-heading--center">
				<h2 class="section-heading__title">
					<?php echo esc_html( $videos_title ?: __( 'Videos', 'landing-page' ) ); ?>
				</h2>
			</header>

			<?php if ( ! empty( $videos ) ) : ?>
				<div class="videos__grid">
					<?php foreach ( $videos as $video_data ) : ?>
						<?php $video = new \Landing_Page\Front\Video_Item( $video_data ); ?>
						<article class="video-card">
							<a href="<?php echo esc_url( $video->get_url() ); ?>" target="_blank" rel="noopener noreferrer">
								<?php if ( $video->get_thumb_url() ) : ?>
									<div class="video-card__thumb">
										<img src="<?php echo esc_url( $video->get_thumb_url() ); ?>" alt="<?php echo esc_attr( $video->get_thumb_alt() ); ?>" />
									</div>
								<?php endif; ?>
								<?php if ( $video->get_title() ) : ?>
									<h3 class="video-card__title"><?php echo esc_html( $video->get_title() ); ?></h3>
								<?php endif; ?>
							</a>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
require LANDING_PAGE_PLUGIN_DIR . '/templates/partials/footer-landing.php';
