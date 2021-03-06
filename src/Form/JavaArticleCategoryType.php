<?php

namespace App\Form;

use App\Entity\JavaArticleCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JavaArticleCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('Description')
            ->add('sort_order')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Publish' => 1,
                    'Draft' => '0'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JavaArticleCategory::class,
        ]);
    }
}
