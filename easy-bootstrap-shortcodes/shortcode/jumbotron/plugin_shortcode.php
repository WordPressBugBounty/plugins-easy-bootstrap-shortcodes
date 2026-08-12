<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * Jumbotron
 * ********************************************************* */

function osc_theme_jumbotron( $params, $content = 'Label' ) {
	$atts = shortcode_atts(
		array(
			'bgcolor' => '',
			'class'   => '',
		),
		$params
	);

	$out     = '';
	$content = str_replace( '<br class="osc" />', '', $content );
	$content = str_replace( '<br class="osc" />\n', '', $content );

	$class      = Sanitizer::class_list( $atts['class'] );
	$style_attr = '';
	if ( '' !== $atts['bgcolor'] ) {
		$style_attr = ' style="background:' . Sanitizer::hex_color( $atts['bgcolor'] ) . ';"';
	}

	$out = '<div class="jumbotron ' . $class . EBS_CONTAINER_CLASS . '"' . $style_attr . '>' . do_shortcode( $content ) . '</div>';

	return $out;
}

ebs_backward_compatibility_callback( 'jumbotron', 'osc_theme_jumbotron' );
