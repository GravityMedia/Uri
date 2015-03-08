#Uniform Resource Identifier (URI)

A PHP 5.3+ library for generating RFC 3986 compliant uniform resource identifiers (URI)

[![Packagist](https://img.shields.io/packagist/v/gravitymedia/uri.svg)](https://packagist.org/packages/gravitymedia/uri)
[![Downloads](https://img.shields.io/packagist/dt/gravitymedia/uri.svg)](https://packagist.org/packages/gravitymedia/uri)
[![License](https://img.shields.io/packagist/l/gravitymedia/uri.svg)](https://packagist.org/packages/gravitymedia/uri)
[![Build](https://img.shields.io/travis/GravityMedia/Uri.svg)](https://travis-ci.org/GravityMedia/Uri)
[![Code Quality](https://img.shields.io/scrutinizer/g/GravityMedia/Uri.svg)](https://scrutinizer-ci.com/g/GravityMedia/Uri/?branch=master)
[![Coverage](https://img.shields.io/scrutinizer/coverage/g/GravityMedia/Uri.svg)](https://scrutinizer-ci.com/g/GravityMedia/Uri/?branch=master)
[![PHP Dependencies](https://www.versioneye.com/user/projects/54a6c39d27b014005400004b/badge.svg)](https://www.versioneye.com/user/projects/54a6c39d27b014005400004b)

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

use GravityMedia\Uri\Uri;

// create URI from string
$uri = Uri::fromString('http://username:password@example.com');

// dump scheme
var_dump($uri->getScheme());

// dump authority
var_dump($uri->getAuthority());
```
