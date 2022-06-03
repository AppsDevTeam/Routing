<?php

namespace ADT\Routing;

interface TranslatorInterface
{
	public function getAvailableLocales(): array;
	public function getDefaultLocale(): string;
}