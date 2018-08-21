<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);


namespace App\Event;


use App\Model\BenchmarkInterface;
use Symfony\Component\EventDispatcher\Event;

class BenchmarkEvent extends Event
{
    /** @var BenchmarkInterface */
    private $benchmark;

    /**
     * BenchmarkEvent constructor.
     *
     * @param BenchmarkInterface $benchmark
     */
    public function __construct(BenchmarkInterface $benchmark)
    {
        $this->benchmark = $benchmark;
    }

    /**
     * @return BenchmarkInterface
     */
    public function getBenchmark(): BenchmarkInterface
    {
        return $this->benchmark;
    }
}