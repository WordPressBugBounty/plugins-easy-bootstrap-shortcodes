<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * Badges
 * ********************************************************* */

function osc_theme_badge( $params, $content = '' ) {
	$atts = shortcode_atts(
		array(
			'bgcolor'     => '',
			'color'       => '',
			'value'       => '',
			'float_right' => '',
			'class'       => '',
		),
		$params
	);

	$out     = '';
	$content = str_replace( '<br class="osc" />', '', $content );
	$content = str_replace( '<br class="osc" />\n', '', $content );

	$style = '';
	if ( '' !== $atts['bgcolor'] ) {
		$style .= 'background:' . Sanitizer::hex_color( $atts['bgcolor'] ) . ';';
	}
	if ( '' !== $atts['color'] ) {
		$style .= 'color:' . Sanitizer::hex_color( $atts['color'] ) . ';';
	}
	$style_attr  = '' !== $style ? ' style="' . Sanitizer::attr( $style ) . '"' : '';
	$float_right = 'true' === $atts['float_right'] ? ' pull-right' : '';
	$class       = Sanitizer::class_list( $atts['class'] );
	$value       = Sanitizer::html( $atts['value'] );

	$out = '<span class="badge ' . $class . $float_right . EBS_CONTAINER_CLASS . '"' . $style_attr . '>' . $value . '</span>';

	return $out;
}

ebs_backward_compatibility_callback( 'badge', 'osc_theme_badge' );
