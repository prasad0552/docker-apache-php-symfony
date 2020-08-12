<?php

namespace App\Controller;

use App\Compiler\Executor;
use App\Entity\JavaArticle;
use App\Form\JavaArticleType;
use App\Repository\JavaArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/java/article")
 */
class JavaArticleController extends AbstractController
{
    /** KernelInterface $appKernel */
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    /**
     * @Route("/", name="java_article_index", methods={"GET"})
     */
    public function index(JavaArticleRepository $javaArticleRepository): Response
    {
        return $this->render('java_article/index.html.twig', [
            'java_articles' => $javaArticleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="java_article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $javaArticle = new JavaArticle();
        $form = $this->createForm(JavaArticleType::class, $javaArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($javaArticle);
            $entityManager->flush();

            return $this->redirectToRoute('java_article_index');
        }

        return $this->render('java_article/new.html.twig', [
            'java_article' => $javaArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="java_article_show", methods={"GET"})
     */
    public function show(JavaArticle $javaArticle): Response
    {
        return $this->render('java_article/show.html.twig', [
            'java_article' => $javaArticle,
        ]);
    }

    /**
     * @param $javaArticle
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getComplierForm($javaArticle)
    {
        return $this->createFormBuilder($javaArticle)
            ->add('language', ChoiceType::class, ['choices' => ['Java' => 'java']])
            ->add('code', TextareaType::class, ['attr' => ['class' => 'tinymce']])
            ->add('input', TextareaType::class, [
                'required' => false,
            ])
            ->add('output', TextareaType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Run Code'])
            ->getForm();
    }

    /**
     * @Route("/{id}/compile", name="java_article_view", methods={"GET","POST"})
     */
    public function view(Request $request, JavaArticle $javaArticle): Response
    {
        $form = $this->getComplierForm($javaArticle);

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
            $javaArticle->setOutput("Compilation : " . (!is_array($comp) ? "Success" : "Fail") . "\n" .
                "Output : " . (!is_array($comp) ? $obj->run($className) : "Fail") . "\n");
            $form = $this->getComplierForm($javaArticle);
        }

        return $this->render('java_article/view.html.twig', [
            'java_article' => $javaArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="java_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, JavaArticle $javaArticle): Response
    {
        $form = $this->createForm(JavaArticleType::class, $javaArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('java_article_index');
        }

        return $this->render('java_article/edit.html.twig', [
            'java_article' => $javaArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="java_article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, JavaArticle $javaArticle): Response
    {
        if ($this->isCsrfTokenValid('delete' . $javaArticle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($javaArticle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('java_article_index');
    }
}
