<?php
/**
 * Helper for rendering social links with inferred icons.
 *
 * @package Landing_Page
 */

namespace Landing_Page\Front;

/**
 * Exposes social links saved on the landing page options with icon metadata.
 */
class Social_Links {
	/**
	 * ACF options post ID used when saving landing page fields.
	 */
	private const OPTIONS_POST_ID = 'landing_page_options';

	/**
	 * Domain-to-icon map used to infer which icon should be displayed.
	 */
	private const ICON_MAP = [
		'facebook.com'  => 'facebook',
		'fb.com'        => 'facebook',
		'instagram.com' => 'instagram',
		'linkedin.com'  => 'linkedin',
		'twitter.com'   => 'twitter',
		'x.com'         => 'twitter',
		'youtube.com'   => 'youtube',
		'youtu.be'      => 'youtube',
		'tiktok.com'    => 'tiktok',
		'pinterest.com' => 'pinterest',
		'threads.net'   => 'threads',
		'whatsapp.com'  => 'whatsapp',
		'wa.me'         => 'whatsapp',
	];

	/**
	 * Return all configured social links in a template-friendly structure.
	 *
	 * Each item includes:
	 * - url: sanitized URL.
	 * - label: link text (falls back to icon slug).
	 * - target: either '_blank' or empty string.
	 * - icon: icon slug inferred from the URL.
	 *
	 * @return array<int,array<string,string>>
	 */
	public function all(): array {
		if ( ! \function_exists( 'get_field' ) ) {
			return [];
		}

		$rows = \get_field( 'socials', self::OPTIONS_POST_ID );

		if ( empty( $rows ) || ! \is_array( $rows ) ) {
			return [];
		}

		$links = [];

		foreach ( $rows as $row ) {
			$link = $this->normalize_link( $row );

			if ( null === $link ) {
				continue;
			}

			$links[] = $link;
		}

		return $links;
	}

	/**
	 * Normalize a single row from the socials repeater.
	 *
	 * @param mixed $row ACF row data.
	 *
	 * @return array<string,string>|null
	 */
	private function normalize_link( $row ): ?array {
		if ( empty( $row['link'] ) || ! \is_array( $row['link'] ) ) {
			return null;
		}

		$link   = $row['link'];
		$url    = isset( $link['url'] ) ? (string) $link['url'] : '';
		$title  = isset( $link['title'] ) ? (string) $link['title'] : '';
		$target = ( isset( $link['target'] ) && '_blank' === $link['target'] ) ? '_blank' : '';

		if ( '' === $url ) {
			return null;
		}

		$icon = $this->detect_icon( $url );

		return [
			'url'    => \esc_url_raw( $url ),
			'label'  => '' !== $title ? \sanitize_text_field( $title ) : $this->fallback_label( $icon ),
			'target' => $target,
			'icon'   => $icon,
		];
	}

	/**
	 * Guess which icon slug should be used based on the URL.
	 *
	 * @param string $url Link URL.
	 *
	 * @return string
	 */
	private function detect_icon( string $url ): string {
		$host = (string) \wp_parse_url( $url, PHP_URL_HOST );
		$host = \strtolower( (string) \preg_replace( '/^www\./', '', $host ) );

		foreach ( self::ICON_MAP as $domain => $icon ) {
			if ( $this->host_matches( $host, $domain ) ) {
				return $icon;
			}
		}

		return 'link';
	}

	/**
	 * Provide a readable fallback label when no link text is supplied.
	 *
	 * @param string $icon Icon slug.
	 *
	 * @return string
	 */
	private function fallback_label( string $icon ): string {
		return \ucwords( \str_replace( '-', ' ', $icon ) );
	}

	/**
	 * Check whether a host matches a given domain (with or without subdomain).
	 *
	 * @param string $host   Parsed host from URL.
	 * @param string $domain Domain to check for.
	 *
	 * @return bool
	 */
	private function host_matches( string $host, string $domain ): bool {
		if ( '' === $host || '' === $domain ) {
			return false;
		}

		if ( $host === $domain ) {
			return true;
		}

		$needle = '.' . $domain;

		return \strlen( $host ) > \strlen( $domain ) && \substr( $host, -\strlen( $needle ) ) === $needle;
	}
}
