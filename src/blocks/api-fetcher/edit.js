/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * Imports the InspectorControls component, which is used to wrap
 * the block's custom controls that will appear in in the Settings
 * Sidebar when the block is selected.
 *
 * Also imports the React hook that is used to mark the block wrapper
 * element. It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#inspectorcontrols
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';

/**
 * Imports the necessary components that will be used to create
 * the user interface for the block's settings.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/panel/#panelbody
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/text-control/
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/toggle-control/
 */
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';

/**
 * Imports the useEffect React Hook. This is used to set an attribute when the
 *
 */
import { useEffect, useState } from 'react';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { url, text, link } = attributes;

	const [ fetchedData, setFetchedData ] = useState( null );
    const [ errorMessage, setErrorMessage ] = useState( '' );

    useEffect( () => {
		// Validate that the required data attributes are present.
        if ( url ) {
			// Fetch data from the API.
            fetch(url)
                .then( ( response ) => {
                    if ( ! response.ok ) {
                        throw new Error(`Error fetching data: ${response.status}`);
                    }
                    return response.json();
                } )
                .then( ( data ) => {
                    setFetchedData( data );
                } )
                .catch( (error) => {
                    console.error( error );
                    setErrorMessage( 'Failed to fetch data' );
                } );
        }
    }, [url] );


	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'write-poetry' ) }>
					<TextControl
						label={ __( 'API url', 'write-poetry' ) }
						value={ url }
						onChange={ ( value ) =>
							setAttributes( { url: value } )
						}
					/>
					<TextControl
						label={ __( 'Link selector', 'write-poetry' ) }
						value={ link }
						onChange={ ( value ) =>
							setAttributes( { link: value } )
						}
					/>
					<TextControl
						label={ __( 'Text selector', 'write-poetry' ) }
						value={ text }
						onChange={ ( value ) =>
							setAttributes( { text: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<span { ...useBlockProps() }>
				{ errorMessage ? (
					<p>{ errorMessage }</p>
				) : fetchedData ? (
					<a href={ fetchedData[link] }>{ fetchedData[text] }</a>
				) : (
					<p>Loading data...</p>
				) }
			</span>
		</>
	);
}


//   https://api.github.com/repos/WritePoetry/wordpress-plugin/releases/latest"
//   data-api-link="html_url"
//   data-api-text="tag_name"
