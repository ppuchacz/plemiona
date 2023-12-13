<?php

namespace App\Translator;

use App\Entity\Enum\BuildingType;

interface AppTranslatorInterface
{
    public function translateBuildingByType(BuildingType $type): string;
}
