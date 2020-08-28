<?php
declare(strict_types=1);

namespace e2221\BootstrapPanels;

use e2221\HtmElement\BaseElement;
use Nette\ComponentModel\IComponent;
use Nette\Utils\Html;

class Content
{
    /** @var string Name id of content */
    protected string $name;

    /** @var BaseElement|IComponent|Html|string  */
    protected $content;

    /** @var Html|BaseElement|null */
    protected $wrapper;

    /**
     * Content constructor.
     * @param string $name
     * @param string|IComponent|Html|BaseElement $content
     */
    public function __construct(string $name, $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * Get wrapper
     * @return BaseElement|Html|null
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }

    /**
     * Wrapper of this content
     * @param $wrapper
     * @return Content
     */
    public function setWrapper($wrapper): Content
    {
        $this->wrapper = $wrapper;
        return $this;
    }

    public function render()
    {
        return $this->content instanceof IComponent ? $this->content->render() : $this->content;
    }

}