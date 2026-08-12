<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * BUTTONS
 * ********************************************************* */

function osc_theme_oscitasthumbnail( $params, $content = 'Label' ) {
	$atts = shortcode_atts(
		array(
			'src'    => '',
			'class'  => '',
			'link'   => '',
			'border' => '',
			'target' => '_self',
			'alt'    => '',
		),
		$params
	);

	$out    = '';
	$src    = Sanitizer::url( $atts['src'] );
	$class  = Sanitizer::class_list( $atts['class'] );
	$link   = Sanitizer::url( $atts['link'] );
	$alt    = Sanitizer::attr( $atts['alt'] );
	$target = '_blank' === $atts['target'] ? '_blank' : '_self';

	if ( '' !== $atts['border'] ) {
		$border_class = 'img-thumbnail';
	} else {
		$border_class = 'img-responsive';
	}

	if ( '' !== $atts['link'] ) {
		$out .= '<a href="' . $link . '" target="' . Sanitizer::attr( $target ) . '">';
	}
	$out .= '<img src="' . $src . '" class="' . $border_class . EBS_CONTAINER_CLASS . ' oscitas-res-image" alt="' . $alt . '">';
	if ( '' !== $atts['link'] ) {
		$out .= '</a>';
	}

	return $out;
}

ebs_backward_compatibility_callback( 'thumbnail', 'osc_theme_oscitasthumbnail' );
