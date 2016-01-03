# Scabbia2 Services Component

[This component](https://github.com/eserozvataf/scabbia2-services) is a tiny dependency management container implementation allow you to share, produce and access instances/variables easily.

[![Build Status](https://travis-ci.org/eserozvataf/scabbia2-services.png?branch=master)](https://travis-ci.org/eserozvataf/scabbia2-services)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/eserozvataf/scabbia2-services/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/eserozvataf/scabbia2-services/?branch=master)
[![Total Downloads](https://poser.pugx.org/eserozvataf/scabbia2-services/downloads.png)](https://packagist.org/packages/eserozvataf/scabbia2-services)
[![Latest Stable Version](https://poser.pugx.org/eserozvataf/scabbia2-services/v/stable)](https://packagist.org/packages/eserozvataf/scabbia2-services)
[![Latest Unstable Version](https://poser.pugx.org/eserozvataf/scabbia2-services/v/unstable)](https://packagist.org/packages/eserozvataf/scabbia2-services)
[![Documentation Status](https://readthedocs.org/projects/scabbia2-documentation/badge/?version=latest)](https://readthedocs.org/projects/scabbia2-documentation)

## Usage

### Basic Key/Value Container

```php
use Scabbia\Services;

$container = new Services();

$container['key'] = 'value';

echo $container['key'];
```

### Singleton Access

```php
use Scabbia\Services;

$container = Services::getCurrent();

$container['key'] = ['sample', 'array'];

var_dump($container['key']);
```

### Setting a Factory

```php
use Scabbia\Services;

$container = Services::getCurrent();

$container->setFactory('key', function () {
    return ['time' => microtime(true)];
});

var_dump($container['key']);
var_dump($container['key']); // will be different than previous one
```

### Decorating

```php
use Scabbia\Services;

$container = Services::getCurrent();

$container['key'] = 'test';

$container->decorate('key', function ($value) {
    return $value . 'ing';
});

$container->decorate('key', function ($value) {
    return strtoupper($value);
});

var_dump($container['key']); // returns 'TESTING'
```

## Links
- [List of All Scabbia2 Components](https://github.com/eserozvataf/scabbia2)
- [Documentation](https://readthedocs.org/projects/scabbia2-documentation)
- [Twitter](https://twitter.com/eserozvataf)
- [Contributor List](contributors.md)
- [License Information](LICENSE)


## Contributing
It is publicly open for any contribution. Bugfixes, new features and extra modules are welcome. All contributions should be filed on the [eserozvataf/scabbia2-services](https://github.com/eserozvataf/scabbia2-services) repository.

* To contribute to code: Fork the repo, push your changes to your fork, and submit a pull request.
* To report a bug: If something does not work, please report it using GitHub issues.
* To support: [![Donate](https://img.shields.io/gratipay/eserozvataf.svg)](https://gratipay.com/eserozvataf/)
