# PHP Cookies

[![GitHub release](https://img.shields.io/github/release/codezero-be/cookie.svg)]()
[![License](https://img.shields.io/packagist/l/codezero/cookie.svg)]()
[![Build Status](https://scrutinizer-ci.com/g/codezero-be/cookie/badges/build.png?b=master)](https://scrutinizer-ci.com/g/codezero-be/cookie/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/codezero-be/cookie/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/codezero-be/cookie/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/codezero-be/cookie/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/codezero-be/cookie/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/codezero/cookie.svg)](https://packagist.org/packages/codezero/cookie)

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/R6R3UQ8V)

### Your friendly, furry cookie monster!

Get and set cookies in vanilla PHP with ease.
A [Laravel](http://laravel.com/) implementation is included, but this has no real advantages if you only use Laravel.

**CAUTION!** Never store sensitive data in a cookie!

## Installation

Install this package through Composer:

```php
composer require codezero/cookie
```

## Vanilla PHP Implementation

Autoload the vendor classes:

```php
require_once 'vendor/autoload.php'; // Path may vary
```

And then use the `VanillaCookie` implementation:

```php
$cookie = new \CodeZero\Cookie\VanillaCookie();
```

If you want your cookies to be encrypted, pass an instance of [codezero/encrypter](https://github.com/codezero-be/encrypter) to the `Cookie` class.
You will also need to provide it with an encryption key that is needed to decrypt the cookie later on.

```php
$key = 'my secret app key';
$encrypter = new \CodeZero\Encrypter\DefaultEncrypter($key);
$cookie = new \CodeZero\Cookie\VanillaCookie($encrypter);
```

> **TIP:** Laravel automagically encrypts cookies by default!

## Laravel 5 Implementation

You can "make" (or inject) a `Cookie` instance anywhere in your app:

```php
$cookie = \App::make('CodeZero\Cookie\Cookie');
```

> **TIP:** Laravel's [IoC container](http://laravel.com/docs/container) will automatically provide the Laravel specific `Cookie` implementation.
> This will use Laravel's [`Cookie`](http://laravel.com/docs/requests) goodness behind the scenes!

## Usage

### Get a cookie

This will return `null` if the cookie doesn't exist or is expired.

```php
$cookieValue = $cookie->get('cookieName');
```

### Store a cookie for a limited time

If you don't specify `$minutesValid`, a default of 60 minutes will be used.

```php
$minutesValid = 120;
$cookie->store('cookieName', 'cookieValue', $minutesValid);
```

### Store a cookie forever

5 years feels like forever... ;)

```php
$cookie->forever('cookieName', 'cookieValue');
```

### Delete a cookie

If the cookie doesn't exist, nothing will happen...

```php
$cookie->delete('cookieName');
```

### Check if a cookie exists

You can check if a cookie exists.
However, keep in mind that a cookie will not be available immediately.
It will be on the next page load.

```php
if ($cookie->exists('cookieName')) {
    // The cookie exists!
}
```

## Testing

```php
$ composer run test
```

## Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
