<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    public function header(){

        $data=Header::query()->firstOrFail();
        $dataNew = null;
        $dataNew = $this->translateModelWithoutIdAndTime($data);


        return response()->json([
            'status'=>'success',
            'data'=>$dataNew
        ]);
    }
}
