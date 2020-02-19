<?php

require_once 'vendor/autoload.php';

$processManager = new \AndrewPits\Calc\ProcessManager(
    new \AndrewPits\Calc\Console\Input(),
    new \AndrewPits\Calc\Console\Output(),
    new \AndrewPits\Calc\RPNCalculator(
        new \AndrewPits\Calc\Operation\OperationCollection(
            new \AndrewPits\Calc\Operation\SubtractionOperation(),
            new \AndrewPits\Calc\Operation\AdditionOperation(),
            new \AndrewPits\Calc\Operation\DivisionOperation(),
            new \AndrewPits\Calc\Operation\MultiplicationOperation()
        )
    )
);

$processManager->run();
