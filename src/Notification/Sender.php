<?php

namespace App\Notification;

use PharIo\Manifest\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Sender {
    public function __construct(protected MailerInterface $mailer){
    }
    public function sendNewUserNotificationToAdmin(UserInterface $user) {
//        file_put_contents('debug.txt', $user->getEmail());

        $message = new \Symfony\Component\Mime\Email();
        $message->from('account@series.com')
            ->to('admin@series.com')
            ->subject('New account created on series.com')
            ->html('<h1>New account</h1>email: ' . $user->getEmail());

        $this->mailer->send($message);
    }
}