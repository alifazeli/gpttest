<?php

declare(strict_types=1);

namespace App\Models\Concerns;

trait SearchIndexable
{
    public function shouldBeSearchable(): bool
    {
        return true;
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->getKey(),
        ];
    }
}
