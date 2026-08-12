<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * BUTTONS
 * ********************************************************* */

function osc_theme_labels( $params, $content = 'Label' ) {
	$atts = shortcode_atts(
		array(
			'type'  => 'label-default',
			'class' => '',
		),
		$params
	);

	$out     = '';
	$content = str_replace( '<br />', '', $content );
	$content = str_replace( "<br />\n", '', $content );

	$type  = Sanitizer::class_list( $atts['type'] );
	$class = Sanitizer::class_list( $atts['class'] );

	$out = '<span class="label ' . $type . ' ' . $class . EBS_CONTAINER_CLASS . '">' . do_shortcode( $content ) . '</span>';

	return $out;
}

ebs_backward_compatibility_callback( 'label', 'osc_theme_labels' );
