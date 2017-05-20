<?php

namespace Architecture\NotifierProvider;

use Domain\Notifier\NotifierProvider;

class Swiftmailer implements NotifierProvider
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $sendTo;

    public function __construct($host, $username, $password, $sendTo)
    {
        $transport = \Swift_SmtpTransport::newInstance($host, 587)
            ->setUsername($username)
            ->setPassword($password);

        $this->mailer = \Swift_Mailer::newInstance($transport);

        $this->from = $username;
        $this->sendTo = $sendTo;
    }

    public function send(array $body)
    {
        $body = $this->prepareBody($body);

        $message = \Swift_Message::newInstance('Financier: New notification', $body);
        $message->setPriority(2);
        $message->setTo($this->sendTo);
        $message->setFrom($this->from);

        $this->mailer->send($message);
    }

    /**
     * @param string[] $body
     *
     * @return string
     */
    private function prepareBody(array $body)
    {
        $start = [
            count($body) . ' notification(s) is/are waiting for you!'
        ];
        return implode("\n\n------------------\n\n", array_merge($start, $body));
    }
}