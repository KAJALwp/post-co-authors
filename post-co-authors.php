<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/kajalgohel/
 * @since             1.0.0
 * @package           Post_Co_Authors
 *
 * @wordpress-plugin
 * Plugin Name:       Post CoAuthors
 * Plugin URI:        https://profiles.wordpress.org/kajalgohel/
 * Description:       Assign multiple contributors to posts and display them on the front-end.
 * Version:           1.0
 * Author:            Kajal Gohel
 * Author URI:        https://profiles.wordpress.org/kajalgohel/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       post-co-authors
 * Domain Path:       /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants.
define( 'POST_CO_AUTHORS_VERSION', '1.0.0' );
define( 'POST_CO_AUTHORS_PATH', plugin_dir_path( __FILE__ ) );
define( 'POST_CO_AUTHORS_URL', plugin_dir_url( __FILE__ ) );
define( 'POST_CO_AUTHORS_BUILD_LIBRARY_URI', untrailingslashit( POST_CO_AUTHORS_URL . 'assets' ) );

// Autoload required classes.
require_once POST_CO_AUTHORS_PATH . 'includes/classes/admin/class-post-co-authors-activator.php';
require_once POST_CO_AUTHORS_PATH . 'includes/classes/admin/class-post-co-authors-deactivator.php';
require_once POST_CO_AUTHORS_PATH . 'includes/classes/admin/class-post-co-authors-admin.php';
require_once POST_CO_AUTHORS_PATH . 'includes/classes/frontend/class-post-co-authors-frontend.php';

// Activation hook.
register_activation_hook( __FILE__, array( 'Post_Contributors_Activator', 'activate' ) );

// Deactivation hook.
register_deactivation_hook( __FILE__, array( 'Post_Contributors_Deactivator', 'deactivate' ) );

/**
 * Begins execution of the plugin.
 *
 * @return void
 * @since    1.0.0
 */
function wp_contributors_run() {
	$admin    = new Post_Contributors_Admin();
	$frontend = new Post_Contributors_Frontend();

	$admin->run();
	$frontend->run();
}
wp_contributors_run();
