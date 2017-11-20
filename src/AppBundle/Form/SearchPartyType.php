<?php

namespace AppBundle\Form;

use AppBundle\Model\SearchParty;
use Symfony\Component\Form\AbstractType;
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
        $builder
            ->add('address')
            ->add('country', CountryType::class);
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
