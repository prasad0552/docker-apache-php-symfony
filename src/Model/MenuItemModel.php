<?php


namespace App\Model;


class MenuItemModel extends \KevinPapst\AdminLTEBundle\Model\MenuItemModel
{
    /**
     * @var string
     */
    protected $isAdmin;

    protected $codeSnippet;

    protected $pdfLink;

    protected $draggable;

    /**
     * @return null
     */
    public function getcodeSnippet()
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
        $pdfLink = false,
        $draggable = false,
        $badgeColor = 'green'
    )
    {
        $this->isAdmin = $isAdmin;
        $this->codeSnippet = $snippet;
        $this->pdfLink = $pdfLink;
        $this->draggable = $draggable;
        parent::__construct($id, $label, $route, $routeArgs, null, null, $badgeColor);
    }

    public function getdraggable()
    {
        return $this->draggable;
    }

    public function getpdfLink()
    {
        return $this->pdfLink;
    }

    public function getisAdmin()
    {
        return $this->isAdmin;
    }
}
