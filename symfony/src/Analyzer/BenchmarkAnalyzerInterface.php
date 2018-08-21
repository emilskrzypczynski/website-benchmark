<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Analyzer;


use App\Model\BenchmarkInterface;

interface BenchmarkAnalyzerInterface
{
    /**
     * @param BenchmarkInterface $benchmark
     * @return bool
     */
    public function isTestedWebsiteSlowerThanAtLeastOneCompetitor(BenchmarkInterface $benchmark): bool;

    /**
     * @param BenchmarkInterface $benchmark
     * @return bool
     */
    public function isTestedWebsiteLoadedTwiceAsSlowAsAtLeastOneCompetitor(BenchmarkInterface $benchmark): bool;

    /**
     * @param float     $websiteLoadTime
     * @param float     $competitorLoadTime
     * @return float
     */
    public function calculateLoadTimeDifference(float $websiteLoadTime, float $competitorLoadTime): float;
}