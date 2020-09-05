<?php

namespace App\Controller;

use App\Compiler\Executor;
use App\Entity\JavaArticle;
use App\Form\JavaArticleType;
use App\Repository\JavaArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Norzechowicz\AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;

/**
 * @Route("/java")
 */
class JavaController extends AbstractController
{
    /** KernelInterface $appKernel */
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    /**
     * @param $javaArticle
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getCompilerForm($javaArticle)
    {
        return $this->createFormBuilder($javaArticle)
            ->add('language', HiddenType::class, ['data' => 'java'])
            ->add('code', AceEditorType::class, array(
                'required' => false,
                'height' => "100%",
                'font_size' => 14,
                'wrapper_attr' => array(), // aceeditor wrapper html attributes.
                'mode' => 'ace/mode/java', // every single default mode must have ace/mode/* prefix
                'theme' => 'ace/theme/cobalt', // every single default theme must have ace/theme/* prefix
                'options_enable_basic_autocompletion' => true,
                'options_enable_live_autocompletion' => true,
                'options_enable_snippets' => true,
                'show_print_margin' => false,
            ))
            ->add('output', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'tinymce', 'rows' => 15]
            ])->getForm();
    }

    /**
     * @Route("/{slug}", name="java_article_view", methods={"GET","POST"})
     */
    public function compile(Request $request, JavaArticle $javaArticle): Response
    {
        $form = $this->getCompilerForm($javaArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $javaArticle = $form->getData();
            $obj = new Executor('java');
            //set compilation path
            $obj->setCompilationPath($this->appKernel->getProjectDir() . '/var/compiler');

            //java
            $java_code = $javaArticle->getCode();
            $className = $javaArticle->getClassName();
            $comp = $obj->compile($java_code, $className);

            if (!is_array($comp)) {
                $javaArticle->setOutput($obj->run($className) . "\n");
            } else {
                $output = "Compilation failed due to following error(s)." . "\n";
                foreach ($comp as $key => $item) {
                    $output .= str_replace('/var/www/html/var/compiler/', '', $item) . "\n";
                }
                $javaArticle->setOutput($output);
            }
            $form = $this->getCompilerForm($javaArticle);
        }

        return $this->render('java_article/view.html.twig', [
            'article' => $javaArticle,
            'form' => $form->createView(),
        ]);
    }
}
