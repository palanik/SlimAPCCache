SlimAPCCache
============

Cache Middleware for PHP [Slim micro framework](http://www.slimframework.com/) using [apccache](http://www.php.net/manual/en/book.apc.php)

## How to Install

Update your `composer.json` to require the `palanik/slimapccache` package.
Run `composer install` to add SlimAPCCache your vendor folder.

    {
        "require": {
            "palanik/slimapccache": "0.0.1.*"
        }
    }

##How to Use this Middleware
```php
<?php
$app = new \Slim\Slim();

use palanik\slimapccache\SlimApcCache;

$app->add($app->add(new SlimApcCache(array(
			'ttl' => 60,
			'caching_prefix' => 'myapp_',
			)));
			
$app->get('/foo', function () use ($app) {
    echo "Hello";
});
$app->run();
?>
```
