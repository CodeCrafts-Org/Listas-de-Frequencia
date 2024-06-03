<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

/**
 * The admin-specific functionality of the plugin.
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class AdminView
{
	/**
	 * The ID of this plugin.
	 */
	private string $pluginName;

	/**
	 * The version of this plugin.
	 */
	private string $version;

	/**
	 * The version of this plugin.
	 */
	private AdminController $adminController;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct(string $pluginName, string $version, AdminController $adminController)
	{
		$this->pluginName = $pluginName;
		$this->version = $version;
		$this->adminController = $adminController;
	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueueStyles(): void
	{
		wp_enqueue_style($this->pluginName, plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueueScripts(): void
	{
		wp_register_script("{$this->pluginName}-frequencias", plugin_dir_url( __FILE__ ) . 'js/frequencias.js');
		wp_register_script("{$this->pluginName}-listas", plugin_dir_url( __FILE__ ) . 'js/listas-de-frequencia.js');
		wp_register_script("{$this->pluginName}-observer", plugin_dir_url( __FILE__ ) . 'js/observer.js');
		wp_register_script("{$this->pluginName}-wordpress-rest-client", plugin_dir_url( __FILE__ ) . 'js/wordpress-rest-client.js');
		
		wp_enqueue_script("{$this->pluginName}-frequencias");
		wp_enqueue_script("{$this->pluginName}-listas");
		wp_enqueue_script("{$this->pluginName}-observer");
		wp_enqueue_script("{$this->pluginName}-wordpress-rest-client");
	}

	public function addMenuAndSubmenus(): void
	{
		add_menu_page('Listas de Frequência', 'Listas de Frequência', 'administrator', 'listas-de-frequencia', [$this->adminController, 'index']);
		add_submenu_page('listas-de-frequencia', 'Listas de Frequência - Cadastro', 'Cadastrar Nova Lista', 'administrator', 'cadastro', [$this->adminController, 'create']);
	}
}
