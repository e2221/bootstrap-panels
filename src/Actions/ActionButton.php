<?php
declare(strict_types=1);


namespace e2221\Actions;


class ActionButton extends BaseActionButton
{
    /** @var string  */
    private string $name;

    public function __construct(string $name, ?string $title=null)
    {
        parent::__construct();
        $this->name = $name;
        $this->title = $title;
        $this->textContent = $title;
    }
}