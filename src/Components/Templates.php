<?php


namespace e2221\BootstrapPanels\Components;


class Templates
{

    private BodyTemplate $bodyTemplate;
    /**
     * @var BodyHeaderTemplate
     */
    private BodyHeaderTemplate $bodyHeaderTemplate;
    /**
     * @var BodyHeaderTabsTemplate
     */
    private BodyHeaderTabsTemplate $bodyHeaderTabsTemplate;
    /**
     * @var BodyHeaderTabsItemsTemplate
     */
    private BodyHeaderTabsItemsTemplate $bodyHeaderTabsItemsTemplate;
    /**
     * @var BodyHeaderTabsItemsLinks
     */
    private BodyHeaderTabsItemsLinks $bodyHeaderTabsLinksTemplate;
    /**
     * @var BodyHeaderTabsAllTemplate
     */
    private BodyHeaderTabsAllTemplate $bodyHeaderTabsAllTemplate;
    /**
     * @var BodyBodyTemplate
     */
    private BodyBodyTemplate $bodyBodyTemplate;

    public function __construct()
    {
        $this->bodyTemplate = new BodyTemplate();
        $this->bodyHeaderTemplate = new BodyHeaderTemplate();
        $this->bodyHeaderTabsTemplate = new BodyHeaderTabsTemplate();
        $this->bodyHeaderTabsItemsTemplate = new BodyHeaderTabsItemsTemplate();
        $this->bodyHeaderTabsLinksTemplate = new BodyHeaderTabsItemsLinks();
        $this->bodyHeaderTabsAllTemplate = new BodyHeaderTabsAllTemplate();
        $this->bodyBodyTemplate = new BodyBodyTemplate();
    }

    /**
     * @return BodyTemplate
     */
    public function getBodyTemplate(): BodyTemplate
    {
        return $this->bodyTemplate;
    }

    /**
     * @return BodyHeaderTemplate
     */
    public function getBodyHeaderTemplate(): BodyHeaderTemplate
    {
        return $this->bodyHeaderTemplate;
    }

    /**
     * @return BodyHeaderTabsTemplate
     */
    public function getBodyHeaderTabsTemplate(): BodyHeaderTabsTemplate
    {
        return $this->bodyHeaderTabsTemplate;
    }

    /**
     * @return BodyHeaderTabsItemsTemplate
     */
    public function getBodyHeaderTabsItemsTemplate(): BodyHeaderTabsItemsTemplate
    {
        return $this->bodyHeaderTabsItemsTemplate;
    }

    /**
     * @return BodyHeaderTabsItemsLinks
     */
    public function getBodyHeaderTabsLinksTemplate(): BodyHeaderTabsItemsLinks
    {
        return clone $this->bodyHeaderTabsLinksTemplate;
    }

    /**
     * @return BodyHeaderTabsAllTemplate
     */
    public function getBodyHeaderTabsAllTemplate(): BodyHeaderTabsAllTemplate
    {
        return $this->bodyHeaderTabsAllTemplate;
    }

    /**
     * @return BodyBodyTemplate
     */
    public function getBodyBodyTemplate(): BodyBodyTemplate
    {
        return $this->bodyBodyTemplate;
    }


}