<?php

function wp_rpt_shortcode($atts)
{
    $a = shortcode_atts(array(
        'ids' => '',
        'featured' => '',
        'column' => '3'
    ), $atts);

    if (!empty($a['ids'])):
        $post_id_array = explode(",", $a['ids']);
        $featured = $a['featured'];
        $column_width = ($a['column'] == 3) ? 4 : (($a['column'] == 4) ? 3 : 4);

        $query = new WP_Query(array('post_type' => 'wp-rpt-cpt', 'post__in' => $post_id_array,'orderby' => 'ID', 'order'   => 'ASC'));
        // The Loop

        ob_start();
        if ($query->have_posts()): ?>
            <section class="pricing1">
                <div class="wp-rpt-container-fluid">
                    <div class="wp-rpt-row">

                        <?php
                        while ($query->have_posts()):

                            $query->the_post();
                            ?>
                            <div class="wp-rpt-col-md-<?php echo $column_width ?>">
                                <div class="column-inner">
                                    <div
                                        class="pricing-wrapper <?php echo (get_the_ID() == $featured) ? "featured" : "" ?>">
                                        <div class="top">
                                            <div class="price">
                                            <span
                                                class="price-currency"><?php echo get_post_meta(get_the_ID(), 'additional_fields_currency', true); ?></span>
                                            <span
                                                class="price-amount"><?php echo get_post_meta(get_the_ID(), 'additional_fields_price', true); ?></span>
                                            <span
                                                class="price-extra"><?php echo get_post_meta(get_the_ID(), 'additional_fields_duration', true); ?></span>
                                            </div>
                                            <div
                                                class="price-title"><?php echo get_post_meta(get_the_ID(), 'additional_fields_additional-text', true); ?></div>
                                            <div class="price-plan">
                                            <span class="t1"
                                                  style="border-color:#31aae2 #31aae2 #31aae2 transparent;"></span>
                                                <?php the_title() ?>
                                                <span class="t2"
                                                      style="border-color:#31aae2 transparent #31aae2 #31aae2;"></span>
                                            </div>
                                        </div>
                                        <div class="pricing-content">
                                            <?php the_content() ?>
                                            <div class="pricing-action-button">
                                                <a class="btn btn-block"
                                                   href="<?php echo get_post_meta(get_the_ID(), 'additional_fields_button-url', true); ?>"><?php echo get_post_meta(get_the_ID(), 'additional_fields_button-text', true); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>
            </section>
            <?php
        else:
            ?>
            Oops, there are no posts.
            </div>
            <?php
        endif;
    else:
        ?>
        Oops, there are no pricing table.
        <?php
    endif;


// Reset Query
    wp_reset_query();

    return ob_get_clean();
}

function register_rpt_shortcode()
{
    add_shortcode('wp_rpt', 'wp_rpt_shortcode');
}

add_action('init', 'register_rpt_shortcode');