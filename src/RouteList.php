<?php

namespace ADT\Routing;

use Contributte\Translation\Translator;


class RouteList extends \Nette\Application\Routers\RouteList
{
	private ?Translator $translator = null;

	public function __construct(string $module = null, ?Translator $translator = null)
	{
		parent::__construct($module);

		$this->translator = $translator;
	}

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

	public function createRoute(string $mask, $metadata = [], int $flags = 0)
	{
		return new Route($mask, $metadata, $flags, $this->translator);
	}
}
