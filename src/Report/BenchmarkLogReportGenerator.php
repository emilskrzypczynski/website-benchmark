<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Report;


use App\Analyzer\BenchmarkAnalyzerInterface;
use App\Model\BenchmarkInterface;
use App\Model\WebsiteTest;
use App\Utils\BenchmarkUtils;
use Psr\Log\LoggerInterface;

class BenchmarkLogReportGenerator implements BenchmarkReportGeneratorInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var BenchmarkAnalyzerInterface */
    private $benchmarkAnalyzer;

    /** @var array */
    private $config;

    /** @var BenchmarkInterface */
    private $benchmark;


    /**
     * BenchmarkLogReportGenerator constructor.
     *
     * @param LoggerInterface               $logger
     * @param BenchmarkAnalyzerInterface    $benchmarkAnalyzer
     * @param array                         $config
     */
    public function __construct(LoggerInterface $logger, BenchmarkAnalyzerInterface $benchmarkAnalyzer, array $config)
    {
        $this->logger = $logger;
        $this->benchmarkAnalyzer = $benchmarkAnalyzer;
        $this->config = $config;
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return BenchmarkReportGeneratorInterface
     */
    public function create(BenchmarkInterface $benchmark): BenchmarkReportGeneratorInterface
    {
        $this->benchmark = $benchmark;

        return $this;
    }

    public function saveToFile(): void
    {
        $content = "Website benchmark results: ";

        $context = $this->createContext($this->benchmark);

        $this->logger->info($content, $context);
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return array
     */
    private function createContext(BenchmarkInterface $benchmark): array
    {
        $context = [];

        $context['websiteTest'] = [
            'url' => $benchmark->getWebsiteTest()->getWebsite()->getUrl(),
            'status' => $benchmark->getWebsiteTest()->getStatus(),
            'loadTime' => $benchmark->getWebsiteTest()->getLoadTime()
        ];

        $context['competitorTests'] = [];

        /** @var WebsiteTest $competitorTest */
        foreach ($benchmark->getCompetitorTests() as $competitorTest) {
            $loadTimeDifference = $this->benchmarkAnalyzer->calculateLoadTimeDifference($benchmark->getWebsiteTest()->getLoadTime(), $competitorTest->getLoadTime());

            $context['competitorTests'][] = [
                'url' => $competitorTest->getWebsite()->getUrl(),
                'status' => $competitorTest->getStatus(),
                'loadTime' => $competitorTest->getLoadTime(),
                'slowerBy' => $loadTimeDifference < 0 ? (- $loadTimeDifference . 's') : '--',
                'fasterBy' => $loadTimeDifference > 0 ? ($loadTimeDifference . 's') : '--',
            ];
        }

        return $context;
    }
}