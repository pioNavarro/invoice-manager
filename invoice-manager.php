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


function im_register_invoice() {

	/**
	 * Post Type: invoices.
	 */

	$labels = [
		"name" => esc_html__( "invoices", "invoice-manager" ),
		"singular_name" => esc_html__( "invoice", "invoice-manager" ),
		"menu_name" => esc_html__( "My invoices", "invoice-manager" ),
		"all_items" => esc_html__( "All invoices", "invoice-manager" ),
		"add_new" => esc_html__( "Add new", "invoice-manager" ),
		"add_new_item" => esc_html__( "Add new invoice", "invoice-manager" ),
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
		"label" => esc_html__( "invoices", "twentytwentytwo" ),
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
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "invoice", $args );
}

add_action( 'init', 'im_register_invoice' );
