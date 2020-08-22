<?php

namespace App\Controller;

use App\Entity\JavaArticleCategory;
use App\Form\JavaArticleCategoryType;
use App\Repository\JavaArticleCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/java/article/category")
 */
class JavaArticleCategoryController extends AbstractController
{
    /**
     * @Route("/", name="java_article_category_index", methods={"GET"})
     */
    public function index(JavaArticleCategoryRepository $javaArticleCategoryRepository): Response
    {
        return $this->render('java_article_category/index.html.twig', [
            'java_article_categories' => $javaArticleCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="java_article_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $javaArticleCategory = new JavaArticleCategory();
        $form = $this->createForm(JavaArticleCategoryType::class, $javaArticleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($javaArticleCategory);
            $entityManager->flush();

            return $this->redirectToRoute('java_article_category_index');
        }

        return $this->render('java_article_category/new.html.twig', [
            'java_article_category' => $javaArticleCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="java_article_category_show", methods={"GET"})
     */
    public function show(JavaArticleCategory $javaArticleCategory): Response
    {
        return $this->render('java_article_category/show.html.twig', [
            'java_article_category' => $javaArticleCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="java_article_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, JavaArticleCategory $javaArticleCategory): Response
    {
        $form = $this->createForm(JavaArticleCategoryType::class, $javaArticleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('java_article_category_index');
        }

        return $this->render('java_article_category/edit.html.twig', [
            'java_article_category' => $javaArticleCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="java_article_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, JavaArticleCategory $javaArticleCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$javaArticleCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($javaArticleCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('java_article_category_index');
    }
}
