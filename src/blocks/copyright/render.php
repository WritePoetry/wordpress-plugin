<?php
/**
 * Block rendering template.
 *
 * @package WritePoetry
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

?>
<p <?php echo esc_attr( get_block_wrapper_attributes() ); ?>>
	<?php esc_html_e( 'Copyright – hello from a dynamic block!', 'write-poetry' ); ?>
</p>
