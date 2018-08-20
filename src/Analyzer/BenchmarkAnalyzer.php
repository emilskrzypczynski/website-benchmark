<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Analyzer;


use App\Model\BenchmarkInterface;
use App\Model\WebsiteTest;
use App\Model\WebsiteTestInterface;

class BenchmarkAnalyzer implements BenchmarkAnalyzerInterface
{
    /**
     * @param float     $websiteLoadTime
     * @param float     $competitorLoadTime
     * @return float
     */
    public function calculateLoadTimeDifference(float $websiteLoadTime, float $competitorLoadTime): float
    {
        return $websiteLoadTime - $competitorLoadTime;
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return bool
     */
    public function isTestedWebsiteSlowerThanAtLeastOneCompetitor(BenchmarkInterface $benchmark): bool
    {
        return $this->getTestedWebsitePosition($benchmark) > 1;
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return bool
     */
    public function isTestedWebsiteLoadedTwiceAsSlowAsAtLeastOneCompetitor(BenchmarkInterface $benchmark): bool
    {
        $result = false;

        $testedWebsiteLoadTime = $benchmark->getWebsiteTest()->getLoadTime();

        /** @var WebsiteTestInterface $competitorTest */
        foreach ($benchmark->getCompetitorTests() as $competitorTest) {
            if (200 !== $competitorTest->getStatus()) {
                continue;
            }

            if ($testedWebsiteLoadTime / $competitorTest->getLoadTime() > 2) {
                $result = true;

                break;
            }
        }

        return $result;
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return int
     */
    private function getTestedWebsitePosition(BenchmarkInterface $benchmark): int
    {
        $sorted = $this->orderWebsitesByLoadTime($benchmark);

        $testedWebsiteUrl = $benchmark->getWebsiteTest()->getWebsite()->getUrl();
        $testedWebsitePosition = null;

        /** @var WebsiteTestInterface $websiteTest */
        foreach ($sorted as $key => $websiteTest) {
            if ($websiteTest->getWebsite()->getUrl() === $testedWebsiteUrl) {
                $testedWebsitePosition = $key + 1;
                break;
            }
        }

        return $testedWebsitePosition;
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return array
     */
    private function orderWebsitesByLoadTime(BenchmarkInterface $benchmark): array
    {
        $websitesTests = [];

        $websitesTests[] = $benchmark->getWebsiteTest();

        /** @var WebsiteTest $competitorTest */
        foreach ($benchmark->getCompetitorTests() as $competitorTest) {
            if (200 !== $competitorTest->getStatus()) {
                continue;
            }

            $websitesTests[] = $competitorTest;
        }

        usort($websitesTests, function(WebsiteTestInterface $a, WebsiteTestInterface $b) {
            return $a->getLoadTime() > $b->getLoadTime();
        });

        return $websitesTests;
    }
}