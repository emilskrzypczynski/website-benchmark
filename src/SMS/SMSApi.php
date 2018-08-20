<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

namespace App\SMS;


use Psr\Log\LoggerInterface;

class SMSApi implements SMSApiInterface
{
    /** @var array */
    private $credentials;

    /** @var LoggerInterface */
    private $logger;

    /**
     * SMSApi constructor.
     * @param array $credentials
     */
    public function __construct(array $credentials, LoggerInterface $logger)
    {
        $this->credentials = $credentials;
        $this->logger = $logger;
    }

    /**
     * @param string $message
     * @return bool
     */
    public function sendMessage(string $number, string $message): bool
    {
        $this->logger->info("SMS API: Message sent. ", ['number' => $number, 'message' => $message]);

        return true;
    }
}