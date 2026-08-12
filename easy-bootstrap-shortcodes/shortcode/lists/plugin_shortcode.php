<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

function osc_theme_list( $params, $content = null ) {
	$atts = shortcode_atts(
		array(
			'class' => '',
		),
		$params
	);

	$content = str_replace( ']<br />', ']', $content );
	$content = str_replace( "]<br />\n", ']', $content );
	$content = str_replace( "<br />\n[", '[', $content );

	$class = Sanitizer::class_list( $atts['class'] );

	return '<ul class="list-group ' . $class . EBS_CONTAINER_CLASS . '">' . do_shortcode( $content ) . '</ul>';
}

ebs_backward_compatibility_callback( 'list', 'osc_theme_list' );

function osc_theme_li( $params, $content = null ) {
	$atts = shortcode_atts(
		array(
			'type' => '',
		),
		$params
	);

	$type = Sanitizer::class_list( $atts['type'] );
	if ( '' !== $type ) {
		$osc_class = '<span class="glyphicon ' . $type . '"></span> ';
	} else {
		$osc_class = '';
	}

	return '<li class="list-group-item' . EBS_CONTAINER_CLASS . '">' . $osc_class . do_shortcode( $content ) . '</li>';
}

ebs_backward_compatibility_callback( 'li', 'osc_theme_li' );
