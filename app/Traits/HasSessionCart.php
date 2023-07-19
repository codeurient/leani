<?php


namespace App\Traits;


trait HasSessionCart
{
    public function validateResolved()
    {
        parent::validateResolved();

        if(!is_array($this->session_cart)) $this->session_cart = [];
    }
}
