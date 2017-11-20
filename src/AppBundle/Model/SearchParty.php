<?php

namespace AppBundle\Model;

use AppBundle\Service\Geocoder\GeoAwareInterface;

/**
 * Class SearchParty
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchParty implements GeoAwareInterface
{
    private $address = '';
    private $country = '';
    
    /**
     * @var float|null
     */
    private $latitude;
    
    /**
     * @var float|null
     */
    private $longitude;
    
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
