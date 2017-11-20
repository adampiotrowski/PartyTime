<?php

namespace AppBundle\Service\Geocoder;

/**
 * Interface GeocodingResultInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface GeocodingResultInterface
{
    public function getLatitude();
    
    public function getLongitude();
}
