<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Mailer;


use App\Model\BenchmarkInterface;
use App\Report\BenchmarkHTMLReportGenerator;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class NotificationMailer implements MailerInterface
{
    /** @var \Swift_Mailer */
    protected $mailer;

    /** @var UrlGeneratorInterface */
    protected $router;

    /** @var EngineInterface */
    protected $templating;

    /** @var TranslatorInterface */
    protected $translator;

    /** @var BenchmarkHTMLReportGenerator */
    protected $benchmarkHTMLReportGenerator;

    /** @var array */
    protected $parameters;


    /**
     * NotificationMailer constructor.
     *
     * @param \Swift_Mailer                 $mailer
     * @param UrlGeneratorInterface         $router
     * @param EngineInterface               $templating
     * @param TranslatorInterface           $translator
     * @param BenchmarkHTMLReportGenerator  $benchmarkHTMLReportGenerator
     * @param array                         $parameters
     */
    public function __construct(
        \Swift_Mailer $mailer,
        UrlGeneratorInterface $router,
        EngineInterface $templating,
        TranslatorInterface $translator,
        BenchmarkHTMLReportGenerator $benchmarkHTMLReportGenerator,
        array $parameters
    )
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->templating = $templating;
        $this->translator = $translator;
        $this->benchmarkHTMLReportGenerator = $benchmarkHTMLReportGenerator;
        $this->parameters = $parameters;
    }

    /**
     * @param string    $from
     * @param string    $to
     * @param string    $subject
     * @param string    $message
     */
    public function sendMessage(string $from, string $to, string $subject, string $message): void
    {
        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($message)
            ->setContentType('text/html');

        $this->mailer->send($message);
    }

    /**
     * @param BenchmarkInterface $benchmark
     */
    public function sendWarningNotification(BenchmarkInterface $benchmark) {
        $subject = $this->translator->trans(
            'email.warning_notification.subject',
            [
                '%pagename%' => $benchmark->getWebsiteTest()->getWebsite()->getUrl()
            ],
            'emails'
        );

        $report = $this->benchmarkHTMLReportGenerator
            ->create($benchmark)
            ->getAsHTML();

        $message = $this->templating->render(
            'email/waring_notification.html.twig',
            [
                'benchmark' => $benchmark,
                'report' => $report
            ]
        );

        $this->sendMessage($this->parameters['from'], $this->parameters['to'], $subject, $message);


    }
}