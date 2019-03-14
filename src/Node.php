<?php

namespace Yiranzai\File;

/**
 * Class Node
 * @package Yiranzai\Dht
 */
class Node
{
    /**
     * @var
     */
    public $data;
    /**
     * @var Node|null
     */
    public $next;
    /**
     * @var
     */
    public $key;

    /**
     * Node constructor.
     * @param string $key
     * @param string $data
     */
    public function __construct(string $key, string $data = null)
    {
        $this->key  = $key;
        $this->data = $data;
    }
}
