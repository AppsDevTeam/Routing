<?php

namespace ADT\Routing;

class RouteList extends \Nette\Application\Routers\RouteList
{
	private ?TranslatorInterface $translator;

	/**
	 * Kvůli laděnce
	 * @var string|null
	 */
	public $path;
	public $domain;

	public function __construct(string $module = null, ?TranslatorInterface $translator = null)
	{
		parent::__construct($module);

		$this->translator = $translator;
	}

	final public function addRoute(string $mask, $metadata = [], int $flags = 0)
	{
		$this->add(static::createRoute($mask, $metadata), $flags);
		return $this;
	}

	final public function prependRoute(string $mask, $metadata = [], int $flags = 0)
	{
		$this->prepend(static::createRoute($mask, $metadata), $flags);
		return $this;
	}

	public function createRoute(string $mask, $metadata = [], int $flags = 0)
	{
		return new Route($mask, $metadata, $flags, $this->translator);
	}
}
