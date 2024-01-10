<?php
/**
 * Plugin Name: Mah Settings
 * Description: Tutorial para crear una página de opciones con React
 * Version: 1.0.0
 * Author: Mario Aguiar
 * Author URI: https://marioaguiar.net
 * License: GPLv2 or later
 * Text Domain: mah-settings
 */

namespace Mah_Settings;

require_once __DIR__ . '/php/class-mah-settings.php';

use Mah_Settings\Settings;


// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$settings = new Settings( __FILE__ );

$settings->init();
