<?php
/**
 * Per-request dynamic CSS accumulator (replaces PHP session transport).
 *
 * @package EasyBootstrapShortcodes
 */

namespace EBS\Styles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Collects and outputs dynamic CSS via wp_add_inline_style().
 */
final class Dynamic_Css {

	/**
	 * Accumulated CSS rules for the current request.
	 *
	 * @var string[]
	 */
	private static $rules = array();

	/**
	 * Add a CSS rule block.
	 *
	 * @param string $css Raw CSS (will be stripped of tags).
	 * @return void
	 */
	public static function add( string $css ): void {
		$css = \EBS\Security\Sanitizer::custom_css( $css );
		if ( '' !== $css ) {
			self::$rules[] = $css;
		}
	}

	/**
	 * Get all accumulated CSS.
	 *
	 * @return string
	 */
	public static function get_all(): string {
		return implode( "\n", self::$rules );
	}

	/**
	 * Register frontend hook to output inline CSS.
	 *
	 * @return void
	 */
	public static function register(): void {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ), 101 );
	}

	/**
	 * Enqueue dynamic CSS handle and attach inline styles.
	 *
	 * @return void
	 */
	public static function enqueue(): void {
		$custom = get_option( 'EBS_CUSTOM_CSS', '' );
		$custom = \EBS\Security\Sanitizer::custom_css( $custom );

		wp_register_style( 'ebs-dynamic', false, array(), '5.0.0' );
		wp_enqueue_style( 'ebs-dynamic' );

		$inline = $custom;
		$accumulated = self::get_all();
		if ( '' !== $accumulated ) {
			$inline .= ( '' !== $inline ? "\n" : '' ) . $accumulated;
		}

		if ( '' !== $inline ) {
			wp_add_inline_style( 'ebs-dynamic', $inline );
		}
	}
}
