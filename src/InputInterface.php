<?php

namespace AndrewPits\Calc;

interface InputInterface
{
    CONST END_OF_INPUT = 'END_OF_INPUT';

    /**
     * @return string
     */
    public function read(): string;
}
