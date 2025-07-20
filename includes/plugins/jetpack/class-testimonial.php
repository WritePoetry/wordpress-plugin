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

namespace WritePoetry\Plugins\Jetpack;

use WritePoetry\Base\Base_Controller;
use WritePoetry\Api\Register_Custom_Fields;

/**
 * Class Testimonial
 *
 * @package WritePoetry\Plugins\Jetpack
 */
class Testimonial extends Base_Controller {
	/**
	 * Invoke hooks.
	 *
	 * @return void
	 */
	public function register() {
		if ( apply_filters( "writepoetry_plugin_remove_testimonial_link", false ) ) {
			add_filter( 'render_block_core/shortcode', array( $this, 'remove_dom_testimonial_link' ), 10, 2 );
		}

		// Force the Testimonials CPT settings to remain visible.
		// https://jetpack.com/support/custom-content-types/#block-themes-and-custom-content-types
		add_filter( 'classic_theme_helper_should_display_testimonials', function( $should_display ) {
			return true;
		} );
	}

	/**
	 * Removes <a> tags inside <span> elements with the class "testimonial-entry-title".
	 *
	 * This method processes the block content to remove links within Jetpack testimonial titles,
	 * replacing them with plain text. It uses DOMDocument to manipulate the HTML structure.
	 *
	 * @param string $block_content The HTML content of the block being rendered.
	 * @param array  $block         The block data (not directly used in this method).
	 * @return string The modified block content with <a> tags removed.
	 */
	public function remove_dom_testimonial_link( $block_content, $block ) {
		// Verify if block content is testimonial
		if ( strpos( $block_content, 'jetpack-testimonial-shortcode') !== false ) {
			// Create new object DOMDocument.
			$dom = new \DOMDocument();
			@$dom->loadHTML( mb_convert_encoding( $block_content, 'HTML-ENTITIES', 'UTF-8' ), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );

			// Find all span with css class "testimonial-entry-title"
			$xpath = new \DOMXPath( $dom );
			$spans = $xpath->query( '//span[contains(@class, "testimonial-entry-title")]' );

			foreach ( $spans as $span ) {
				// Find all tag with <a> inside the span.
				$links = $span->getElementsByTagName('a' );
				while ( $links->length > 0 ) {
					$link = $links->item( 0 );

					// Replace link with text contnet.
					$textNode = $dom->createTextNode( $link->textContent );
					$link->parentNode->replaceChild( $textNode, $link );
				}
			}

			// Find all <a> tags with CSS class "testimonial-featured-image"
			$image_links = $xpath->query( '//a[contains(@class, "testimonial-featured-image")]' );

			foreach ( $image_links as $image_link ) {
				// Find the <img> tag inside the <a> tag.
				$images = $image_link->getElementsByTagName( 'img' );
				if ( $images->length > 0 ) {
					$img = $images->item( 0 );

					// Replace the <a> tag with the <img> tag.
					$image_link->parentNode->replaceChild( $img, $image_link );
				}
			}

			// Save modified HTML.
			$block_content = $dom->saveHTML();
		}


		return $block_content;
	}
}
