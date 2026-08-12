<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

function osc_theme_iconhead( $params, $content = null ) {
	$atts = shortcode_atts(
		array(
			'class' => '',
			'style' => '',
			'type'  => 'h1',
			'color' => '',
		),
		$params
	);

	$out   = '';
	$type  = Sanitizer::heading_tag( $atts['type'] );
	$class = Sanitizer::class_list( $atts['class'] );
	$style = $atts['style'];

	$color_attr = '';
	if ( '' !== $atts['color'] ) {
		$color_attr = 'style="color:' . Sanitizer::hex_color( $atts['color'] ) . ';"';
	}

	if ( '' !== $style ) {
		$iconcount = array_filter( explode( ' ', $style ) );
		if ( 1 === count( $iconcount ) ) {
			$style = 'glyphicon ' . $style;
		}
		$style = ' <span class=" ' . Sanitizer::class_list( $style ) . '" ' . $color_attr . '></span> ';
	}

	$out = '<' . $type . ' class="' . $class . EBS_CONTAINER_CLASS . '" >' . $style . do_shortcode( $content ) . '</' . $type . '>';

	return $out;
}

ebs_backward_compatibility_callback( 'iconheading', 'osc_theme_iconhead' );
