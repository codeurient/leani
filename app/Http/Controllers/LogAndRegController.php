<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Header;
use App\Models\LogAndReg;
use Illuminate\Http\Request;

class LogAndRegController extends Controller
{
    public function logandreg()
    {

        $data=LogAndReg::query()->firstOrFail();
        $data = $this->translateModelWithoutIdAndTime($data);

        return response()->json([
            'status'=>'success',
            'data'=>$data,
            'header' => Header::getData(),
            'footer' => Footer::getData(),
        ]);

    }
}
