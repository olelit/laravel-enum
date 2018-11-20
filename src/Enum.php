<?php

namespace MadWeb\Enum;

use MadWeb\Enum\Rules\EnumRule;
use MyCLabs\Enum\Enum as MyCLabsEnum;

abstract class Enum extends MyCLabsEnum
{
    /**
     * Default enum value.
     */
    const __default = null;

    /**
     * {@inheritdoc}
     */
    public function __construct($value = null)
    {
        if (is_null($value)) {
            $value = static::__default;
        }

        parent::__construct($value);
    }

    public static function randomKey(): string
    {
        $keys = self::keys();

        return $keys[array_rand($keys)];
    }

    public static function randomValue(): string
    {
        $values = self::values();

        return $values[array_rand($values)];
    }

    public function label(): string
    {
        return self::getLabel($this->getValue());
    }

    public static function labels(): array
    {
        $result = [];

        foreach (static::toArray() as $value) {
            $result[$value] = static::getLabel($value);
        }

        return $result;
    }

    private static function getLabel(string $value): string
    {
        $lang_key = sprintf(
            '%s.%s.%s',
            config('enum.lang_file_path'),
            static::class,
            $value
        );

        return trans()->has($lang_key) ? __($lang_key) : $value;
    }

    public function is($value)
    {
        return $this->getValue() === ($value instanceof self ? $value->getValue() : $value);
    }

    public static function toArray(bool $include_default = false): array
    {
        $result = parent::toArray();

        if (! $include_default) {
            unset($result['__default']);
        }

        return $result;
    }

    /**
     * Returns all consts (possible values) as an array according to `SplEnum` class.
     */
    public function getConstList(bool $include_default = false): array
    {
        return static::toArray($include_default);
    }

    /**
     * Returns the validation rule (to validate by value).
     *
     * @return EnumRule
     */
    public static function rule(): EnumRule
    {
        return new EnumRule(static::class, false);
    }

    /**
     * Returns the validation rule (to validate by key).
     *
     * @return EnumRule
     */
    public static function ruleByKey(): EnumRule
    {
        return new EnumRule(static::class, true);
    }
}
