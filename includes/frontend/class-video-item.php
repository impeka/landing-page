<?php
/**
 * Represents a single video entry with derived thumbnail data.
 *
 * @package Landing_Page
 */

namespace Landing_Page\Front;

/**
 * Normalizes video data for templates.
 */
class Video_Item {
	/**
	 * Raw video data.
	 *
	 * @var array<string,mixed>
	 */
	private $video;

	/**
	 * Normalized thumbnail URL.
	 *
	 * @var string|null
	 */
	private $thumb_url;

	/**
	 * Extracted video ID (YouTube).
	 *
	 * @var string|null
	 */
	private $video_id;

	/**
	 * Constructor.
	 *
	 * @param array<string,mixed> $video Video data from ACF.
	 */
	public function __construct( array $video ) {
		$this->video = $video;
		$this->video_id = Video_Thumbnails::extract_id( $this->get_url() );
		$this->thumb_url = Video_Thumbnails::get(
			$this->get_url(),
			$video['thumbnail']['url'] ?? null
		);
	}

	/**
	 * Get the video URL.
	 *
	 * @return string
	 */
	public function get_url(): string {
		return (string) ( $this->video['video_url'] ?? '' );
	}

	/**
	 * Get the video title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return (string) ( $this->video['title'] ?? '' );
	}

	/**
	 * Get the thumbnail URL.
	 *
	 * @return string|null
	 */
	public function get_thumb_url(): ?string {
		return $this->thumb_url;
	}

	/**
	 * Get the thumbnail alt text.
	 *
	 * @return string
	 */
	public function get_thumb_alt(): string {
		if ( ! empty( $this->video['thumbnail']['alt'] ) ) {
			return (string) $this->video['thumbnail']['alt'];
		}

		return $this->get_title();
	}

	/**
	 * Get the extracted video ID (YouTube).
	 *
	 * @return string|null
	 */
	public function get_video_id(): ?string {
		return $this->video_id;
	}
}
