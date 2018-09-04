mod-stats
===========
Module stats PIXELION CMS

[![Latest Stable Version](https://poser.pugx.org/panix/mod-stats/v/stable)](https://packagist.org/packages/panix/mod-stats) [![Total Downloads](https://poser.pugx.org/panix/mod-stats/downloads)](https://packagist.org/packages/panix/mod-stats) [![Monthly Downloads](https://poser.pugx.org/panix/mod-stats/d/monthly)](https://packagist.org/packages/panix/mod-stats) [![Daily Downloads](https://poser.pugx.org/panix/mod-stats/d/daily)](https://packagist.org/packages/panix/mod-stats) [![Latest Unstable Version](https://poser.pugx.org/panix/mod-stats/v/unstable)](https://packagist.org/packages/panix/mod-stats) [![License](https://poser.pugx.org/panix/mod-stats/license)](https://packagist.org/packages/panix/mod-stats)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist panix/mod-stats "*"
```

or add

```
"panix/mod-stats": "*"
```

to the require section of your `composer.json` file.

Add to web config.
```
'modules' => [
    'stats' => ['class' => 'panix\mod\stats\Module'],
],
