<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

function osc_theme_notification( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'type'  => '',
			'close' => 'false',
			'class' => '',
		),
		$atts
	);

	$type  = Sanitizer::class_list( $atts['type'] );
	$class = Sanitizer::class_list( $atts['class'] );

	if ( 'true' === $atts['close'] ) {
		$type .= ' alert-dismissable';
	}

	$result  = '<div class = "alert ' . $type . ' ' . $class . EBS_CONTAINER_CLASS . '">';
	if ( 'true' === $atts['close'] ) {
		$result .= '<button type = "button" class = "close' . EBS_CONTAINER_CLASS . '" data-dismiss = "alert" aria-hidden = "true">&times;
    </button>';
	}
	$result .= do_shortcode( $content );
	$result .= '</div>';

	return $result;
}

ebs_backward_compatibility_callback( 'notification', 'osc_theme_notification' );
