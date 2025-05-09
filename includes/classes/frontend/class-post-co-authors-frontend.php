<?php
/**
 * Frontend class for WP Contributors plugin.
 *
 * This file contains the frontend class that handles the display of contributors
 * and enqueues related assets on the front-end.
 *
 * @package    Post_Co_Authors
 * @subpackage Post_Co_Authors/includes/classes/frontend
 * @since      1.0.0
 * @author     Kajal Gohel
 */

/**
 * Class Post_Contributors_Frontend
 *
 * Handles the display and functionality of contributors on the front-end.
 *
 * @package    Post_Co_Authors
 * @subpackage Post_Co_Authors/includes/classes/frontend
 * @since      1.0.0
 */
class Post_Contributors_Frontend {

	/**
	 * Initialize the frontend hooks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'the_content', array( $this, 'append_contributors_to_content' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
	}

	/**
	 * Append the contributors list to the post content.
	 *
	 * @param string $content The original post content.
	 * @return string Modified post content with contributors appended.
	 */
	public function append_contributors_to_content( $content ) {
		// Only modify content for single posts.
		if ( ! is_singular( 'post' ) ) {
			return $content;
		}

		// Retrieve the contributors from post meta.
		$contributors = get_post_meta( get_the_ID(), '_wp_contributors', true );
		if ( empty( $contributors ) || ! is_array( $contributors ) ) {
			return $content;
		}

		// Build the contributors box.
		ob_start();
		?>
		<div class="post-co-authors-box">
			<h3><?php esc_html_e( 'Contributors', 'post-co-authors' ); ?></h3>
			<ul>
				<?php foreach ( $contributors as $user_id ) : ?>
					<?php
					$user = get_user_by( 'ID', $user_id );
					if ( $user ) :
						$avatar       = get_avatar( $user_id, 32 );
						$author_url   = get_author_posts_url( $user_id );
						$display_name = $user->display_name;
						?>
						<li>
							<?php echo wp_kses_post( $avatar ); ?>
							<a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $display_name ); ?></a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
		return $content . ob_get_clean();
	}

	/**
	 * Enqueue front-end styles and scripts for the Contributors plugin.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function enqueue_frontend_assets() {
		if ( is_singular( 'post' ) ) {
			wp_enqueue_style(
				'post-co-authors-style',
				POST_CO_AUTHORS_BUILD_LIBRARY_URI . '/css/post-co-authors.css',
				array(),
				POST_CO_AUTHORS_VERSION
			);

			wp_enqueue_script(
				'post-co-authors-script',
				POST_CO_AUTHORS_BUILD_LIBRARY_URI . '/js/post-co-authors.js',
				array( 'jquery' ),
				POST_CO_AUTHORS_VERSION,
				true
			);
		}
	}
}
