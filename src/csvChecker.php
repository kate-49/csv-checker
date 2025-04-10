<?php declare(strict_types=1);

final class CsvChecker
{
    /* @var []string */
    private array $fileNames;
    private string $dir;

    public function __construct()
    {
        $this->fileNames = [];
        $this->dir = './src/csvsToCheck';
        $fileNames = scandir($this->dir);
        foreach($fileNames as $fileName) {
            if (strlen($fileName) > 3) {
                $this->fileNames[] = $fileName;
            }
        }
        $this->cvCollection = [];
    }

    public function runThroughAllCvsToCollectData(): array
    {
        foreach($this->fileNames AS $filename) {
            var_dump("filename");
            var_dump($filename);
            $fileObject = new CV($filename);
            $noteablePhases = [];

            $file = $this->dir . '/' . $filename;
            $fileAsArray = explode("\n", file_get_contents($file));

            foreach($fileAsArray as $Row) {
                $Row = str_getcsv($Row, ";");
                if (!empty($Row[0])) {
                    $noteablePhases[] = $Row[0];
                }
            }

            $fileObject->setContent($noteablePhases);
            $this->cvCollection[] = $fileObject;
        };
        return $this->cvCollection;
    }

    public function searchForPhase(string $phaseToFind): array
    {
        $stringThatIsFound = [];
        foreach($this->cvCollection AS $cv) {
            foreach($cv->getContent() AS $content) {
                if (str_contains($content, $phaseToFind)) {
                    $stringThatIsFound[$cv->getFilename()] = $content;
                }
            };
        }

        var_dump($stringThatIsFound);
        return $stringThatIsFound;
    }

}

class CV {
    public $fileName;
    public array $content;

    function setFilename($filename) {
        $this->fileName = $filename;
    }

    function newCV($filename, $content) {
        $this->fileName = $filename;
        $this->content = $content;
        return $this;
    }

    function setContent(array $content) {
        $this->content = $content;
    }

    function getContent() {
        return $this->content;
    }

    function getFilename() {
        return $this->fileName;
    }
}