<?php

namespace AndrewPits\Calc;

interface OutputInterface
{
    /**
     * @param string $string
     *
     * @return void
     */
    public function write(string $string): void;
}
