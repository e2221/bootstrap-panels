<?php


namespace e2221\BootstrapPanels\Components;


use e2221\BootstrapPanels\BootstrapPanels;

class Templates
{
    private BodyTemplate $bodyTemplate;
    private BodyHeaderTemplate $bodyHeaderTemplate;
    private BodyHeaderTabsTemplate $bodyHeaderTabsTemplate;
    private BodyHeaderTabsItemsTemplate $bodyHeaderTabsItemsTemplate;
    private BodyHeaderTabsItemsLinks $bodyHeaderTabsLinksTemplate;
    private BodyHeaderTabsAllTemplate $bodyHeaderTabsAllTemplate;
    private BodyBodyTemplate $bodyBodyTemplate;
    private HeaderRightContent $headerRightContent;

    public function __construct(BootstrapPanels $bootstrapPanels)
    {
        $this->bodyTemplate = new BodyTemplate();
        $this->bodyHeaderTemplate = new BodyHeaderTemplate();
        $this->bodyHeaderTabsTemplate = new BodyHeaderTabsTemplate();
        $this->bodyHeaderTabsItemsTemplate = new BodyHeaderTabsItemsTemplate();
        $this->bodyHeaderTabsLinksTemplate = new BodyHeaderTabsItemsLinks();
        $this->bodyHeaderTabsAllTemplate = new BodyHeaderTabsAllTemplate();
        $this->bodyBodyTemplate = new BodyBodyTemplate();
        $this->headerRightContent = new HeaderRightContent($bootstrapPanels);
    }

    /**
     * Get body template
     * @return BodyTemplate
     */
    public function getBodyTemplate(): BodyTemplate
    {
        return $this->bodyTemplate;
    }

    /**
     * Get header right content
     * @return HeaderRightContent
     */
    public function getHeaderRightContent(): HeaderRightContent
    {
        return $this->headerRightContent;
    }

    /**
     * Get body header template
     * @return BodyHeaderTemplate
     */
    public function getBodyHeaderTemplate(): BodyHeaderTemplate
    {
        return $this->bodyHeaderTemplate;
    }

    /**
     * Get body header tabs template
     * @return BodyHeaderTabsTemplate
     */
    public function getBodyHeaderTabsTemplate(): BodyHeaderTabsTemplate
    {
        return $this->bodyHeaderTabsTemplate;
    }

    /**
     * Get body header tabs items template
     * @return BodyHeaderTabsItemsTemplate
     */
    public function getBodyHeaderTabsItemsTemplate(): BodyHeaderTabsItemsTemplate
    {
        return $this->bodyHeaderTabsItemsTemplate;
    }

    /**
     * Get body header tabs links template
     * @return BodyHeaderTabsItemsLinks
     */
    public function getBodyHeaderTabsLinksTemplate(): BodyHeaderTabsItemsLinks
    {
        return clone $this->bodyHeaderTabsLinksTemplate;
    }

    /**
     * Get body header tabs all template
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