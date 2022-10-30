<?php
/**
 * Enqueue a script in invoice_manager post type.
 *
 * @param int $hook Hook suffix for the current admin page.
 */

 
function im_enqueue_admin_scripts( $hook ) {
    $screen = get_current_screen();
    if  ( 'invoice_manager' != $screen->post_type ) {
        return;
    }
    wp_enqueue_style( 'im-admin-styles', plugin_url . 'assets/css/styles.css');
    wp_enqueue_style( 'im-admin-ui', 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css');
    wp_enqueue_script( 'im-admin-script', plugin_url . 'assets/js/scripts.js', array('jquery', 'jquery-ui-datepicker'), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'im_enqueue_admin_scripts' );

function im_enqueue_shortcode_scripts() {
    /* 
        Register Scripts 
    */
    wp_register_style( 'im-data-table-styles-min', plugin_url . 'assets/datatables/datatables.min.css' , array(), '1.0.0', 'all' );
    wp_register_style( 'im-data-table-bootstrap-styles-min', plugin_url . 'assets/datatables/Bootstrap-5-5.1.3/css/bootstrap.min.css' , array('im-data-table-styles-min'), '1.0.0', 'all' );
    wp_register_style( 'im-data-table-styles', plugin_url . 'assets/css/data-table-styles.css' , array(), '1.0.0', 'all' );
    wp_register_script( 'im-data-table-scripts', plugin_url . 'assets/datatables/datatables.min.js', array('jquery'), '1.0.0', 'all' );
    wp_register_script( 'im-data-table-scripts-bootstrap', plugin_url . 'assets/datatables/Bootstrap-5-5.1.3/js/bootstrap.bundle.min.js', array('im-data-table-scripts'), '1.0.0', 'all' );
    wp_register_script( 'im-table-scripts', plugin_url . 'assets/js/data-table-script.js' , array('im-data-table-scripts'), '1.0.0', 'all' );
    wp_localize_script( 'im-table-scripts', 'imAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
}

add_action( 'wp_enqueue_scripts', 'im_enqueue_shortcode_scripts' );
