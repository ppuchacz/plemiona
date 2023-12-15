<?php

namespace App\Api\Model\Resource;

class Resource
{
    public function __construct(
        public string $type,
        public int $amount
    ) {}
}
