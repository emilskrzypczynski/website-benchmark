<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Mailer;


interface MailerInterface
{

    /**
     * @param string    $from
     * @param string    $to
     * @param string    $subject
     * @param string    $body
     */
    public function sendMessage(string $from, string $to, string $subject, string $body): void;
}