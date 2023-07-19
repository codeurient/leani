<?php

namespace App\Services\Cactus;

use App\Http\Requests\CactusTariffsRequest;

class CactusService
{
    protected string $apiUrl;
    private string $authToken = '';
    private string $shopID = '';

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        if (app()->environment('production')) {
            $this->apiUrl = 'https://app.kak2c.ru';
        } else {
            $this->apiUrl = 'https://app-test.kak2c.ru';
        }
        $this->apiUrl = 'https://app.kak2c.ru';
        $this->shopID = config('cactus.shop_id');

        $this->makeAuth();
    }

    /**
     * @throws \Exception
     */
    private function makeAuth()
    {
        $response = $this->initRequest()->post($this->apiUrl . '/api/lite/auth', [
            'login' => config('cactus.login'),
            'password' => config('cactus.password'),
        ]);

        if (!$response->successful() or !$response->json()) {
            throw new \Exception('Auth failed at kak2c.ru - check login data');
        }

        $this->authToken = $response->json('access_token');
    }

    protected function initRequest(): \Illuminate\Http\Client\PendingRequest
    {
        $request = \Http::acceptJson()->contentType('application/json');
        if ($this->authToken) $request->withHeaders([
            'Authorization' => 'Bearer ' . $this->authToken,
            'Domain' => 'shop' . $this->shopID,
        ]);
        return $request;
    }

    public function tariffs(CactusTariffsRequest $request)
    {
        $response = $this->initRequest()->post($this->apiUrl . '/api/lite/tariffs', [
            'fromTempoline' => false,
            'sourceRegionFias' => null,
            'sourceAreaFias' => null,
            'sourceCityFias' => null,
            'sourceSettlementFias' => null,
            'sourcePostalCode' => null,
            'regionFias' => $request->region_fias,
            'areaFias' => $request->area_fias,
            'cityFias' => $request->city_fias,
            'settlementFias' => $request->settlement_fias,
            'postalCode' => $request->postal_code,
            'weight' => $request->weight,
            'insuranceSum' => $request->insurance_sum, // оценочная стоимость товара для расчета суммы страховки
            'codSum' => $request->cod_sum, // сумма наложенного платежа, которую курьерская компания возьмёт с покупателя, следует передавать стоимость доставки + стоимость товаров в случае если оплата при получении.
        ]);

        if (!$response->successful()) {
            throw new \Exception('Failed to fetch tariffs' . $response->json());
        }

        return $response->json();
    }
}
