<?php

declare(strict_types=1);

namespace modules\books\tests\unit;

use modules\books\forms\ReportForm;
use modules\books\services\ReportService;

class ReportTest extends TestCase
{


    public function testTop10()
    {
        $reportService = new ReportService();
        $reportForm = new ReportForm();
        $reportForm->release_year = 2024;

        $top = $reportService->top10($reportForm);
        $data = $top->getModels();
        $this->assertEquals(2, $data[0]['books']);
        $this->assertEquals(1, $data[1]['books']);


        $reportForm->release_year = 2022;
        $top = $reportService->top10($reportForm);
        $data = $top->getModels();
        $this->assertEmpty($data);
    }
}
