<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientsPopupPostRequest;
use App\Mail\ContactSendMail;
use App\Models\Contact;
use App\Models\Footer;
use App\Models\Header;
use App\Services\SendMailService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact()
    {

        $data=Contact::query()->firstOrFail();
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

        foreach ($data['social'] as $key => $item){
            $data['social'][$key]['attributes']['social_logo'] = $this->getMedia($item['attributes']['social_logo']);
        }

        return response()->json([
            'status'=>'success',
            'data'=>$data,
            'header' => Header::getData(),
            'footer' => Footer::getData(),
        ]);
    }

    public function contact_send(ClientsPopupPostRequest $request){
        \Mail::to(config('mail.mailers.smtp.username'))->queue(new ContactSendMail(
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
