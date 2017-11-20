<?php

namespace AppBundle\Service\Geocoder;

/**
 * Class GeocodingResult
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class GeocodingResult implements GeocodingResultInterface
{
    /**
     * @var float|null
     */
    private $latitude;
    
    /**
     * @var float|null
     */
    private $longitude;
    
    public function setLatitude(float $latitude = null)
    {
        $this->latitude = $latitude;
    }
    
    public function setLongitude(float $longitude = null)
    {
        $this->longitude = $longitude;
    }
    
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    public function getLongitude()
    {
        return $this->longitude;
    }
}
