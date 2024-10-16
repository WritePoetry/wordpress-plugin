<?php
/**
 * Product zoom class.
 *
 * @package           WritePoetry
 * @subpackage        WritePoetry/Base
 * @author            Giacomo Secchi <giacomo.secchi@gmail.com>
 * @copyright         2023 Giacomo Secchi
 * @license           GPL-2.0-or-later
 * @since             0.2.4
 */

namespace WritePoetry\Plugins\WooCommerce;

use WritePoetry\Base\Base_Controller;

/**
 * Class Product_Zoom
 *
 * @package WritePoetry\Plugins\WooCommerce
 */
class Product_Zoom extends WooCommerce_Controller {
	/**
	 * Invoke hooks.
	 *
	 * @return void
	 */
	public function register() {

		// Check option for product zoom.
		if ( 'no' === get_option( "{$this->prefix}_product_zoom" ) ) {
			$this->disable_product_zoom();
		}
	}

	/**
	 * Disable product zoom.
	 *
	 * @return void
	 */
	public function disable_product_zoom() {
		add_action(
			'wp',
			function () {
				remove_theme_support( 'wc-product-gallery-zoom' );
				// @phpcs:disable Squiz.PHP.CommentedOutCode.Found, Squiz.Commenting.InlineComment.InvalidEndChar
				// remove_theme_support( 'wc-product-gallery-lightbox' );
				// remove_theme_support( 'wc-product-gallery-slider' );
				// @phpcs:enable
			},
			100
		);

		add_filter(
			'woocommerce_single_product_image_thumbnail_html',
			function ( $html ) {
				return strip_tags( $html, '<div><img>' );
			}
		);
	}
}
