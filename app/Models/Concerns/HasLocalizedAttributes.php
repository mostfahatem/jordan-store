<?php

namespace App\Models\Concerns;

trait HasLocalizedAttributes
{
    /**
     * Get the value of a bilingual column (e.g. name_ar / name_en) for the active locale.
     */
    public function localized(string $field): ?string
    {
        $locale = app()->getLocale();

        return $this->getAttribute("{$field}_{$locale}") ?? $this->getAttribute("{$field}_ar");
    }
}
