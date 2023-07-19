<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Footer;
use App\Models\Header;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $data=Checkout::query()->firstOrFail();
        $data = $this->translateModelWithoutIdAndTime($data);

        return response()->json([
            'status'=>'success',
            'data'=>$data,
            'header' => Header::getData(),
            'footer' => Footer::getData(),
        ]);

    }
}
