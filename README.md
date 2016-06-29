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

```php
require 'vendor/autoload.php';

use GravityMedia\Uri\Uri;

// create URI from string
$uri = Uri::fromString('http://username:password@example.com/this/is/a/path?argument=value#my_fragment');

// dump scheme
print $uri->getScheme(); // http

// dump authority
print $uri->getAuthority(); // username:password@example.com

// dump user
print $uri->getUserinfo(); // username:password

// dump host
print $uri->getHost(); // example.com

// dump port
print $uri->getPort(); // 80

// dump path
print $uri->getPath(); // /this/is/a/path

// dump argument
print $uri->getQuery(); // argument=value

// dump fragment
print $uri->getFragment(); // my_fragment

// remove path
$uri = $uri->withPath('');

// change query
$uri = $uri->withQuery('foo=bar');

// remove fragment
$uri->withFragment('');

// dump URI
print $uri->toString(); // http://username:password@example.com?foo=bar
```
