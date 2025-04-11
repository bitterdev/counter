<?php

namespace Concrete\Package\Counter\Block\Counter;

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{
    protected $btTable = 'btCounter';
    protected $btInterfaceWidth = 400;
    protected $btInterfaceHeight = 500;

    public function getBlockTypeDescription(): string
    {
        return t("Display animated numbers on your website.");
    }

    public function getBlockTypeName(): string
    {
        return t("Counter");
    }

    public function add()
    {
        $this->set("duration", null);
        $this->set("value", null);
        $this->set("description", null);
    }

}
