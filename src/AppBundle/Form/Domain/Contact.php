<?php

namespace AppBundle\Form\Domain;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=30)
     */
    public $fullName;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    public $emailAddress;

    /**
     * @Assert\NotBlank
     */
    public $message;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=5, max=50)
     */
    public $subject;

    public $company;
    public $phoneNumber;

    public function createMessage($recipient, $body)
    {
        return \Swift_Message::newInstance()
            ->setFrom($this->emailAddress, $this->fullName)
            ->setTo($recipient)
            ->setSubject($this->subject)
            ->setBody($body)
        ;
    }
} 
