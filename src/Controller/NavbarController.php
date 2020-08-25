<?php


namespace App\Controller;


use KevinPapst\AdminLTEBundle\Event\NavbarUserEvent;
use KevinPapst\AdminLTEBundle\Event\ShowUserEvent;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends \KevinPapst\AdminLTEBundle\Controller\NavbarController
{
    /**
     * @return Response
     */
    public function userAction(): Response
    {
        if (!$this->hasListener(NavbarUserEvent::class)) {
            return new Response();
        }

        /** @var ShowUserEvent $userEvent */
        $userEvent = $this->dispatch(new NavbarUserEvent());

        if ($userEvent instanceof ShowUserEvent && null !== $userEvent->getUser()) {
            return $this->render(
                'Navbar/user.html.twig',
                [
                    'user' => $userEvent->getUser(),
                    'links' => $userEvent->getLinks(),
                    'showProfileLink' => $userEvent->isShowProfileLink(),
                    'showLogoutLink' => $userEvent->isShowLogoutLink(),
                ]
            );
        } else {
            return $this->render('Navbar/loginactions.html.twig');
        }

        return new Response();
    }
}
