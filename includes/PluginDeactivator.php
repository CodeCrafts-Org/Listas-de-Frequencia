<?php

namespace CodeCrafts\ListasDeFrequencia\Includes;

/**
 * Fired during plugin deactivation
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 */
class PluginDeactivator
{
	protected PluginDatabase $pluginDatabase;

	public function __construct(PluginDatabase $pluginDatabase) {
		$this->pluginDatabase = $pluginDatabase;
	}

	/**
	 * 
	 */
	public function deactivate(): void
	{
		$this->pluginDatabase->down();
	}
}
