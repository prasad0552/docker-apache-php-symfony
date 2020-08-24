<?php


namespace App\Controller;

use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SidebarController extends \KevinPapst\AdminLTEBundle\Controller\SidebarController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function menuAction(Request $request): Response
    {
        if (!$this->hasListener(SidebarMenuEvent::class)) {
            return new Response();
        }

        /** @var SidebarMenuEvent $event */
        $event = $this->dispatch(new SidebarMenuEvent($request));

        return $this->render(
            'sidebar/menu.html.twig',
            [
                'menu' => $event->getItems(),
            ]
        );
    }
}
