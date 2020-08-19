<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Repository\JavaArticleRepository;
use Doctrine\ORM\EntityManager;
use KevinPapst\AdminLTEBundle\Event\BreadcrumbMenuEvent;
use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use KevinPapst\AdminLTEBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class MenuBuilder configures the main navigation.
 */
class MenuBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;

    protected $javaArticleRepository;

    /**
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(AuthorizationCheckerInterface $security, JavaArticleRepository $javaArticleRepository)
    {
        $this->security = $security;
        $this->javaArticleRepository = $javaArticleRepository;
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

    /**
     * Generate the main menu.
     *
     * @param SidebarMenuEvent $event
     */
    public function onSetupNavbar(SidebarMenuEvent $event)
    {
        $language = new MenuItemModel('java', 'Java', null, [], 'far fa-arrow-alt-circle-right');

        $javaCategory1 = new MenuItemModel('java-sub-category-1', 'Basics', null, [], 'far fa-arrow-alt-circle-right');
        $language->addChild($javaCategory1);
        $articles = $this->javaArticleRepository
            ->createQueryBuilder('java_article')
            ->andWhere('java_article.id IN (:ids)')
            ->setParameter('ids', [1,2])
            ->getQuery()
            ->getArrayResult();

        usort($articles, function ($item1, $item2) {
            return $item1['sort_order'] <=> $item2['sort_order'];
        });

        foreach ($articles as $article) {
            $javaCategory1->addChild(new MenuItemModel($article['slug'], $article['title'], 'java_article_view', ['id' => $article['id']]));
        }

        $javaCategory2 = new MenuItemModel('java-sub-category-2', 'Methods', null, [], 'far fa-arrow-alt-circle-right');
        $article = current($articles);
        $javaCategory2->addChild(new MenuItemModel($article['slug'], 'Methods', 'java_article_view', ['id' => $article['id']]));
        $language->addChild($javaCategory2);

        $javaCategory3 = new MenuItemModel('java-sub-category-3', 'Classes', null, [], 'far fa-arrow-alt-circle-right');
        $article = current($articles);
        $javaCategory3->addChild(new MenuItemModel($article['slug'], 'OOP', 'java_article_view', ['id' => $article['id']]));

        $language->addChild($javaCategory3);

        $event->addItem($language);

        if ($this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $event->addItem(
                new MenuItemModel('logout', 'Logout', 'logout', [], 'fas fa-sign-out-alt')
            );
        } else {
            $event->addItem(
                new MenuItemModel('login', 'Login', 'login', [], 'fas fa-sign-in-alt')
            );
        }

        $this->activateByRoute(
            $event->getRequest()->get('_route'),
            $event->getItems()
        );
    }

    /**
     * @param string $route
     * @param MenuItemModel[] $items
     */
    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } elseif ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }
    }
}
