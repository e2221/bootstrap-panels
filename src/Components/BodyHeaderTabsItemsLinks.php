<?php


namespace e2221\BootstrapPanels\Components;


use e2221\HtmElement\HrefElement;
use Nette\Utils\Html;

class BodyHeaderTabsItemsLinks extends HrefElement
{
    public array $attributes = ['class' => 'nav-link'];

    /** @var bool Is this link active? */
    public bool $isActive=false;

    /** @var string Active class */
    public string $activeClass = 'active font-weight-bold';

    /**
     * Set link active
     * @param bool $active
     * @return $this
     */
    public function setActive(bool $active=true): BodyHeaderTabsItemsLinks
    {
        $this->isActive = $active;
        return $this;
    }

    /**
     * Set custom active class
     * @param string $class
     * @return $this
     */
    public function setActiveClass(string $class): BodyHeaderTabsItemsLinks
    {
        $this->activeClass = $class;
        return $this;
    }

    public function render(): ?Html
    {
        if($this->isActive)
            $this->setClass($this->activeClass);
        return parent::render();
    }
}