<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints\DateTime as DateTime;


/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{
    public function __construct()
    {
        $this->dateSend = new \DateTime("now");
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messagesSent")
     */
    private $fromUser;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messagesRecieved")
     */
    private $toUser;

    /**
     * @var string
     *
     * @ORM\Column(name="topic", type="string", length=255)
     */
    private $topic;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSend", type="datetime")
     */
    private $dateSend;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fromUser
     *
     * @param string $fromUser
     *
     * @return Message
     */
    public function setFromUser($fromUser)
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * Get fromUser
     *
     * @return string
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * Set toUser
     *
     * @param string $toUser
     *
     * @return Message
     */
    public function setToUser($toUser)
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * Get toUser
     *
     * @return string
     */
    public function getToUser()
    {
        return $this->toUser;
    }

    /**
     * Set topic
     *
     * @param string $topic
     *
     * @return Message
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Message
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set dateSend
     *
     * @param \DateTime $dateSend
     *
     * @return Message
     */
    public function setDateSend($dateSend)
    {
        $this->dateSend = $dateSend;

        return $this;
    }

    /**
     * Get dateSend
     *
     * @return \DateTime
     */
    public function getDateSend()
    {
        return $this->dateSend;
    }

    /**
     * Set emailAdress
     *
     * @param string $emailAdress
     *
     * @return Message
     */
    public function setEmailAdress($emailAdress)
    {
        $this->emailAdress = $emailAdress;

        return $this;
    }

    /**
     * Get emailAdress
     *
     * @return string
     */
    public function getEmailAdress()
    {
        return $this->emailAdress;
    }
}
