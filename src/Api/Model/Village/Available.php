<?php

namespace App\Api\Model\Village;

class Available
{
    public function __construct(
        public string $name,
        public string $type
    )
    {
    }
}