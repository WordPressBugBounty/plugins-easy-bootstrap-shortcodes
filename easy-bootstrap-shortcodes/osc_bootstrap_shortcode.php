<?php
/*
  Plugin Name: Easy Bootstrap Shortcode
  Plugin URI: http://www.oscitasthemes.in
  Description: Add bootstrap 3.0.3 styles to your theme by wordpress editor shortcode buttons.
  Version: 5.0.0
  Requires at least: 6.5
  Tested up to: 7.0
  Requires PHP: 7.4
  Author: oscitas
  Author URI: http://www.oscitasthemes.in
  License: GPLv2 or later
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: easy-bootstrap-shortcodes
  Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * function used to check whether ebs activated this check included in EBS Pro
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- Legacy global kept for extension compatibility.
$_EBS_SESSION_STARTED = false;
function osc_ebs_plugin_exists( $prevent ) {
    return 'ebs';
}
$checkplugin=apply_filters('osc_ebs_pro_plugin_exists',false);
if(isset($checkplugin) && $checkplugin=='ebsp'):
    add_action('admin_notices', 'ebs_showAdminMessages');

    function ebs_showMessage($message, $errormsg = false)
    {
        if ($errormsg) {
            echo '<div id="message" class="error ebs_notification">';
        }
        else {
            echo '<div id="message" class="update-nag ebs_notification">';
        }
        echo '<p><strong>' . esc_html( $message ) . '</strong></p></div>';
    }

    /*
     * Show message when EBS and EBS pro both activated
     */
    function ebs_showAdminMessages()
    {
        ebs_showMessage(__("Easy Bootstrap Shortcode Pro activated, deactivate Easy Bootstrap Shortcode free version", 'easy-bootstrap-shortcodes'), false);
    }
else:
    /*
    Define Global variable and constants
    */
    add_filter( 'osc_ebs_plugin_exists', 'osc_ebs_plugin_exists' );
    define('EBS_PLUGIN_URL',plugins_url('/',__FILE__));
    define('EBS_JS_CDN','https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js');
    define('EBS_RESPOND_CDN','https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js');
    define('EBS_VERSION', '5.0.0');

    require_once __DIR__ . '/includes/class-ebs-sanitizer.php';
    require_once __DIR__ . '/includes/class-ebs-dynamic-css.php';
    require_once __DIR__ . '/includes/class-ebs-gutenberg.php';

    \EBS\Styles\Dynamic_Css::register();
    \EBS\Editor\Gutenberg::register();
    add_action('admin_init','check_ebsp_status');
    function check_ebsp_status(){
        $file   = basename( __FILE__ );
        $folder = basename( dirname( __FILE__ ) );
        $hook = "after_plugin_row_{$folder}/{$file}";
        add_action( $hook, 'ebsp_register_licence_key');
    }
    function ebsp_register_licence_key( $plugin_name )

    {
        $ebsprefix='ebsp';
        $plugin_name='easy-bootstrap-shortcode-pro/osc_bootstrap_shortcode.php ';
        echo '</tr><tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">' . wp_kses(
            __( 'Easy Bootstrap Shortcode Pro also available, <a href="http://oscitasthemes.in/products/easy-bootstrap-shortcodes-pro/">click here</a> to purchase one now', 'easy-bootstrap-shortcodes' ),
            array(
                'a' => array( 'href' => true ),
            )
        ) . '</div></td>';
    }

    add_action('admin_enqueue_scripts', 'osc_add_admin_ebs_scripts');
    add_action('admin_menu', 'osc_ebs_add_admin_menu');
    add_filter('mce_external_plugins', 'osc_editor_enable_mce');
    /*
     * Include bootstrap js and css file if activated theme is not an oscitas product
     */
    if(!apply_filters('plugin_oscitas_theme_check',false)){
        add_action('wp_enqueue_scripts', 'osc_add_frontend_ebs_scripts',-100);
    }



    register_activation_hook(__FILE__, 'osc_ebs_activate_plugin');
    register_deactivation_hook(__FILE__, 'osc_ebs_deactivate_plugin');

    /*
     * Plugin activation hook set default plugin setting on activation
     */
    function osc_ebs_activate_plugin() {
        $isSet=apply_filters('ebs_custom_option',false);
        if (!$isSet) {

            // EBS_BOOTSTRAP_JS_LOCATION   '1' - for plugin file, '2' - don't user EBS files but use from other plugin or theme, '3' - to user CDN path
            update_option( 'EBS_BOOTSTRAP_JS_LOCATION', 1 );
            update_option( 'EBS_BOOTSTRAP_JS_CDN_PATH', EBS_JS_CDN );
            update_option( 'EBS_BOOTSTRAP_RESPOND_CDN_PATH', EBS_RESPOND_CDN );
            // EBS_BOOTSTRAP_RESPOND_LOCATION   '1' - for plugin file, '2' - don't user EBS files but use from other plugin or theme, '3' - to user CDN path
            update_option('EBS_BOOTSTRAP_RESPOND_LOCATION',2);

            // EBS_BOOTSTRAP_CSS_LOCATION   '1' - for plugin file, '2' - don't user EBS files but use from other plugin or theme
            update_option( 'EBS_BOOTSTRAP_CSS_LOCATION', 1 );
            update_option( 'EBS_EDITOR_OPT','icon');
            update_option( 'EBS_EDITOR_OPT','icon');
            if(get_option('EBS_SHORTCODE_PREFIX')==false){
                update_option( 'EBS_SHORTCODE_PREFIX', '' );
            }
            update_option( 'EBS_INCLUDE_FA',1);
            update_option( 'EBS_SESSION_CLOSE',0);
            if(get_option('EBS_CUSTOM_CSS')==''){
                update_option( 'EBS_CUSTOM_CSS','');
            }
        }

    }

    /*
     * Plugin deactivation hook, delete option on deactivation
     */
    function osc_ebs_deactivate_plugin() {
        $isSet=apply_filters('ebs_custom_option',false);
        if (!$isSet) {
            delete_option( 'EBS_BOOTSTRAP_JS_LOCATION' );
            delete_option( 'EBS_BOOTSTRAP_JS_CDN_PATH' );
            delete_option( 'EBS_BOOTSTRAP_CSS_LOCATION');
            delete_option( 'EBS_BOOTSTRAP_RESPOND_LOCATION' );
            delete_option( 'EBS_BOOTSTRAP_RESPOND_CDN_PATH' );
            delete_option('EBS_EDITOR_OPT');
            delete_option('EBS_INCLUDE_FA');
            delete_option('EBS_SESSION_CLOSE');
        }
    }

    /*
     * Add plugin setting page on plugin listing page after activation
     */
    function osc_ebs_settings_link( $links ) {
        $isSet=apply_filters('ebs_custom_option',false);
        if (!$isSet) {
            $settings_link = '<a href="admin.php?page=ebs/ebs-settings.php">'.__('Settings', 'easy-bootstrap-shortcodes').'</a>';
            array_push( $links, $settings_link );
        }
        return $links;
    }

    add_filter( "plugin_action_links_".plugin_basename( __FILE__ ), 'osc_ebs_settings_link' );

    /*
     * Create EBS admin Menu
     */
    function osc_ebs_add_admin_menu() {
        $isSet=apply_filters('ebs_custom_option',false);
        if (!$isSet) {
            add_menu_page(__('EBS Settings', 'easy-bootstrap-shortcodes'), __('EBS Settings', 'easy-bootstrap-shortcodes'), 'manage_options', 'ebs/ebs-settings.php', 'osc_ebs_setting_page', plugins_url('/images/icon.png', __FILE__));

            $sub_page= add_submenu_page( 'ebs/ebs-settings.php',__('osCitas Offers', 'easy-bootstrap-shortcodes'), __('osCitas Offers', 'easy-bootstrap-shortcodes'), 'manage_options', 'ebs-pro-demo', 'osc_ebs_pro_demo_page' );
            add_action('admin_print_styles-' . $sub_page, 'ebsProDemoPage_register_admin_styles');
        }
    }


    /*
     * Add EBS pto Demo page css
     */
    function ebsProDemoPage_register_admin_styles(){
        wp_enqueue_style('ebs_pro_demo', EBS_PLUGIN_URL.'styles/ebs_pro_demo.css');
    }
    function osc_ebs_pro_demo_page(){
        include 'lib/ebspro-demo.php';
    }

/*
 * Render EBS Setting Page & update EBS options
 */
    function osc_ebs_setting_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to access this page.', 'easy-bootstrap-shortcodes' ) );
        }

        if ( isset( $_POST['ebs_submit'] ) ) {
            check_admin_referer( 'ebs_save_settings', 'ebs_settings_nonce' );

            $js_location = isset( $_POST['b_js'] ) ? absint( $_POST['b_js'] ) : 1;
            if ( $js_location < 1 || $js_location > 3 ) {
                $js_location = 1;
            }

            $css_location = isset( $_POST['b_css'] ) ? absint( $_POST['b_css'] ) : 1;
            if ( $css_location < 1 || $css_location > 3 ) {
                $css_location = 1;
            }

            $respond_location = isset( $_POST['respond_js'] ) ? absint( $_POST['respond_js'] ) : 2;
            if ( $respond_location < 1 || $respond_location > 3 ) {
                $respond_location = 2;
            }

            $editor_opt = isset( $_POST['ebsp_editor_opt'] ) ? sanitize_key( $_POST['ebsp_editor_opt'] ) : 'icon';
            if ( ! in_array( $editor_opt, array( 'icon', 'dropdown' ), true ) ) {
                $editor_opt = 'icon';
            }
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized via Sanitizer::custom_css().
            $custom_css = isset( $_POST['ebs_custom_css'] ) ? \EBS\Security\Sanitizer::custom_css( wp_unslash( $_POST['ebs_custom_css'] ) ) : '';
            $fa_icon    = isset( $_POST['fa_icon'] ) ? 1 : 0;
            $session_close = isset( $_POST['use_ebs_session_close'] ) ? 1 : 0;
            $shortcode_prefix = isset( $_POST['shortcode_prefix'] ) ? sanitize_key( wp_unslash( $_POST['shortcode_prefix'] ) ) : '';
            $cdn_path = isset( $_POST['cdn_path'] ) ? esc_url_raw( wp_unslash( $_POST['cdn_path'] ) ) : EBS_JS_CDN;
            $respond_cdn_path = isset( $_POST['respond_cdn_path'] ) ? esc_url_raw( wp_unslash( $_POST['respond_cdn_path'] ) ) : EBS_RESPOND_CDN;

            update_option( 'EBS_BOOTSTRAP_JS_LOCATION', $js_location );
            update_option( 'EBS_BOOTSTRAP_JS_CDN_PATH', $cdn_path );
            update_option( 'EBS_BOOTSTRAP_CSS_LOCATION', $css_location );
            update_option( 'EBS_BOOTSTRAP_RESPOND_LOCATION', $respond_location );
            update_option( 'EBS_BOOTSTRAP_RESPOND_CDN_PATH', $respond_cdn_path );
            update_option( 'EBS_EDITOR_OPT', $editor_opt );
            update_option( 'EBS_CUSTOM_CSS', $custom_css );
            update_option( 'EBS_INCLUDE_FA', $fa_icon );
            update_option( 'EBS_SESSION_CLOSE', $session_close );
            update_option( 'EBS_SHORTCODE_PREFIX', $shortcode_prefix );

            $js = $js_location;
            $cdn = $cdn_path;
            $css = $css_location;
            $respond = $respond_location;
            $respondcdn = $respond_cdn_path;
            $ebsp_editor_opt = $editor_opt;
            $ebs_custom_css = $custom_css;
            $shortcode_prefix = $shortcode_prefix;
            $use_ebs_session_close = $session_close;
        } else {
            $js = get_option( 'EBS_BOOTSTRAP_JS_LOCATION', 1 );
            $cdn = get_option( 'EBS_BOOTSTRAP_JS_CDN_PATH', EBS_JS_CDN );
            $css = get_option( 'EBS_BOOTSTRAP_CSS_LOCATION', 1 );
            $respond = get_option( 'EBS_BOOTSTRAP_RESPOND_LOCATION', 2 );
            $respondcdn = get_option( 'EBS_BOOTSTRAP_RESPOND_CDN_PATH', EBS_RESPOND_CDN );
            $ebsp_editor_opt=get_option('EBS_EDITOR_OPT','icon');
            $ebs_custom_css=get_option('EBS_CUSTOM_CSS','');
            $shortcode_prefix=get_option('EBS_SHORTCODE_PREFIX','');
            $fa_icon=get_option('EBS_INCLUDE_FA',1);
            $use_ebs_session_close=get_option('EBS_SESSION_CLOSE',0);
        }
        include 'ebs_settings.php';
    }

    /*
     * Define global JS variable for admin panel
     */
    add_action('admin_head', 'osc_ebs_ajax_ul');
    function osc_ebs_ajax_ul(){
        $ebsp_editor_opt=get_option('EBS_EDITOR_OPT','icon');

        ?>
        <script type="text/javascript">
            var ebs_ajaxurl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
            var ebs_url='<?php echo esc_url( EBS_PLUGIN_URL ); ?>';
            var ebs_editor_opt='<?php echo esc_js( $ebsp_editor_opt ); ?>';
            var ebs_dropdown_obj=<?php echo wp_json_encode( ebs_shortcodes() ); ?>;
            var ebs_dropdown_grp=<?php echo wp_json_encode( ebs_groups() ); ?>;

        </script>
    <?php
    }

    /*
     * Add css and scripts to admin panel
     */
    function osc_add_admin_ebs_scripts() {
        global $pagenow;
        $fa_icon=get_option('EBS_INCLUDE_FA',1);
        $use_ebs_session_close=get_option('EBS_SESSION_CLOSE',0);
        $screen = get_current_screen();
        if ($screen->id == 'toplevel_page_ebs/ebs-settings') {
            wp_enqueue_style('ebs-setting', plugins_url('/styles/ebs-setting.min.css', __FILE__));
        }
        wp_enqueue_script('ebs-main', plugins_url('/js/ebs_main.js', __FILE__), array( 'jquery' ), EBS_VERSION, true );
        $shortcode_prefix=get_option('EBS_SHORTCODE_PREFIX','');
        wp_localize_script( 'ebs-main', 'ebs', array(
            'font_awe'=>$fa_icon,
            'ebs_prefix'=>$shortcode_prefix
        ));

    }

    /*
     * Add additional css to tinymce editor
     */
    add_action('admin_print_styles','ebsp_tinymce_button_css');
    function ebsp_tinymce_button_css() {

        wp_register_style('ebsp_tinymce_button_css', plugins_url('/styles/editor.css', __FILE__), array());

        wp_enqueue_style('ebsp_tinymce_button_css');


        wp_enqueue_style('dashicons');

    }
/*
 * Add css to tinymce editor
 */
    function osc_editor_enable_mce($plugin_array){
        $fa_icon=get_option('EBS_INCLUDE_FA',1);
        $use_ebs_session_close=get_option('EBS_SESSION_CLOSE',0);
        wp_enqueue_script('jquery');
        wp_enqueue_style('thickbox');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script('jquery-ui-slider');
//        wp_enqueue_script('jquery-ui-dialog');
//        wp_enqueue_style ( 'wp-jquery-ui-dialog');
        wp_enqueue_style('ebs-magnific-popup', plugins_url('/styles/magnific-popup.css', __FILE__));  wp_enqueue_script('ebs-magnific-popup', plugins_url('/js/magnific-popup.js', __FILE__));
        wp_enqueue_style('EBS_jquery-ui-slider-css', plugins_url('/styles/slider.css', __FILE__));
        if (!apply_filters('ebs_bootstrap_icon_css_url',false)) {
            wp_enqueue_style('bootstrap-icon', plugins_url('/styles/bootstrap-icon.min.css', __FILE__));
        } else{
            wp_enqueue_style('bootstrap-icon', apply_filters('ebs_bootstrap_icon_css_url',false));
        }

        if (!apply_filters('ebs_custom_bootstrap_admin_css',false)) {
            wp_enqueue_style('ebs_bootstrap_admin', plugins_url('/styles/bootstrap_admin.min.css', __FILE__));
        } if($fa_icon==1){
            wp_enqueue_style('bootstrap-fa-icon', plugins_url('/styles/font-awesome.min.css', __FILE__));
        }
        return $plugin_array;
    }

    /*
     * Add bootstrap css and js to frontend if current theme is not an oscitas theme
     */
    function osc_add_frontend_ebs_scripts() {
        wp_enqueue_script('jquery');
        $isSet=apply_filters('ebs_custom_option',false);
        if (!$isSet) {
            $js = get_option( 'EBS_BOOTSTRAP_JS_LOCATION', 1 );
            $respond = get_option( 'EBS_BOOTSTRAP_RESPOND_LOCATION', 2 );
            $cdn = get_option( 'EBS_BOOTSTRAP_JS_CDN_PATH', EBS_JS_CDN );
            $respondcdn = get_option( 'EBS_BOOTSTRAP_RESPOND_CDN_PATH', EBS_RESPOND_CDN );
            $css = get_option( 'EBS_BOOTSTRAP_CSS_LOCATION', 1 );
            $fa_icon=get_option('EBS_INCLUDE_FA',1);
            $use_ebs_session_close=get_option('EBS_SESSION_CLOSE',0);
//			http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js

            if ($js == 1) {
                if (!apply_filters('ebs_bootstrap_js_url',false)) {
                    wp_enqueue_script('bootstrap', plugins_url('/js/bootstrap.min.js', __FILE__));
                } else{
                    wp_enqueue_script('bootstrap', apply_filters('ebs_bootstrap_js_url',false));
                }
            } elseif ($js == 3) {
                if (!apply_filters('ebs_bootstrap_js_cdn',false)) {
                    wp_enqueue_script('bootstrap', $cdn);
                } else{
                    wp_enqueue_script('bootstrap', apply_filters('ebs_bootstrap_js_cdn',false));
                }
            }
            //$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
            $user_agent = isset( $_SERVER['HTTP_USER_AGENT'] )
                    ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) )
                    : '';
            if ( $user_agent && preg_match( '/(?i)msie [1-8]/', $user_agent ) ) {
                if ($respond == 1) {
                    if (!apply_filters('ebs_bootstrap_respond_url',false)) {
                        wp_enqueue_script('bootstrap_respond', plugins_url('/js/respond.min.js', __FILE__));
                    } else{
                        wp_enqueue_script('bootstrap_respond', apply_filters('ebs_bootstrap_respond_url',false));
                    }
                } elseif ($respond == 3) {
                    if (!apply_filters('ebs_bootstrap_respond_cdn',false)) {
                        wp_enqueue_script('bootstrap_respond', $respondcdn);
                    } else{
                        wp_enqueue_script('bootstrap_respond', apply_filters('ebs_bootstrap_respond_cdn',false));
                    }
                }
            }
            if ($css == 1) {
                if (!apply_filters('ebs_bootstrap_css_url',false)) {
                    wp_enqueue_style('bootstrap', plugins_url('/styles/bootstrap.min.css', __FILE__));
                } else {
                    wp_enqueue_style('bootstrap', apply_filters('ebs_bootstrap_css_url',false));
                }
            }
            elseif($css==3){
                if (!apply_filters('ebs_no_bootstrap_theme_css_url',false)) {
                    wp_enqueue_style('bootstrap', plugins_url('/styles/bootstrap-oscitas.css', __FILE__));
                } else {
                    wp_enqueue_style('bootstrap', apply_filters('ebs_no_bootstrap_theme_css_url',false));
                }

            }
            else {
                if (!apply_filters('ebs_bootstrap_icon_css_url',false)) {
                    //wp_enqueue_style('bootstrap-icon', plugins_url('/styles/bootstrap-icon.min.css', __FILE__));
                } else{
                    wp_enqueue_style('bootstrap-icon', apply_filters('ebs_bootstrap_icon_css_url',false));
                }
            }
            if($fa_icon==1){
                if(!apply_filters('ebs_bootstrap_fa_icon_include_from_theme_or_plugin',false)){
                    if (!apply_filters('ebs_bootstrap_fa_icon_frontend_css_url',false)) {
                        wp_enqueue_style('bootstrap-fa-icon', plugins_url('/styles/font-awesome.min.css', __FILE__));
                    } else{
                        wp_enqueue_style('bootstrap-fa-icon', apply_filters('ebs_bootstrap_fa_icon_frontend_css_url',false));
                    }
                }
            }
        }
    }

// Shortcodes

    /**
     * Legacy no-op kept for backward compatibility with extensions.
     */
    function ebs_session_start() {}

    /**
     * Legacy no-op kept for backward compatibility with extensions.
     */
    function ebs_session_end() {}

    include('shortcode/functions.php');
    include('lib/widget.php');
endif;
