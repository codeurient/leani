<?php

namespace App\Http\Controllers;

use App\Models\AboutBrand;
use App\Models\Footer;
use App\Models\Header;
use Illuminate\Http\Request;

class AboutBrandController extends Controller
{

    public function aboutBrand()
    {
        $data = AboutBrand::query()->firstOrFail();
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


        foreach ($data['photo_blocks'] as $keyPhotoBlock => $photoBlock) {
            $data['photo_blocks'][$keyPhotoBlock]['attributes']['add_photo_block'] = $this->getMedia($photoBlock['attributes']['add_photo_block']);
        }
        unset($keyPhotoBlock, $photoBlock);


        foreach ($data['slider_photos'] as $keySliderPhotos => $sliderPhoto) {
            foreach ($sliderPhoto['attributes']['photos'] as $keyPhotos => $photo) {
                $data['slider_photos'][$keySliderPhotos]['attributes']['photos'][$keyPhotos]['attributes']['add_slide_photo'] = $this->getMedia($photo['attributes']['add_slide_photo']);
            }
        }
        unset($keySliderPhotos, $sliderPhoto);


        foreach ($data['reviews'] as $keyReview => $review) {
            $data['reviews'][$keyReview]['attributes']['photo'] = $this->getMedia($review['attributes']['photo_review']);
        }
        unset($keyPhotoBlock, $photoBlock);


        return response()->json([
            'status' => 'success',
            'data' => $data,
            'header' => Header::getData(),
            'footer' => Footer::getData(),
        ]);

    }
}
