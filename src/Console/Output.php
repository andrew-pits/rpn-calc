<?php

declare(strict_types = 1);

namespace AndrewPits\Calc\Console;

use AndrewPits\Calc\OutputInterface;

class Output implements OutputInterface
{
    /**
     * @inheritDoc
     */
    public function write(string $string): void
    {
        echo $string . PHP_EOL;
    }
}
