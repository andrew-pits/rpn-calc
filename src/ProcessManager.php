<?php

declare(strict_types = 1);

namespace AndrewPits\Calc;

use AndrewPits\Calc\Exception\NotEnoughOperandsException;
use DivisionByZeroError;
use Exception;

class ProcessManager
{
    const QUIT_COMMAND = 'q';

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

    public function __construct(InputInterface $input, OutputInterface $output, CalculatorInterface $calculator)
    {
        $this->input = $input;
        $this->output = $output;
        $this->calculator = $calculator;
    }

    /**
     * @return void
     */
    public function start(): void
    {
        while (true) {
            $value = $this->input->read();

            if ($value === InputInterface::END_OF_INPUT || $value === self::QUIT_COMMAND) {
                $this->output->write('Bye');

                return;
            }

            if (!is_numeric($value) && !$this->calculator->supportsOperator($value)) {
                $this->output->write(sprintf('Value "%s" is not supported, try numeric value or operation symbol:', $value));
                continue;
            }

            try {
                $result = $this->calculator->process($value);
            } catch (NotEnoughOperandsException $e) {
                $this->output->write('At least two operands are required for operation, try adding more:');
                continue;
            } catch (DivisionByZeroError $e) {
                $this->output->write('Can not divide by zero, try another operation:');
                continue;
            } catch (Exception $e) {
                $this->output->write('Something went wrong');
                // Here we would log the error in real project
                return;
            }
            $this->output->write((string) $result);
        }
    }
}
