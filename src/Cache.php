<?php

namespace Yiranzai\File;

use DateTime;
use DateInterval;

/**
 * Class Cache
 * @package Yiranzai\File
 */
class Cache
{
    public const DEFAULT_PATH = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data'
    . DIRECTORY_SEPARATOR;
    /**
     * @var string
     */
    protected $dataPath = self::DEFAULT_PATH;
    /**
     * @var Filesystem
     */
    protected $file;
    /**
     * @var array
     */
    protected $guarded = ['file'];

    /**
     * Hash constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!empty($config)) {
            foreach ($config as $key => $item) {
                if (in_array($key, $this->guarded, true)) {
                    continue;
                }
                $this->$key = $item;
            }
        }
        $this->file = new Filesystem();
    }

    /**
     * 存储数据
     *
     * @param string                   $key
     * @param string                   $data
     * @param string|DateTime|int|null $minutes
     * @return Cache
     * @throws \Exception
     */
    public function put(string $key, string $data, $minutes = null): Cache
    {
        $this->ensureCacheDirectoryExists($path = $this->path($key));

        if ($this->file->exists($path = $this->path($key))) {
            if ($bucket = $this->getBucket($path)) {
                $bucket->putNode($key, $data, $this->generateDate($minutes));
            }
        } else {
            $bucket = new Bucket($key, $data, $this->generateDate($minutes));
        }
        $this->file->put($path, serialize($bucket));
        return $this;
    }

    /**
     * @param string $key
     * @param string $data
     * @return Cache
     * @throws \Exception
     */
    public function forever(string $key, string $data): Cache
    {
        $this->put($key, $data);
        return $this;
    }

    /**
     * @param $minutes
     * @return DateTime
     * @throws \Exception
     */
    protected function generateDate($minutes): ?DateTime
    {
        if ($minutes === null) {
            return null;
        }
        if ($minutes instanceof \DateTime) {
            return $minutes;
        }
        if (is_int($minutes)) {
            $date = new DateTime();
            return $date->add(new DateInterval('PT' . $minutes . 'M'));
        }
        try {
            return new DateTime($minutes);
        } catch (\Exception $exception) {
            throw new $exception;
        }
    }

    /**
     * @param  string $path
     * @return void
     */
    protected function ensureCacheDirectoryExists($path): void
    {
        if (!$this->file->exists(dirname($path))) {
            $this->file->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * @param string $key
     * @return string
     */
    protected function path(string $key): string
    {
        $parts = array_slice(str_split($hash = hash('sha256', $key), 2), 0, 2);

        return $this->dataPath . DIRECTORY_SEPARATOR . implode(
            DIRECTORY_SEPARATOR,
            $parts
        ) . DIRECTORY_SEPARATOR . $hash;
    }

    /**
     * @param string $path
     * @return Bucket|null
     */
    protected function getBucket(string $path): ?Bucket
    {
        $bucket = $this->file->get($path);
        if ($bucket) {
            $bucket = unserialize($bucket, ['allowed_classes' => [Node::class, Bucket::class, DateTime::class]]);
        }
        return $bucket;
    }

    /**
     * 获取数据
     *
     * @param string $key
     * @param null   $default
     * @return null|string
     * @throws \Exception
     */
    public function get(string $key, $default = null): ?string
    {
        if (!$this->file->exists($path = $this->path($key))) {
            return $default;
        }
        if (!$bucket = $this->getBucket($path)) {
            return $default;
        }
        if ($node = $bucket->findNode($key)) {
            if ($node->isExpired()) {
                $this->delete($key);
            }
            return $node->getData($default);
        }
        return $default;
    }

    /**
     * 删除一个数据
     *
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        if (!$this->file->exists($path = $this->path($key))) {
            return true;
        }
        if (!($bucket = $this->getBucket($path))) {
            return true;
        }
        $bucket->delNode($key);
        if (!$bucket->isNull()) {
            $this->file->put($path, serialize($bucket));
        }
        return $this->file->delete($path);
    }

    /**
     *  删除所有的数据
     */
    public function flush(): void
    {
        $this->file->deleteDirectory($this->dataPath);
    }

    /**
     * @param string $path
     * @return $this
     */
    public function dataPath(string $path): self
    {
        $this->dataPath = $path;
        return $this;
    }
}
