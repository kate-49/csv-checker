<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require './src/csvChecker.php';
final class CsvCheckerTest extends TestCase
{
    private $calculator;

    protected function setUp(): void
    {
        $this->calculator = new CsvChecker();
    }

    protected function tearDown(): void
    {
        $this->calculator = NULL;
    }

    public function testAdd()
    {
        $result = $this->calculator->add(1, 2);
        $this->assertEquals(3, $result);
    }

}