# file-cache

<p align="center">
  <img src="https://cdn.yiranzai.cn/yiranzai/logo/mouse/mouse1.png" alt="" width="20%">
</p>

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

PHP File Cache, use chaining resolve hash conflict. one cache, one file, one bucket.

## Feature

This package is different from other packages

-   Cache can set expired time.
-   Use chaining resolve hash conflict.
-   Hash key is the path to store data.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
src/
tests/
vendor/
```

## Install

Via Composer

```bash
$ composer require yiranzai/file-cache
```

## Usage

### API

This package provides these methods.

-   `put($key, $data, $minutes): Cache`  put one cache to file,set expired time
    -   `$minutes` can be a `int` or `DateTime` or `null` or [Supported Date and Time Formats ](http://us1.php.net/manual/zh/datetime.formats.php)
-   `forever($key, $data): Cache`  forever save one cache to file
-   `get($key, $default = null): ?string`  get the data corresponding to the key
-   `delete($key): bool`  delete one cache
-   `flush(): void`  delete all cache
-   `dataPath($path): self`  change data save path

### Demo

```php
$cache = new Yiranzai\File\Cache();

$cache->put('key', 'data', 10);
$cache->put('key1', 'data1', new DateTime());
$cache->put('key2', 'data2', 'now');
$cache->forever('key3', 'data3');

$cache->get('key');   // data

$cache->delete('key');   // true

$cache->flush();

$cache->get('not_exists','nothing');   // nothing
$cache->dataPath('YOUR_PATH');

// or

$cache = new Yiranzai\File\Cache(['dataPath'=>'YOUR_PATH']);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email wuqingdzx@gmail.com instead of using the issue tracker.

## Credits

-   [yiranzai][link-author]
-   [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/yiranzai/file-cache.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/yiranzai/php-file-cache/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/yiranzai/php-file-cache.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/yiranzai/php-file-cache.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/yiranzai/file-cache.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/yiranzai/file-cache
[link-travis]: https://travis-ci.org/yiranzai/php-file-cache
[link-scrutinizer]: https://scrutinizer-ci.com/g/yiranzai/php-file-cache/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/yiranzai/php-file-cache
[link-downloads]: https://packagist.org/packages/yiranzai/file-cache
[link-author]: https://github.com/yiranzai
[link-contributors]: ../../contributors
