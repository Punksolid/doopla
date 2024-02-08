# Doopla PHP Library

## Description

This is a PHP library for interacting with the Doopla platform. It provides a simple and easy-to-use interface for making requests to the Doopla API.

## Installation

This library can be installed via Composer:

```bash
composer require punksolid/doopla
```

## Usage

First, you need to instantiate the `Doopla` class with an instance of `HttpClientInterface`. You can use the `MockHttpClient` for testing purposes.

```php
use Punksolid\Doopla\Doopla;
use Symfony\Component\HttpClient\MockHttpClient;

$client = new MockHttpClient();
$doopla = new Doopla($client);
```

### Setting User Credentials

You can set the user's email and password using the `setEmail` and `setPassword` methods respectively.

```php
$doopla->setEmail('user@example.com');
$doopla->setPassword('password');
```

### Logging In

To log in, simply call the `login` method.

```php
$doopla->login();
```

### Getting Account Balance

You can get the account balance by calling the `getBalance` method.

```php
$balance = $doopla->getBalance();
```

## Testing

This library comes with a set of unit tests. You can run these tests using PHPUnit.

```bash
vendor/bin/phpunit
```

## Contributing

Contributions are welcome. Please submit a pull request with any enhancements.

## License

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
