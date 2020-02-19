<?php

declare(strict_types=1);

namespace Tests;

use AndrewPits\Calc\CalculatorInterface;
use AndrewPits\Calc\ProcessManager;
use AndrewPits\Calc\Exception\NotEnoughOperandsException;
use AndrewPits\Calc\InputInterface;
use AndrewPits\Calc\OutputInterface;
use PHPUnit\Framework\TestCase;

class ProcessManagerTest extends TestCase
{
    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var CalculatorInterface
     */
    private $calculator;

    /**
     * @var ProcessManager
     */
    private $processManager;

    public function setUp()
    {
        $this->input = $this->createMock(InputInterface::class);
        $this->output = $this->createMock(OutputInterface::class);
        $this->calculator = $this->createMock(CalculatorInterface::class);

        $this->processManager = new ProcessManager($this->input, $this->output, $this->calculator);
    }

    public function testItHandlesDivisionByZero()
    {
        $this->calculator->method('process')->will($this->throwException(new \DivisionByZeroError()));
        $this->input->expects($this->at(0))->method('read')->willReturn('0');

        $this->input->expects($this->at(1))->method('read')->willReturn(
            InputInterface::END_OF_INPUT
        ); // so it will be closed

        $this->output->expects($this->at(0))->method('write')->willReturn(
            'Can not divide by zero, try another operation:'
        );
        $this->processManager->run();
    }

    public function testItHandlesNotEnoughOperands()
    {
        $this->calculator->method('process')->will($this->throwException(new NotEnoughOperandsException()));
        $this->input->expects($this->at(0))->method('read')->willReturn('0');

        $this->input->expects($this->at(1))->method('read')->willReturn(
            InputInterface::END_OF_INPUT
        ); // so it will be closed

        $this->output->expects($this->at(0))->method('write')->willReturn(
            'At least two operands are required for operation, try adding more:'
        );
        $this->processManager->run();
    }

    public function testItHandlesException()
    {
        $this->calculator->method('process')->will($this->throwException(new \Exception()));
        $this->input->expects($this->at(0))->method('read')->willReturn('0');

        $this->output->expects($this->at(0))->method('write')->willReturn('Something went wrong');
        $this->processManager->run();
    }

    public function testItRejectsNotNumericValuesAndNotSupportedOperations()
    {
        $this->input->expects($this->at(0))->method('read')->willReturn('not_numeric');

        $this->input->expects($this->at(1))->method('read')->willReturn(
            InputInterface::END_OF_INPUT
        ); // so it will be closed

        $this->output->expects($this->at(0))->method('write')->willReturn(
            'Value "not_numeric" is not supported, try numeric value or operation symbol:'
        );
        $this->processManager->run();
    }

    public function testItAcceptsSupportedOperations()
    {
        $this->input->expects($this->at(0))->method('read')->willReturn('not_numeric');

        $this->calculator->expects($this->once())->method('process')->with('not_numeric')->willReturn(23);
        $this->calculator->method('supportsOperator')->with('not_numeric')->willReturn(true);

        $this->input->expects($this->at(1))->method('read')->willReturn(
            InputInterface::END_OF_INPUT
        ); // so it will be closed

        $this->output->expects($this->at(0))->method('write')->willReturn(
            '23'
        );

        $this->processManager->run();
    }

    public function testItAcceptsNumericValues()
    {
        $this->input->expects($this->at(0))->method('read')->willReturn('2');
        $this->calculator->expects($this->once())->method('process')->with('2')->willReturn(2);

        $this->input->expects($this->at(1))->method('read')->willReturn(
            InputInterface::END_OF_INPUT
        ); // so it will be closed

        $this->output->expects($this->at(0))->method('write')->willReturn(
            '2'
        );

        $this->processManager->run();
    }
}
