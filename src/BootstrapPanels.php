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

    /** @var callable|null */
    protected $beforeRenderCallback=null;

    public function __construct()
    {
        $this->documentTemplates = new Templates($this);
    }

    /**
     * Set before render callback
     * @param callable|null $beforeRenderCallback
     * @return BootstrapPanels
     */
    public function setBeforeRenderCallback(?callable $beforeRenderCallback): self
    {
        $this->beforeRenderCallback = $beforeRenderCallback;
        return $this;
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
     * @param int|null $moveToPosition
     * @return Panel
     */
    public function addPanel(string $id, string $title=null, ?int $moveToPosition=null): Panel
    {
        $this->panels[$id] = new Panel($this, $id, $title);
        if(is_numeric($moveToPosition))
            $this->movePanelPosition($id, $moveToPosition);
        return $this->panels[$id];
    }

    /**
     * Move panel to position [1 = first, 2 = second, ...]
     * @param string $panelID
     * @param int $position
     * @return $this
     */
    public function movePanelPosition(string $panelID, int $position)
    {
        if(count($this->panels) > 0)
        {
            $newState = [];
            $panelToMove = $this->getPanels()[$panelID];
            unset($this->panels[$panelID]);
            $panels = $this->getPanels();
            $used = false;
            foreach(array_keys($panels) as $key => $value)
            {
                if($key+1 == $position){
                    $newState[$panelID] = $panelToMove;
                    $used = true;
                }
                $newState[$value] = $panels[$value];
            }
            if($used === false)
                $newState[$panelID] = $panelToMove;
            $this->panels = $newState;
        }
        return $this;
    }


    /**
     * Set active panel
     * @param string $panel
     * @param bool $throw
     * @return $this
     * @throws UnexistingPannelException
     */
    public function setPanel(string $panel, bool $ignoreNonExisting=false, bool $throw=false): self
    {
        if($ignoreNonExisting === true)
        {
            $this->panel = $panel;
        }else{
            if($this->getPanel($panel, $throw))
            {
                $this->panel = $panel;
            }else{
                $this->setPanelFirst();
            }
        }
        return $this;
    }

    /**
     * Set panel from key
     * @param int $key
     * @return $this
     */
    public function setPanelFromKey(int $key): self
    {
        if(count($this->panels) >= $key+1)
        {
            $this->panel = array_keys($this->panels)[$key];
        }
        return $this;
    }

    /**
     * Set first panel as active
     * @return $this
     */
    public function setPanelFirst(): self
    {
        if(count($this->panels) > 0)
            $this->panel = (string)array_key_first($this->panels);
        return $this;
    }

    /**
     * Set next panel as active
     * @return $this
     */
    public function setPanelNext(): self
    {
        if(count($this->panels) > 0)
        {
            $active = $this->getActivePanel();
            $keys = array_keys($this->panels);
            $activeKey = array_search($active, $keys);
            if(isset($keys[$activeKey+1]))
            {
                $this->panel = $keys[$activeKey+1];
            }else{
                $this->setPanelFirst();
            }
        }
        return $this;
    }

    /**
     * Set previouse panel as active
     * @return $this
     */
    public function setPanelPreviouse(): self
    {
        if(count($this->panels) > 0)
        {
            $active = $this->getActivePanel();
            $keys = array_keys($this->panels);
            $activeKey = array_search($active, $keys);
            if(isset($keys[$activeKey-1]))
            {
                $this->panel = $keys[$activeKey-1];
            }else{
                $this->setPanelFirst();
            }
        }
        return $this;
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
        return $panel->addContent($name, $content);
    }

    /**
     * Get panel
     * @param string $panelId
     * @param bool $throw
     * @return Panel|null
     * @throws UnexistingPannelException
     */
    public function getPanel(string $panelId, bool $throw=true): ?Panel
    {
        if(!isset($this->panels[$panelId]))
        {
            if($throw === true)
                throw new UnexistingPannelException('Panel "' . $panelId . '" does not exist');
            return null;
        }
        return $this->panels[$panelId];
    }

    /**
     * Get active panel instance
     * @return Panel
     */
    public function getActivePanel(): Panel
    {
        if(empty($this->panel) || is_null($this->getPanel($this->panel, false)))
            $this->setPanelFirst();
        return $this->panels[$this->panel];
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
        return $this->getActivePanel()->getContent()[$contentName]->getWrapper();
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

    /**
     * Redraw panels
     */
    public function handleRedrawPanels(): void
    {
        $this->redrawControl('panels');
    }

    /**
     * Before render
     */
    public function beforeRender(): void
    {
        if(is_callable($this->beforeRenderCallback))
            call_user_func($this->beforeRenderCallback, $this);
    }

    /**
     * Renderer
     */
    public function render(): void
    {
        $this->beforeRender();
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
