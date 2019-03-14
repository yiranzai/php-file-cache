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

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require yiranzai/file-cache
```

## Usage

``` php
$cache = new Yiranzai\File\Cache();

$cache->put('key', 'data');
$cache->get('key');   // data

$cache->get('not_exists','nothing');   // nothing
$cache->dataPath('YOUR_PATH');

// or

$cache = new Yiranzai\File\Cache(['dataPath'=>'YOUR_PATH']);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email wuqingdzx@gmail.com instead of using the issue tracker.

## Credits

- [yiranzai][link-author]
- [All Contributors][link-contributors]

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
