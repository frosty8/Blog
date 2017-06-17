<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Support_Mail as Support_Mail;

use AppBundle\Form\Support_MailType as Support_MailType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;




class SupportController extends Controller
{
	

////////////////////////////////////////////// MAILER ////////////////////////////////////////////////////
////////////////////////////////////////// Wysłanie maila ////////////////////////////////////////////////
/**
* @Route("/support/e-mail", name="support_e-mail")
* 
*/
public function contact_SendEmailAction(Request $request)
{

    $mail = new Support_Mail();

    $form = $this->createForm(Support_MailType::class, $mail);        
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $mail->setSendTo($this->getParameter('mailer_user'));
        $mail->setSendFrom($this->getUser()->getEmail());
        $mail->setMessageTopic($form->getData()->getMessageTopic());
        $mail->setMessageBody($form->getData()->getMessageBody());
    
        $message = \Swift_Message::newInstance()
                ->setSubject($mail->getMessageTopic())
                ->setFrom($mail->getSendFrom())
                ->setTo($mail->getSendTo())
                ->setBody(
                        'Wiadomość od: '.$this->getUser().' - '.$mail->getSendFrom().'
                        <br>Wysłano: '.$mail->getDateSend()->format('Y-m-d H:i:s').'<br><br>'
                        .$mail->getMessageBody(),
                        'text/html'

        );    
       $message->setCharset('UTF-8');
       $this->get('mailer')->send($message);
       $this->addFlash('notice', 'Dziękujemy za wiadomość');      

        return $this->redirect($request->getUri());   
    }

    return $this->render('support/send_mail.html.twig', [
        'form' => $form->createView()]);

}
}