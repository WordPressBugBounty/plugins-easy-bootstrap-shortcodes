<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;
use EBS\Styles\Dynamic_Css;

/* * *********************************************************
 * jQuery UI Accordion (sliders)
 * ********************************************************* */

$_oscitas_slider        = array();
$_oscitas_slider_slides = array();

function osc_theme_sliders( $params, $content = null ) {
	global $_oscitas_slider, $_oscitas_slider_counter;

	if ( ! count( $_oscitas_slider ) ) {
		$_oscitas_slider = array( 'current_id' => 0 );
	}

	$atts = shortcode_atts(
		array(
			'id'           => count( $_oscitas_slider ),
			'class'        => '',
			'interval'     => '',
			'controls'     => '',
			'bullets'      => '',
			'pause'        => '',
			'wrap'         => '',
			'captioncolor' => '',
			'navcolor'     => '',
		),
		$params
	);

	wp_enqueue_script( 'ebs_fit_text', EBS_PLUGIN_URL . 'js/jquery.fittext.js' );

	$id           = Sanitizer::int( $atts['id'] );
	$class        = Sanitizer::class_list( $atts['class'] );
	$interval     = Sanitizer::attr( $atts['interval'] );
	$pause        = Sanitizer::attr( $atts['pause'] );
	$wrap         = Sanitizer::attr( $atts['wrap'] );
	$captioncolor = Sanitizer::hex_color( $atts['captioncolor'] );
	$navcolor     = Sanitizer::hex_color( $atts['navcolor'] );

	$_oscitas_slider[ $id ]              = array();
	$_oscitas_slider['current_id']       = count( $_oscitas_slider ) - 1;
	$_oscitas_slider_slides[ $_oscitas_slider['current_id'] ] = array();

	$bulllet_content = '';

	$scontent = do_shortcode( $content );
	if ( count( $_oscitas_slider[ $id ]['bullets'] ) ) {
		$bulllet_content = isset( $_oscitas_slider[ $id ]['bullets'] ) && is_array( $_oscitas_slider[ $id ]['bullets'] ) ? implode( '', $_oscitas_slider[ $id ]['bullets'] ) : '';
	}

	$output = '';
	if ( '' !== trim( $scontent ) || count( $_oscitas_slider[ $id ]['details'] ) ) {
		$scontent = isset( $_oscitas_slider[ $id ]['details'] ) && is_array( $_oscitas_slider[ $id ]['details'] ) ? implode( '', $_oscitas_slider[ $id ]['details'] ) : '';

		$output .= '<div id="oscitas-slider-' . $id . '" class="carousel ebs-carousel slide ' . $class . EBS_CONTAINER_CLASS . '" data-ride="carousel" data-interval="' . $interval . '" data-pause="' . $pause . '" data-wrap="' . $wrap . '">';
		if ( '' !== $atts['bullets'] ) {
			$output .= ' <ol class="carousel-indicators">' . $bulllet_content . '</ol>';
		}

		$output .= ' <div class="carousel-inner ' . EBS_CONTAINER_CLASS . '" >' . $scontent;
		$output .= '</div>';

		if ( '' !== $atts['controls'] ) {
			$output .= ' <a class="left carousel-control" href="#oscitas-slider-' . $id . '" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#oscitas-slider-' . $id . '" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>';
		}

		$output .= '</div>';

		Dynamic_Css::add(
			"
#oscitas-slider-{$id} a.carousel-control span{
    color:{$navcolor};
}
#oscitas-slider-{$id} ol.carousel-indicators {
    margin:0;
}
#oscitas-slider-{$id} ol.carousel-indicators li{
    border-color:{$navcolor};
    margin :1px;
    float: left;
}
#oscitas-slider-{$id} ol.carousel-indicators li.active{
    background-color:{$navcolor};
}
#oscitas-slider-{$id} .carousel-caption .ebs-caption{
    color:#FFFFFF;
    color:{$captioncolor};
    line-height:1.5;
    margin:0;
    padding:0;
}
#oscitas-slider-{$id} .carousel-inner > .item > img,  #oscitas-slider-{$id} .carousel-inner > .item > a > img{
    width:100%;
}
        "
		);
	}

	$_oscitas_slider['current_id'] -= 1;

	return $output;
}

ebs_backward_compatibility_callback( 'slider', 'osc_theme_sliders' );

function osc_theme_slider( $params, $content = null ) {
	global $_oscitas_slider, $_oscitas_slider_slides;

	$index = $_oscitas_slider['current_id'];
	if ( ! isset( $_oscitas_slider_slides[ $index ] ) ) {
		$_oscitas_slider_slides[ $index ] = array();
	}

	$atts = shortcode_atts(
		array(
			'title'   => 'title',
			'image'   => '',
			'caption' => '',
			'active'  => '',
			'slideid' => count( $_oscitas_slider_slides[ $index ] ),
		),
		$params
	);

	$title   = Sanitizer::html( $atts['title'] );
	$image   = Sanitizer::url( $atts['image'] );
	$caption = Sanitizer::html( $atts['caption'] );
	$active  = Sanitizer::class_list( $atts['active'] );
	$slideid = Sanitizer::int( $atts['slideid'] );

	if ( ! empty( $atts['image'] ) ) {
		$_oscitas_slider[ $index ]['bullets'][] = '<li data-target="#oscitas-slider-' . $index . '" data-slide-to="' . $slideid . '" class="' . $active . '"></li>';
		$_oscitas_slider_slides[ $index ][ $slideid ] = array();

		$caption_html = '';
		if ( ! empty( $atts['caption'] ) ) {
			$caption_html = '<p class="ebs-caption">' . $caption . '</p>';
		}
		if ( ! empty( $content ) ) {
			$caption_html = '<p class="ebs-caption">' . do_shortcode( $content ) . '</p>';
		}

		$_oscitas_slider[ $index ]['details'][] =
			'<div class="item ' . $active . EBS_CONTAINER_CLASS . '">' .
				'<img src="' . $image . '" >' .
				'<div class="carousel-caption' . EBS_CONTAINER_CLASS . '">' .
					'<h3 class="ebs-caption">' . $title . '</h3>' .
					$caption_html .
				'</div>' .
			'</div>';
	}
}

ebs_backward_compatibility_callback( 'slide', 'osc_theme_slider' );
