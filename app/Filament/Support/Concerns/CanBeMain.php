<?php

namespace App\Filament\Support\Concerns;

use Closure;

trait CanBeMain
{
    public function isMain(Closure $isMain): static
    {
        return $this->iconColor('primary')
            ->icons(['heroicon-s-star' => fn () => $this->evaluate($isMain)]);
    }
}
