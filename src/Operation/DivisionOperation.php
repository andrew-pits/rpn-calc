<?php

declare(strict_types = 1);

namespace AndrewPits\Calc\Operation;

use DivisionByZeroError;

class DivisionOperation extends Operation
{
    /**
     * @inheritdoc
     */
    protected function evaluateValues($firstOperand, $secondOperand)
    {
        if ($secondOperand == 0) {
            throw new DivisionByZeroError('Can not divide by zero');
        }

        return $firstOperand / $secondOperand;
    }

    /**
     * @inheritdoc
     */
    public function getSymbol(): string
    {
        return '/';
    }
}
