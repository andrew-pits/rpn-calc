<?php

declare(strict_types = 1);

namespace AndrewPits\Calc\Console;

use AndrewPits\Calc\InputInterface;

class Input implements InputInterface
{
    /**
     * @inheritDoc
     */
    public function read(): string
    {
        $input = readline('> ');
        if ($input === false) { // Ctrl + D
            return InputInterface::END_OF_INPUT;
        }

        return $input;
    }
}
