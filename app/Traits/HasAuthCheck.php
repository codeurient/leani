<?php


namespace App\Traits;


trait HasAuthCheck
{
    private ?int $customer_id;

    public function __construct()
    {
        $this->customer_id = auth('api')->check() ? auth('api')->user()->id : null;
    }
}
