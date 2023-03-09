<?php
class EmailSender {
    private $emailServer;

    public function __construct(EmailServerInterface $emailServer) {
        $this->emailServer = $emailServer;
    }

    public function send($to, $name, $subject, $message) {
        $this->emailServer->sendEmail($to, $name, $subject, $message);
    }
}
?>