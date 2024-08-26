<?php
/*
    Plugin Name: Media Attacher
    Description: Auto attach media to matching product name
    Author: Yousseif Ahmed
    Version: 1.0
*/

// Function to attach media to a product by media ID and product name
function attach_media_to_product($attachId) {
    // Get the media name
    $media_name = get_the_title($attachId);

    // Get the product ID by the media name
    $product_id = wc_get_product_id_by_name($media_name);

    // Check if the product exists and the media is not already attached
    if ($product_id && get_post($attachId)->post_parent != $product_id) {
        // Attach media to the product
        $attach = array(
            'ID'           => $attachId,
            'post_parent'  => $product_id
        );
        wp_update_post($attach);  // Update the post parent to attach the media
        return true;  // Successfully attached
    } else {
        return false;  // No matching product found or media already attached
    }
}

// Admin notice to display the result of the operation
function admin_notice_media_attached() {
    if (!empty($_REQUEST['attach'])) {
        $attached_count = intval($_REQUEST['attach']);
        printf(
            '<div id="message" class="updated notice is-dismissible"><p>' . __('Attached %d media item(s).', 'txtdomain') . '</p></div>', 
            $attached_count
        );
    }
    
    if (!empty($_REQUEST['skipped'])) {
        $media_fetching_array = explode(',', $_REQUEST['media_fetching']);
        $skipped_count = intval($_REQUEST['skipped']);
        printf(
            '<div id="message" class="notice notice-warning is-dismissible"><p>' . __('Skipped %d media item(s) without matching products or already attached: %s', 'txtdomain') . '</p></div>',
            $skipped_count, implode(', ', array_map('esc_html', $media_fetching_array))
        );
    }
}

// Add a "Attach Media(s)" option to the bulk actions dropdown
function attach_media_to_product_bulk_action($actions) {
    $actions['attach_media_to_product'] = __('Attach Media(s)', 'txtdomain');
    return $actions;
}

// Handle the bulk action of attaching media to products
 function handle_attaching_media_bulk_action ($redirect_url, $action, $post_ids) {
    if ($action == 'attach_media_to_product') {
        $attached_ids = [];
        $skipped_ids = [];
        $media_fetching = [];
        
        foreach ($post_ids as $post_id) {
            if (attach_media_to_product($post_id)) {
                $attached_ids[] = $post_id;
            } else {
                $skipped_ids[] = $post_id;
                $media_fetching[] = get_the_title($post_id); // Store the media title for display
            }
        }

        // Add attached/skipped numbers to URL slug for admin notice redirection
        $redirect_url = add_query_arg(array(
            'attach' => count($attached_ids),
            'skipped' => count($skipped_ids),
            'media_fetching' => implode(',', array_map('esc_html', $media_fetching)),
        ), $redirect_url);
    }
    
    return $redirect_url;
}

// Function to get product ID by name
function wc_get_product_id_by_name($product_name) {
    global $wpdb;
    $product_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = 'product'", $product_name));
    return $product_id ? $product_id : null;
}

