<?php

namespace AppBundle\Entity;

use AppBundle\Service\Geocoder\GeoAwareInterface;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Party
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Party implements GeoAwareInterface
{
    private $id;
    private $name        = '';
    private $description = '';
    private $address     = '';
    private $country     = '';
    private $email       = '';
    
    /**
     * @var float|null
     */
    private $latitude;
    
    /**
     * @var float|null
     */
    private $longitude;
    
    /**
     * @var \DateTime|null
     */
    private $availableFrom;
    
    /**
     * @var \DateTime|null
     */
    private $availableTo;
    
    /**
     * @var Collection
     */
    private $comments;
    
    public function __construct()
    {
        $this->comments      = new ArrayCollection();
        $this->availableFrom = Carbon::now()->addDay(7);
        $this->availableTo   = Carbon::now()->addDay(8);
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setDescription(string $description)
    {
        $this->description = $description;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function setAddress(string $address)
    {
        $this->address = $address;
    }
    
    public function getAddress(): string
    {
        return $this->address;
    }
    
    public function getCountry(): string
    {
        return $this->country;
    }
    
    public function setCountry(string $country)
    {
        $this->country = $country;
    }
    
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setAvailableFrom(\DateTime $availableFrom)
    {
        $this->availableFrom = $availableFrom;
    }
    
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }
    
    public function setAvailableTo(\DateTime $availableTo)
    {
        $this->availableTo = $availableTo;
    }
    
    public function getAvailableTo()
    {
        return $this->availableTo;
    }
    
    public function getComments(): Collection
    {
        return $this->comments;
    }
    
    public function setComments(Collection $comments)
    {
        $this->comments = $comments;
    }
    
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    public function setLatitude(float $latitude = null)
    {
        $this->latitude = $latitude;
    }
    
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    public function setLongitude(float $longitude = null)
    {
        $this->longitude = $longitude;
    }
    
    public function getGeocodableAddress(): string
    {
        return sprintf('%s, %s', $this->address, $this->country);
    }
}

