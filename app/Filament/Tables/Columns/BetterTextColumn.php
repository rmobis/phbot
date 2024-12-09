<?php

namespace App\Filament\Tables\Columns;

use App\Filament\Support\Concerns\CanBeMain;
use App\Filament\Support\Concerns\CanLinkToResource;
use Filament\Tables\Columns\TextColumn;

class BetterTextColumn extends TextColumn
{
    use CanBeMain;
    use CanLinkToResource;

    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            'parent' => [$this->getTable()->getRelationship()->getParent()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }
}
