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
