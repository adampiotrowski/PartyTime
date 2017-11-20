<?php

namespace AppBundle\Validator;

use AppBundle\Entity\Party;
use Carbon\Carbon;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class AvailabilityDatesValidator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDatesValidator extends ConstraintValidator
{
    /**
     * Validates the party availability dates
     *
     * @param Party      $entity
     * @param Constraint $constraint
     */
    public function validate($entity, Constraint $constraint)
    {
        if (!$entity instanceof Party) {
            throw new \InvalidArgumentException('Expected instance of ' . Party::class);
        }
        
        if ($this->context instanceof ExecutionContextInterface) {
            $availableFrom = Carbon::instance($entity->getAvailableFrom());
            $availableTo   = Carbon::instance($entity->getAvailableTo());
            $minimumStart  = Carbon::now()->addDay(7);
            
            /**
             * Check whether the party ends after it starts
             */
            if ($availableTo->lessThanOrEqualTo($availableFrom)) {
                $this->context
                    ->buildViolation('The party can not end before or on the same day it starts.')
                    ->atPath('availableTo')
                    ->addViolation();
            }
            
            if (false === $availableFrom->isNextWeek()) {
                $this->context
                    ->buildViolation('The party must start at least in a week.')
                    ->atPath('availableFrom')
                    ->addViolation();
            }
        }
    }
}
