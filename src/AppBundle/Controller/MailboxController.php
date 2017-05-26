<?php


namespace AppBundle\Controller;

use AppBundle\Entity\User as User;
use AppBundle\Entity\Message as Message;
use AppBundle\Form\MessageType as MessageType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MailboxController extends Controller
{
	/**
	*
	* @Route("/skrzynka", name="mailbox")
	*/
	public function openMailboxAction(Request $request)
	{
		
    	$form = null;
    	$message = new Message();

    	$form = $this->createForm(MessageType::class, $message);

////////////////////////////// Wiadomość w serwisie - do bazy danych ////////////////////////////////////
    	$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

         	$em = $this->getDoctrine()->getManager();
         	$sendTo = $em
	         	->getRepository('AppBundle:User')
	         	->findOneByUsername($form
	         		->getData()
	         		->getToUser());

	        if (!is_null($sendTo)) {
	        $message->setToUser($sendTo);        		
    		$message->setFromUser($this->getUser());

         	$em->persist($message);
         	$em->flush();

         	$this->addFlash('notice', 'Wiadomość wysłana');
         	return $this->redirectToRoute('mailbox');
	        }

	        else{
	        	//throw new Exception("Error Processing Request", 1);   //////// ZROBIĆ PORZĄDNIE ///////
	        	$this->addFlash('notice', 'Nie znaleziono użytkownika');
	        }
        }

        return $this->render('mailbox/mailboxNew.html.twig', [
        	'form' => is_null($form) ? $form : $form->createView()]);

	}

	/**
	*
	* @Route("/skrzynka/odebrane", name="mail_recieved")
	*/
	public function showRecievedMessagesAction()
	{
		$repo = $this->getDoctrine()->getRepository('AppBundle:Message');
		$recievedMessages = $repo->findByToUser($this->getUser());

		return $this->render('mailbox/mailboxMessages.html.twig', [
			'messages' => $recievedMessages,
			'showRecieved' => true

			]);
	}

	/**
	*
	* @Route("skrzynka/wyslane", name="mail_sent")
	*/
	public function showSentMessagesAction()
	{
		$repo = $this->getDoctrine()->getRepository('AppBundle:Message');
		$sentMessages = $repo->findByFromUser($this->getUser());

		return $this->render('mailbox/mailboxMessages.html.twig', [
			'messages' => $sentMessages,
			]);
	}

	/**
	*
	* @Route("skrzynka/kasuj/{message}", name="mail_message_delete")
	*/
	public function deleteMessageAction(Message $message)
	{
		
		$em = $this->getDoctrine()->getManager();

		if (!$message) {
			throw new RuntimeException();	////////////// ZROBIĆ PORZĄDNIE ////////////////////		
			
		}
		else{
			$em->remove($message);
			$em->flush();
		}

		$messages = $em->getRepository('AppBundle:Message')->findByToUser($this->getUser());

		return $this->render('mailbox/mailboxMessages.html.twig', [
			'messages' => $messages
			]);
	}

	/**
	*
	* @Route("/skrzynka/{messageToShow}", name="mail_message_show")
	*/
	public function showMessageAction(Message $messageToShow)
	{
		// $repo = $this->getDoctrine()->getRepository('AppBundle:Message');
		// $messageToShow = $repo->findOne
		

		return $this->render('mailbox/mailboxShowMessage.html.twig', [
			'messageToShow' => $messageToShow

			]);
	}

}
