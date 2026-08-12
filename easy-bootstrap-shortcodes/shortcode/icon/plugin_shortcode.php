<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * BUTTONS
 * ********************************************************* */

function osc_theme_icon($params, $content = null) {
    $atts = shortcode_atts(array(
        'type' => '',
        'color' => '',
        'class' => '',
        'fontsize' => ''
    ), $params);

    $type     = Sanitizer::class_list( $atts['type'] );
    $class    = Sanitizer::class_list( $atts['class'] );
    $color    = Sanitizer::hex_color( $atts['color'] );
    $fontsize = Sanitizer::int( $atts['fontsize'] );

    $style_parts = array();
    if ( $color !== '' ) {
        $style_parts[] = 'color:' . $color . ';';
    }
    if ( $fontsize !== 0 ) {
        $style_parts[] = 'font-size:' . $fontsize . 'px;';
    }
    $style = implode( '', $style_parts );

    $iconcount = explode( ' ', $atts['type'] );
    array_filter( $iconcount );
    if ( count( $iconcount ) === 1 ) {
        $type = 'glyphicon ' . $type;
    }

    $out = '<i class=" ' . $type . ' ' . $class . '" style="' . $style . '"></i>';
    return $out;
}

ebs_backward_compatibility_callback('icon', 'osc_theme_icon');
