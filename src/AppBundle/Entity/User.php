<?php


namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    public function __construct()
    {
        parent::__construct();

        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->messagesSent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->messagesRecieved = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @var
    * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
    *
    */
    private $comments;

    /**
    * @var
    *
    * @ORM\OneToMany(targetEntity="Message", mappedBy="fromUser")
    */
    private $messagesSent;

    /**
    * @var
    * 
    * @ORM\OneToMany(targetEntity="Message", mappedBy="toUser")
    */
    private $messagesRecieved;

    
    public function getId()
    {
        return $this->id;
    }
    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add messagesSent
     *
     * @param \AppBundle\Entity\Message $messagesSent
     *
     * @return User
     */
    public function addMessagesSent(\AppBundle\Entity\Message $messagesSent)
    {
        $this->messagesSent[] = $messagesSent;

        return $this;
    }

    /**
     * Remove messagesSent
     *
     * @param \AppBundle\Entity\Message $messagesSent
     */
    public function removeMessagesSent(\AppBundle\Entity\Message $messagesSent)
    {
        $this->messagesSent->removeElement($messagesSent);
    }

    /**
     * Get messagesSent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessagesSent()
    {
        return $this->messagesSent;
    }

    /**
     * Add messagesRecieved
     *
     * @param \AppBundle\Entity\Message $messagesRecieved
     *
     * @return User
     */
    public function addMessagesRecieved(\AppBundle\Entity\Message $messagesRecieved)
    {
        $this->messagesRecieved[] = $messagesRecieved;

        return $this;
    }

    /**
     * Remove messagesRecieved
     *
     * @param \AppBundle\Entity\Message $messagesRecieved
     */
    public function removeMessagesRecieved(\AppBundle\Entity\Message $messagesRecieved)
    {
        $this->messagesRecieved->removeElement($messagesRecieved);
    }

    /**
     * Get messagesRecieved
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessagesRecieved()
    {
        return $this->messagesRecieved;
    }
}
