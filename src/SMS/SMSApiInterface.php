<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

namespace App\SMS;


interface SMSApiInterface
{
    public function sendMessage(string $number, string $message);
}