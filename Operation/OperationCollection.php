<?php

declare(strict_types=1);

namespace AndrewPits\Calc\Operation;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class OperationCollection implements Countable, IteratorAggregate
{
    /**
     * @var array
     */
    private $elements = [];

    /**
     * OperationCollection constructor.
     *
     * @param OperationInterface ...$operations
     */
    public function __construct(OperationInterface ...$operations)
    {
        foreach ($operations as $operation) {
            $this->add($operation);
        }
    }

    /**
     * @param OperationInterface $operation
     */
    public function add(OperationInterface $operation): void
    {
        if (isset($this->elements[$operation->getSymbol()])) {
            throw new \InvalidArgumentException('Operations with duplicates symbols are not allowed in collection');
        }

        $this->elements[$operation->getSymbol()] = $operation;
    }

    /**
     * @param OperationInterface $operation
     */
    public function remove(OperationInterface $operation): void
    {
        if (isset($this->elements[$operation->getSymbol()])) {
            unset($this->elements[$operation->getSymbol()]);
        }
    }

    /**
     * @param string $symbol
     *
     * @return OperationInterface|null
     */
    public function get(string $symbol): ?OperationInterface
    {
        return $this->elements[$symbol] ?? null;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }
}
