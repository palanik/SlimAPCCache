SlimAPCCache
============

Cache Middleware for PHP [Slim micro framework](http://www.slimframework.com/) using [APC Cache](http://www.php.net/manual/en/book.apc.php)

## How to Install

1. Update your `composer.json` to require the `palanik/slim-apc-cache` package.
2. Run `composer install` to add SlimAPCCache your vendor folder.
```json
{
  "require": {
    "palanik/slim-apc-cache": "0.0.2.*"
  }
}
```

##How to Use this Middleware
```php
<?php
require ('./vendor/autoload.php');

$app = new \Slim\Slim();

use palanik\SlimAPCCache\SlimAPCCache;

$app->add(new SlimAPCCache(array(
			'ttl' => 60,
			'caching_prefix' => 'myapp_',
			)));
			
$app->get('/foo', function () use ($app) {
    echo "Hello Bar";
});

$app->run();
?>
```
