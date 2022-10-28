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
function im_add_page_template_to_dropdown( $templates )
{
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
function im_change_page_template($template)
{
    $isPage =  'templates/page-template.php';

    if (is_page() && $isPage =='templates/page-template.php') {
        $meta = get_post_meta(get_the_ID());
        if (!empty($meta['_wp_page_template'][0]) && $meta['_wp_page_template'][0] != $template && $isPage == $meta['_wp_page_template'][0]) {
            $template = plugin_dir_path. $meta['_wp_page_template'][0];
        }
    }

    return $template;
}