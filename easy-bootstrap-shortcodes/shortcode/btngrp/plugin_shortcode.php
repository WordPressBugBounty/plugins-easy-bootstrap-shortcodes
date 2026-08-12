<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

function osc_theme_btngrp( $params, $content = null ) {
	$atts = shortcode_atts(
		array(
			'style' => '',
			'class' => '',
		),
		$params
	);

	$content = str_replace( ']<br />', ']', $content );
	$content = str_replace( "]<br />\n", ']', $content );
	$content = str_replace( "<br />\n[", '[', $content );

	$style = in_array( $atts['style'], array( 'vertical', 'justified' ), true ) ? $atts['style'] : '';
	$class = Sanitizer::class_list( $atts['class'] );
	$out   = '';

	if ( 'vertical' === $style ) {
		$out .= '<div class="btn-group-vertical ' . $class . EBS_CONTAINER_CLASS . '">' . do_shortcode( $content ) . '</div>';
	} elseif ( 'justified' === $style ) {
		$out .= '<div class="btn-group btn-group-justified ' . $class . EBS_CONTAINER_CLASS . '">' . do_shortcode( $content ) . '</div>';
	} else {
		$out .= '<div class="btn-group ' . $class . EBS_CONTAINER_CLASS . '">' . do_shortcode( $content ) . '</div>';
	}

	return $out;
}

ebs_backward_compatibility_callback( 'buttongroup', 'osc_theme_btngrp' );
