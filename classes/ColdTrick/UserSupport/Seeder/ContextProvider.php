<?php

namespace ColdTrick\UserSupport\Seeder;

use Elgg\Router\Route;

/**
 * Helper to get route information
 */
trait ContextProvider {
	
	/**
	 * @var Route[]
	 */
	protected $valid_routes;
	
	/**
	 * Get a random route to use in seeding
	 *
	 * @return Route
	 */
	protected function getRandomRoute(): Route {
		if (!isset($this->valid_routes)) {
			$routes = _elgg_services()->routes->all();
			
			$this->valid_routes = array_filter($routes, function (Route $route, $name) {
				$parts = explode(':', $name);
				
				return in_array($parts[0], ['default', 'collection']);
			}, ARRAY_FILTER_USE_BOTH);
		}
		
		$key = array_rand($this->valid_routes);
		$route = $this->valid_routes[$key];
		
		$route->setMatchedParameters([
			'_route' => $key,
		]);
		
		return $route;
	}
	
	/**
	 * Get a route url
	 *
	 * @param Route $route (optional) route to use
	 *
	 * @return null|string
	 */
	protected function getUrl(Route $route = null): ?string {
		if (!$route instanceof Route) {
			$route = $this->getRandomRoute();
		}
		
		$route_params = $route->getRequirements();
		$params = [];
		foreach ($route_params as $name => $spec) {
			switch ($name) {
				case 'guid':
				case 'container_guid':
					$params[$name] = $this->getRandomGroup()->guid;
					break;
					
				case 'username':
					$params[$name] = $this->getRandomUser()->username;
					break;
					
				case 'owner_guid':
					$params[$name] = $this->getRandomUser()->guid;
					break;
			}
		}
		
		return elgg_generate_url($route->getName(), $params);
	}
	
	/**
	 * Get the help context from a route
	 *
	 * @param Route $route (optional) route to use
	 *
	 * @return null|string
	 */
	protected function getHelpContext(Route $route = null): ?string {
		if (!$route instanceof Route) {
			$route = $this->getRandomRoute();
		}
		
		$path = $route->getPath();
		if (str_contains($path, '{')) {
			return trim(substr($path, 0, strpos($path, '{')), '/');
		}
		
		return trim($path, '/');
	}
}
