<?php

namespace App\Filament\Tables\Actions;

use Filament\Tables\Actions\Action;

class BetterAction extends Action
{
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            'parent' => [$this->getTable()->getRelationship()->getParent()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }
}
