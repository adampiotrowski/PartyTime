<?php

namespace AppBundle\Form;

use AppBundle\Model\SearchParty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SearchPartyType
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchPartyType extends AbstractType
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
            ->add('address')
            ->add('country', CountryType::class);
        
        $builder->get('address')->addModelTransformer($transformer);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchParty::class,
        ]);
    }
    
    public function getBlockPrefix()
    {
        return 'appbundle_search_party';
    }
}
