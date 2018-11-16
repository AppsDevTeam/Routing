<?php

namespace ADT;

use Nette\Application\Request as AppRequest;
use Nette\Http\Url;


/**
 * The bidirectional route with non-standard port support for absolute masks.
 */
class Route extends \Nette\Application\Routers\Route
{
	/**
	 * Constructs absolute URL from Request object.
	 * @return string|null
	 */
	public function constructUrl(AppRequest $appRequest, Url $refUrl)
	{
		$url = parent::constructUrl($appRequest, $refUrl);

		if ($url !== null && ! in_array($refUrl->getPort(), Url::$defaultPorts, true)) {
			$url = preg_replace(
				'/^('
				. preg_quote($refUrl->getScheme(), '/') . '):\/\/'
				. preg_quote($refUrl->getHost(), '/') . '\//',
				'$1://' . $refUrl->getHost() . ':' . $refUrl->getPort() . '/',
				$url
			);
		}

		return $url;
	}
}