<?php

declare(strict_types=1);

namespace Yiranzai\File\Tests;

use PHPUnit\Framework\TestCase;
use Yiranzai\File\Bucket;

class BucketTest extends TestCase
{
    public function testBucket()
    {
        $strOne   = 'test1';
        $strTwo   = 'test2';
        $strThree = 'test3';
        $strFour  = 'test4';
        $strFive  = 'test5';
        $bucket   = new Bucket($strOne, $strOne);
        $bucket->putNode($strTwo, $strTwo);
        $this->assertSame(2, $bucket->countNode());
        $this->assertSame($strTwo, $bucket->findNode($strTwo)->data);
        $this->assertSame($strOne, $bucket->findNode($strOne)->data);
        $bucket->putNode($strOne, $strTwo);
        $this->assertSame($strTwo, $bucket->findNode($strOne)->data);
        $bucket->putNode($strTwo, $strOne);
        $this->assertSame($strOne, $bucket->findNode($strTwo)->data);
        $this->assertNull($bucket->findNode('nothing'));
        $bucket->putNode($strOne, $strOne);
        $bucket->putNode($strTwo, $strTwo);
        $bucket->addNode($strThree, $strThree);
        $bucket->addNode($strFive, $strFive);
        $bucket->insertNode($strFour, $strThree, $strFour);
        $bucket->showNode();
        $this->assertSame($bucket->findNode($strFour)->next->data, $bucket->find($strFive));
        $bucket->delNode($strFour);
        $this->assertNull($bucket->findNode($strFour));
        $bucket->delNode($strOne);
        $this->assertNull($bucket->findNode($strOne));
    }
}
