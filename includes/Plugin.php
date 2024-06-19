<?php

namespace CodeCrafts\ListasDeFrequencia\Includes;

use CodeCrafts\ListasDeFrequencia\AdminView\AdminApiRouter;
use CodeCrafts\ListasDeFrequencia\AdminView\AdminController;
use CodeCrafts\ListasDeFrequencia\AdminView\AdminView;
use CodeCrafts\ListasDeFrequencia\App\DependencyInjectionContainers\ApplicationContainer;

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

	protected ApplicationContainer $applicationContainer;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 */
	public function __construct(PluginLoader $pluginLoader, string $name, string $version, ApplicationContainer $applicationContainer) {
		$this->pluginLoader = $pluginLoader;
		$this->name = $name;
		$this->version = $version;
		$this->applicationContainer = $applicationContainer;

		$this->setLocale();
		$this->defineAdminHooks();
		$this->defineApplicationHooks();
		$this->defineAdminApiRoutes();
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
			$this->getVersion(),
			new AdminController(),
		);
		$this->pluginLoader->addAction('admin_enqueue_scripts', $adminView, 'enqueueStyles');
		$this->pluginLoader->addAction('admin_enqueue_scripts', $adminView, 'enqueueScripts');
		$this->pluginLoader->addAction('admin_menu', $adminView, 'addMenuAndSubmenus');
	}
	
	private function defineApplicationHooks(): void
	{
		$service = $this->applicationContainer->makeListasDeFrequenciaService();

		$this->pluginLoader->addAction('create_lista', $service, 'createLista', 1, 1);
		$this->pluginLoader->addAction('create_frequencia_for_lista', $service, 'createFrequenciaForLista', 1, 2);
		$this->pluginLoader->addAction('set_presenca_from_frequencia', $service, 'setPresencaFromFrequencia', 1, 2);

		$listaByParentGetter = new class($service)
		{
			protected $service;

			public function __construct($service) {
				$this->service = $service;
			}
			public function getListaByParent($result, $parentId, $parentType) {
				echo print_r($result, true);
				echo print_r($parentId, true);
				echo print_r($parentType, true);
				die();

				return null;
			}
		};
		$this->pluginLoader->addFilter('get_lista_by_parent', $listaByParentGetter, 'getListaByParent', 1, 2);
	}
	
	private function defineAdminApiRoutes(): void
	{
		$adminApiRouter = new AdminApiRouter($this->applicationContainer);

		$this->pluginLoader->addAction('rest_api_init', $adminApiRouter, 'registerRoutes', 1, 1);
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
