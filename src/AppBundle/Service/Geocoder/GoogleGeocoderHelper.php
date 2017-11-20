<?php

namespace AppBundle\Service\Geocoder;

use Geocoder\Model\AddressCollection;
use Geocoder\Provider\GoogleMaps;
use Ivory\HttpAdapter\CurlHttpAdapter;
use Psr\Log\LoggerInterface;

/**
 * Class GoogleGeocoderHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class GoogleGeocoderHelper implements GeocoderHelperInterface
{
    /**
     * @var string
     */
    private $apiKey;
    
    /**
     * @var string
     */
    private $locale;
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    public function __construct(string $apiKey, string $locale, LoggerInterface $logger)
    {
        $this->apiKey = $apiKey;
        $this->locale = $locale;
        $this->logger = $logger;
    }
    
    public function geocodeAddress(GeoAwareInterface $address): GeocodingResultInterface
    {
        $geocoder = $this->createGeocoder();
        $result    = new GeocodingResult();
        
        try {
            $geocodeResult = $geocoder->geocode($address->getGeocodableAddress());
            if ($geocodeResult instanceof AddressCollection) {
                $result->setLongitude($geocodeResult->first()->getLongitude());
                $result->setLatitude($geocodeResult->first()->getLatitude());
            }
        } catch (\Exception $e) {
            $this->logger->error('An error occurred during geocoding.', [
                'address' => $address->getGeocodableAddress(),
                'message' => $e->getMessage(),
            ]);
        }
        
        return $result;
    }
    
    private function createGeocoder(): GoogleMaps
    {
        $httpAdapter = new CurlHttpAdapter();
        
        return new \Geocoder\Provider\GoogleMaps(
            $httpAdapter,
            $this->locale,
            '',
            true,
            $this->apiKey
        );
    }
}
