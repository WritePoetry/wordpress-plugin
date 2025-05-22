<?php
/**
 * Utilities class.
 *
 * @package           WritePoetry
 * @subpackage        WritePoetry/Base
 * @author            Giacomo Secchi <giacomo.secchi@gmail.com>
 * @copyright         2023 Giacomo Secchi
 * @license           GPL-2.0-or-later
 * @since             0.2.0
 */

namespace WritePoetry\Base;

use WritePoetry\Base\Base_Controller;
/**
 * Utilities class.
 *
 * @since  0.2.0
 * @access public
 */
class Utils extends Base_Controller {
	/**
	 * Invoke hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'query_vars', array( $this, 'add_query_vars' ) );
		add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', array( $this, 'exclude_posts_from_xml_sitemaps' ), 10, 2 );

		add_filter(
			'init',
			function () {
				add_action( 'template_redirect', array( $this, 'redirect_single_posts_to_not_found' ), 10, 2 );
			},
			10,
			2
		);
	}


	/**
	 * Add query string parameters site-wide.
	 *
	 * @param array $qvars The current query string parameters.
	 * @since  0.2.2
	 * @access public
	 *
	 * @return array The updated query string parameters.
	 */
	public function add_query_vars( $qvars ) {

		foreach ( apply_filters( "writepoetry_query_vars", array() ) as $qv ) {
			$qvars[] = $qv;
		}

		return $qvars;
	}

	/**
	 * This method attempts to retrieve the user's IP address by checking
	 * the 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', and 'REMOTE_ADDR'
	 * server variables in that order, and returns the first valid IP address.
	 *
	 * @since  0.2.6
	 * @access public
	 * @return string The user's IP address or an empty string if not found.
	 */
	public static function get_user_ip() {
		return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
	}


	/**
	 * Redirect single posts to 404.
	 */
	public function redirect_single_posts_to_not_found() {
		global $wp_query;
		foreach ( apply_filters( "writepoetry_redirect_to_not_found", array() ) as $post ) {
			if ( is_singular( $post ) ) {				
				$wp_query->set_404();
				status_header( 404 );
				get_template_part( '404' );
			}
		}
	}

	/**
	 * Excludes posts from XML sitemaps.
	 *
	 * @return array The IDs of posts to exclude.
	 */
	public function exclude_posts_from_xml_sitemaps() {
		foreach ( apply_filters( "writepoetry_exclude_posts_from_xml_sitemaps", array() ) as $post ) {
			$args = array(
				'post_type'      => $post,
				'posts_per_page' => -1,
				'fields'         => 'ids', // Only get post IDs
			);

			$post_ids = get_posts( $args );

			// $post_ids now contains an array of post IDs
			return $post_ids;
		}
	}
}
