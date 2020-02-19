<?php

declare(strict_types = 1);

namespace AndrewPits\Calc;

use AndrewPits\Calc\Exception\NotEnoughOperandsException;
use AndrewPits\Calc\Exception\UnsupportedOperationException;

interface CalculatorInterface
{
    /**
     * @param float|int|string $value
     *
     * @throws NotEnoughOperandsException
     * @throws UnsupportedOperationException
     *
     * @return float|int
     */
    public function process($value);

    /**
     * @param string $symbol
     *
     * @return bool
     */
    public function supportsOperator(string $symbol): bool;
}
