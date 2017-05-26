<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message as Message;
use AppBundle\Entity\User as User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\MessageType as MessageType;



class SupportController extends Controller
{
	

////////////////////////////////////////////// MAILER ////////////////////////////////////////////////////
////////////////////////////////////////// Wysłanie maila ////////////////////////////////////////////////
/**
* @Route("/support/e-mail", name="support_e-mail")
* 
*/
public function contact_SendEmailAction()
{

   $to = 'frost8b@gmail.com';
   $from = 'frostydev8@gmail.com';
   $name = $this->getUser();

    $message = \Swift_Message::newInstance()
        ->setSubject('Hello hello')
        ->setFrom($from)
        ->setTo($to)
        ->setBody("
                Witaj $name, dziękuję za rejestrację na blogu i zapraszam do dyskusji.<br>
                Pozdrawiam,<br>
                Marcin",
                'text/html'

    );
    $message->setCharset('UTF-8');
    $this->get('mailer')->send($message);

    $this->addFlash('notice', 'Wysłano wiadomość!');
    return $this->redirectToRoute('homepage');

}
}