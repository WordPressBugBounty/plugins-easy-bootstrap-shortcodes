<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

header( 'Content-type: text/css; charset=UTF-8' );

require_once dirname( __DIR__ ) . '/includes/class-ebs-sanitizer.php';

if ( ! session_id() ) {
	session_start();
}

if ( isset( $_SESSION['ebs_dynamic_css'] ) ) {
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS sanitized by Sanitizer::custom_css().
    echo \EBS\Security\Sanitizer::custom_css( (string) $_SESSION['ebs_dynamic_css'] );
}

if ( isset( $_SESSION['ebs_slider_css'] ) && is_array( $_SESSION['ebs_slider_css'] ) ) {
	foreach ( $_SESSION['ebs_slider_css'] as $ebs_val ) {
		$ebs_slider_key = 'ebs_slider_each_' . $ebs_val;
		if ( isset( $_SESSION[ $ebs_slider_key ] ) ) {
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS sanitized by Sanitizer::custom_css().
            echo \EBS\Security\Sanitizer::custom_css( (string) $_SESSION[ $ebs_slider_key ] );
		}
	}
}
