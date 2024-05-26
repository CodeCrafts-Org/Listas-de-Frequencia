<?php

namespace CodeCrafts\ListasDeFrequencia\Includes;

use CodeCrafts\ListasDeFrequencia\Admin\AdminView;
use CodeCrafts\ListasDeFrequencia\Public\PublicView;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class Plugin
{
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 */
	protected PluginLoader $pluginLoader;

	/**
	 * The unique identifier of this plugin.
	 */
	protected string $name;

	/**
	 * The current version of the plugin.
	 */
	protected string $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 */
	public function __construct(PluginLoader $pluginLoader, string $name, string $version) {
		$this->pluginLoader = $pluginLoader;
		$this->name = $name;
		$this->version = $version;

		$this->setLocale();
		$this->defineAdminHooks();
		$this->definePublicHooks();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the CodeCrafts_Frequencias_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 */
	private function setLocale(): void
	{
		$pluginTranslation = new PluginTranslation();
		$this->pluginLoader->addAction('plugins_loaded', $pluginTranslation, 'loadPluginTextdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 */
	private function defineAdminHooks(): void
	{
		$adminView = new AdminView(
			$this->getName(), 
			$this->getVersion()
		);
		$this->pluginLoader->addAction('admin_enqueue_scripts', $adminView, 'enqueueStyles');
		$this->pluginLoader->addAction('admin_enqueue_scripts', $adminView, 'enqueueScripts');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 */
	private function definePublicHooks(): void
	{
		$publicView = new PublicView(
			$this->getName(),
			$this->getVersion()
		);
		$this->pluginLoader->addAction('wp_enqueue_scripts', $publicView, 'enqueueStyles');
		$this->pluginLoader->addAction('wp_enqueue_scripts', $publicView, 'enqueueScripts');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run(): void
	{
		$this->pluginLoader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 */
	public function getLoader(): PluginLoader
	{
		return $this->pluginLoader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 */
	public function getVersion(): string
	{
		return $this->version;
	}
}
