<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Header;
use App\Models\PersonalAccount;

class PersonalAccountController extends Controller
{
    public function personalaccount()
    {
        $data = PersonalAccount::query()->firstOrFail();
        $data = $this->translateModelWithoutIdAndTime($data);

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'header' => Header::getData(),
            'footer' => Footer::getData(),
        ]);
    }
}
