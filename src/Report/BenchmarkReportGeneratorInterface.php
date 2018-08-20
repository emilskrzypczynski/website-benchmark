<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Report;


use App\Model\BenchmarkInterface;

interface BenchmarkReportGeneratorInterface
{
    /**
     * @param BenchmarkInterface $benchmark
     * @return BenchmarkReportGeneratorInterface
     */
    public function create(BenchmarkInterface $benchmark): BenchmarkReportGeneratorInterface;
}