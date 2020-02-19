<?php

namespace Tests;

use AndrewPits\Calc\Exception\NotEnoughOperandsException;
use AndrewPits\Calc\Exception\UnsupportedOperationException;
use AndrewPits\Calc\Operation\OperationCollection;
use AndrewPits\Calc\Operation\OperationInterface;
use AndrewPits\Calc\RPNCalculator;
use PHPUnit\Framework\TestCase;
use stdClass;
use InvalidArgumentException;

class RPNCalculatorTest extends TestCase
{
    const TEST_OPERATOR_SYMBOL = '-';
    /**
     * @var RPNCalculator
     */
    private $calculator;

    /**
     * @var OperationCollection
     */
    private $collection;

    /**
     * @var OperationInterface
     */
    private $operation;

    public function setUp(): void
    {
        $this->collection = $this->createMock(OperationCollection::class);
        $this->operation = $this->createMock(OperationInterface::class);

        $this->calculator = new RPNCalculator($this->collection);
    }

    public function testItProcesses()
    {
        $this->collection->method('get')->with(self::TEST_OPERATOR_SYMBOL)->willReturn($this->operation);
        $this->operation->method('evaluate')->willReturnCallback(function ($a, $b) {
            return $a - $b;
        });

        $this->assertEquals(6, $this->calculator->process(6));
        $this->assertEquals(4, $this->calculator->process(4));
        $this->assertEquals(2, $this->calculator->process(self::TEST_OPERATOR_SYMBOL));
    }

    /**
     * @dataProvider invalidArgumentsProvider
     */
    public function testItDoesNotProcessWithWrongArguments($argument)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->process($argument);
    }

    public function testItProcessesMoreThanTwoOperandsSimultaneously()
    {
        $this->collection->method('get')->with(self::TEST_OPERATOR_SYMBOL)->willReturn($this->operation);
        $this->operation->method('evaluate')->willReturnCallback(function ($a, $b) {
            return $a - $b;
        });

        $this->assertEquals('6', $this->calculator->process(6));
        $this->assertEquals('4', $this->calculator->process(4));
        $this->assertEquals('2', $this->calculator->process(2));
        $this->assertEquals('2', $this->calculator->process(self::TEST_OPERATOR_SYMBOL));
        $this->assertEquals('4', $this->calculator->process(self::TEST_OPERATOR_SYMBOL));
    }

    public function testItSupportsOperation()
    {
        $this->collection->method('get')->with('|')->willReturn($this->operation);
        $this->assertTrue($this->calculator->supportsOperator('|'));
    }

    public function testItDoesNotSupportOperation()
    {
        $this->collection->method('get')->with('|')->willReturn(null);
        $this->assertFalse($this->calculator->supportsOperator('|'));
    }

    public function testItDoesNotProcessWithUnsupportedOperation()
    {
        $this->expectException(UnsupportedOperationException::class);
        $this->collection->method('get')->with('|')->willReturn(null);
        $this->calculator->process($this->calculator->process('|'));
    }

    public function testItDoesNotProcessWithLessThanTwoOperands()
    {
        $this->collection->method('get')->with(self::TEST_OPERATOR_SYMBOL)->willReturn($this->operation);
        $this->operation->method('evaluate')->willReturnCallback(function ($a, $b) {
            return $a - $b;
        });

        $this->expectException(NotEnoughOperandsException::class);
        $this->calculator->process(self::TEST_OPERATOR_SYMBOL);
    }

    public function invalidArgumentsProvider()
    {
        return [
            [[]],
            [new stdClass()],
            [true]
        ];
    }
}
