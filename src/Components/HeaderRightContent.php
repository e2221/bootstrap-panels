<?php
declare(strict_types=1);


namespace e2221\BootstrapPanels\Components;

use e2221\BootstrapPanels\BootstrapPanels;
use e2221\HtmElement\BaseElement;
use Nette\Utils\Html;

class HeaderRightContent extends BaseElement
{
    protected ?string $elName = 'div';

    private BootstrapPanels $bootstrapPanels;

    public function __construct(BootstrapPanels $bootstrapPanels)
    {
        parent::__construct();
        $this->bootstrapPanels = $bootstrapPanels;
    }

    public function render(): ?Html
    {
        $countOfActionButtons = count($this->bootstrapPanels->getActionButtons());
        if($countOfActionButtons == 0)
            return null;

        $el = BaseElement::getStatic('div', ['class' => 'float-right']);
        $wrapper = BaseElement::getStatic();

        if($countOfActionButtons > 1)
        {
            $wrapper->setElName('div');
            $wrapper->setAttributes([
                'class'     => 'btn-group',
                'role'      => 'group'
            ]);
        }

        foreach($this->bootstrapPanels->getActionButtons() as $key => $button)
            $wrapper->addElement($button);

        $el->addElement($wrapper);
        $this->addElement($el);
        return parent::render();
    }
}