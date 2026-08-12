<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;
use EBS\Styles\Dynamic_Css;

/* * *********************************************************
 * Servicebox
 * ********************************************************* */
$_ebsp_servicebox = array();

function osc_theme_servicebox($params, $content = null) {
    global $_ebsp_servicebox;
    $atts = shortcode_atts(array(
        'id' => count( $_ebsp_servicebox ),
        'icon' => '',
        'type' => 'icon',
        'icontype' => 'glyphicon',
        'icon_size' => 40,
        'iconbg_size' => 100,
        'iconbg_radius' => 50,
        'margin_bottom' => 30,
        'margin_top' => 30,
        'iconbgcolor' => '#FFFFFF',
        'iconcolor' => '#777777',
        'headingtype' => 'h3',
        'heading' => '',
        'class' => '',
        'readmore' => '',
        'readmore_link' => '',
        'readmore_text' => '',
        'readmore_type' => '',
        'readmorestyle' => 'default',
        'readmore_bgcolor' => '',
        'readmore_fgcolor' => ''
    ), $params);

    $id              = Sanitizer::int( $atts['id'] );
    $icon            = Sanitizer::class_list( $atts['icon'] );
    $icontype        = Sanitizer::class_list( $atts['icontype'] );
    $icon_size       = Sanitizer::int( $atts['icon_size'] );
    $iconbg_size     = Sanitizer::int( $atts['iconbg_size'] );
    $iconbg_radius   = Sanitizer::int( $atts['iconbg_radius'] );
    $margin_bottom   = Sanitizer::int( $atts['margin_bottom'] );
    $margin_top      = Sanitizer::int( $atts['margin_top'] );
    $iconbgcolor     = Sanitizer::hex_color( $atts['iconbgcolor'] );
    $iconcolor       = Sanitizer::hex_color( $atts['iconcolor'] );
    $headingtype     = Sanitizer::heading_tag( $atts['headingtype'] );
    $heading         = Sanitizer::html( $atts['heading'] );
    $class           = Sanitizer::class_list( $atts['class'] );
    $readmore        = $atts['readmore'];
    $readmore_link   = Sanitizer::url( $atts['readmore_link'] );
    $readmore_text   = Sanitizer::html( $atts['readmore_text'] );
    $readmore_type   = Sanitizer::class_list( $atts['readmore_type'] );
    $readmorestyle   = $atts['readmorestyle'];
    $readmore_bgcolor = Sanitizer::hex_color( $atts['readmore_bgcolor'] );
    $readmore_fgcolor = Sanitizer::hex_color( $atts['readmore_fgcolor'] );

    $out   = '';
    $style = '';
    $_ebsp_servicebox[ $id ] = array();

    $out .= '<div id="osc_servicebox_' . $id . '" class="osc_servicebox ' . $class . '">';

    if ( $icon !== '' ) {
        $out .= '<span class="' . $icontype . ' ' . $icon . ' icon_bg iconcircle"></span>';
    }

    if ( $heading !== '' ) {
        $out .= '<' . $headingtype . '>' . $heading . '</' . $headingtype . '>';
    }
    $out .= '<div class="osc_servicebox_content">';
    $out .= do_shortcode( $content );
    $out .= '</div>';
    if ( $readmore === 'true' ) {
        if ( $readmore_type !== '' ) {
            $btnclass = ' btn ' . $readmore_type;
        } else {
            $btnclass = ' osc_servicebox_readmore';
        }
        $out .= '<a href="' . $readmore_link . '" class="osc_servicebox_readmore_css' . $btnclass . '">' . $readmore_text . '</a>';
    }
    $out .= '</div>';

    if ( $readmore === 'true' && $readmorestyle === 'custom' ) {
        $style .= '
	#osc_servicebox_' . $id . ' .osc_servicebox_readmore_css{
	color:' . $readmore_fgcolor . ';
	background-color:' . $readmore_bgcolor . ';
	}';
    }
    $lineheight = $iconbg_size - 10;
    $style .= '
	#osc_servicebox_' . $id . ' .iconcircle{

	}
	#osc_servicebox_' . $id . ' span.iconcircle {
	    color:' . $iconcolor . ';
	    font-size:' . $icon_size . 'px;
	    line-height:' . $lineheight . 'px;
	   background-color:' . $iconbgcolor . ';
	    height:' . $iconbg_size . 'px;
	    width:' . $iconbg_size . 'px;
	    margin-top:' . $margin_top . 'px;
	    margin-bottom:' . $margin_bottom . 'px;
	    border-radius:' . $iconbg_radius . '%;
        -moz-border-radius: ' . $iconbg_radius . '%;
	    -webkit-border-radius: ' . $iconbg_radius . '%;
	    -ms-border-radius: ' . $iconbg_radius . '%;
        -o-border-radius: ' . $iconbg_radius . '%;
    ;
	}';

    Dynamic_Css::add( $style );

    return $out;
}

ebs_backward_compatibility_callback('servicebox', 'osc_theme_servicebox');
