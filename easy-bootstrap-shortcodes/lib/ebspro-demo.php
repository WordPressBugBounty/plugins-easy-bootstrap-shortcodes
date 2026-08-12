<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="ebs-prodemo-outer">
    <div class="ebspro-titlebar">
        <h1>osCitas Plugin <?php esc_html_e( 'Offeres', 'easy-bootstrap-shortcodes' ); ?></h1>
        <div class="osc-logo">
            <img src="<?php echo esc_url( EBS_PLUGIN_URL . 'images/osc-logo.png' ); ?>" alt="" />
        </div>
    </div>

    <div class="ebs-pro-content" style="margin-top: 10px; text-align: center;">
        <?php
        $ebs_offer_args = array(
            'method' => 'GET',
        );
        $ebs_offer_response = wp_remote_request( 'http://docs.oscitasthemes.in/offers/index.php', $ebs_offer_args );
        if ( ! is_wp_error( $ebs_offer_response ) ) {
            echo wp_kses_post( wp_remote_retrieve_body( $ebs_offer_response ) );
        }
        ?>
    </div>
</div>
