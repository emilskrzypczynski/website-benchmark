<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Report;


use App\Model\BenchmarkInterface;
use Symfony\Component\Templating\EngineInterface;

class BenchmarkHTMLReportGenerator implements BenchmarkReportGeneratorInterface
{
    /** @var EngineInterface */
    private $templating;

    /** @var array */
    private $config;

    /** @var BenchmarkInterface */
    private $benchmark;

    /** @var string */
    private $content;


    /**
     * BenchmarkHTMLReportGenerator constructor.
     *
     * @param EngineInterface $templating
     * @param $config
     */
    public function __construct(EngineInterface $templating, $config)
    {
        $this->templating = $templating;

        $this->config = $config;
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return BenchmarkReportGeneratorInterface
     */
    public function create(BenchmarkInterface $benchmark): BenchmarkReportGeneratorInterface
    {
        $this->benchmark = $benchmark;

        $html = $this->templating->render(
            $this->config['template'],
            ['benchmarkResults' => $benchmark]
        );

        $this->content = $html;

        return $this;
    }

    /**
     * @return string
     */
    public function getAsHTML(): string
    {
        return $this->content;
    }
}