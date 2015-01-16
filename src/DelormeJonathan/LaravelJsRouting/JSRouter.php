<?php namespace DelormeJonathan\LaravelJsRouting;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

class JSRouter
{
	public static function generate(){
		$router = Route::getRoutes();
		$routesByAction = array();
		$routesByName = array();

		foreach ($router as $route) {
			if ($route->getActionName() != 'Closure') {
				$routesByAction[$route->getActionName()]['route'] = str_replace('?}', '}', Config::get('app.url') . url($route->getPath());
				$routesByAction[$route->getActionName()]['parameters'] = $route->parameterNames();
			}
			if ($route->getName() != '') {
				$routesByName[$route->getName()]['route'] = str_replace('?}', '}', Config::get('app.url') . url($route->getPath());
				$routesByName[$route->getName()]['parameters'] = $route->parameterNames();
			}
		}


		return View::make('LaravelJsRouting::script', array('routesByAction' => json_encode($routesByAction), 'routesByName' => json_encode($routesByName)));
	}
}