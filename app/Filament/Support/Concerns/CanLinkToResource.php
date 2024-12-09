<?php

namespace App\Filament\Support\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Model;

trait CanLinkToResource
{
    public function viewLink(Closure $linkRecord): static
    {
        return $this->url(function () use ($linkRecord): ?string {
            $linkRecord = $this->evaluate($linkRecord);
            if (! $linkRecord instanceof Model) {
                return null;
            }

            $resourceName = $linkRecord->getTable();

            return route(
                "filament.admin.resources.{$resourceName}.view",
                ['record' => $linkRecord]
            );
        });
    }
}
