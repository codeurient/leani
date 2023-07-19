<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientsPopupPostRequest;
use App\Mail\PartnerRequestMail;
use App\Models\Footer;
use App\Models\Header;
use App\Models\Partner;
use App\Services\SendMailService;

class PartnerController extends Controller
{
    public function partner()
    {
        $data = Partner::query()->firstOrFail();

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

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'header' => Header::getData(),
            'footer' => Footer::getData(),
        ]);
    }

    public function partner_send(ClientsPopupPostRequest $request): \Illuminate\Http\JsonResponse
    {
        \Mail::to(config('mail.mailers.smtp.username'))->queue(new PartnerRequestMail(
            $request->name,
            $request->phone,
            $request->email,
            $request->clientMessage,
        ));

        return response()->json([
            'status' => 'success',
            'massage' => 'Send success!'
        ]);
    }

}
