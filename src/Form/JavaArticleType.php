<?php

namespace App\Form;

use App\Entity\JavaArticle;
use App\Entity\JavaArticleCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JavaArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => JavaArticleCategory::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a Category'
            ])
            ->add('title')
            ->add('description')
            ->add('code', TextareaType::class, ['attr' => ['class' => 'tinymce', 'rows' => 15]])
            ->add('slug')
            ->add('className')
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
            'data_class' => JavaArticle::class,
        ]);
    }
}
