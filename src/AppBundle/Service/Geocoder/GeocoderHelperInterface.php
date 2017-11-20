<?php

namespace AppBundle\Service\Geocoder;

/**
 * Interface GeocoderHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface GeocoderHelperInterface
{
    public function geocodeAddress(GeoAwareInterface $address): GeocodingResultInterface;
}
