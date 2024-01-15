/**
 * WordPress dependencies
 */
import { createRoot } from '@wordpress/element';

/**
 * Internal dependencies
 */
import Settings from './components/settings';

const rootElement = document.querySelector( '#mah-settings' );

if ( rootElement ) {
    createRoot( rootElement ).render( <Settings /> );
}
