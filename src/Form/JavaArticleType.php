<?php

namespace App\Form;

use App\Entity\JavaArticle;
use App\Entity\JavaArticleCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Norzechowicz\AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;

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
//            ->add('description')
            ->add('code', AceEditorType::class, array(
                'font_size' => 14,
                'height' => "300px",
                'wrapper_attr' => array(), // aceeditor wrapper html attributes.
                'mode' => 'ace/mode/java', // every single default mode must have ace/mode/* prefix
                'theme' => 'ace/theme/cobalt', // every single default theme must have ace/theme/* prefix
                'options_enable_basic_autocompletion' => true,
                'options_enable_live_autocompletion' => true,
                'options_enable_snippets' => false
            ))
//            ->add('code', TextareaType::class, ['attr' => ['class' => 'tinymce', 'rows' => 15]])
            ->add('codeSnippet', TextareaType::class, ['required' => false, 'attr' => ['rows' => 15]])
//            ->add('slug')
            ->add('className')
            ->add('referenceLink', UrlType::class, ['required' => false])
            ->add('sort_order')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Publish' => 1,
                    'Draft' => 0
                ]
            ])->add('isDraggable', ChoiceType::class, [
                'choices' => [
                    'Yes' => 1,
                    'No' => 0
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
