<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use EBS\Security\Sanitizer;

/* * *********************************************************
 * Row
 * ********************************************************* */

function osc_theme_row($params, $content = null) {
    $atts = shortcode_atts(array(
        'class' => ''
    ), $params);
    $class = Sanitizer::class_list( $atts['class'] );
    $result = '<div class="row ' . $class . EBS_CONTAINER_CLASS . '">';
    $content = str_replace("]<br />", ']', $content);
    $content = str_replace("<br />\n[", '[', $content);
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('row', 'osc_theme_row');
/* * *********************************************************
 * TWO
 * ********************************************************* */

function osc_theme_column($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'lg' => '',
        'mdoff' => '',
        'smoff' => '',
        'xsoff' => '',
        'lgoff' => '',
        'mdhide' => '',
        'smhide' => '',
        'xshide' => '',
        'lghide' => '',
        'mdclear' => '',
        'smclear' => '',
        'xsclear' => '',
        'lgclear' => '',
        'off' => ''
    ), $params);

    $arr = array('md', 'xs', 'sm');
    $classes = array();
    foreach ($arr as $k => $aa) {
        $val = $atts[$aa];
        if ($val == 12 || $val == '') {
            $classes[] = 'col-' . $aa . '-12';
        } else {
            $classes[] = 'col-' . $aa . '-' . Sanitizer::int( $val );
        }
    }
    $arr2 = array('mdoff', 'smoff', 'xsoff', 'lgoff');
    foreach ($arr2 as $k => $aa) {
        $nn = str_replace('off', '', $aa);
        $val = $atts[$aa];
        if ($val == 0 || $val == '') {
            //$classes[] = '';
        } else {
            $classes[] = 'col-' . $nn . '-offset-' . Sanitizer::int( $val );
        }
    }
    $arr2 = array('mdhide', 'smhide', 'xshide', 'lghide');
    foreach ($arr2 as $k => $aa) {
        $nn = str_replace('hide', '', $aa);
        if ($atts[$aa] == 'yes') {
            $classes[] = 'hidden-' . $nn;
        }
    }
    $arr2 = array('mdclear', 'smclear', 'xsclear', 'lgclear');
    foreach ($arr2 as $k => $aa) {
        $nn = str_replace('clear', '', $aa);
        if ($atts[$aa] == 'yes') {
            $classes[] = 'clear-' . $nn;
        }
    }
    $off = Sanitizer::int( $atts['off'] );
    if ($off !== 0) {
        $classes[] = 'col-lg-offset-' . $off;
    }

    $lg = Sanitizer::int( $atts['lg'] );
    $result = '<div class="col-lg-' . $lg . ' ' . implode(' ', $classes) . EBS_CONTAINER_CLASS . '">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('column', 'osc_theme_column');


function osc_theme_one_half($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-6 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . '  one-half">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_half', 'osc_theme_one_half');

function osc_theme_one_half_last($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-6 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' one-half-last">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_half_last', 'osc_theme_one_half_last');

/* * *********************************************************
 * THIRD
 * ********************************************************* */

function osc_theme_one_third($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="sc-column col-lg-4 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' ">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_third', 'osc_theme_one_third');

function osc_theme_one_third_last($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-4 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . '  column-last">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_third_last', 'osc_theme_one_third_last');

function osc_theme_two_third($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class=" col-lg-8 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' ">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('two_third', 'osc_theme_two_third');

function osc_theme_two_third_last($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-8 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . '  column-last ">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('two_third_last', 'osc_theme_two_third_last');

/* * *********************************************************
 * FOURTH
 * ********************************************************* */

function osc_theme_one_fourth($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-3 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' one-fourth">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_fourth', 'osc_theme_one_fourth');

function osc_theme_one_fourth_last($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-3 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' column-last one-fourth-last">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_fourth_last', 'osc_theme_one_fourth_last');

function osc_theme_three_fourth($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-3 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . '  three-fourth">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('three_fourth', 'osc_theme_three_fourth');

function osc_theme_three_fourth_last($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-6  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' column-last three-fourth-last">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('three_fourth_last', 'osc_theme_three_fourth_last');

function osc_theme_one_fourth_second($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-3  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' one-fourth-second">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_fourth_second', 'osc_theme_one_fourth_second');

function osc_theme_one_fourth_third($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }

    $result = '<div class="col-lg-3  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' one-fourth-third">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_fourth_third', 'osc_theme_one_fourth_third');

function osc_theme_one_half_second($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-6  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' one-half-second">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_half_second', 'osc_theme_one_half_second');

function osc_theme_one_third_second($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-4  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' one-third-second">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_third_second', 'osc_theme_one_third_second');

function osc_theme_one_column($params, $content = null) {
    $atts = shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params);
    $md = $atts['md'];
    $sm = $atts['sm'];
    $xs = $atts['xs'];
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . Sanitizer::int( $md );
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . Sanitizer::int( $sm );
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . Sanitizer::int( $xs );
    }
    $result = '<div class="col-lg-12  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . Sanitizer::int( $atts['off'] ) . EBS_CONTAINER_CLASS . ' one-column">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

ebs_backward_compatibility_callback('one_column', 'osc_theme_one_column');
