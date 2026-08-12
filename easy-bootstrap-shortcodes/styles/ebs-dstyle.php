<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

header( 'Content-type: text/css; charset=UTF-8' );

require_once dirname( __DIR__ ) . '/includes/class-ebs-sanitizer.php';

$ebs_css_ebs = '.osc_servicebox {
    padding: 1px;
    text-align: center;
    transition: background-color 0.2s linear 0s, color 0.2s linear 0s;
    width: 100%;
    margin: 0 0 10px 0;
}

.icon_bg{
    font-size: 40px;
}
.osc_servicebox h1, .osc_servicebox h2, .osc_servicebox h3, .osc_servicebox h4, .osc_servicebox h5, .osc_servicebox h6{
    font-size: 20px;
    font-weight: normal;
    letter-spacing: -1px;
    margin: 9px 0;
    padding-bottom: 9px;
    padding-top: 3px;
    text-align: center;
    text-transform: uppercase;
}
.osc_servicebox_readmore {
    border-radius: 5px;
    display: inline-block;
    margin: 15px 0 20px;
    padding: 8px 15px;
    text-decoration:none;
}
.iconcircle{
    margin: 30px auto;
}

.iconcircle{ background-color: #FFFFFF; border-radius: 50%; -moz-border-radius: 50%; -webkit-border-radius: 50%; -ms-border-radius: 50%;
    -o-border-radius: 50%; height: 100px;  line-height: 90px;   width: 100px; }';

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS sanitized by Sanitizer::custom_css().
echo \EBS\Security\Sanitizer::custom_css( $ebs_css_ebs );

if ( ! session_id() ) {
	session_start();
}

//if ( isset( $_SESSION['ebs_servicebox_css'] ) && is_array( $_SESSION['ebs_servicebox_css'] ) && count( $_SESSION['ebs_servicebox_css'] ) > 0 ) {
//	foreach ( $_SESSION['ebs_servicebox_css'] as $ebs_sbox ) {
//		if ( isset( $_SESSION[ $ebs_sbox ] ) ) {
//            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS sanitized by Sanitizer::custom_css().
//            echo \EBS\Security\Sanitizer::custom_css( (string) $_SESSION[ $ebs_sbox ] );
//		}
//	}
//}

if ( isset( $_SESSION['ebs_servicebox_css'] ) && is_array( $_SESSION['ebs_servicebox_css'] ) ) {
    foreach ( $_SESSION['ebs_servicebox_css'] as $ebs_sbox ) {
        $ebs_sbox = sanitize_key( wp_unslash( (string) $ebs_sbox ) );
        if ( '' === $ebs_sbox || ! isset( $_SESSION[ $ebs_sbox ] ) ) {
            continue;
        }
        $css = sanitize_text_field( wp_unslash( (string) $_SESSION[ $ebs_sbox ] ) );
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS sanitized by Sanitizer::custom_css().
        echo \EBS\Security\Sanitizer::custom_css( $css );
    }
}
