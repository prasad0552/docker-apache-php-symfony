<?php


namespace App\Model;


class MenuItemModel extends \KevinPapst\AdminLTEBundle\Model\MenuItemModel
{
    /**
     * @var string
     */
    protected $isAdmin;

    protected $codeSnippet;

    /**
     * @return null
     */
    public function getCodeSnippet()
    {
        return $this->codeSnippet;
    }

    public function __construct(
        $id,
        $label,
        $route,
        $routeArgs = [],
        $isAdmin = false,
        $snippet = null,
        $icon = false,
        $badge = false,
        $badgeColor = 'green'
    )
    {
        $this->isAdmin = $isAdmin;
        $this->codeSnippet = $snippet;
        parent::__construct($id, $label, $route, $routeArgs, $icon, $badge, $badgeColor);
    }

    public function getisAdmin()
    {
        return $this->isAdmin;
    }
}
