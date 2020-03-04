<?php

namespace MadWeb\Enum;

/**
 * @mixin \MadWeb\Enum\Enum
 * @internal Uses for custom casting implementation
 */
trait EnumCastable
{
    public function get($model, string $key, $value, array $attributes)
    {
        return new static($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof static) {
            return $value->getValue();
        }

        return (new static($value))->getValue();
    }
}
