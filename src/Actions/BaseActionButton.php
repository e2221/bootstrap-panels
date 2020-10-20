<?php
declare(strict_types=1);


namespace e2221\Actions;


use e2221\HtmElement\HrefElement;

class BaseActionButton extends HrefElement
{
    public array $attributes = [
        'class'     => 'btn'
    ];

    public string $class = 'btn-xs btn-outline-secondary';
}