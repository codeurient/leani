<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Header;
use App\Models\ThanksPage;
use Illuminate\Http\Request;

class ThanksPageController extends Controller
{
    public function thankspage()
    {

        $data=ThanksPage::query()->firstOrFail();
        $data = $this->translateModelWithoutIdAndTime($data);

        foreach ($data['blocks'] as $key => $block)
        {
            $data['blocks'][$key]['attributes']['photo'] = $this->getOneMedia($block['attributes']['photo']);
        }
        unset($key,$block);


        return response()->json([
            'status'=>'success',
            'data'=>$data,
            'header' => Header::getData(),
            'footer' => Footer::getData(),
        ]);

    }
}
