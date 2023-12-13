<?php

namespace App\Translator;

use App\Entity\Enum\BuildingType;
use Symfony\Contracts\Translation\TranslatorInterface;

class AppTranslator implements AppTranslatorInterface, TranslatorInterface
{
    const DOMAIN = 'app';
    const BUILDINGS_PREFIX = 'building.';

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function translateBuildingByType(BuildingType $type): string
    {
        return $this->trans(self::BUILDINGS_PREFIX . $type->value);
    }

    public function trans(string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        return $this->translator->trans($id, $parameters, self::DOMAIN, $locale);
    }

    public function getLocale(): string
    {
        return $this->translator->getLocale();
    }
}
