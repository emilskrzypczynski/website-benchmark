<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

namespace App\SMS;


use App\Model\BenchmarkInterface;
use Symfony\Component\Translation\TranslatorInterface;

class SMSNotifier
{
    /** @var SMSApi */
    private $SMSApi;

    /** @var array */
    private $config;

    /** @var TranslatorInterface */
    private $translator;

    /**
     * SMSNotifier constructor.
     * @param SMSApi $SMSApi
     * @param TranslatorInterface $translator
     */
    public function __construct(SMSApi $SMSApi, array $config, TranslatorInterface $translator)
    {
        $this->SMSApi = $SMSApi;
        $this->config = $config;
        $this->translator = $translator;
    }

    /**
     * @param BenchmarkInterface $benchmark
     */
    public function sendWarningNotification(BenchmarkInterface $benchmark)
    {
        $pagename = $benchmark->getWebsiteTest()->getWebsite()->getUrl();

        $content = $this->translator->trans('sms.warning_notification.body', ['%pagename%' => $pagename], 'sms');

        $this->sendMessage($content);
    }

    /**
     * @param string $message
     */
    public function sendMessage(string $message)
    {
        $number = $this->config['to'];

        $this->SMSApi->sendMessage($number, $message);
    }
}