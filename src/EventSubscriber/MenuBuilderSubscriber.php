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
        $event->addItem(
            new MenuItemModel('homepage', 'Homepage', 'homepage', [], 'fas fa-tachometer-alt')
        );

        $event->addItem(
            new MenuItemModel('context', 'Context', 'context', [], 'fas fa-code')
        );

        $demo = new MenuItemModel('java', 'Java', null, [], 'far fa-arrow-alt-circle-right');
        $demo->setBadge('New Courses');

        $articles = $this->javaArticleRepository->createQueryBuilder('java_article')->getQuery()->getArrayResult();

        foreach ($articles as $article) {
            $demo->addChild(new MenuItemModel($article['slug'], $article['title'], 'java_article_view', ['id' => $article['id']]));
        }

        $event->addItem($demo);

        $event->addItem(
                new MenuItemModel('compiler', 'Compiler', 'compiler', [], 'fas fa-terminal')
        );

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