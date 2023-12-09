<?php

namespace App\Api\Model\Village;

class GetMethod
{
    /**
     * @param Building[] $buildings
     */
    public function __construct(
        public array $buildings = []
    ) {}
}