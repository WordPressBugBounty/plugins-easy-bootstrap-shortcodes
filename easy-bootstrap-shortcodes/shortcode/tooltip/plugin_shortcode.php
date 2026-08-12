<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * Tooltip
 * ********************************************************* */

function osc_theme_tooltip($params, $content = 'Tooltip') {
    $atts = shortcode_atts(array(
        'type' => '',
        'link' => '',
        'tooltip' => '',
        'style' => '',
        'class' => '',
        'target' => '',
    ), $params);

    $type    = $atts['type'];
    $link    = Sanitizer::url( $atts['link'] );
    $tooltip = Sanitizer::attr( $atts['tooltip'] );
    $style   = Sanitizer::attr( $atts['style'] );
    $class   = Sanitizer::class_list( $atts['class'] );
    $target  = Sanitizer::attr( $atts['target'] );

    $out = '';
    if ( $type === 'link' ) {
        $out = '<a href="' . $link . '" data-placement="' . $style . '" title="' . $tooltip . '" class="osc_tooltip ' . $class . '" target="' . $target . '">' . do_shortcode( $content ) . '</a>
';
    } elseif ( $type === 'button' ) {
        $out = '<button type="button" data-toggle="tooltip" data-placement="' . $style . '" title="' . $tooltip . '" class="btn osc_tooltip ' . $class . '">' . do_shortcode( $content ) . '</button>';
    }

    if ( EBS_TOOLTIP_TEMPLATE === '' ) {
        $out .= "
    <script>
        jQuery(document).ready(function() {
            jQuery('.osc_tooltip').tooltip();
        });
    </script>
    ";

    } else {
        $out .= "
    <script>
       jQuery(document).ready(function(){
        jQuery('.osc_tooltip').tooltip({template:'" . EBS_TOOLTIP_TEMPLATE . "'});
        });
    </script>
    ";
    }

    return $out;
}

ebs_backward_compatibility_callback('tooltip', 'osc_theme_tooltip');
