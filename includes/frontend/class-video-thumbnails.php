<?php
/**
 * Video helper utilities.
 *
 * @package Landing_Page
 */

namespace Landing_Page\Front;

/**
 * Provides thumbnail helpers for video sources.
 */
class Video_Thumbnails {
	/**
	 * Get the best available thumbnail for a given video URL.
	 *
	 * Prefers an override URL if provided; otherwise tries to derive YouTube's hqdefault image.
	 *
	 * @param string      $video_url  Original video URL.
	 * @param string|null $override   Optional override thumbnail URL.
	 *
	 * @return string|null
	 */
	public static function get( string $video_url, ?string $override = null ): ?string {
		if ( ! empty( $override ) ) {
			return $override;
		}

		return self::youtube_thumb( $video_url );
	}

	/**
	 * Extract the video ID (YouTube only).
	 *
	 * @param string $url Video URL.
	 *
	 * @return string|null
	 */
	public static function extract_id( string $url ): ?string {
		if ( '' === $url ) {
			return null;
		}

		$parsed = \wp_parse_url( $url );

		if ( empty( $parsed['host'] ) ) {
			return null;
		}

		$host  = \strtolower( $parsed['host'] );
		$path  = $parsed['path'] ?? '';
		$query = $parsed['query'] ?? '';

		if ( false !== \strpos( $host, 'youtu.be' ) ) {
			return \ltrim( $path, '/' );
		}

		if ( false !== \strpos( $host, 'youtube.com' ) ) {
			if ( 0 === \strpos( $path, '/watch' ) ) {
				$params = [];
				\parse_str( $query, $params );
				return $params['v'] ?? null;
			}

			if ( 0 === \strpos( $path, '/embed/' ) ) {
				$parts = \explode( '/', \trim( $path, '/' ) );
				return \end( $parts );
			}
		}

		return null;
	}

	/**
	 * Derive a YouTube thumbnail if possible.
	 *
	 * @param string $url Video URL.
	 *
	 * @return string|null
	 */
	private static function youtube_thumb( string $url ): ?string {
		if ( '' === $url ) {
			return null;
		}

		$parsed = \wp_parse_url( $url );

		if ( empty( $parsed['host'] ) ) {
			return null;
		}

		$host  = \strtolower( $parsed['host'] );
		$path  = $parsed['path'] ?? '';
		$query = $parsed['query'] ?? '';

		$video_id = null;

		if ( false !== \strpos( $host, 'youtu.be' ) ) {
			$video_id = \ltrim( $path, '/' );
		} elseif ( false !== \strpos( $host, 'youtube.com' ) ) {
			if ( 0 === \strpos( $path, '/watch' ) ) {
				$params   = [];
				\parse_str( $query, $params );
				$video_id = $params['v'] ?? null;
			} elseif ( 0 === \strpos( $path, '/embed/' ) ) {
				$parts    = \explode( '/', \trim( $path, '/' ) );
				$video_id = \end( $parts );
			}
		}

		return $video_id ? \sprintf( 'https://img.youtube.com/vi/%s/hqdefault.jpg', $video_id ) : null;
	}
}
