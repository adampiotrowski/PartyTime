<?php

namespace AppBundle\Form;

use AppBundle\Entity\Party;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PartyType
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new CallbackTransformer(
            function ($originalInput) {
                return $originalInput;
            },
            function ($submittedValue) {
                return (string)$submittedValue;
            }
        );
        
        $builder
            ->add('name')
            ->add('description')
            ->add('address')
            ->add('country', CountryType::class)
            ->add('email')
            ->add('availableFrom')
            ->add('availableTo');
        
        $builder->get('name')->addModelTransformer($transformer);
        $builder->get('description')->addModelTransformer($transformer);
        $builder->get('address')->addModelTransformer($transformer);
        $builder->get('email')->addModelTransformer($transformer);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Party::class,
        ]);
    }
    
    public function getBlockPrefix()
    {
        return 'appbundle_party';
    }
}
