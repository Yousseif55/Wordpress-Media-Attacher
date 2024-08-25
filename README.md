# Media Attacher Plugin
Description
Media Attacher is a WordPress plugin designed to automatically attach media files to products based on matching product names. If a media item's title matches a product's name, the media will be attached to that product as a child post. This plugin also adds a bulk action option to the WordPress admin area, allowing you to attach multiple media files to products at once.

Features
Automatically attaches media to products based on matching titles.
Bulk action to attach multiple media items to products.
Admin notices to show the result of the bulk operation.
Displays skipped media items and their titles if no matching products are found.
Installation
Upload the media-attacher plugin folder to your WordPress plugins directory (/wp-content/plugins/).
Activate the plugin through the 'Plugins' menu in WordPress.
Usage
Bulk Actions:

Go to the WordPress Admin Dashboard.
Navigate to the Media Library (/wp-admin/upload.php).
Select the media items you want to attach.
From the Bulk Actions dropdown menu, select Attach Media(s) and click Apply.
Admin Notices:

After performing the bulk action, the admin will display a notice showing the number of media items attached and any items that were skipped.
Functions
attach_media_to_product($attachId)
Attaches a media item to a product if a product exists with the same name as the media item's title.

Parameters: $attachId (int) - The ID of the media item to be attached.
Returns: true if the media was successfully attached, false otherwise.
admin_notice_media_attached()
Displays admin notices about the result of the bulk attach operation.

attach_media_to_product_bulk_action($actions)
Adds the "Attach Media(s)" option to the bulk actions dropdown in the Media Library.

Parameters: $actions (array) - Existing bulk actions.
Returns: Modified $actions array with the new bulk action.
wc_get_product_id_by_name($product_name)
Retrieves the product ID based on the product's name.

Parameters: $product_name (string) - The name of the product.
Returns: The product ID if found, null otherwise.
Changelog
Version 1.0
Initial release with basic functionality to attach media to products based on matching names.
Added bulk action support for attaching multiple media items.
Included admin notices for operation results and skipped media.
Notes
Ensure that media item titles exactly match product names for successful attachment.
If media items are already attached to products or no matching product is found, those media items will be skipped.
Author
Yousseif Ahmed

License
This plugin is licensed under the GPLv2 license.

