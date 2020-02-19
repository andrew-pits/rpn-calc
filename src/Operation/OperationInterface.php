<?php

declare(strict_types = 1);

namespace AndrewPits\Calc\Operation;

interface OperationInterface
{
    /**
     * @param int|float $firstOperand
     * @param int|float $secondOperand
     *
     * @return int|float
     */
    public function evaluate($firstOperand, $secondOperand);

    /**
     * @return string
     */
    public function getSymbol(): string;
}
