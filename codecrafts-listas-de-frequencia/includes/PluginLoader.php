<?php

namespace CodeCrafts\ListasDeFrequencia\Includes;

/**
 * Register all actions and filters for the plugin
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 */
class PluginLoader
{
	/**
	 * The array of actions registered with WordPress.
	 */
	protected array $actions = [];

	/**
	 * The array of filters registered with WordPress.
	 */
	protected array $filters = [];

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 */
	public function addAction(string $action, object $component, string $method, int $priority = 10, int $acceptedArgs = 1): void
	{
		$this->actions[] = [
			'hook' => $action,
			'callback' => [$component, $method],
			'priority' => $priority,
			'acceptedArgs' => $acceptedArgs,
		];
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 */
	public function addFilter(string $filter, object $component, string $method, int $priority = 10, int $acceptedArgs = 1): void
	{
		$this->filters[] = [
			'hook' => $filter,
			'callback' => [$component, $method],
			'priority' => $priority,
			'acceptedArgs' => $acceptedArgs,
		];
	}

	/**
	 * Register the filters and actions with WordPress.
	 */
	public function run(): void
	{
		foreach ($this->filters as $filter) {
			add_filter(
				$filter['hook'],
				$filter['callback'], 
				$filter['priority'],
				$filter['acceptedArgs']
			);
		}
		foreach ($this->actions as $action) {
			add_action(
				$action['hook'],
				$action['callback'],
				$action['priority'],
				$action['acceptedArgs']
			);
		}
	}
}
