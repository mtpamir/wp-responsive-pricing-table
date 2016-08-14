<?php

defined( 'ABSPATH' ) or die( 'Keep Quit' );

if(!class_exists('WP_RPT_Meta_Box')):

class WP_RPT_Meta_Box {
    private $screens = array(
        'wp-rpt-cpt',
    );
    private $fields = array(
        array(
            'id' => 'currency',
            'label' => 'Currency',
            'type' => 'text',
        ),
        array(
            'id' => 'price',
            'label' => 'Price',
            'type' => 'text',
        ),
        array(
            'id' => 'duration',
            'label' => 'Duration',
            'type' => 'text',
        ),
        array(
            'id' => 'additional-text',
            'label' => 'Additional Text',
            'type' => 'text',
        ),
        array(
            'id' => 'button-text',
            'label' => 'Button Text',
            'type' => 'text',
        ),
        array(
            'id' => 'button-url',
            'label' => 'Button URL',
            'type' => 'text',
        ),
    );

    /**
     * Class construct method. Adds actions to their respective WordPress hooks.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_post' ) );
    }

    /**
     * Hooks into WordPress' add_meta_boxes function.
     * Goes through screens (post types) and adds the meta box.
     */
    public function add_meta_boxes() {
        foreach ( $this->screens as $screen ) {
            add_meta_box(
                'additional-fields',
                __( 'additional fields', 'text-domain' ),
                array( $this, 'add_meta_box_callback' ),
                $screen,
                'advanced',
                'default'
            );
        }
    }

    /**
     * Generates the HTML for the meta box
     *
     * @param object $post WordPress post object
     */
    public function add_meta_box_callback( $post ) {
        wp_nonce_field( 'additional_fields_data', 'additional_fields_nonce' );
        $this->generate_fields( $post );
    }

    /**
     * Generates the field's HTML for the meta box.
     */
    public function generate_fields( $post ) {
        $output = '';
        foreach ( $this->fields as $field ) {
            $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
            $db_value = get_post_meta( $post->ID, 'additional_fields_' . $field['id'], true );
            switch ( $field['type'] ) {
                default:
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        $field['type'] !== 'color' ? 'class="regular-text"' : '',
                        $field['id'],
                        $field['id'],
                        $field['type'],
                        $db_value
                    );
            }
            $output .= $this->row_format( $label, $input );
        }
        echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
    }

    /**
     * Generates the HTML for table rows.
     */
    public function row_format( $label, $input ) {
        return sprintf(
            '<tr><th scope="row">%s</th><td>%s</td></tr>',
            $label,
            $input
        );
    }
    /**
     * Hooks into WordPress' save_post function
     */
    public function save_post( $post_id ) {
        if ( ! isset( $_POST['additional_fields_nonce'] ) )
            return $post_id;

        $nonce = $_POST['additional_fields_nonce'];
        if ( !wp_verify_nonce( $nonce, 'additional_fields_data' ) )
            return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

        foreach ( $this->fields as $field ) {
            if ( isset( $_POST[ $field['id'] ] ) ) {
                switch ( $field['type'] ) {
                    case 'email':
                        $_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
                        break;
                    case 'text':
                        $_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
                        break;
                }
                update_post_meta( $post_id, 'additional_fields_' . $field['id'], $_POST[ $field['id'] ] );
            } else if ( $field['type'] === 'checkbox' ) {
                update_post_meta( $post_id, 'additional_fields_' . $field['id'], '0' );
            }
        }
    }
}
new WP_RPT_Meta_Box;

endif;