<?php

namespace ADT\Routing;

use Nette\Application\Request as AppRequest;
use Nette\Http\Url;
use Nette\Http\UrlScript;
use Nette\Localization\ITranslator;


/**
 * The bidirectional route with non-standard port support for absolute masks and locale
 */
class Route extends \Nette\Application\Routers\Route
{
	public bool $enableLocale;

	public function __construct(string $mask, $metadata = [], int $flags = 0, $disableLocaleParameter = false, ?ITranslator $translator = null)
	{
		$this->enableLocale = !$disableLocaleParameter && $translator && count($translator->getAvailableLocales()) > 1;

		if ($this->enableLocale) {
			$locale = '[<locale' . ($translator->getDefaultLocale() ? '=' . $translator->getDefaultLocale() : '') . ' ' . implode('|', $translator->getAvailableLocales()) . '>/]';
			$hostUrl = (new Url($mask))->getHostUrl();
			$mask = $hostUrl ?
				$hostUrl . '/' . ltrim(str_replace($hostUrl, $locale, $mask), '/'):
				$locale . $mask;
		}

		parent::__construct($mask, $metadata, $flags);
	}

	public function constructUrl(array $params, UrlScript $refUrl): ?string
	{
		$url = parent::constructUrl($params, $refUrl);

		if ($this->enableLocale && $url !== null) {
			$url = new Url($url);
			$url->setQueryParameter('originalLocale', null);
			$url = (string)$url;
		}

		if ($url !== null && ! in_array($refUrl->getPort(), Url::$defaultPorts, true)) {
			$nurl = new Url($url);
			$nurl->setPort($refUrl->getPort());
			$url = $nurl->getAbsoluteUrl();
		}

		return $url;
	}
}
