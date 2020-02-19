<?php

declare(strict_types = 1);

namespace AndrewPits\Calc\Operation;

class AdditionOperation extends Operation
{
    /**
     * @inheritdoc
     */
    protected function evaluateValues($firstOperand, $secondOperand)
    {
        return $firstOperand + $secondOperand;
    }

    /**
     * @inheritdoc
     */
    public function getSymbol(): string
    {
        return '+';
    }
}
