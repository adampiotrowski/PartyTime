<?php

namespace AppBundle\Entity;

use Carbon\Carbon;

/**
 * Class Party
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Comment
{
    private $id;
    private $email   = '';
    private $comment = '';
    private $createdAt;
    
    /**
     * @var Party
     */
    private $party;
    
    public function __construct(Party $party)
    {
        $this->createdAt = Carbon::now();
        $this->party     = $party;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    
    public function getComment(): string
    {
        return $this->comment;
    }
    
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    public function getParty(): Party
    {
        return $this->party;
    }
}

