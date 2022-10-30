<?php
function im_get_data() {
    /* 
        $restaurantName = get_post_meta( $post->ID, '_restaurant_name', true); 
        $startDate = get_post_meta( $post->ID, '_start_date', true); 
        $endDate = get_post_meta( $post->ID, '_end_date', true); 
        $total = get_post_meta( $post->ID, '_total', true); 
        $status = get_post_meta( $post->ID, '_status', true); 
        $fees = get_post_meta( $post->ID, '_fees', true); 
        $transfer = get_post_meta( $post->ID, '_transfer', true); 
    */

    $length = $_POST['length'];
    $draw = $_POST['draw'];

    $the_query = new WP_Query( array( 
        'posts_per_page' => $length, 
        's' => esc_attr( $_POST['keyword'] ), 
        'post_type' => 'invoice_manager'
    ) );
    $posts = $the_query->posts;

    print_r($posts);
    print_r($the_query);
    $arrayData =  array(
        ["id" => "1234",
        "invoice_id" => "1234",
        "restaurant_name" => "1234",
        "start_date" => "1234",
        "end_date" => "1234",
        "total" => "1234",
        "status" => "1234",
        "fees" => "1234",
        "transfer" => "1234"]
    );

    $tableData = array(
        "draw" => $draw,
        "recordsTotal" => 57,
        "recordsFiltered" => 57,
        "data" => $arrayData
    );
    $json = json_encode($tableData);
    die($json);
 }

/* enable to allow AJAX request for non-login users */
// add_action("wp_ajax_nopriv_im_get_data", "im_get_data");

/* AJAX request for login users only */
add_action("wp_ajax_im_get_data", "im_get_data");