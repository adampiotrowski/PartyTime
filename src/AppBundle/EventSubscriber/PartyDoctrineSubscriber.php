<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Entity\Party;
use AppBundle\Service\Geocoder\GeocoderHelperInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * Class PartyDoctrineSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PartyDoctrineSubscriber implements EventSubscriber
{
    private $geocoderHelper;
    
    public function __construct(GeocoderHelperInterface $geocoderHelper)
    {
        $this->geocoderHelper = $geocoderHelper;
    }
    
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }
    
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->onPartySave($args);
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->onPartySave($args);
    }
    
    private function onPartySave(LifecycleEventArgs $args)
    {
        $party = $args->getObject();
        
        if ($party instanceof Party) {
            $result = $this->geocoderHelper->geocodeAddress($party);
            $party->setLatitude($result->getLatitude());
            $party->setLatitude($result->getLatitude());
        }
    }
}
