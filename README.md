# Uniform Resource Identifier (URI)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gravitymedia/uri.svg)](https://packagist.org/packages/gravitymedia/uri)
[![Software License](https://img.shields.io/packagist/l/gravitymedia/uri.svg)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/GravityMedia/Uri.svg)](https://travis-ci.org/GravityMedia/Uri)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/GravityMedia/Uri.svg)](https://scrutinizer-ci.com/g/GravityMedia/Uri/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/GravityMedia/Uri.svg)](https://scrutinizer-ci.com/g/GravityMedia/Uri)
[![Total Downloads](https://img.shields.io/packagist/dt/gravitymedia/uri.svg)](https://packagist.org/packages/gravitymedia/uri)
[![Dependency Status](https://img.shields.io/versioneye/d/php/gravitymedia:uri.svg)](https://www.versioneye.com/user/projects/54fcb6ba4f31084fdc000719)

A PHP library for generating RFC 3986 compliant uniform resource identifiers (URI).

## Requirements

This library has the following requirements:

 - PHP 5.6+

## Installation

Install Composer in your project:

```bash
$ curl -s https://getcomposer.org/installer | php
```

Require the package via Composer:

```bash
$ php composer.phar require gravitymedia/uri
```

## Usage

This example illustrates te basic usage of an URI object.

```php
// require autoloader
require 'vendor/autoload.php';

// import classes
use GravityMedia\Uri\Uri;

// create URI object from string
$uri = Uri::fromString('http://username:password@example.com:8080/this/is/a/path?argument=value#my_fragment');

// dump scheme
var_dump($uri->getScheme()); // string(4) "http"

// dump authority
var_dump($uri->getAuthority()); // string(29) "username:password@example.com"

// dump user info
var_dump($uri->getUserInfo()); // string(17) "username:password"

// dump host
var_dump($uri->getHost()); // string(11) "example.com"

// dump port
var_dump($uri->getPort()); // int(8080)

// dump path
var_dump($uri->getPath()); // string(15) "/this/is/a/path"

// dump argument
var_dump($uri->getQuery()); // string(14) "argument=value"

// dump fragment
var_dump($uri->getFragment()); // string(11) "my_fragment"

// remove path and remove fragment
$uri = $uri->withPath('')->withFragment('');

// dump URI
var_dump($uri->toString()); // string(56) "http://username:password@example.com:8080?argument=value"
```

The URI also supports URN syntax.

```php
// require autoloader
require 'vendor/autoload.php';

// import classes
use GravityMedia\Uri\Uri;

// create URI object from string
$uri = Uri::fromString('urn:example:animal:ferret:nose');

// dump scheme
var_dump($uri->getScheme()); // string(3) "urn"

// dump path
var_dump($uri->getPath()); // string(26) "example:animal:ferret:nose"
```

Use the `SchemeRegistry` to support additional schemes and normalize the the URI string.

```php
// require autoloader
require 'vendor/autoload.php';

// import classes
use GravityMedia\Uri\SchemeRegistry;
use GravityMedia\Uri\Uri;

// register SSH scheme
SchemeRegistry::registerSchemes([
    'ssh' => 22,
]);

// create URI object from string
$uri = Uri::fromString('ssh://git@github.com:22/GravityMedia/Uri.git');

// dump normalized URI
var_dump($uri->toString()); // string(41) "ssh://git@github.com/GravityMedia/Uri.git"
```

The `AbstractQuery` class allows to define and manipulate the query string.

```php
// require autoloader
require 'vendor/autoload.php';

// import classes
use GravityMedia\Uri\AbstractQuery;
use GravityMedia\Uri\Uri;

/**
 * My query class.
 */
class MyQuery extends AbstractQuery
{
    /**
     * The argument.
     *
     * @var mixed
     */
    protected $argument;

    /**
     * Get argument.
     *
     * @return mixed
     */
    public function getArgument()
    {
        return $this->argument;
    }

    /**
     * Set argument.
     *
     * @param mixed $argument
     *
     * @return $this
     */
    public function setArgument($argument)
    {
        $this->argument = $argument;

        return $this;
    }
}

// create URI object from string
$uri = Uri::fromString('http://example.com?argument=value');

// create my query object from string
$query = MyQuery::fromString($uri->getQuery());

// dump array representation of query
var_dump($query->toArray()); // array(1) { ["argument"]=> string(5) "value" }

// update query argument value
var_dump($query->setArgument('new value')->toString()); // string(18) "argument=new+value"

// change query
$uri = $uri->withQuery($query->toString());

// dump URI
var_dump($uri->toString()); // string(37) "http://example.com?argument=new+value"
```
