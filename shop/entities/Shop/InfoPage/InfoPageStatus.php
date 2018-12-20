<?php

namespace shop\entities\Shop\InfoPage;

class InfoPageStatus
{
    const PAGE_OTHER = 0;
    const PAGE_MAIN = 1;
    const PAGE_CONTACT = 2;
    const PAGE_ABOUT = 3;

    public $value;
    public $created_at;

    public function __construct($value, $created_at)
    {
        $this->value = $value;
        $this->created_at = $created_at;
    }
}