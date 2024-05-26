<?php

namespace CodeCrafts\ListasDeFrequencia\Public;

/**
 * The public-facing functionality of the plugin.
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 */
class PluginPublic {

	/**
	 * The ID of this plugin.
	 */
	private string $pluginName;

	/**
	 * The version of this plugin.
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct(string $pluginName, string $version)
	{
		$this->pluginName = $pluginName;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueueStyles(): void
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in PluginLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The PluginLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->pluginName, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 */
	public function enqueueScripts(): void
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in PluginLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The PluginLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->pluginName, plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), $this->version, false );
	}
}
