<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

function osc_theme_deslist( $params, $content = null ) {
	$atts = shortcode_atts(
		array(
			'class' => '',
			'style' => '',
		),
		$params
	);

	$content = str_replace( ']<br />', ']', $content );
	$content = str_replace( "]<br />\n", ']', $content );
	$content = str_replace( "<br />\n[", '[', $content );

	$style = Sanitizer::class_list( $atts['style'] );
	$class = Sanitizer::class_list( $atts['class'] );

	return '<dl class="osc-deslist ' . $style . ' ' . $class . EBS_CONTAINER_CLASS . '">' . do_shortcode( $content ) . '</dl>';
}

ebs_backward_compatibility_callback( 'dl', 'osc_theme_deslist' );

function osc_theme_dlitem( $params, $content = null ) {
	$atts = shortcode_atts(
		array(
			'heading' => '',
		),
		$params
	);

	$heading = do_shortcode( Sanitizer::shortcode_content( $atts['heading'] ) );
	$out     = '<dt>' . $heading . '</dt>';
	$out    .= '<dd>' . do_shortcode( $content ) . '</dd>';

	return $out;
}

ebs_backward_compatibility_callback( 'dlitem', 'osc_theme_dlitem' );
