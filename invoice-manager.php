<?php
/*
Plugin Name: Invoice Manager
Plugin URI: https://github.com/pioNavarro/invoice-manager
Description: This is a Invoice Manager Sample.
Author: Pio Navarro
Author URI: https://www.linkedin.com/in/pio-navarro/
Version: 1.0
*/

define('plugin_dir_path', plugin_dir_path( __FILE__ ));
define('plugin_url', plugin_dir_url( __FILE__ ));

/* 
    enqueue scripts
*/
include(plugin_dir_path.'admin/enqueue.php');

/* 
    ajax request
*/
include(plugin_dir_path.'admin/ajax.php');

add_filter( 'theme_page_templates', 'im_add_page_template_to_dropdown' );
add_filter('template_include', 'im_change_page_template', 99);

/**
* Add page templates.
*
* @param  array  $templates  The list of page templates
*
* @return array  $templates  The modified list of page templates
*/
function im_add_page_template_to_dropdown( $templates ) {
   $templates['templates/page-template.php'] = __( 'Invoice Manager Template', 'invoice-manager' );

   return $templates;
}

/**
 * Change the page template to the selected template on the dropdown
 * 
 * @param $template
 *
 * @return mixed
 */
function im_change_page_template($template) {
    $isPage =  'templates/page-template.php';

    if (is_page() && $isPage =='templates/page-template.php') {
        $meta = get_post_meta(get_the_ID());
        if (!empty($meta['_wp_page_template'][0]) && $meta['_wp_page_template'][0] != $template && $isPage == $meta['_wp_page_template'][0]) {
            $template = plugin_dir_path. $meta['_wp_page_template'][0];
        }
    }

    return $template;
}

function im_get_header() {
    include(plugin_dir_path.'templates/template-header.php');
}

function im_get_footer() {
    include(plugin_dir_path.'templates/template-footer.php');
}

/* 
	Invoice Shortcode 
	Display invoice data table
*/

function im_datatable($atts) {
	wp_enqueue_style( 'im-data-table-styles-min' );
	wp_enqueue_style( 'im-data-table-bootstrap-styles-min' );
	wp_enqueue_style( 'im-data-table-styles' );
	wp_enqueue_script( 'im-data-table-scripts' );
	wp_enqueue_script( 'im-data-table-scripts-bootstrap' );
	wp_enqueue_script( 'im-table-scripts' );
    ob_start();
	include(plugin_dir_path.'shortcode/data-table.php');
    ?> Here <?php
    return ob_get_clean();
}

add_shortcode( 'invoice-table', 'im_datatable');

function im_register_invoice() {

	/**
	 * Post Type: invoice_manager.
	 */

	$labels = [
		"name" => esc_html__( "Invoice Manager", "invoice-manager" ),
		"singular_name" => esc_html__( "invoice", "invoice-manager" ),
		"menu_name" => esc_html__( "Manage invoices", "invoice-manager" ),
		"all_items" => esc_html__( "All invoices", "invoice-manager" ),
		"add_new" => esc_html__( "New invoice", "invoice-manager" ),
		"add_new_item" => esc_html__( "Invoice Number", "invoice-manager" ),
		"edit_item" => esc_html__( "Edit invoice", "invoice-manager" ),
		"new_item" => esc_html__( "New invoice", "invoice-manager" ),
		"view_item" => esc_html__( "View invoice", "invoice-manager" ),
		"view_items" => esc_html__( "View invoices", "invoice-manager" ),
		"search_items" => esc_html__( "Search invoices", "invoice-manager" ),
		"not_found" => esc_html__( "No invoices found", "invoice-manager" ),
		"not_found_in_trash" => esc_html__( "No invoices found in trash", "invoice-manager" ),
		"parent" => esc_html__( "Parent invoice:", "invoice-manager" ),
		"featured_image" => esc_html__( "Featured image for this invoice", "invoice-manager" ),
		"set_featured_image" => esc_html__( "Set featured image for this invoice", "invoice-manager" ),
		"remove_featured_image" => esc_html__( "Remove featured image for this invoice", "invoice-manager" ),
		"use_featured_image" => esc_html__( "Use as featured image for this invoice", "invoice-manager" ),
		"archives" => esc_html__( "invoice archives", "invoice-manager" ),
		"insert_into_item" => esc_html__( "Insert into invoice", "invoice-manager" ),
		"uploaded_to_this_item" => esc_html__( "Upload to this invoice", "invoice-manager" ),
		"filter_items_list" => esc_html__( "Filter invoices list", "invoice-manager" ),
		"items_list_navigation" => esc_html__( "invoices list navigation", "invoice-manager" ),
		"items_list" => esc_html__( "invoices list", "invoice-manager" ),
		"attributes" => esc_html__( "invoices attributes", "invoice-manager" ),
		"name_admin_bar" => esc_html__( "invoice", "invoice-manager" ),
		"item_published" => esc_html__( "invoice published", "invoice-manager" ),
		"item_published_privately" => esc_html__( "invoice published privately.", "invoice-manager" ),
		"item_reverted_to_draft" => esc_html__( "invoice reverted to draft.", "invoice-manager" ),
		"item_scheduled" => esc_html__( "invoice scheduled", "invoice-manager" ),
		"item_updated" => esc_html__( "invoice updated.", "invoice-manager" ),
		"parent_item_colon" => esc_html__( "Parent invoice:", "invoice-manager" ),
	];

	$args = [
		"label" => esc_html__( "Manage Invoice", "invoice-manager" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "invoice", "with_front" => true ],
		"query_var" => true,
        "menu_position" => 5,
        "menu_icon" => "dashicons-store",
		"supports" => [ "title", "editor", "thumbnail", "custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "invoice_manager", $args );    
}

function im_settings() {
    $success = false;
    if($_POST){
        //Update entire array
        update_option('im_options', $_POST);
        $success = true;
    }
    include(plugin_dir_path.'admin/settings.php');
}

function advert_add_to_menu() {
    add_submenu_page(
        'edit.php?post_type=invoice_manager', 
        esc_html__( "Settings", "invoice-manager" ), 
        esc_html__( "Settings", "invoice-manager" ), 
        'manage_options', 
        'im-settings', 
        'im_settings' 
    );
}

add_action('admin_menu', 'advert_add_to_menu');

add_action( 'init', 'im_register_invoice' );

function mi_placeholder_enter_title($title)
{
    $screen = get_current_screen();
    if  ( 'invoice_manager' != $screen->post_type ) {
        return  $title;
    }
   
     return $title = 'Invoice Number';
}

// Customize title place holder
add_filter( 'enter_title_here', 'mi_placeholder_enter_title', 99 );


/**
 * Register meta box(es).
 */

//related functions structure 
function add_my_action_boxes($post_type, $post){
			add_meta_box(
					'action_box_1',
					'Invoice Details',
					'call_back_function_one_to_show_content',
					'invoice_manager',
					'normal',
					'high',
			);
}

add_action('add_meta_boxes', 'add_my_action_boxes', 10, 2);

function call_back_function_one_to_show_content($post){
    $options = array('ongoing','verified','pending');
    $restaurantName = get_post_meta( $post->ID, '_restaurant_name', true); 
    $startDate = get_post_meta( $post->ID, '_start_date', true); 
    $endDate = get_post_meta( $post->ID, '_end_date', true); 
    $total = get_post_meta( $post->ID, '_total', true); 
    $status = get_post_meta( $post->ID, '_status', true); 
    $fees = get_post_meta( $post->ID, '_fees', true); 
    $transfer = get_post_meta( $post->ID, '_transfer', true); 
    include(plugin_dir_path.'admin/custom-fields.php');
    ?>
<?php
}

function call_back_function_two_to_show_content($post_id,$post, $update){
    // Only set for post_type = post!
	if ( 'invoice_manager' !== $post->post_type ) {
		return;
	}

    $keys = array('restaurant_name','start_date','end_date','total', 'status', 'fees', 'transfer');

    foreach($keys as $key):
        if ( array_key_exists( $key, $_POST ) ) {
            update_post_meta(
            $post_id,
            '_'.$key,
            $_POST[$key]
            );
        }
    endforeach;

    // print_r($_POST);
}

add_action( 'save_post', 'call_back_function_two_to_show_content', 99, 3);