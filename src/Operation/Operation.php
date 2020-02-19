<?php

declare(strict_types = 1);

namespace AndrewPits\Calc\Operation;

use InvalidArgumentException;

abstract class Operation implements OperationInterface
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function evaluate($firstOperand, $secondOperand)
    {
        $this->validateOperands($firstOperand, $secondOperand);
        return $this->evaluateValues($firstOperand, $secondOperand);
    }

    /**
     * @return string
     */
    abstract public function getSymbol(): string;

    /**
     * @param $firstOperand
     * @param $secondOperand
     *
     * @return int|float
     */
    abstract protected function evaluateValues($firstOperand, $secondOperand);

    /**
     * @param $firstOperand
     * @param $secondOperand
     *
     * @throws InvalidArgumentException
     */
    protected function validateOperands($firstOperand, $secondOperand)
    {
        if (!is_numeric($firstOperand) || !is_numeric($secondOperand)) {
            throw new InvalidArgumentException('Operands should be numeric');
        }
    }
}
