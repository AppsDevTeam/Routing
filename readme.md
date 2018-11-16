# RoutePort

Adds non-standard port support for routes with absolute path mask.

## Installation

The recommended way to install is via Composer:

```
composer require adt/route-port
```

It requires PHP version 5.6 and supports PHP up to 7.3.

## Usage

It's very simple, just define your routes using `\ADT\Route` class:

```php
$router[] = new \ADT\Route('//yourwebsite.com/<presenter>/<action>', 'Homepage:default');
```

Your application then, instead of instant redirection back to port 80, or 443, will preserve server port between HTTP requests, so you will be able to see your page defined by route with an absolute mask e.g. on port 1234:

```
https://yourwebsite.com:1234/articles/new
```