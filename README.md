# Landing Page

WordPress plugin that pairs with Advanced Custom Fields Pro to manage a designated landing page with a custom template, header, and footer partials.

## Features
- Pick the landing page under **Settings > Landing Page**; the selected ID is stored in the `landing_page_target_page` option.
- Adds a **Pages > Landing Page** ACF options sub-page that saves against the `landing_page_options` post ID so content persists if you swap the target page.
- Overrides the chosen page with `templates/landing-page.php`, including dedicated header/footer partials and a `landing-page` menu location.
- Social links helper (`Landing_Page\Front\Social_Links`) returns sanitized links with an inferred icon slug from the URL (Facebook, Instagram, LinkedIn, Twitter/X, YouTube, TikTok, Pinterest, Threads, WhatsApp; falls back to `link`).
- Loads translations from `languages` (text domain: `landing-page`).

## Requirements
- WordPress 6.x+
- Advanced Custom Fields Pro

## Setup
1. Activate the plugin alongside ACF Pro.
2. Go to **Settings > Landing Page** and choose which page should use the landing template.
3. Open **Pages > Landing Page** (the ACF options page) to populate header/footer fields, social links, and other content.
4. Adjust markup in `templates/landing-page.php` and its partials in `templates/partials/` as needed.

## Social links helper
Use the helper to loop socials and render an icon based on the URL domain. The `icon` value can power an SVG, font icon, or background image.

```php
<?php
use Landing_Page\Front\Social_Links;

$socials = ( new Social_Links() )->all();

if ( $socials ) : ?>
	<div class="landing-page-socials">
		<?php foreach ( $socials as $social ) : ?>
			<a class="social-link social-link--<?php echo esc_attr( $social['icon'] ); ?>"
				href="<?php echo esc_url( $social['url'] ); ?>"
				target="<?php echo esc_attr( $social['target'] ); ?>"
				rel="<?php echo esc_attr( $social['target'] ? 'noopener noreferrer' : '' ); ?>">
				<span class="social-link__icon" aria-hidden="true">
					<?php echo esc_html( $social['icon'] ); ?>
				</span>
				<span class="screen-reader-text"><?php echo esc_html( $social['label'] ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
```

## Assets and development
- Compiled CSS lives at `assets/css/landing-page.css` (enqueued via `Landing_Page\Front\Template_Override`). Source SCSS is in `src/scss/`; `@font-face` blocks load local Museo files from `assets/fonts/`.
- Template override path: `templates/landing-page.php`; header/footer partials: `templates/partials/header-landing.php`, `templates/partials/footer-landing.php`.
- Option name: `landing_page_target_page`; ACF options post ID: `landing_page_options`.
