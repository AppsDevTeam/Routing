<?php


namespace ADT\Routing;


class RouteList extends \Nette\Application\Routers\RouteList
{
	final public function addRoute(string $mask, $metadata = [], int $flags = 0)
	{
		$this->add(static::createRoute($mask, $metadata, $flags), $flags);
		return $this;
	}

	final public function prependRoute(string $mask, $metadata = [], int $flags = 0)
	{
		$this->prepend(static::createRoute($mask, $metadata, $flags), $flags);
		return $this;
	}

	public static function createRoute(string $mask, $metadata = [], int $flags = 0)
	{
		return new Route($mask, $metadata, $flags);
	}
}
