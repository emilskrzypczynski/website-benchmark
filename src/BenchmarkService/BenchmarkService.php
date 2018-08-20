<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\BenchmarkService;


use App\DataTransformer\BenchmarkDataTransformer;
use App\Form\Model\BenchmarkRequest;
use App\Model\BenchmarkInterface;
use App\Model\WebsiteTest;
use GuzzleHttp\TransferStats;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class BenchmarkService
{

    /** @var BenchmarkDataTransformer */
    private $dataTransformer;

    /**
     * BenchmarkService constructor.
     * @param BenchmarkDataTransformer $dataTransformer
     */
    public function __construct(BenchmarkDataTransformer $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }

    public function createFromRequest(BenchmarkRequest $benchmarkRequest): BenchmarkInterface
    {
        $benchmark = $this->dataTransformer->createModelFromRequest($benchmarkRequest);

        $testedWebsiteUrl = $benchmark->getWebsiteTest()->getWebsite()->getUrl();

        $competitorWebsiteUrls = array_map(function (WebsiteTest $competitorTest) {
            return $competitorTest->getWebsite()->getUrl();
        }, $benchmark->getCompetitorTests()->toArray());

        $requestUrls = $competitorWebsiteUrls;

        array_unshift($requestUrls, $testedWebsiteUrl);

        $client = new Client();
        $promises = [];
        $stats = [];

        foreach ($requestUrls as $requestUrl) {
            $promises[] = $client->getAsync($requestUrl, [
                'on_stats' => function(TransferStats $transferStats) use (&$stats, $requestUrl) {
                    $stats[$requestUrl] = $transferStats->getHandlerStats();
                }

            ]);
        }

        Promise\settle($promises)->wait();

        $benchmark->getWebsiteTest()->setStatus($stats[$testedWebsiteUrl]['http_code']);

        if ($stats[$testedWebsiteUrl]['http_code'] === 200) {
            $benchmark->getWebsiteTest()->setLoadTime($stats[$testedWebsiteUrl]['total_time']);
        }

        /** @var WebsiteTest $competitorTest */
        foreach($benchmark->getCompetitorTests() as $competitorTest) {
            $competitorUrl = $competitorTest->getWebsite()->getUrl();

            $competitorTest->setStatus($stats[$competitorUrl]['http_code']);

            if ($stats[$testedWebsiteUrl]['http_code'] === 200) {
                $competitorTest->setLoadTime($stats[$competitorUrl]['total_time']);
            }
        }

        return $benchmark;
    }
}