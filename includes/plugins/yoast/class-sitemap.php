<?php
/**
 * Add metafields to portfolio CPT.
 *
 * @package           WritePoetry
 * @subpackage        WritePoetry/Base
 * @author            Giacomo Secchi <giacomo.secchi@gmail.com>
 * @copyright         2023 Giacomo Secchi
 * @license           GPL-2.0-or-later
 * @since             0.2.4
 */

namespace WritePoetry\Plugins\Yoast;

use WritePoetry\Base\Base_Controller;

/**
 * Class Portfolio
 *
 * @package WritePoetry\Plugins\Yoast
 */
class Sitemap extends Base_Controller {
	/**
	 * Invoke hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_filter( 'home_url', array( $this, 'force_default_language_url' ), 10, 2 );
	}

	/**
	 * Forces the default language URL for specific paths.
	 * This function ensures that certain paths, like 'sitemap.xml', do not include the language slug.
	 *
	 * @param string $url  The generated URL.
	 * @param string $path The path being added to the URL.
	 * @return string The modified URL without the language slug for specific paths.
	 */
	public function force_default_language_url( $url, $path ) {
		// Check if the path is 'sitemap.xml'.
		if ( $path === 'sitemap.xml' ) {

		   // Remove the language slug from the URL by using the default home URL.
		   $url = home_url( '/sitemap.xml' );
		}

		return $url;
	}
}
