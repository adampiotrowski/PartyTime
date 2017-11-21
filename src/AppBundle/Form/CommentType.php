<?php

namespace AppBundle\Form;

use AppBundle\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CommentType
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CommentType extends AbstractType
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
            ->add('email')
            ->add('comment');
    
        $builder->get('comment')->addModelTransformer($transformer);
        $builder->get('email')->addModelTransformer($transformer);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
    
    public function getBlockPrefix()
    {
        return 'appbundle_comment';
    }
}
