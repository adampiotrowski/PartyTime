<?php

namespace AppBundle\Service\Geocoder;

/**
 * Interface GeoAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface GeoAwareInterface
{
    public function getGeocodableAddress(): string;
    
    public function getLatitude();
    
    public function setLatitude(float $latitude = null);
    
    public function getLongitude();
    
    public function setLongitude(float $longitude = null);
}
