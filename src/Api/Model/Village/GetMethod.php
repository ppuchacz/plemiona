<?php

namespace App\Api\Model\Village;

class GetMethod
{
    /**
     * @param Building[] $buildings
     * @param Available[] $available
     */
    public function __construct(
        public array $buildings = [],
        public array $available = []
    ) {}
}