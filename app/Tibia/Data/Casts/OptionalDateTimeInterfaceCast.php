<?php

namespace App\Tibia\Data\Casts;

use DateTimeInterface;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

// TODO: implement Spatie\LaravelData\Casts\IterableItemCast
readonly class OptionalDateTimeInterfaceCast implements Cast
{
    protected DateTimeInterfaceCast $innerCast;

    public function __construct(
        null|string|array $format = null,
        ?string $type = null,
        ?string $setTimeZone = null,
        ?string $timeZone = null
    ) {
        $this->innerCast = new DateTimeInterfaceCast($format, $type, $setTimeZone, $timeZone);
    }

    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): DateTimeInterface|Uncastable|null
    {
        if ($value === '') {
            return null;
        }

        return $this->innerCast->cast($property, $value, $properties, $context);
    }
}
