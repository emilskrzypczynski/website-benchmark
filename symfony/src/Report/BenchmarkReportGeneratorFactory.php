<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Report;


use App\Analyzer\BenchmarkAnalyzerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Templating\EngineInterface;

class BenchmarkReportGeneratorFactory extends ReportGeneratorFactory
{
    /**
     * @param string                            $type
     * @param array|null                        $config
     * @param null|EngineInterface              $templating
     * @param null|LoggerInterface              $logger
     * @return BenchmarkHTMLReportGenerator|BenchmarkLogReportGenerator|mixed
     * @throws \Exception
     */
    public function createReport(
        string $type,
        ?array $config = [],
        ?EngineInterface $templating = null,
        ?LoggerInterface $logger = null
    )
    {
        switch ($type) {
            case self::TYPE_HTML:
                return new BenchmarkHTMLReportGenerator($templating, $config);
                break;
            case self::TYPE_LOG:
                return new BenchmarkLogReportGenerator($logger, $config);
                break;
        }

        throw new \Exception(sprintf("Cannot create the %s type of report.", $type));
    }
}