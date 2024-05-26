<?php

require_once __DIR__ . '/../vendor/autoload.php';

use CodeCrafts\ListasDeFrequencia\Includes\Plugin;
use CodeCrafts\ListasDeFrequencia\Includes\PluginActivator;
use CodeCrafts\ListasDeFrequencia\Includes\PluginDeactivator;
use CodeCrafts\ListasDeFrequencia\Includes\PluginLoader;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           CodeCrafts_ListasDeFrequencia
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

register_activation_hook(__FILE__, [PluginActivator::class, 'activate']);
register_deactivation_hook(__FILE__, [PluginDeactivator::class, 'deactivate']);

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
$plugin = new Plugin(
	/* loader: */ new PluginLoader(),
	/* name: */ 'codecrafts-listas-de-frequencia',
	/* version: */ '1.0.0'
);
$plugin->run();
