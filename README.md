# dear-api

A fork of https://github.com/UmiMood/dear-api.

PHP Library for [dear systems](https://dearinventory.docs.apiary.io) API v2.

## Requirements

* PHP 7.4+
* guzzlehttp/guzzle 7.2+
* ext-json extension

## Installation

```bash
composer require rocketmen/dearapi
```

Otherwise just download the package and add it to the autoloader.

## API Documentation
[docs](https://dearinventory.docs.apiary.io)

## Usage


Create a Dear instance.
```php
$dear = Rocketmen\Dear\Dear::create("DEAR-ACCOUNT_ID", "DEAR-APPLICATION-KEY");
```

Get data from API
```php

$products = $dear->product()->get([]);
$accounts = $dear->account()->get([]);
$me = $dear->me()->get([]);

```

Push a new record to the API
```php

$response = $dear->product()->create($params); // see docs for available parameters

```

Update an existing record
```php

$response = $dear->product()->update($guid, $params); // see docs for available parameters

```

Delete a record
```php

$response = $dear->product()->delete($guid, []);

```

## Links ##
 * [License](./LICENSE)
