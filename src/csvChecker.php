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
            $fileObject = new CV();
            $fileObject->setFilename($filename);
            $noteablePhases = [];

            $file = $this->dir . '/' . $filename;
            $fileAsArray = explode("\n", file_get_contents($file));

            foreach($fileAsArray as $Row) {
                $rowAsSentence = explode(".", $Row);
                foreach($rowAsSentence as $sentence) {
                    $nr = str_getcsv($sentence, ".");
                    if (!empty($nr[0])) {
                        $noteablePhases[] = $nr[0];
                    }
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
            $subArray = [];
            foreach($cv->getContent() AS $content) {
                if (str_contains($content, $phaseToFind)) {
                    $subArray[] = $content;
                }
            };
            $stringThatIsFound[$cv->getFilename()] = $subArray;
        }

        return $stringThatIsFound;
    }

    public function identifyDuplicatePhrases(string $phaseToFind): array
    {
        $stringThatIsFound = [];
        foreach($this->cvCollection AS $cv) {
            $subArray = [];
            foreach($cv->getContent() AS $content) {
                if (str_contains($content, $phaseToFind)) {
                    $subArray[] = $content;
                }
            };
            $stringThatIsFound[$cv->getFilename()] = $subArray;
        }

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