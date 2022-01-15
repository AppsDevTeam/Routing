<?php


namespace App\Router;


use ADT\Routing\Route;

class RouteList extends \ADT\Routing\RouteList
{
	/** @var string|null */
	public $path;

	public static function createRoute(string $mask, $metadata = [], int $flags = 0)
	{
		return new Route($mask, $metadata);
	}
}
