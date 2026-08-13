<?php
/**
 * Output sanitization helpers for EBS shortcodes.
 *
 * @package EasyBootstrapShortcodes
 */

namespace EBS\Security;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Centralized escaping and sanitization for shortcode output.
 */
final class Sanitizer {

	/**
	 * Escape a value for use in an HTML attribute.
	 *
	 * @param string $value Raw attribute value.
	 * @return string
	 */
	public static function attr( string $value ): string {
		return esc_attr( $value );
	}

	/**
	 * Escape plain text for HTML output.
	 *
	 * @param string $value Raw text.
	 * @return string
	 */
	public static function html( string $value ): string {
		return esc_html( $value );
	}

	/**
	 * Escape a URL for use in href/src attributes.
	 *
	 * @param string $value Raw URL.
	 * @return string
	 */
	public static function url( string $value ): string {
		return esc_url( $value );
	}

	/**
	 * Sanitize a space-separated list of CSS class names.
	 *
	 * @param string $value Raw class string.
	 * @return string
	 */
	public static function class_list( string $value ): string {
		if ( '' === $value ) {
			return '';
		}

		$classes = array_filter(
			array_map(
				static function ( string $class ): string {
					return sanitize_html_class( trim( $class ) );
				},
				preg_split( '/\s+/', $value, -1, PREG_SPLIT_NO_EMPTY )
			)
		);

		return implode( ' ', $classes );
	}

	/**
	 * Sanitize a hex color value.
	 *
	 * @param string $value Raw color.
	 * @return string Sanitized color or empty string.
	 */
	public static function hex_color( string $value ): string {
		$color = sanitize_hex_color( $value );
		return $color ? $color : '';
	}

	/**
	 * Sanitize shortcode inner content allowing safe post HTML.
	 *
	 * @param string $content Raw content.
	 * @return string
	 */
	public static function shortcode_content( string $content ): string {
		return wp_kses_post( $content );
	}

	/**
	 * Sanitize a positive integer.
	 *
	 * @param mixed $value Raw value.
	 * @return int
	 */
	public static function int( $value ): int {
		return absint( $value );
	}

	/**
	 * Sanitize a heading tag name (h1-h6).
	 *
	 * @param string $tag Raw tag name.
	 * @return string
	 */
	public static function heading_tag( string $tag ): string {
		$allowed = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
		$tag     = strtolower( sanitize_key( $tag ) );
		return in_array( $tag, $allowed, true ) ? $tag : 'h3';
	}

	/**
	 * Sanitize custom CSS for inline style output.
	 *
	 * @param string $css Raw CSS.
	 * @return string
	 */
	public static function custom_css( string $css ): string {
		$css = wp_strip_all_tags( $css );
		$css = str_replace( array( '<', '>' ), '', $css );
		return $css;
	}
}
