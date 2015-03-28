# Cookie

[![GitHub release](https://img.shields.io/github/release/codezero-be/cookie.svg)]()
[![License](https://img.shields.io/packagist/l/codezero/cookie.svg)]()
[![Build Status](https://img.shields.io/travis/codezero-be/cookie.svg?branch=master)](https://travis-ci.org/codezero-be/cookie)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/codezero-be/cookie.svg)](https://scrutinizer-ci.com/g/codezero-be/cookie)
[![Total Downloads](https://img.shields.io/packagist/dt/codezero/cookie.svg)](https://packagist.org/packages/codezero/cookie)

### Your friendly, furry cookie monster!

Get and set cookies in PHP with ease. Supports vanilla PHP and [Laravel 5](http://laravel.com/).

**CAUTION!** Never store sensitive data in a cookie!

## Installation

Install this package through Composer:

    composer require codezero/cookie

## Vanilla PHP Implementation

Autoload the vendor classes:

    require_once 'vendor/autoload.php'; // Path may vary

And then use the `VanillaCookie` implementation:

    $cookie = new \CodeZero\Cookie\VanillaCookie();

If you want your cookies to be encrypted, pass an instance of [codezero/encrypter](https://github.com/codezero-be/encrypter) to the `Cookie` class. You will also need to provide it with an encryption key that is needed to decrypt the cookie later on.

    $key = 'my secret app key';
    $encrypter = new \CodeZero\Encrypter\DefaultEncrypter($key);
    $cookie = new \CodeZero\Cookie\VanillaCookie($encrypter);

> **TIP:** Laravel automagically encrypts cookies by default!

## Laravel 5 Implementation

Add a reference to `LaravelCookieServiceProvider` to the providers array in `config/app.php`:

    'providers' => [
        'CodeZero\Cookie\LaravelCookieServiceProvider'
    ]

Then you can "make" (or inject) a `Cookie` instance anywhere in your app:

    $cookie = \App::make('CodeZero\Cookie\Cookie');


> **TIP:** Laravel's [IoC container](http://laravel.com/docs/5.0/container) will automatically provide the Laravel specific `Cookie` implementation. This will use Laravel's [`Cookie`](http://laravel.com/docs/5.0/requests) goodness behind the scenes!

## Usage

### Get a cookie

This will return `null` if the cookie doesn't exist or is expired.

    $cookieValue = $cookie->get('cookieName');

### Store a cookie for a limited time

If you don't specify `$minutesValid`, a default of 60 minutes will be used.

    $minutesValid = 120;
    $cookie->store('cookieName', 'cookieValue', $minutesValid);

### Store a cookie forever

5 years feels like forever... ;)

    $cookie->forever('cookieName', 'cookieValue');

### Delete a cookie

If the cookie doesn't exist, nothing will happen...

    $cookie->delete('cookieName');

## Testing

    $ vendor/bin/phpspec run

## Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---
[![Analytics](https://ga-beacon.appspot.com/UA-58876018-1/codezero-be/cookie)](https://github.com/igrigorik/ga-beacon)