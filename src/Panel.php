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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Content[]
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
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
        if($content instanceof IComponent)
            $this->bootstrapPanels->addComponent($content, $name);
        return $this->content[$name] = new Content($this, $name, $content);
    }

    public function render()
    {
        $render = [];
        foreach($this->content as $contentName => $content)
        {
             $render[] = $content->render();
        }
        return implode("",$render);
    }


}