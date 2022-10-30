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
    $the_query = new WP_Query( array( 
        'posts_per_page' => $length, 
        's' => esc_attr( $_POST['search']['value'] ), 
        'post_type' => 'invoice_manager'
    ) );
    $draw = $_POST['draw'];
    $arrayData = array();
    $tableData = array(
        "draw" => $draw,
        "recordsTotal" => $the_query->post_count,
        "recordsFiltered" => $the_query->post_count,
        "data" => $arrayData
    );
    
    $posts = $the_query->posts;
    
    foreach ($posts as $key => $post) {
        $restaurantName = get_post_meta( $post->ID, '_restaurant_name', true); 
        $startDate = get_post_meta( $post->ID, '_start_date', true); 
        $endDate = get_post_meta( $post->ID, '_end_date', true); 
        $total = get_post_meta( $post->ID, '_total', true); 
        $status = get_post_meta( $post->ID, '_status', true); 
        $fees = get_post_meta( $post->ID, '_fees', true); 
        $transfer = get_post_meta( $post->ID, '_transfer', true); 
        $order = get_post_meta( $post->ID, '_order', true); 
        
        $arrayData[] = [
            "id" => $post->ID,
            "invoice_id" => $post->post_title,
            "restaurant_name" => $restaurantName,
            "start_date" => $startDate,
            "end_date" => $endDate,
            "total" =>  $total,
            "status" => $status,
            "fees" => $fees,
            "orders" => $order,
            "transfer" => $transfer
        ];
    }

    $tableData['data'] =  $arrayData;
    $json = json_encode($tableData);
    die($json);
 }

/* enable to allow AJAX request for non-login users */
// add_action("wp_ajax_nopriv_im_get_data", "im_get_data");

/* AJAX request for login users only */
add_action("wp_ajax_im_get_data", "im_get_data");