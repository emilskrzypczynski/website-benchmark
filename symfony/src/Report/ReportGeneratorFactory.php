<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Report;


use Psr\Log\LoggerInterface;
use Symfony\Component\Templating\EngineInterface;

abstract class ReportGeneratorFactory
{
    public const TYPE_HTML = 'html';
    public const TYPE_LOG = 'log';

    /**
     * @param       EngineInterface $templating
     * @param       string $type
     * @param       array $config
     * @return      mixed
     */
    abstract public function createReport(string $type, ?array $config = [], ?EngineInterface $templating = null, ?LoggerInterface $logger = null);
}