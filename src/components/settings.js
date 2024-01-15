/**
 * WordPress dependencies
 */
import {
    Button,
    Card,
    CardBody,
    CardDivider,
    CardFooter,
    TextControl,
    ToggleControl,
} from '@wordpress/components';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const Settings = () => {
    const [ apiKey, setApiKey ] = useState( '' );
    const [ toggled, setToggled ] = useState( false );

    const saveSettings = () => {
        console.log( 'Guardar' );
    };

    return (
        <>
            <h1>{ __( 'Selecciona las opciones deseadas', 'mah-settings' ) }</h1>

            <Card>
                <CardBody>
                    <TextControl
                        help={ __( 'Ingresa tu API key', 'mah-settings' ) }
                        label={ __( 'API Key', 'mah-settings' ) }
                        onChange={ setApiKey }
                        value={ apiKey }
                    />
                </CardBody>

                <CardDivider />

                <CardBody>
                    <ToggleControl
                        label={ __( 'Activar funcionalidad', 'mah-settings' ) }
                        onChange={ setToggled }
                        checked={ toggled }
                    />
                </CardBody>

                <CardFooter>
                    <Button
                        disabled={ ! apiKey }
                        onClick={ saveSettings }
                        variant="primary"
                    >
                        { __( 'Guardar', 'mah-settings' ) }
                    </Button>
                </CardFooter>
            </Card>
        </>
    );
}

export default Settings;