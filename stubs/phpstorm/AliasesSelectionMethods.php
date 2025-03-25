<?php

namespace Nesk\Puphpeteer\Traits;

use Nesk\Puphpeteer\Resources\ElementHandle;

trait AliasesSelectionMethods
{
    /**
     * @return ?ElementHandle
     */
    public function querySelector(...$arguments): void {}

    /**
     * @return ElementHandle[]
     */
    public function querySelectorAll(...$arguments): void {}
}
