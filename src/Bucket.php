<?php

namespace Yiranzai\File;

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
     * @param $key
     * @param $data
     */
    public function __construct(string $key, string $data = null)
    {
        $this->head = new Node($key, $data);
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
     * @param string $key
     * @param string $data
     * @return Bucket
     */
    public function addNode(string $key, string $data = null): Bucket
    {
        $cur = $this->head;
        while ($cur->next !== null) {
            $cur = $cur->next;
        }
        $new       = new Node($key, $data);
        $cur->next = $new;
        return $this;
    }

    /**
     * 增加节点
     *
     * @param string $key
     * @param string $data
     * @return Bucket
     */
    public function putNode(string $key, string $data = null): Bucket
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
        $new       = new Node($key, $data);
        $cur->next = $new;
        return $this;
    }

    /**
     * 紧接着插在$noNum后
     *
     * @param string $k
     * @param string $index
     * @param string $data
     * @return Bucket
     */
    public function insertNode(string $k, string $index, string $data = null): Bucket
    {
        $cur = $this->head;
        $new = new Node($k, $data);
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
        if ($cur->next !== null) {
            if ($cur->key === $key) {
                $this->head = $cur->next;
            } else {
                while ($cur->next !== null) {
                    if ($cur->next->key === $key) {
                        $cur->next = $cur->next->next;
                        break;
                    }
                    $cur = $cur->next;
                }
            }
        }
        return $this;
    }

    /**
     * 遍历链表
     *
     * @return Bucket
     */
    public function showNode(): Bucket
    {
        $cur = $this->head;
        while ($cur->next !== null) {
            $cur = $cur->next;
            echo $cur->data . PHP_EOL;
        }
        return $this;
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
     * 寻找某节点的值
     *
     * @param string $key
     * @return string|null
     */
    public function find(string $key): ?string
    {
        $node = $this->findNode($key);
        return $node === null ? null : $node->data;
    }
}
