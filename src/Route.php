<?php

namespace ADT\Routing;

use Contributte\Translation\Translator;
use Nette\Http\Url;
use Nette\Http\UrlScript;
use Nette\Utils\Strings;


/**
 * The bidirectional route with non-standard port support for absolute masks and locale
 *
 * / => [<locale=cs cs|en>]
 * url => [<locale=cs cs|en>/]url
 * /url => [<locale=cs cs|en>/]url
 * https://www.example.com/url => https://www.example.com/[<locale=cs cs|en>/]url
 */
class Route extends \Nette\Application\Routers\Route
{
	public bool $enableLocale;

	public function __construct(string $mask, $metadata = [], int $flags = 0, Translator $translator = null)
	{
		$this->enableLocale = (bool) $translator;

		if ($this->enableLocale) {
			$hostUrl = (new Url($mask))->getHostUrl();
			$locale = '[<locale' . ($translator->getDefaultLocale() ? '=' . $translator->getDefaultLocale() : '') . ' ' . implode('|', $translator->getAvailableLocales()) . '>/]';

			if ($hostUrl) {
				$mask = str_replace($hostUrl . '/', $locale, $mask);
			}
			$mask = ltrim($mask, '/');
			$mask = ($hostUrl ? $hostUrl . '/' : $locale) . $mask;
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

			// removes trailing slash
			if (
				$url === $params['locale'] . '/' // en/
				|| $url === '/' . $params['locale'] . '/' // /en/
				|| Strings::endsWith($url, '/' . $params['locale'] . '/') // https://www.example.com/en/
			) {
				$url = rtrim($url, '/');
			}
		}

		if ($url !== null && ! in_array($refUrl->getPort(), Url::$defaultPorts, true)) {
			$nurl = new Url($url);
			$nurl->setPort($refUrl->getPort());
			$url = $nurl->getAbsoluteUrl();
		}

		return $url;
	}
}
