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
			$nurl = new Url($url);
			$nurl->setPort($refUrl->getPort());
			$url = $nurl->getAbsoluteUrl();
		}

		return $url;
	}
}
