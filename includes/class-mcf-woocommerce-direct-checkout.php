<?php
/**
 * Add new mime types
 *
 * @package     MCF
 * @subpackage  MCF/includes
 * @copyright   Copyright (c) 2014, Jason Witt
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @author      Jason Witt <contact@jawittdesigns.com>
 */

class MCF_WooCommerce_Direct_Checkout {

	/**
	 * Initialize the class
	 */
	public function __construct() {
		define( 'MCF_WOOCOMMERCE_REDIRECT_CHECKOUT', true );

		// Add Authorization Token to download_package
		add_filter( 'plugins_loaded', function() {

				if ( class_exists( 'WooCommerce' ) && MCF_WOOCOMMERCE_REDIRECT_CHECKOUT ) {

					$this->disable_ajax_cart();

					add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'skip_cart_redirect_checkout' ) );
					add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'woocommerce_product_add_to_cart_text' ), 10, 2 );
					add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'woocommerce_product_add_to_cart_text' ), 10, 2 );
					add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'woocommerce_loop_add_to_cart_link' ) );
					add_filter( 'wc_add_to_cart_message_html', array( $this, 'remove_add_to_cart_message' ) );

				}
			}
		);
	}

	/**
     * Go to checkout page bypassing cart
	 * based on the story of https://rudrastyh.com/woocommerce/redirect-to-checkout-skip-cart.html
     *
     * @since  1.0.0
     * @access public
     * @return viod
     */
	public function disable_ajax_cart( ){

		if ( 'no' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) ) {
			return;
		}

		update_option( 'woocommerce_enable_ajax_add_to_cart', 'no' );
	}

	// define the woocommerce_product_add_to_cart_text callback
	public function woocommerce_product_add_to_cart_text( $text, $product ){
		return $product->is_purchasable() && $product->is_in_stock() ? __( 'Buy now', 'woocommerce' ) : __( 'Read more', 'woocommerce' );
	}

	public function skip_cart_redirect_checkout( $url ) {
		return wc_get_checkout_url();
	}

	public function woocommerce_loop_add_to_cart_link( $url ) {
		return str_replace( 'Add to cart', 'Buy now', $add_to_cart_html );
	}


	public function remove_add_to_cart_message( $message ){
		return '';
	}
}
