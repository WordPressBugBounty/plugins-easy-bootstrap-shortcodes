<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * BUTTONS
 * ********************************************************* */

function osc_theme_progressbar( $params, $content = null ) {
	$atts = shortcode_atts(
		array(
			'value'    => '50',
			'barstyle' => '',
			'bartype'  => '',
			'class'    => '',
			'label'    => '',
		),
		$params
	);

	$value    = Sanitizer::int( $atts['value'] );
	$barstyle = Sanitizer::class_list( $atts['barstyle'] );
	$bartype  = Sanitizer::class_list( $atts['bartype'] );
	$class    = Sanitizer::class_list( $atts['class'] );
	$label    = Sanitizer::html( $atts['label'] );

	$out = '' !== $atts['label'] ? '<div class="osc_bar_outer"><label class="osc-progressbar-label' . EBS_CONTAINER_CLASS . '">' . $label . '</label>' : '';
	$out .= '<div class="progress ' . $barstyle . ' ' . $class . ' osc-progressbar' . EBS_CONTAINER_CLASS . '">
  <div class="progress-bar ' . $bartype . EBS_CONTAINER_CLASS . '"  role="progressbar" aria-valuenow="' . $value . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $value . '%">
    <span class="sr-only' . EBS_CONTAINER_CLASS . '">' . $value . '% Complete</span>
  </div>
</div>';
	$out .= '' !== $atts['label'] ? '</div>' : '';

	return $out;
}

ebs_backward_compatibility_callback( 'progressbar', 'osc_theme_progressbar' );
