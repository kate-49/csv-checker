<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require './src/csvChecker.php';
final class CsvCheckerTest extends TestCase
{
    private $csvChecker;

    protected function setUp(): void
    {
        $this->csvChecker = new CsvChecker();
    }

    protected function tearDown(): void
    {
        $this->csvChecker = NULL;
    }

    public function testRunThroughAllCvsToCollectData()
    {
        $result = $this->csvChecker->runThroughAllCvsToCollectData();
        var_dump($result[0]);
        $this->assertEquals(['Kate Smith', '48 Parkhill Road'], $result);
    }

}