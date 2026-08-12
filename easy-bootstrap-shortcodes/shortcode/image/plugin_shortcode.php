<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * BUTTONS
 * ********************************************************* */

function osc_theme_image( $params, $content = 'Label' ) {
	$atts = shortcode_atts(
		array(
			'src'   => '',
			'class' => '',
			'shape' => '',
		),
		$params
	);

	$src   = Sanitizer::url( $atts['src'] );
	$class = Sanitizer::class_list( $atts['class'] );
	$shape = Sanitizer::class_list( $atts['shape'] );

	$out = '<img src="' . $src . '" class="' . $class . ' ' . $shape . EBS_CONTAINER_CLASS . '">';

	return $out;
}

ebs_backward_compatibility_callback( 'image', 'osc_theme_image' );
