<?php

namespace CodeCrafts\ListasDeFrequencia\Includes;

/**
 * Fired during plugin activation
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 */
class PluginActivator
{
	protected PluginDatabase $pluginDatabase;

	public function __construct(PluginDatabase $pluginDatabase) {
		$this->pluginDatabase = $pluginDatabase;
	}

	/**
	 * 
	 */
	public function activate(): void
	{
		$this->pluginDatabase->up();
	}
}
