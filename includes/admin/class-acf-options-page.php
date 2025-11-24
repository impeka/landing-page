<?php
/**
 * Registers the ACF options page that becomes available after selection.
 *
 * @package Landing_Page
 */

namespace Landing_Page\Admin;

/**
 * Adds an ACF options page under Pages when configured.
 */
class Acf_Options_Page {
	private const POST_ID = 'landing_page_options';

	/**
	 * Hook into ACF initialization.
	 */
	public function __construct() {
		\add_action( 'acf/init', [ $this, 'register_options_page' ] );
		\add_action( 'acf/init', [ $this, 'register_fields' ] );
	}

	/**
	 * Register the Landing Page options page when prerequisites are met.
	 */
	public function register_options_page(): void {
		if ( ! \function_exists( 'acf_add_options_sub_page' ) ) {
			return;
		}

		if ( 0 === (int) \get_option( Settings_Page::OPTION_NAME, 0 ) ) {
			return;
		}

		\acf_add_options_sub_page(
			[
				'page_title'      => \__( 'Landing Page', 'landing-page' ),
				'menu_title'      => \__( 'Landing Page', 'landing-page' ),
				'parent_slug'     => 'edit.php?post_type=page',
				'menu_slug'       => 'landing-page-acf-settings',
				'capability'      => 'edit_pages',
				'position'        => false,
				'redirect'        => false,
				'post_id'         => self::POST_ID,
				'update_button'   => \__( 'Save Landing Page Settings', 'landing-page' ),
				'updated_message' => \__( 'Landing Page settings saved.', 'landing-page' ),
			]
		);
	}

	/**
	 * Register the Landing Page's custom fields
	 */
	public function register_fields(): void {

		acf_add_local_field_group( array(
			'key' => 'group_6924bca9df4d9',
			'title' => __( 'Landing Page Footer', 'impeka-landing-page' ),
			'fields' => array(
				array(
					'key' => 'field_6924bcaaa3642',
					'label' => __( 'ACC Logo (Footer)', 'impeka-landing-page' ),
					'name' => 'acc_logo_footer',
					'aria-label' => '',
					'type' => 'image',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
					'allow_in_bindings' => 0,
					'preview_size' => 'medium',
				),
				array(
					'key' => 'field_6924bd15a3643',
					'label' => __( 'Footer Subtitle', 'impeka-landing-page' ),
					'name' => 'footer_subtitle',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'maxlength' => '',
					'allow_in_bindings' => 0,
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
				),
				array(
					'key' => 'field_6924bd20a3644',
					'label' => __( 'Footer Links', 'impeka-landing-page' ),
					'name' => 'footer_links',
					'aria-label' => '',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'row',
					'pagination' => 0,
					'min' => 0,
					'max' => 0,
					'collapsed' => '',
					'button_label' => __( 'Add Link', 'impeka-landing-page' ),
					'rows_per_page' => 20,
					'sub_fields' => array(
						array(
							'key' => 'field_6924bd2aa3645',
							'label' => __( 'Link', 'impeka-landing-page' ),
							'name' => 'link',
							'aria-label' => '',
							'type' => 'link',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'allow_in_bindings' => 0,
							'parent_repeater' => 'field_6924bd20a3644',
						),
					),
				),
				array(
					'key' => 'field_6924bd4da3646',
					'label' => __( 'Telephone Link', 'impeka-landing-page' ),
					'name' => 'telephone',
					'aria-label' => '',
					'type' => 'link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'allow_in_bindings' => 0,
				),
				array(
					'key' => 'field_6924bd7ea3647',
					'label' => __( 'Micetype Links', 'impeka-landing-page' ),
					'name' => 'micetype_links',
					'aria-label' => '',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'row',
					'pagination' => 0,
					'min' => 0,
					'max' => 0,
					'collapsed' => '',
					'button_label' => __( 'Add Link', 'impeka-landing-page' ),
					'rows_per_page' => 20,
					'sub_fields' => array(
						array(
							'key' => 'field_6924bda0a3648',
							'label' => __( 'Link', 'impeka-landing-page' ),
							'name' => 'link',
							'aria-label' => '',
							'type' => 'link',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'allow_in_bindings' => 0,
							'parent_repeater' => 'field_6924bd7ea3647',
						),
					),
				),
				array(
					'key' => 'field_6924bdb6a3649',
					'label' => __( 'Socials', 'impeka-landing-page' ),
					'name' => 'socials',
					'aria-label' => '',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'row',
					'pagination' => 0,
					'min' => 0,
					'max' => 0,
					'collapsed' => '',
					'button_label' => __( 'Add Social Link', 'impeka-landing-page' ),
					'rows_per_page' => 20,
					'sub_fields' => array(
						array(
							'key' => 'field_6924bde1a364a',
							'label' => __( 'Link', 'impeka-landing-page' ),
							'name' => 'link',
							'aria-label' => '',
							'type' => 'link',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'allow_in_bindings' => 0,
							'parent_repeater' => 'field_6924bdb6a3649',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'landing-page-acf-settings',
					),
				),
			),
			'menu_order' => 100,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
			'show_in_rest' => 0,
		) );

			acf_add_local_field_group( array(
			'key' => 'group_6924bbbf96b8f',
			'title' => 'Landing Page Header',
			'fields' => array(
				array(
					'key' => 'field_6924bbc46f1f5',
					'label' => __( 'CCA Logo', 'impeka-landing-page' ),
					'name' => 'cca_logo',
					'aria-label' => '',
					'type' => 'image',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
					'allow_in_bindings' => 0,
					'preview_size' => 'medium',
				),
				array(
					'key' => 'field_6924bc156f1f6',
					'label' => __( 'Move It Logo', 'impeka-landing-page' ),
					'name' => 'move_it_logo',
					'aria-label' => '',
					'type' => 'image',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
					'allow_in_bindings' => 0,
					'preview_size' => 'medium',
				),
				array(
					'key' => 'field_6924bc336f1f7',
					'label' => __( 'Move It Tagline', 'impeka-landing-page' ),
					'name' => 'move_it_tagline',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'maxlength' => '',
					'allow_in_bindings' => 0,
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
				),
				array(
					'key' => 'field_6924bc436f1f8',
					'label' => __( 'Lead', 'impeka-landing-page' ),
					'name' => 'lead',
					'aria-label' => '',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'allow_in_bindings' => 0,
					'tabs' => 'all',
					'toolbar' => 'basic',
					'media_upload' => 0,
					'delay' => 1,
				),
				array(
					'key' => 'field_6924bc656f1f9',
					'label' => __( 'Header Button', 'impeka-landing-page' ),
					'name' => 'header_button',
					'aria-label' => '',
					'type' => 'link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'allow_in_bindings' => 0,
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'landing-page-acf-settings',
					),
				),
			),
			'menu_order' => 1,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
			'show_in_rest' => 0,
		) );
	}
}
