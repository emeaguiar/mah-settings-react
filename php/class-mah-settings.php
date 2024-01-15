<?php
/**
 * @package Mah_Settings
 */

namespace Mah_Settings;

/**
 * Maneja la página de opciones
 */
class Settings {
    /**
     * @var string
     */
    private $plugin_path = '';

    /**
     * Menu slug.
     * 
     * @var string
     */
    private $menu_slug = '';

    public function __construct( string $plugin_file ) {
        $this->plugin_path = plugin_dir_path( $plugin_file );
    }

    /**
     * Registra los hooks.
     * 
     * @return void 
     */
    public function init(): void {
        add_action( 'admin_menu', [ $this, 'add_menu_page' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        add_action( 'rest_api_init', [ $this, 'register_settings' ] );
    }

    /**
     * Registra la página de opciones.
     * 
     * @return void 
     */
    public function add_menu_page(): void {
        $this->menu_slug = add_menu_page(
            __( 'Mah Settings', 'mah-settings' ),
            __( 'Mah Settings', 'mah-settings' ),
            'manage_options',
            'mah-settings',
            [ $this, 'render_settings_page' ],
            'dashicons-admin-generic',
            99
        );
    }

    /**
     * Renderiza la página de opciones.
     * 
     * @return void 
     */
    public function render_settings_page(): void {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Mah Settings', 'mah-settings' ); ?></h1>
            <div id="mah-settings"></div>
        </div>
        <?php
    }

    /**
     * Registra los scripts y estilos.
     * 
     * @return void 
     */
    public function enqueue_scripts(): void {
        $screen = get_current_screen();

        if ( $screen->id !== $this->menu_slug ) {
            return;
        }

        $asset = include $this->plugin_path . '/build/settings.asset.php';

        wp_enqueue_script(
            'mah-settings',
            plugins_url() . '/mah-settings-react/build/settings.js',
            $asset['dependencies'],
            $asset['version'],
            true
        );

        wp_enqueue_style( 'wp-components' );
    }

    /**
     * Registra las opciones.
     * 
     * @return void 
     */
    public function register_settings(): void {
        register_setting(
            'mah_settings',
            'mah_api_key',
            [
                'description'       => __( 'API Key', 'mah-settings' ),
                'sanitize_callback' => 'sanitize_text_field',
                'show_in_rest'      => true,
                'type'              => 'string',
            ]
        );

        register_setting(
            'mah_settings',
            'mah_function',
            [
                'description'       => __( 'Funcion X', 'mah-settings' ),
                'show_in_rest'      => true,
                'type'              => 'boolean',
            ]
        );
    }
}
