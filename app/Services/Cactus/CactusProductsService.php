<?php


namespace App\Services\Cactus;


class CactusProductsService extends CactusService
{
    public function productsList()
    {
        $response = $this->initRequest()->get($this->apiUrl . '/api/lite/products');

        return $response->json();
    }
}
