<?php
/**
 * Handles plugin uninstallation.
 *
 * Triggered when the plugin is deleted via the WordPress dashboard.
 *
 * @package    Post_Co_Authors
 * @subpackage Post_Co_Authors
 * @since      1.0.0
 * @author     Kajal Gohel
 */

if ( ! defined( 'POST_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Remove plugin options.
delete_option( 'post_contributors_version' );

/**
 * Deletes aPost metadata related to contributors.ost
 * Retrieves posts that have the '_post_contributors' metadata and deletes it.
 * This is done to ensure that any data associated with contributors is properly removed.
 */
$args = array(
	'post_type' => 'post',
	'meta_key'  => '_post_contributors', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
	'fields'    => 'ids', // Only retrieve post IDs for efficiency.
);

$query = new WP_Query( $args );

// Check if any posts have the '_post_contributors' metadata.
if ( $query->have_posts() ) {
	foreach ( $query->posts as $single_post_id ) {
		// Delete the '_post_contributors' metadata for each post.
		delete_post_meta( $single_post_id, '_post_contributors' );
	}
}

// Clear cache for affected objects.
wp_cache_flush();
