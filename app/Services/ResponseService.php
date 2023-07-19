<?php


namespace App\Services;


use App\Models\Customer;
use App\Models\Footer;
use App\Models\Header;

class ResponseService
{
    public static function error($errors = [], $message = '', $status = 422)
    {
        return response([
            'message' => $message,
            'errors' => $errors
        ], $status);
    }

    public static function authSuccess($accessToken, Customer $customer)
    {
        return response([
            'status' => 'success',
            'accessToken' => $accessToken,
            'client' => $customer,
        ]);
    }

    public static function successWithHeaderFooter($data)
    {
        return response([
            'status' => 'success',
            'киты?' => '🐋💨',
            'data' => $data,
            'header' => Header::getData(),
            'footer' => Footer::getData(),
        ]);
    }

    public static function success($data)
    {
        return response([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
