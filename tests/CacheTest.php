<?php

declare(strict_types=1);

namespace Yiranzai\File\Tests;

use PHPUnit\Framework\TestCase;
use Yiranzai\File\Cache;
use Yiranzai\File\Filesystem;

class CacheTest extends TestCase
{
    /**
     * Test that true does in fact equal true
     */
    public function testCacheDefault()
    {
        $str   = 'test';
        $path  = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
        $dataPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data2' . DIRECTORY_SEPARATOR;
        $file  = new Filesystem();
        $cache = new Cache(['file' => 'tests', $str => $str]);
        $cache->put($str, $str);
        $this->assertSame($str, $cache->get($str));
        $this->assertSame('abc', $cache->get('abc', 'abc'));

        $this->assertTrue($file->exists($path));
        $file->deleteDirectory($path);
        $this->assertFalse($file->exists($path));

        $cache->dataPath($dataPath);
        $cache->put($str, $str);
        $this->assertSame($str, $cache->get($str));
        $this->assertSame('abc', $cache->get('abc', 'abc'));

        $this->assertTrue($file->exists($dataPath));
        $file->deleteDirectory($dataPath);
        $this->assertFalse($file->exists($dataPath));
    }
}
