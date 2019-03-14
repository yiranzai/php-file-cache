<?php

namespace Yiranzai\File;

use DateTime;

/**
 * Class Bucket
 * @package Yiranzai\Dht
 */
class Bucket
{
    /**
     * @var Node
     */
    protected $head;

    /**
     * Bucket constructor.
     * @param string        $key
     * @param string        $data
     * @param DateTime|null $date
     */
    public function __construct(string $key, string $data = null, DateTime $date = null)
    {
        $this->head = new Node($key, $data, $date);
    }

    /**
     * 链表有几个元素
     *
     * @return int
     */
    public function countNode(): int
    {
        $cur = $this->head;
        $i   = 1;
        while ($cur->next !== null) {
            ++$i;
            $cur = $cur->next;
        }
        return $i;
    }

    /**
     * 增加节点
     *
     * @param string        $key
     * @param string        $data
     * @param DateTime|null $date
     * @return Bucket
     */
    public function addNode(string $key, string $data = null, DateTime $date = null): Bucket
    {
        $cur = $this->head;
        while ($cur->next !== null) {
            $cur = $cur->next;
        }
        $new       = new Node($key, $data, $date);
        $cur->next = $new;
        return $this;
    }

    /**
     * 增加节点
     *
     * @param string        $key
     * @param string        $data
     * @param DateTime|null $date
     * @return Bucket
     */
    public function putNode(string $key, string $data = null, DateTime $date = null): Bucket
    {
        $cur = $this->head;
        if ($cur->key === $key) {
            $cur->data = $data;
            return $this;
        }
        while ($cur->next !== null) {
            $cur = $cur->next;
            if ($cur->key === $key) {
                $cur->data = $data;
                return $this;
            }
        }
        $new       = new Node($key, $data, $date);
        $cur->next = $new;
        return $this;
    }

    /**
     * 紧接着插在$noNum后
     *
     * @param string        $k
     * @param string        $index
     * @param string        $data
     * @param DateTime|null $date
     * @return Bucket
     */
    public function insertNode(string $k, string $index, string $data = null, DateTime $date = null): Bucket
    {
        $cur = $this->head;
        $new = new Node($k, $data, $date);
        if ($cur->key !== $index) {
            while ($cur->next !== null) {
                $cur = $cur->next;
                if ($cur->key === $index) {
                    break;
                }
            }
        }
        $new->next = $cur->next;
        $cur->next = $new;
        return $this;
    }

    /**
     * 删除第$no个节点
     *
     * @param string $key
     * @return Bucket
     */
    public function delNode(string $key): Bucket
    {
        $cur = $this->head;
        if ($cur->key === $key) {
            $this->head = $cur->next;
        }
        while ($cur->next !== null) {
            if ($cur->next->key === $key) {
                $cur->next = $cur->next->next;
                break;
            }
            $cur = $cur->next;
        }
        return $this;
    }

    /**
     * 遍历链表
     *
     * @return Bucket
     * @throws \Exception
     */
    public function showNode(): Bucket
    {
        $cur = $this->head;
        while ($cur->next !== null) {
            $cur = $cur->next;
            echo $cur->getData() . PHP_EOL;
        }
        return $this;
    }

    /**
     * 寻找某节点的值
     *
     * @param string $key
     * @return string|null
     * @throws \Exception
     */
    public function find(string $key): ?string
    {
        $node = $this->findNode($key);
        return $node === null ? null : $node->getData();
    }

    /**
     * 寻找节点
     *
     * @param string $key
     * @return Node|null
     */
    public function findNode(string $key): ?Node
    {
        $cur = $this->head;
        if ($cur->key === $key) {
            return $cur;
        }
        while ($cur->next !== null) {
            $cur = $cur->next;
            if ($cur->key === $key) {
                return $cur;
            }
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->head === null;
    }
}
