<?php

declare(strict_types=1);

namespace Tests\Operation;

use AndrewPits\Calc\Operation\AdditionOperation;
use PHPUnit\Framework\TestCase;

class AdditionOperationTest extends TestCase
{
    /**
     * @var AdditionOperation
     */
    private $operation;

    public function setUp()
    {
        $this->operation = new AdditionOperation();
    }

    /**
     * @dataProvider operandsProvider
     */
    public function testItEvaluates($a, $b, $result)
    {
        $this->assertEquals($result, $this->operation->evaluate($a, $b));
    }

    public function testItGivesSymbol()
    {
        $this->assertEquals('+', $this->operation->getSymbol());
    }

    public function operandsProvider()
    {
        return [
            [2, 2, 2 + 2],
            [3.33, 2, 3.33 + 2],
            [133, 13.04, 133 + 13.04]
        ];
    }
}
