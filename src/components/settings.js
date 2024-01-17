/**
 * WordPress dependencies
 */
import {
    Button,
    Card,
    CardBody,
    CardDivider,
    CardFooter,
    Notice,
    Spinner,
    TextControl,
    ToggleControl,
} from '@wordpress/components';
import { store as coreStore, useEntityProp } from '@wordpress/core-data';
import { useDispatch } from '@wordpress/data';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const Settings = () => {
    const [ isLoading, setIsLoading ] = useState( false );
    const [ showNotice, setShowNotice ] = useState( false );
    const [ apiKey, setApiKey ] = useEntityProp(
        'root',
        'site',
        'mah_api_key'
    );
    const [ toggled, setToggled ] = useEntityProp(
        'root',
        'site',
        'mah_function'
    );
    const { saveEditedEntityRecord } = useDispatch( coreStore );

    const saveSettings = async () => {
        setIsLoading( true );

        await saveEditedEntityRecord(
            'root',
            'site',
            undefined,
            {
                mah_api_key: apiKey,
                mah_function: toggled,
            }
        );

        setShowNotice( true );
        setIsLoading( false );
    };

    return (
        <>
            <h1>{ __( 'Selecciona las opciones deseadas', 'mah-settings' ) }</h1>

            <Card>
                { showNotice && (
                    <CardBody>
                        <Notice
                            isDismissible
                            onDismiss={ () => setShowNotice( false ) }
                            status="success"
                        >
                            { __( 'Guardado con éxito', 'mah-settings' ) }
                        </Notice>
                    </CardBody>
                ) }

                <CardBody>
                    <TextControl
                        help={ __( 'Ingresa tu API key', 'mah-settings' ) }
                        label={ __( 'API Key', 'mah-settings' ) }
                        onChange={ setApiKey }
                        value={ apiKey || '' } 
                    />
                </CardBody>

                <CardDivider />

                <CardBody>
                    <ToggleControl
                        label={ __( 'Activar funcionalidad', 'mah-settings' ) }
                        onChange={ setToggled }
                        checked={ toggled || false }
                    />
                </CardBody>

                <CardFooter>
                    <Button
                        disabled={ ! apiKey || isLoading }
                        onClick={ saveSettings }
                        variant="primary"
                    >
                        { isLoading && <Spinner /> }
                        { ! isLoading && __( 'Guardar', 'mah-settings' ) }
                    </Button>
                </CardFooter>
            </Card>
        </>
    );
} 

export default Settings;