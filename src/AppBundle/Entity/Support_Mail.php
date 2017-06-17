<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints\DateTime as DateTime;

use Doctrine\ORM\Mapping as ORM;


/**
 * Support_Mail
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Support_MailRepository")
 */
class Support_Mail
{

    private $sendTo;
    private $sendFrom;
    private $messageTopic;
    private $messageBody;
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
     * Set sendTo
     *
     * @param string $sendTo
     *
     * @return Support_Mail
     */
    public function setSendTo($sendTo)
    {
        $this->sendTo = $sendTo;

        return $this;
    }

    /**
     * Get sendTo
     *
     * @return string
     */
    public function getSendTo()
    {
        return $this->sendTo;
    }

    /**
     * Set sendFrom
     *
     * @param string $sendFrom
     *
     * @return Support_Mail
     */
    public function setSendFrom($sendFrom)
    {
        $this->sendFrom = $sendFrom;

        return $this;
    }

    /**
     * Get sendFrom
     *
     * @return string
     */
    public function getSendFrom()
    {
        return $this->sendFrom;
    }

    /**
     * Set messageTopic
     *
     * @param string $messageTopic
     *
     * @return Support_Mail
     */
    public function setMessageTopic($messageTopic)
    {
        $this->messageTopic = $messageTopic;

        return $this;
    }

    /**
     * Get messageTopic
     *
     * @return string
     */
    public function getMessageTopic()
    {
        return $this->messageTopic;
    }


    /**
     * Set messageBody
     *
     * @param string $messageBody
     *
     * @return Support_Mail
     */
    public function setMessageBody($messageBody)
    {
        $this->messageBody = $messageBody;

        return $this;
    }

    /**
     * Get messageBody
     *
     * @return string
     */
    public function getMessageBody()
    {
        return $this->messageBody;
    }

    /**
     * Set dateSend
     *
     * @param \DateTime $dateSend
     *
     * @return Support_Mail
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

    public function __construct()
    {
        $this->dateSend = new \DateTime("now");
    }
}

