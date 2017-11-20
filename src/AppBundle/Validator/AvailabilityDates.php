<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class AvailabilityDates
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDates extends Constraint
{
    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
