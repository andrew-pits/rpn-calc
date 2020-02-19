<?php

declare(strict_types = 1);

namespace AndrewPits\Calc\Operation;

class SubtractionOperation extends Operation
{
    /**
     * @inheritdoc
     */
    protected function evaluateValues($firstOperand, $secondOperand)
    {
        return $firstOperand - $secondOperand;
    }

    /**
     * @inheritdoc
     */
    public function getSymbol(): string
    {
        return '-';
    }
}
