<?php


namespace App\Model;


class MenuItemModel extends \KevinPapst\AdminLTEBundle\Model\MenuItemModel
{
    /**
     * @var string
     */
    protected $isAdmin;

    public function __construct(
        $id,
        $label,
        $route,
        $routeArgs = [],
        $isAdmin = false,
        $icon = false,
        $badge = false,
        $badgeColor = 'green'
    )
    {
        $this->isAdmin = $isAdmin;
        parent::__construct($id, $label, $route, $routeArgs, $icon, $badge, $badgeColor);
    }

    public function getisAdmin()
    {
        return $this->isAdmin;
    }
}
