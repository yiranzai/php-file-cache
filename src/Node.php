<?php

namespace Yiranzai\File;

use DateTime;

/**
 * Class Node
 * @package Yiranzai\Dht
 */
class Node
{
    /**
     * @var string
     */
    public $data;
    /**
     * @var Node|null
     */
    public $next;
    /**
     * @var string
     */
    public $key;
    /**
     * @var DateTime
     */
    protected $expiredAt;

    /**
     * Node constructor.
     * @param string   $key
     * @param string   $data
     * @param DateTime $expiredAt
     */
    public function __construct(string $key, string $data, DateTime $expiredAt = null)
    {
        $this->key       = $key;
        $this->data      = $data;
        $this->expiredAt = $expiredAt;
    }

    /**
     * @param null|string $default
     * @return string|null
     * @throws \Exception
     */
    public function getData($default = null): ?string
    {
        if ($this->isExpired()) {
            return $default;
        }
        return $this->data;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isExpired(): bool
    {
        if ($this->expiredAt === null) {
            return false;
        }
        return $this->expiredAt < new DateTime();
    }
}
