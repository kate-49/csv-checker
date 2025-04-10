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
        $expectedCV1 = (new CV)->newCV(
            'Another_cv.txt',
            [
                'Kate Smith',
                'Email: cv2@gmail',
                'com /  Phone: 321654987 / Github: Kate-1123',
                '	Skills:',
                '	Background:',
                'Working as a full stack developer in a multidisciplinary agile team',
                ' Building user-centered RESTful web systems',
                ' Working closely with other developers and Webops staff to write code and resolve live issues',
                ' Working with designers, user researchers and product managers to ensure high-quality user-centered code is delivered',
                'Notable work:',
                '* Generating a scheduled multipage spreadsheet for users in PHP and sending this to relevant parties using the Notify API',
                ' This involved creating a scheduled AWS task to generate the reports, using a custom database query to identify which individuals needed a report',
                ' ',
                'It also involved creating a secondary AWS task to publish the reports',
                ' The reports were written in SQL and then generated by PHP, and sent to an internal microservice written to talk to Notify',
                ' From here I worked to amend the microservice to send the report to the third party Notify API and therefore the public',
                '* Identifying  timeouts within the live service and moving some user-generated reports to a read only api endpoint',
                ' This optimised database capacity and improved performance for other users without adding additional business costs',
                '* Creating a header  used across multiple microservices',
                '* Prototyping a new microservice',
                ' Refining user for this  Ensuring this was accessible through Wave testing; improved based on user feedback',
                '* Handling document upload to a new microservice',
                '* Creating automated/ scheduled letters and  for case managers to highlight when cases require work, tasks were created on the system while letters were sent via the Notify Api to the public',
                '* Creating permissions so staff can delete , with a failsafe days to prevent errors'
            ]
        );
        $expectedCV2 = (new CV)->newCV(
            'test_cv.txt',
            [
                'Kate Smith',
                'Email: testemail@gmail',
                'com /  Phone: 123456789 / Github: Kate-9952',
                '	Skills:',
                '	Background:',
                'Working as a full stack developer in a multidisciplinary agile team',
                ' Building user-centered RESTful web systems',
                ' Working closely with other developers and Webops staff to write code and resolve live issues',
                ' Working with designers, user researchers and product managers to ensure high-quality user-centered code is delivered',
                'Notable work:',
                '* Generating a scheduled multipage spreadsheet for users in PHP and sending this to relevant parties using the Notify API',
                ' This involved creating a scheduled AWS task to generate the reports, using a custom database query to identify which individuals needed a report',
                ' ',
                'It also involved creating a secondary AWS task to publish the reports',
                ' The reports were written in SQL and then generated by PHP, and sent to an internal microservice written to talk to Notify',
                ' From here I worked to amend the microservice to send the report to the third party Notify API and therefore the public',
                '* Identifying excessive timeouts within the live service and moving some user-generated reports to a read only api endpoint',
                ' This optimised database capacity and improved performance for other users without adding additional business costs',
                ' ',
                '* Creating a header component used across multiple microservices',
                '* Prototyping a new microservice',
                ' Refining user requirements for this service',
                ' Ensuring this was accessible through Wave testing; improved based on user feedback',
                '* Handling document upload to a new microservice',
                '* Creating automated/ scheduled letters and tasks for case managers to highlight when cases require work, tasks were created on the system while letters were sent via the Notify Api to the public',
                '* Creating permissions so staff can delete documents, with a failsafe of 30 days to prevent errors',
            ]
        );
        $this->assertEquals(
            [
                $expectedCV1,
                $expectedCV2
            ], $result
        );
    }

    public function testSearchForPhase()
    {
        $this->csvChecker->runThroughAllCvsToCollectData();
        $result = $this->csvChecker->searchForPhase("PHP");
        $this->assertEquals(
            [
                'Another_cv.txt' => [
                    '* Generating a scheduled multipage spreadsheet for users in PHP and sending this to relevant parties using the Notify API',
                    ' The reports were written in SQL and then generated by PHP, and sent to an internal microservice written to talk to Notify'
                ],
                'test_cv.txt' => [
                    '* Generating a scheduled multipage spreadsheet for users in PHP and sending this to relevant parties using the Notify API',
                    ' The reports were written in SQL and then generated by PHP, and sent to an internal microservice written to talk to Notify'
                ],
            ],
            $result
        );
    }

    public function testSearchForLongerPhase()
    {
        $this->csvChecker->runThroughAllCvsToCollectData();
        $result = $this->csvChecker->searchForPhase("Generating a scheduled multipage spreadsheet");
        $this->assertEquals(
            [
                'Another_cv.txt' => [
                    '* Generating a scheduled multipage spreadsheet for users in PHP and sending this to relevant parties using the Notify API',
                ],
                'test_cv.txt' => [
                    '* Generating a scheduled multipage spreadsheet for users in PHP and sending this to relevant parties using the Notify API',
                ],
            ],
            $result
        );
    }
}