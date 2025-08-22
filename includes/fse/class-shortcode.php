<?php
/**
 * Example class.
 *
 * @package           WritePoetry
 * @subpackage        WritePoetry/Base
 * @author            Giacomo Secchi <giacomo.secchi@gmail.com>
 * @copyright         2023 Giacomo Secchi
 * @license           GPL-2.0-or-later
 * @since             0.2.4
 */

namespace WritePoetry\FSE;

use WritePoetry\Base\Base_Controller;

/**
 * Class Blocks
 */
class Shortcode extends Base_Controller {
	/**
	 * Invoke hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_filter( 'render_block', array( $this, 'support_gutenberg_shortcode' ), 10, 2 );
	}

	/**
	 * Filters the content of a Gutenberg block to process shortcodes within "core/shortcode" blocks.
	 *
	 * This function checks if the current block is of type "core/shortcode" and, if so,
	 * processes the shortcode contained in the block's `innerHTML` field. This is useful
	 * for ensuring that shortcodes are correctly rendered within the Gutenberg editor.
	 *
	 * @param string $block_content The block content being rendered.
	 * @param array  $block         The block data, including attributes and inner content.
	 *
	 * @return string The modified block content with shortcodes processed (if applicable).
	 */
	public function support_gutenberg_shortcode( $block_content, $block ) {

		if ( isset( $block['blockName'] ) && 'core/shortcode' === $block['blockName'] ) {
			$block_content = do_shortcode( $block['innerHTML'] );
		}

		return $block_content;
	}
}
