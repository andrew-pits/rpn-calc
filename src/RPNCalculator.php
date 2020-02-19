<?php

declare(strict_types = 1);

namespace AndrewPits\Calc;

use AndrewPits\Calc\Exception\NotEnoughOperandsException;
use AndrewPits\Calc\Exception\UnsupportedOperationException;
use AndrewPits\Calc\Operation\OperationCollection;
use SplStack;
use InvalidArgumentException;

class RPNCalculator implements CalculatorInterface
{
    /**
     * @var SplStack;
     */
    private $stack;

    /**
     * @var OperationCollection
     */
    private $operationCollection;

    /**
     * Calculator constructor.
     *
     * @param OperationCollection $operationCollection
     */
    public function __construct(OperationCollection $operationCollection)
    {
        $this->stack = new SplStack();
        $this->stack->push(0);
        $this->operationCollection = $operationCollection;
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException
     */
    public function process($value)
    {
        if (!is_numeric($value) && !is_string($value)) {
            throw new InvalidArgumentException('Value should be numeric for operand or string for operation');
        }

        if (is_numeric($value)) {
            $this->stack->push((float) $value);

            return $this->stack->top();
        }

        $operator = $this->operationCollection->get($value);

        if (!$operator) {
            throw new UnsupportedOperationException(sprintf('Operator %s is not supported', $operator));
        }

        if ($this->stack->count() < 2) {
            throw new NotEnoughOperandsException('At least two operands should be provided before executing operation');
        }

        $secondOperand = $this->stack->pop();
        $firstOperand = $this->stack->pop();
        $this->stack->push($operator->evaluate($firstOperand, $secondOperand));

        return $this->stack->top();
    }

    /**
     * @inheritdoc
     */
    public function supportsOperator(string $symbol): bool
    {
        return $this->operationCollection->get($symbol) !== null;
    }
}
