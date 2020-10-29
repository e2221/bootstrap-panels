<?php
declare(strict_types=1);

namespace e22221\BootstrapPanels;

use e2221\BootstrapPanels\BootstrapPanels;
use e2221\BootstrapPanels\Content;
use e2221\HtmElement\BaseElement;
use Nette\ComponentModel\IComponent;
use Nette\Utils\Html;

class Panel
{
    /** @var string Panel id */
    protected string $id;

    /** @var string|null Panel title */
    protected string $title;

    /** @var Html|BaseElement|null Wrapper of  */
    protected $contentWrapper=null;

    /** @var Content[] */
    protected array $content=[];
    /**
     * @var BootstrapPanels
     */
    private BootstrapPanels $bootstrapPanels;


    public function __construct(BootstrapPanels $bootstrapPanels, string $id, ?string $title=null)
    {
        $this->id = $id;
        $this->title = $title ?? $id;
        $this->bootstrapPanels = $bootstrapPanels;
    }

    /**
     * Get panel title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get panel id
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get panel content
     * @return Content[]
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * Get content wrapper
     * @return BaseElement|Html|null
     */
    public function getContentWrapper()
    {
        return $this->contentWrapper;
    }

    /**
     * Set Content wrapper
     * @param Html|BaseElement $contentWrapper
     * @return Panel
     */
    public function setContentWrapper($contentWrapper): Panel
    {
        $this->contentWrapper = $contentWrapper;
        return $this;
    }

    /**
     * Add Content
     * @param string $name
     * @param $content
     * @return Content
     */
    public function addContent(string $name, $content): Content
    {
        if($content instanceof IComponent && is_null($content->getPresenterIfExists()))
            $this->bootstrapPanels->addComponent($content, $name);
        return $this->content[$name] = new Content($this, $name, $content);
    }

    /**
     * Render panel
     * @return string
     */
    public function render()
    {
        $render = [];
        foreach($this->content as $contentName => $content)
        {
            $render[] = $content->render();
        }
        return implode("",$render);
    }

    /**
     * End panel - go back to bootstrap panels main class
     * @return BootstrapPanels
     */
    public function endPanel(): BootstrapPanels
    {
        return $this->bootstrapPanels;
    }


}