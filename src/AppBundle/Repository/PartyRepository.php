<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class PartyRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PartyRepository extends EntityRepository
{
    /**
     * Filters the parties by distance using geo coordinates
     *
     * @param float|null $latitude
     * @param float|null $longitude
     * @param int        $distance in kilometers
     *
     * @return array
     */
    public function getNearestParties(float $latitude = null, float $longitude = null, int $distance = 2)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->addSelect(
                '( 6371 * ACOS(COS(RADIANS(' . $latitude . '))' .
                '* COS( RADIANS( p.latitude ) )' .
                '* COS( RADIANS( p.longitude )' .
                '- RADIANS(' . $longitude . ') )' .
                '+ sin( RADIANS(' . $latitude . ') )' .
                '* sin( RADIANS( p.latitude ) ) ) ) as distance'
            )
            ->having('distance < :distance')
            ->setParameter('distance', $distance)
            ->orderBy('distance', 'ASC');
        
        return $queryBuilder->getQuery()->getResult();
    }
}
