<?php

function test_shortcode_function($atts) {
    $a = shortcode_atts( array(
        'fake' => 'fake',
        'real' => 'real',
    ), $atts );

    //return "foo = {$a['foo']}";

    $return_string= "{$a['real']} is {$a['fake']}";
    return $return_string;
}

function register_test_shortcode(){
    add_shortcode('ehsan', 'test_shortcode_function');
}

add_action( 'init', 'register_test_shortcode');

function wp_rpt_shortcode($atts)
{
    $a = shortcode_atts(array(
        'ids' => '1,2,3',
        'featured' => '',
    ), $atts);

    //$return_string= "{$a['ids']} is {$a['featured']}";

    $post_id_array = explode(",", $a['ids']);
    print_r($post_id_array);
    $query = new WP_Query(array('post_type' => 'wp-rpt-cpt', 'post__in' => $post_id_array));
// The Loop
    $return_string = "";
    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {

            $query->the_post();
            ?>
            <h1><?php the_title() ?></h1>
            <div class='post-content'><?php the_content() ?></div>
            <?php
        }
    }
    else{
    ?>

    Oops, there are no posts.

    <?php
}

// Reset Query
    wp_reset_query();

    return ob_get_clean();
}

function register_rpt_shortcode(){
    add_shortcode('wp_rpt', 'wp_rpt_shortcode');
}

add_action( 'init', 'register_rpt_shortcode');