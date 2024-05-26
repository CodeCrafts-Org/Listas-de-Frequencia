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
	public function loadPluginTextdomain(): bool
	{
		$domain = 'codecrafts-listas-de-frequencia';
		$deprecated = false;
		$pluginRelativePath = dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/';

		return load_plugin_textdomain($domain, $deprecated, $pluginRelativePath);
	}
}
