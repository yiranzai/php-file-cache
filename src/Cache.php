<?php

namespace Yiranzai\File;

/**
 * Class Cache
 * @package Yiranzai\File
 */
class Cache
{
    /**
     *
     */
    public const DEFAULT_PATH = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
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
     * @param string $key
     * @param string $data
     * @return Cache
     */
    public function put(string $key, string $data): Cache
    {
        $this->ensureCacheDirectoryExists($path = $this->path($key));

        if ($this->file->exists($path = $this->path($key))) {
            if ($bucket = $this->getBucket($path)) {
                $bucket->putNode($key, $data);
            }
        } else {
            $bucket = new Bucket($key, $data);
        }
        $this->file->put($path, serialize($bucket));
        return $this;
    }

    /**
     * @param      $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null)
    {
        if (!$this->file->exists($path = $this->path($key))) {
            return $default;
        }
        if (!$bucket = $this->getBucket($path)) {
            return $default;
        }
        if ($node = $bucket->findNode($key)) {
            return $node->data;
        }
        return $default;
    }

    /**
     * @param string $path
     * @return Bucket|null
     */
    protected function getBucket(string $path): ?Bucket
    {
        $bucket = $this->file->get($path);
        if ($bucket) {
            $bucket = unserialize($bucket, array('allowed_classes' => [Node::class, Bucket::class]));
        }
        return $bucket;
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
     * @param string $path
     * @return $this
     */
    public function dataPath(string $path): self
    {
        $this->dataPath = $path;
        return $this;
    }
}
