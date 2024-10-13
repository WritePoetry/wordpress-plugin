/**
 * WordPress dependencies
 */
import domReady from '@wordpress/dom-ready';


const initialize = () => {
	'use strict';

	// Select all blocks with the class for your plugin
	const blocks = document.getElementsByClassName( 'wp-block-write-poetry-api-fetcher' );



	Array.from( blocks ).forEach(( block ) => {

		let url = block.getAttribute( 'data-url' )
		let link = block.getAttribute( 'data-link' );
		let text = block.getAttribute( 'data-text' );

		// Validate that the required data attributes are present
		if ( ! url ) {
			console.warn( 'No url provided "wp-block-my-plugin-block".' );
			return; // Exit the function if no blocks are found
		}

		if ( ! link || ! text ) {
            console.warn('Missing data-link or data-text attribute.');
            return;
        }

		// Fetch data from the API
		fetch( url )
			.then( ( response ) => {
				 // Check for non-200 response codes
				 if ( ! response.ok ) {
                    throw new Error(`Error fetching data: ${response.status} - ${response.statusText}`);
                }
                return response.json();
			} )
			.then( ( data ) => {
				const element = document.createElement( 'a' );

				if ( ! element ) {
					console.error( 'Element could not be created' );
					return;
				}

				element.textContent = data[ text ];
				element.href = data[ link ];

				block.replaceChildren( element );
			} )
			.catch( ( error ) => console.error( error ) );
	});



};



if ( typeof window !== 'undefined' ) {
	domReady( initialize );
}
