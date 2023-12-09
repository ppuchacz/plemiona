<?php

namespace App\Api\Model\Village;

class Building
{
    public function __construct(
        public int $id,
        public string $name,
        public string $type,
        public int $level
    )
    {
    }
}