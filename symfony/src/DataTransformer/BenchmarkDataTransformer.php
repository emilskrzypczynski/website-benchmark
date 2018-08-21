<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\DataTransformer;


use App\Form\Model\BenchmarkRequest;
use App\Model\Benchmark;
use App\Model\BenchmarkInterface;
use App\Model\Website;
use App\Model\WebsiteTest;

class BenchmarkDataTransformer
{
    /**
     * @param BenchmarkRequest $request
     * @return BenchmarkInterface
     */
    public function createModelFromRequest(BenchmarkRequest $request): BenchmarkInterface
    {
        $benchmark = new Benchmark();

        $website = (new Website())
            ->setUrl($request->getWebsite());

        $websiteTest = (new WebsiteTest())
            ->setWebsite($website)
            ->setBenchmark($benchmark);

        $benchmark->setWebsiteTest($websiteTest);

        foreach ($request->getCompetitors() as $competitorUrl) {
            $competitorWebsite = (new Website())
                ->setUrl($competitorUrl);

            $competitorTest = (new WebsiteTest())
                ->setWebsite($competitorWebsite)
                ->setBenchmark($benchmark);

            $benchmark->addCompetitorTest($competitorTest);
        }

        return $benchmark;
    }
}