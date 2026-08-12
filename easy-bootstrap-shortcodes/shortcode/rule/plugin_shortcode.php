<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * HR Rule
 * ********************************************************* */

function theme_hrrule( $params, $content = null ) {
	$atts = shortcode_atts(
		array(
			'style'  => '',
			'class'  => '',
			'margin' => '',
		),
		$params
	);

	$out     = '';
	$margin1 = '';
	$style   = Sanitizer::class_list( $atts['style'] );
	$class   = Sanitizer::class_list( $atts['class'] );

	if ( '' !== $atts['margin'] ) {
		$margin1 = ' style="margin:' . Sanitizer::int( $atts['margin'] ) . 'px 0"';
	}

	$out = '<hr ' . $margin1 . 'class="' . $class . ' ' . $style . ' osc-rule" />';

	return $out;
}

add_shortcode( 'rule', 'theme_hrrule' );
