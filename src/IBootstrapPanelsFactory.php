<?php


namespace App\Utils\BootstrapComponents\BootstrapPanels;


interface IBootstrapPanelsFactory
{
    /** @return BootstrapPanels */
    function create();
}