<?php

namespace App\Services\Zone\Contracts;

interface ZoneCacheTagsServiceContract
{
    /**
     * @return string[]
     */
    public function getCacheTags(): array;
}
