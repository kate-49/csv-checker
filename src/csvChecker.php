<?php declare(strict_types=1);


final class CsvChecker
{
    /* @var []string */
    private array $fileNames;
    private string $dir;

    public function __construct()
    {
        $this->dir = './src/csvsToCheck';
        $fileNames = scandir($this->dir);
        if ($fileNames) {
            $this->fileNames = $fileNames;
        }
        $this->noteablePhases = [];
    }

    public function runThroughAllCvsToCollectData(): array
    {
        foreach($this->fileNames AS $filename) {

            $file = $this->dir . '/' . $filename;
            $file2 = file_get_contents($file);
            $fileAsArray = explode("\n", $file2);
            foreach($fileAsArray as $Row) {
                $Row = str_getcsv($Row, ";");
                if (!empty($Row[0])) {
                    var_dump("row");
                    var_dump($Row);
                    $this->noteablePhases[] = $Row[0];
                }
            }
        };
        var_dump($this->noteablePhases);
        return $this->noteablePhases;
    }

}