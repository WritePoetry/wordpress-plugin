/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from './block.json';
import { graphicBracketsIcon } from '../../packages/icons';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
registerBlockType( metadata.name, {
	icon: graphicBracketsIcon,
	/**
	 * @see ./edit.js
	 */
	edit: Edit,
	/**
	 * @see ./save.js
	 */
	save,
	/**
	 * Sets animation.
	 *
	 * @param  attributes
	 * @return {{'data-url': *}}
	 */
	getEditWrapperProps( attributes ) {
		const { url } = attributes;
		if ( undefined !== url ) {
			return { 'data-url': url };
		}
	},
} );
