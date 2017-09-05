<?php

namespace Distil\Common;

use Distil\Criterion;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Exceptions\InvalidLimit;
use Distil\Keywords\Keyword;
use Distil\Keywords\HasKeywords;
use Distil\Keywords\Value;

final class Limit implements Criterion, HasKeywords
{
    const NAME = 'limit';

    const UNLIMITED = null;
    const KEYWORD_UNLIMITED = 'unlimited';
    const DEFAULT = 10;

    public function __construct(?int $value = self::DEFAULT)
    {
        if ($value === 0) {
            throw InvalidLimit::cannotBeZero();
        }

        $this->value = $value;
    }

    /**
     * @return static
     */
    public static function fromString(string $value): self
    {
        $value = (new Keyword(static::class, $value))->value();

        if ($value === null || is_numeric($value)) {
            return new static($value ? (int) $value : $value);
        }

        throw InvalidCriterionValue::expectedNumeric(static::class);
    }

    public function name(): string
    {
        return self::NAME;
    }

    public function value(): ?int
    {
        return $this->value;
    }

    public function isUnlimited(): bool
    {
        return $this->value() === self::UNLIMITED;
    }

    public static function keywords(): array
    {
        return [self::KEYWORD_UNLIMITED => self::UNLIMITED];
    }

    public function __toString(): string
    {
        return (new Value($this, $this->value))->keyword() ?: (string) $this->value;
    }
}
