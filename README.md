#Uniform Resource Identifier (URI)

A PHP 5.3+ library for generating RFC 3986 compliant uniform resource identifiers (URI)

[![Packagist](https://img.shields.io/packagist/v/gravitymedia/uri.svg)](https://packagist.org/packages/gravitymedia/uri)
[![Downloads](https://img.shields.io/packagist/dt/gravitymedia/uri.svg)](https://packagist.org/packages/gravitymedia/uri)
[![License](https://img.shields.io/packagist/l/gravitymedia/uri.svg)](https://packagist.org/packages/gravitymedia/uri)
[![Build](https://img.shields.io/travis/GravityMedia/Uri.svg)](https://travis-ci.org/GravityMedia/Uri)
[![Code Quality](https://img.shields.io/scrutinizer/g/GravityMedia/Uri.svg)](https://scrutinizer-ci.com/g/GravityMedia/Uri/?branch=master)
[![Coverage](https://img.shields.io/scrutinizer/coverage/g/GravityMedia/Uri.svg)](https://scrutinizer-ci.com/g/GravityMedia/Uri/?branch=master)
[![PHP Dependencies](https://www.versioneye.com/user/projects/54fcb6ba4f31084fdc000719/badge.svg)](https://www.versioneye.com/user/projects/54fcb6ba4f31084fdc000719)

##Requirements##

This library has the following requirements:

 - PHP 5.3+

##Installation##

Install composer in your project:

```bash
$ curl -s https://getcomposer.org/installer | php
```

Create a `composer.json` file in your project root:

```json
{
    "require": {
        "gravitymedia/uri": "dev-master"
    }
}
```

Install via composer:

```bash
$ php composer.phar install
```

##Usage##

```php
require 'vendor/autoload.php';

use GravityMedia\Uri\Component\Authority;
use GravityMedia\Uri\Uri;

// define default port
Authority::$defaultPort = 80;

// create URI from string
$uri = Uri::fromString('http://username:password@example.com/this/is/a/path?argument=value#my_fragment');

// dump scheme
print $uri->getScheme(); // http

// dump authority
print $uri->getAuthority(); // username:password@example.com

// dump user
print $uri->getAuthority()->getUserinfo()->getUser(); // username

// dump pass
print $uri->getAuthority()->getUserinfo()->getPass(); // password

// dump host
print $uri->getAuthority()->getHost(); // example.com

// dump port
print $uri->getAuthority()->getPort(); // 80

// dump path
print $uri->getPath(); // /this/is/a/path

// dump argument
print $uri->getQuery('argument'); // value

// dump fragment
print $uri->getFragment(); // my_fragment

// remove path
$uri->setPath(null);

// change query
$query = $uri->getQuery();
unset($query['argument']);
$query['foo'] = 'bar';

// remove fragment
$uri->setFragment(null);

// dump URI
print strval($uri); // http://username:password@example.com?foo=bar
```
