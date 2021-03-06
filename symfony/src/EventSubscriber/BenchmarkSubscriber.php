<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);


namespace App\EventSubscriber;

use App\Analyzer\BenchmarkAnalyzer;
use App\Event\BenchmarkEvent;
use App\Event\Events;
use App\Mailer\MailerInterface;
use App\Mailer\NotificationMailer;
use App\Report\BenchmarkLogReportGenerator;
use App\SMS\SMSNotifier;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class BenchmarkSubscriber implements EventSubscriberInterface
{
    /** @var NotificationMailer */
    private $notificationMailer;

    /** @var SMSNotifier */
    private $SMSNotifier;

    /** @var BenchmarkLogReportGenerator */
    private $benchmarkLogReportGenerator;

    /** @var BenchmarkAnalyzer */
    private $benchmarkAnalyzer;



    public function __construct(MailerInterface $notificationMailer, SMSNotifier $SMSNotifier, BenchmarkLogReportGenerator $benchmarkLogReportGenerator, BenchmarkAnalyzer $benchmarkAnalyzer)
    {
        $this->notificationMailer = $notificationMailer;
        $this->SMSNotifier = $SMSNotifier;
        $this->benchmarkLogReportGenerator = $benchmarkLogReportGenerator;
        $this->benchmarkAnalyzer = $benchmarkAnalyzer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::ON_BENCHMARK_FINISH => [
                ['saveBenchmarkResultToLogFile'],
                ['analyzeBenchmark'],
            ]
        ];
    }

    /**
     * @param BenchmarkEvent $event
     */
    public function saveBenchmarkResultToLogFile(BenchmarkEvent $event): void
    {
        $benchmark = $event->getBenchmark();

        $this->benchmarkLogReportGenerator
            ->create($benchmark)
            ->saveToFile();
    }

    /**
     * @param BenchmarkEvent $event
     */
    public function analyzeBenchmark(BenchmarkEvent $event): void
    {
        $benchmark = $event->getBenchmark();

        if ($this->benchmarkAnalyzer->isTestedWebsiteSlowerThanAtLeastOneCompetitor($benchmark)) {
            $this->notificationMailer->sendWarningNotification($event->getBenchmark());
        }

        if ($this->benchmarkAnalyzer->isTestedWebsiteLoadedTwiceAsSlowAsAtLeastOneCompetitor($benchmark)) {
            $this->SMSNotifier->sendWarningNotification($benchmark);
        }
    }
}