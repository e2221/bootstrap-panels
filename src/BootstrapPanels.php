<?php
declare(strict_types=1);

namespace e2221\BootstrapPanels;

use e2221\Actions\ActionButton;
use e2221\BootstrapPanels\Components\Templates;
use e2221\BootstrapPanels\Exceptions\UnexistingPannelException;
use e2221\HtmElement\BaseElement;
use e22221\BootstrapPanels\Panel;
use Exception;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\ComponentModel\IComponent;
use Nette\Utils\Html;

class BootstrapPanels extends Control
{
    protected array $templates = [];

    /** @var BaseElement|Html|string|null */
    protected $panelTitle=null;

    /** @var Panel[]  */
    protected array $panels=[];

    /** @var ActionButton[] */
    protected array $actionButtons=[];

    /** @var string @persistent */
    public string $panel='';

    /** @var Templates Document templates */
    private Templates $documentTemplates;

    public function __construct()
    {
        $this->documentTemplates = new Templates($this);
    }

    /**
     * Get document templates
     * @return Templates
     */
    public function getDocumentTemplates(): Templates
    {
        return $this->documentTemplates;
    }

    /**
     * Get action buttons
     * @return ActionButton[]
     */
    public function getActionButtons(): array
    {
        return $this->actionButtons;
    }

    /**
     * Add action button
     * @param string $name
     * @param string|null $title
     * @return ActionButton
     */
    public function addActionButton(string $name, ?string $title=null)
    {
        return $this->actionButtons[] = new ActionButton($name, $title);
    }

    /**
     * @param BaseElement|Html|string|null $title
     * @return BootstrapPanels
     */
    public function setTitle($title): BootstrapPanels
    {
        $this->panelTitle = $title;
        return $this;
    }

    /**
     * Get panel title
     * @return BaseElement|Html|string
     */
    public function getTitle()
    {
        if(is_null($this->panelTitle))
            return null;
        if(!$this->panelTitle instanceof BaseElement && !$this->panelTitle instanceof Html)
        {
            $this->panelTitle = BaseElement::getStatic()->setTextContent($this->panelTitle);
        }
        return $this->panelTitle;
    }

    /**
     * Add Panel
     * @param string $id
     * @param string|null $title
     * @return Panel
     */
    public function addPanel(string $id, string $title=null): Panel
    {
        return $this->panels[$id] = new Panel($this, $id, $title);
    }

    /**
     * Add content to panel (primary for add IComponent content)
     * @param string $panelId
     * @param $name
     * @param $content
     * @return Content
     * @throws UnexistingPannelException
     */
    public function addContent(string $panelId, $name, $content): Content
    {
        $panel = $this->getPanel($panelId);
        if($content instanceof IComponent)
            $this->addComponent($content, $name);
        return $panel->addContent($name, $content);
    }

    /**
     * Get panel
     * @param string $panelId
     * @return Panel
     * @throws UnexistingPannelException
     */
    public function getPanel(string $panelId): Panel
    {
        if(!isset($this->panels[$panelId]))
            throw new UnexistingPannelException('Panel "' . $panelId . '" does not exist');
        return $this->panels[$panelId];
    }

    /**
     * Get active panel instance
     * @return Panel
     */
    public function getActivePanel(): Panel
    {
        return $this->panels[empty($this->panel) ? array_key_first($this->panels) : $this->panel];
    }

    /**
     * Get all panels
     * @return Panel[]
     */
    public function getPanels(): array
    {
        return $this->panels;
    }

    /**
     * Get active panel content
     * @return Content[]
     */
    public function getActivePanelContent(): array
    {
        return $this->getActivePanel()->getContent();
    }

    /**
     * Get active panel wrapper
     * @return BaseElement|Html|null
     */
    public function renderActivePanelWrapper()
    {
        $panel = $this->panels[empty($this->panel) ? array_key_first($this->panels) : $this->panel];
        return $panel->getContentWrapper();
    }

    /**
     * Get content wrapper
     * @param string $contentName
     * @return BaseElement|Html|null
     */
    public function renderContentWrapper(string $contentName)
    {
        return
            $this->getActivePanel()->getContent()[$contentName]->getWrapper();
    }

    /**
     * Add custom template
     * @param $templatePath
     * @throws Exception
     */
    public function addTemplate($templatePath): void
    {
        if (!file_exists($templatePath)) {
            throw new Exception("Template '{$templatePath}' does not exist.");
        }
        $this->templates[] = $templatePath;
    }

    public function getTemplates(): array
    {
        $templates = $this->templates;
        $templates[] = __DIR__ . '/BootstrapPanels.blocks.latte';
        return $templates;
    }

    public function handleRedrawPanels(): void
    {
        $this->redrawControl('panels');
    }

    public function redrawHeader(): void
    {
        parent::redrawControl('panels');
        $this->redrawControl('header');
    }

    public function redrawBody(): void
    {
        parent::redrawControl('panels');
        $this->redrawControl('body');
    }

    public function render(): void
    {
        $this->template->documentTemplates = $this->getDocumentTemplates();
        $this->template->templates = $this->getTemplates();
        $this->template->panels = $this->panels;
        $this->template->panel = $this->getActivePanel();
        $this->template->setFile(__DIR__ . '/BootstrapPanels.latte');
        $this->template->render();
    }

}

class BootstrapPanelsTemplate extends Template
{
    public BootstrapPanels $control;
    public array $templates;
    public array $panels=[];
    public Panel $panel;
    public Templates $documentTemplates;
}
