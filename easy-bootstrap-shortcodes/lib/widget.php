<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * Create EBS widgets to to parse EBS shortcodes in sidebar
 */
add_action( 'widgets_init', 'osc_ebsp_content_widget' );

function osc_ebsp_content_widget() {
	register_widget( 'Ebs_Custom_Widget' );
}

class Ebs_Custom_Widget extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'   => 'ebs_custom_widget',
			'description' => __( 'EBS widget to show EBS/other shortcodes in sidebar.', 'easy-bootstrap-shortcodes' ),
		);
		$control_ops = array( 'id_base' => 'ebsp-widget' );
		parent::__construct( 'ebsp-widget', __( 'EBS Shortcode Compiler', 'easy-bootstrap-shortcodes' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		$title       = apply_filters( 'widget_title', $instance['title'] );
		$ebs_content = $instance['ebs_content'];

		echo wp_kses_post( $args['before_widget'] );

		if ( $title ) {
			echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] );
		}

		if ( $ebs_content ) {
			?>
			<div class="ebs_widget_content">
				<?php echo do_shortcode( $ebs_content ); ?>
			</div>
			<div class="clear"></div>
			<?php
		}

		echo wp_kses_post( $args['after_widget'] );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']       = wp_strip_all_tags( $new_instance['title'] );
		$instance['ebs_content'] = $new_instance['ebs_content'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'       => 'EBS Shortcode',
			'ebs_content' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'easy-bootstrap-shortcodes' ); ?>:</label>
			<input class="osc_ebs_input" style=" width: 100%; display: block;" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ebs_content' ) ); ?>"><?php esc_html_e( 'Shortcode', 'easy-bootstrap-shortcodes' ); ?>:</label>
			<textarea class="osc_ebs_input" style=" height: 250px;
    width: 100%; display: block;" id="<?php echo esc_attr( $this->get_field_id( 'ebs_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ebs_content' ) ); ?>" ><?php echo esc_textarea( $instance['ebs_content'] ); ?></textarea>
		</p>

		<?php
	}
}
