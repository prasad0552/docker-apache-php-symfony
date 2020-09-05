<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Repository\JavaArticleCategoryRepository;
use App\Repository\JavaArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use KevinPapst\AdminLTEBundle\Event\BreadcrumbMenuEvent;
use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use App\Model\MenuItemModel;
use Proxies\__CG__\App\Entity\JavaArticleCategory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Twig\Error\RuntimeError;

/**
 * Class MenuBuilder configures the main navigation.
 */
class MenuBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;

    /**
     * @var JavaArticleCategoryRepository
     */
    protected $categoryRepository;

    /**
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(AuthorizationCheckerInterface $security, JavaArticleCategoryRepository $categoryRepository)
    {
        $this->security = $security;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SidebarMenuEvent::class => ['onSetupNavbar', 100],
            BreadcrumbMenuEvent::class => ['onSetupNavbar', 100],
        ];
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    /**
     * Generate the main menu.
     *
     * @param SidebarMenuEvent $event
     */
    public function onSetupNavbar(SidebarMenuEvent $event)
    {
        try {
            if ($this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                if ($this->security->isGranted('ROLE_USER')) {
                    $language = new MenuItemModel('java-curriculum', 'Java Curriculum', null, [], false, null, '/assets/files/Adults - Java Curriculum.pdf');
                    /**
                     * @var \App\Entity\JavaArticleCategory[] $categories
                     */
                    $categories = $this->categoryRepository->createQueryBuilder('category')
                        ->andWhere('category.status = :status')
                        ->setParameter('status', 1)
                        ->addOrderBy('category.sort_order')
                        ->getQuery()
                        ->execute();

                    foreach ($categories as $category) {
                        $categoryItem = new MenuItemModel($this->slugify($category->getName()), $category->getName(), null);
                        $articles = $category->getActiveJavaArticles();
                        if ($articles->isEmpty()) {
                            continue;
                        }

                        foreach ($articles as $article) {
                            $categoryItem->addChild(new MenuItemModel($article->getSlug(), $article->getTitle(), 'java_article_view', ['slug' => $article->getSlug()], false, $article->getCodeSnippet(), false, $article->getIsDraggable()));
                        }
                        $language->addChild($categoryItem);
                    }

                    $event->addItem($language);
                }

                if ($this->security->isGranted('ROLE_ADMIN')) {
                    $admin = new MenuItemModel('admin', 'Manage Curriculum', null, [], true);
                    $admin->addChild(new MenuItemModel('categories', 'Categories', 'java_article_category_index'));
                    $admin->addChild(new MenuItemModel('articles', 'Topics', 'java_article_index'));

                    $event->addItem($admin);
                }
            }

            $this->activateByRoute(
                $event->getRequest()->get('_route'),
                $event->getRequest()->attributes->get('_route_params'),
                $event->getItems()
            );
        } catch (RuntimeError $exception) {

        } catch (RouteNotFoundException $exception) {

        }
    }

    /**
     * @param string $route
     * @param [] $items
     * @param MenuItemModel[] $items
     */
    protected function activateByRoute($route, $attributes, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $attributes, $item->getChildren());
            } elseif ($item->getRoute() == $route && $attributes == $item->getRouteArgs()) {
                $item->setIsActive(true);
            }
        }
    }
}
