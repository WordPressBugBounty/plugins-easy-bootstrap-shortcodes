<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

function osc_theme_btngrptoolbar( $params, $content = null ) {
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

	$class = Sanitizer::class_list( $atts['class'] );
	$out   = '<div class="btn-toolbar ' . $class . EBS_CONTAINER_CLASS . '" role="toolbar">' . do_shortcode( $content ) . '</div>';

	return $out;
}

ebs_backward_compatibility_callback( 'btngrptoolbar', 'osc_theme_btngrptoolbar' );
