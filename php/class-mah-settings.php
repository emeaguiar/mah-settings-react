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
    }
}
