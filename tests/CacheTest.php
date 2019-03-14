<?php

declare(strict_types=1);

namespace Yiranzai\File\Tests;

use PHPUnit\Framework\TestCase;
use Yiranzai\File\Cache;
use Yiranzai\File\Filesystem;

class CacheTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCacheDefault()
    {
        $str      = 'test';
        $path     = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
        $dataPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data2' . DIRECTORY_SEPARATOR;
        $file     = new Filesystem();
        $cache    = new Cache(['file' => 'tests', $str => $str]);
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

    /**
     * @throws \Exception
     */
    public function testDelete()
    {
        $path   = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
        $strOne = 'test1';
        $cache  = new Cache();
        $file   = new Filesystem();
        $cache->put($strOne, $strOne);
        $this->assertTrue($cache->delete($strOne));
        $this->assertNull($cache->get($strOne));
        $this->assertTrue($cache->delete('nothing'));

        $this->assertTrue($file->exists($path));
        $file->deleteDirectory($path);
        $this->assertFalse($file->exists($path));
    }

    /**
     * @throws \Exception
     */
    public function testFlush()
    {
        $path     = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
        $strOne   = 'test1';
        $strTwo   = 'test2';
        $strThree = 'test3';
        $strFour  = 'test4';
        $cache    = new Cache();
        $file     = new Filesystem();
        $date     = new \DateTime();
        $date->sub(new \DateInterval('PT10M'));
        $cache->forever($strOne, $strOne);
        $cache->put($strTwo, $strTwo, 10);

        $cache->put($strThree, $strThree, $date);
        $this->assertNull($cache->get($strThree));

        $cache->put($strFour, $strFour, 'now');

        $cache->flush();

        $this->assertFalse($file->exists($path));
    }

    public function testDateExcetion()
    {
        $this->expectException(\Exception::class);
        $strOne = 'test1';

        $cache = new Cache();
        $cache->put($strOne, $strOne, 'asdhadjksh');
    }
}
