<?php
namespace ProductsBundle\Services;

class Mailer
{
    public function sendNotificationForNewProduct(){

        $transport = new \Swift_SmtpTransport('smtp.gmail.com', 465,'ssl');
        $transport->setUsername('');
        $transport->setPassword('');

        $mailer = new \Swift_Mailer($transport);

        $message =  (new \Swift_Message())
            ->setSubject('Send from my first Symfony Application')
            ->setFrom('heuckam@gmail.com', 'Kaloyan Aleksiev')
            ->setBody('Ko staa maniaci?!?! :) -> (5pts)Create service for sending emails to notify list of predefined email addresses for 
new products in application.');
        $predefinedList = ['kikoman1@abv.bg', 'kalexiev@map-mr.com', 'hprodanov@map-mr.com', 'tgeorgieva@map-mr.com', 'lqlqlq@gbg.bg', 'Maleksieva@c3i-inc.com'];
        $numberOfSuccessfullySentMails = 0;
        foreach ($predefinedList as $address => $name)
        {
            $message->setTo($name);
            $numberOfSuccessfullySentMails += $mailer->send($message, $failedRecipients);
        }
        return $numberOfSuccessfullySentMails;
    }
}