<?php

namespace CodeCrafts\ListasDeFrequencia\Includes;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 */
class PluginTranslation
{
	/**
	 * Load the plugin text domain for translation.
	 */
	public function loadPluginTextdomain(): void
	{
		load_plugin_textdomain(
			'codecrafts-listas-de-frequencia',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
