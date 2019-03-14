# Changelog

All notable changes to `file-cache` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [1.0.0] - 2019-03-14

### Added

-   `forever($key, $data): Cache`  forever save one cache to file
-   `delete($key): bool`  delete one cache
-   `flush(): void`  delete all cache

### Deprecated

-   `put($key, $data, $minutes): Cache`  put one cache to file,set expired time
    -   `minutes` can be a `int` or `DateTime` or `null` or [Supported Date and Time Formats ](http:us1.php.net/manual/zh/datetime.formats.php)
-   `get($key, $default = null): ?string`  get the data corresponding to the key
-   `dataPath($path): self`  change data save path

### Fixed

-   Bucket::delNode() delete head has bug

### Removed

-   Nothing

### Security

-   Nothing
