<?php
function im_get_data() {

    $length = $_POST['length'];
    $start = $_POST['start'];
    $searchValue = $_POST['search']['value'];
    $order = $_POST['order'][0]['dir'];
    $column = $_POST['order'][0]['column'];
    $columnName = $_POST['columns'][$column]['data'];

    $metaQuery = array();

    // $keys = array('_restaurant_name','_status','_start_date','_end_date','_total','_fees','_transfer','_order');
    $keys = array('_restaurant_name','_status');

    foreach($keys as $key){
        $metaQuery[] = array(
            'key'     => $key,
            'value'   => $searchValue ,
            'compare' => 'LIKE'
        );
    }

    $the_query = new WP_Query(array( 
        '_meta_or_title'    => $searchValue,
        'posts_per_page'    => $length, 
        'post_status'       => 'publish',
        /* 's'                 => esc_attr( $searchValue ),  */
        'post_type'         => 'invoice_manager',
        'orderby'             =>   array( $columnName => $order ),
        'offset' => $start,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key'     => '_restaurant_name',
                'value'   => $searchValue ,
                'compare' => 'LIKE'
            ),
            array(
                'key'     => '_status',
                'value'   => $searchValue ,
                'compare' => 'LIKE'
            )
        ) 
    ));
    wp_reset_postdata(); //clean your query
    $draw = $_POST['draw'];
    $arrayData = array();
    $tableData = array(
        "the_query" => $the_query,
        "draw" => $draw,
        "recordsTotal" => $the_query->found_posts,
        "recordsFiltered" => $the_query->found_posts,
        "data" => $arrayData
    );
    
    $posts = $the_query->posts;
    
    foreach ($posts as $key => $post) {
        $restaurantName = get_post_meta( $post->ID, '_restaurant_name', true); 
        $startDate = get_post_meta( $post->ID, '_start_date', true);
        $startDate = (!empty($startDate)) ?  date('d/m/Y', strtotime($startDate)) : ''; 
        $endDate = get_post_meta( $post->ID, '_end_date', true); 
        $endDate = (!empty($endDate)) ?  date('d/m/Y', strtotime($endDate)) : ''; 
        $total = get_post_meta( $post->ID, '_total', true); 
        $status = get_post_meta( $post->ID, '_status', true); 
        $fees = get_post_meta( $post->ID, '_fees', true); 
        $transfer = get_post_meta( $post->ID, '_transfer', true); 
        $order = get_post_meta( $post->ID, '_order', true); 
        
        $arrayData[] = [
            "id" => $post->ID,
            "post_title" => $post->post_title,
            "_restaurant_name" => $restaurantName,
            "_start_date" => $startDate,
            "_end_date" =>   $endDate,
            "_total" =>  $total,
            "_status" => $status,
            "_fees" => $fees,
            "_orders" => $order,
            "_transfer" => $transfer,
            "image" => get_the_post_thumbnail( $post->ID, array( 32, 32), array( 'class' => 'alignleft' ) )
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

function mark_as_paid() {
    
    if(!count($_POST['post-ids'])) die('No Selected data');
    foreach ($_POST['post-ids'] as $postID) {
        update_post_meta($postID , '_status', 'verified' );
    }
    $json = json_encode(['success' => true, 'update' => count($_POST['post-ids'])]);
    die($json);
}

add_action("wp_ajax_mark_as_paid", "mark_as_paid");