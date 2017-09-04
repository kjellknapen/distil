<?php

namespace BeatSwitch\Distil\Criteria\Common;

use BeatSwitch\Distil\Criteria\Types\ListCriterion;

final class Sort extends ListCriterion
{
    const NAME = 'sort';

    public function __construct(string ...$values)
    {
        parent::__construct(...$values);
    }

    public function name(): string
    {
        return self::NAME;
    }

    /**
     * @return SortField[]
     */
    public function sortFields(): array
    {
        return array_map(SortField::class.'::fromString', $this->value());
    }
}
