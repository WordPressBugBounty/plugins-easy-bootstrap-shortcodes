<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * BUTTONS
 * ********************************************************* */

function osc_theme_button($params, $content = null) {
    $atts = shortcode_atts(array(
        'title' => 'osCitas',
        'link' => '',
        'linkrel' => '',
        'type' => 'link',
        'style' => '',
        'align' => '',
        'target' => '',
        'icon' => '',
        'class' => '',
        'iconcolor' => ''
    ), $params);

    $title     = Sanitizer::html( $atts['title'] );
    $link      = Sanitizer::url( $atts['link'] );
    $linkrel   = Sanitizer::attr( $atts['linkrel'] );
    $style     = Sanitizer::class_list( $atts['style'] );
    $class     = Sanitizer::class_list( $atts['class'] );
    $align     = $atts['align'];
    $type      = $atts['type'];
    $target    = $atts['target'];
    $icon      = Sanitizer::class_list( $atts['icon'] );
    $iconcolor = Sanitizer::hex_color( $atts['iconcolor'] );

    $out = '';
    $iconcount = array();
    if ( $icon ) {
        $iconcount = explode( ' ', $atts['icon'] );
    }
    array_filter( $iconcount );
    if ( count( $iconcount ) === 1 ) {
        $icon = 'glyphicon ' . $icon;
    }

    $iconcolor_attr = '';
    if ( $iconcolor !== '' ) {
        $iconcolor_attr = 'style="color:' . $iconcolor . ';"';
    }

    if ( $icon !== '' ) {
        if ( $align === 'right' ) {
            $value = $title . ' <i class="' . $icon . '" ' . $iconcolor_attr . '></i>';
        } else {
            $value = '<i class="' . $icon . '" ' . $iconcolor_attr . '></i> ' . $title;
        }
    } else {
        $value = $title;
    }

    $target_attr = ' target="' . ( $target !== 'false' ? '_blank' : '_self' ) . '"';

    if ( $type === 'link' ) {
        $out = '<a class="btn ' . $style . ' ' . $class . ' ' . EBS_CONTAINER_CLASS . '" href="' . $link . '" rel="' . $linkrel . '" ' . $target_attr . '>' . $value . '</a>';
    } elseif ( $type === 'button' ) {
        $out = '<button class="btn ' . $style . ' ' . $class . ' ' . EBS_CONTAINER_CLASS . '">' . $value . '</button>';
    }
    return $out;
}

ebs_backward_compatibility_callback('button', 'osc_theme_button');
