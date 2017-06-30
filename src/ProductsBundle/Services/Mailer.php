<?php
namespace ProductsBundle\Services;

class Mailer
{
    public function sendNotificationForNewProduct(){

        $transport = new \Swift_SmtpTransport('smtp.gmail.com', 465,'ssl');
        $transport->setUsername('heuckam@gmail.com');
        $transport->setPassword('');

        $mailer = new \Swift_Mailer($transport);

        $message =  (new \Swift_Message())
            ->setSubject('Send from my first Symfony Application')
            ->setFrom('heuckam@gmail.com', 'Kaloyan Aleksiev')
            ->setTo('kikoman1@abv.bg','kalexiev@map-mr.com')
            ->setBody('Ko staa maniaci?!?! :) -> (5pts)Create service for sending emails to notify list of predefined email addresses for 
new products in application.');
        $numberOfSuccessfullySentMails = $mailer->send($message);
        return $numberOfSuccessfullySentMails;
    }
}