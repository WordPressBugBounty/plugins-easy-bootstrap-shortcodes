<?php
/**
 * Gutenberg block editor integration.
 *
 * @package EasyBootstrapShortcodes
 */

namespace EBS\Editor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the EBS shortcode inserter sidebar for the block editor.
 */
final class Gutenberg {

	/**
	 * Bootstrap Gutenberg integration.
	 *
	 * @return void
	 */
	public static function register(): void {
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue block editor scripts and pass shortcode registry data.
	 *
	 * @return void
	 */
	public static function enqueue_assets(): void {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$plugin_url = EBS_PLUGIN_URL;
		$version    = '5.0.0';

		wp_enqueue_script(
			'ebs-block-editor-insert',
			$plugin_url . 'js/ebs-block-editor-insert.js',
			array(
				'wp-blocks',
				'wp-data',
				'wp-block-editor',
			),
			$version,
			true
		);

		wp_enqueue_script(
			'ebs-block-editor',
			$plugin_url . 'js/ebs-block-editor.js',
			array(
				'wp-plugins',
				'wp-edit-post',
				'wp-element',
				'wp-components',
				'wp-i18n',
				'wp-blocks',
				'wp-data',
				'ebs-block-editor-insert',
			),
			$version,
			true
		);

		$shortcodes = function_exists( 'ebs_shortcodes' ) ? ebs_shortcodes() : array();
		$groups     = function_exists( 'ebs_groups' ) ? ebs_groups() : array();

		wp_localize_script(
			'ebs-block-editor',
			'ebsBlockEditor',
			array(
				'shortcodes' => $shortcodes,
				'groups'     => $groups,
				'prefix'     => get_option( 'EBS_SHORTCODE_PREFIX', '' ),
				'pluginUrl'  => $plugin_url,
				'title'      => __( 'EBS Shortcodes', 'easy-bootstrap-shortcodes' ),
			)
		);

		self::enqueue_popup_assets();
	}

	/**
	 * Enqueue assets required by Magnific Popup shortcode modals in block editor.
	 *
	 * @return void
	 */
	private static function enqueue_popup_assets(): void {
		$plugin_file = dirname( __DIR__ ) . '/osc_bootstrap_shortcode.php';
		$plugin_url  = EBS_PLUGIN_URL;
		$version     = '5.0.0';

		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_style( 'ebs-magnific-popup', $plugin_url . 'styles/magnific-popup.css', array(), $version );
		wp_enqueue_script( 'ebs-magnific-popup', $plugin_url . 'js/magnific-popup.js', array( 'jquery' ), $version, true );
		wp_enqueue_style( 'EBS_jquery-ui-slider-css', $plugin_url . 'styles/slider.css', array(), $version );
		wp_enqueue_style( 'bootstrap-icon', $plugin_url . 'styles/bootstrap-icon.min.css', array(), $version );
		wp_enqueue_style( 'ebs_bootstrap_admin', $plugin_url . 'styles/bootstrap_admin.min.css', array(), $version );

		$fa_icon = get_option( 'EBS_INCLUDE_FA', 1 );
		if ( 1 === (int) $fa_icon ) {
			wp_enqueue_style( 'bootstrap-fa-icon', $plugin_url . 'styles/font-awesome.min.css', array(), $version );
		}

		wp_enqueue_script( 'ebs-main', $plugin_url . 'js/ebs_main.js', array( 'jquery', 'ebs-block-editor-insert' ), $version, true );
		wp_localize_script(
			'ebs-main',
			'ebs',
			array(
				'font_awe'   => $fa_icon,
				'ebs_prefix' => get_option( 'EBS_SHORTCODE_PREFIX', '' ),
			)
		);

		wp_enqueue_script(
			'ebs-js-translation-scripts',
			$plugin_url . 'js/osc-localize.js',
			array(),
			$version,
			true
		);

		global $elements;
		if ( ! empty( $elements ) && is_array( $elements ) ) {
			foreach ( $elements as $element ) {
				$js_file = dirname( __DIR__ ) . '/shortcode/' . $element . '/' . $element . '_plugin.js';
				if ( file_exists( $js_file ) ) {
					wp_enqueue_script(
						'ebs-sc-' . $element,
						$plugin_url . 'shortcode/' . $element . '/' . $element . '_plugin.js',
						array( 'ebs-main', 'ebs-block-editor-insert' ),
						$version,
						true
					);
				}
			}
		}
	}

	/**
	 * Determine whether the current post uses the block editor.
	 *
	 * @return bool
	 */
	public static function is_block_editor_active(): bool {
		if ( ! function_exists( 'use_block_editor_for_post' ) ) {
			return false;
		}

		global $post;
		if ( $post && is_object( $post ) ) {
			return use_block_editor_for_post( $post );
		}

		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		return $screen && $screen->is_block_editor();
	}
}
