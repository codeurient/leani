<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Header;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function information()
    {
        $data=Information::query()->firstOrFail();
        $data = $this->translateModelWithoutIdAndTime($data);

        $data['poster'] = $this->getMedia($data['poster']);

        $data['photo_comp'] = $this->getMedia($data['photo_comp']);
        $data['video_comp'] = $this->getMedia($data['video_comp']);
        $data['photo_notebook'] = $this->getMedia($data['photo_notebook']);
        $data['video_notebook'] = $this->getMedia($data['video_notebook']);
        $data['photo_tablet'] = $this->getMedia($data['photo_tablet']);
        $data['video_tablet'] = $this->getMedia($data['video_tablet']);
        $data['photo_phone'] = $this->getMedia($data['photo_phone']);
        $data['video_phone'] = $this->getMedia($data['video_phone']);


        foreach ($data['infos'] as $keyInfos => $info)
        {
            foreach ($info['attributes']['logos'] as $keyLogos => $logo)
            {
                $data['infos'][$keyInfos]['attributes']['logos'][$keyLogos]['attributes']['add_logo'] = $logo['attributes']['add_logo'] = $this->getMedia($logo['attributes']['add_logo']);
            }
        }
        unset($keyInfos,$info);

        return response()->json([
            'status'=>'success',
            'data'=>$data,
            'header' => Header::getData(),
            'footer' => Footer::getData(),
        ]);

    }
}
