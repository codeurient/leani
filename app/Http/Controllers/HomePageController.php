<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Header;
use App\Models\HomePage;
use App\Services\ResponseService;

class HomePageController extends Controller
{
    public function homepage()
    {
        $data = HomePage::latest()->firstOrFail();
        $dataNew = null;
        $dataNew = $this->translateModelWithoutIdAndTime($data);

        $dataNew['video_clip'] = $this->getMedia($dataNew['video_clip']);
        $dataNew['video'] = $this->getMedia($dataNew['video']);
        $dataNew['poster_2'] = $this->getMedia($dataNew['poster_2']);


        foreach ($dataNew['heading_sliders'] as $key => $slide) {
            $dataNew['heading_sliders'][$key]['attributes']['photo_comp'] = $this->getMedia($slide['attributes']['photo_comp']);
            $dataNew['heading_sliders'][$key]['attributes']['video_comp'] = $this->getMedia($slide['attributes']['video_comp']);

            $dataNew['heading_sliders'][$key]['attributes']['photo_notebook'] = $this->getMedia($slide['attributes']['photo_notebook']);
            $dataNew['heading_sliders'][$key]['attributes']['video_notebook'] = $this->getMedia($slide['attributes']['video_notebook']);

            $dataNew['heading_sliders'][$key]['attributes']['photo_tablet'] = $this->getMedia($slide['attributes']['photo_tablet']);
            $dataNew['heading_sliders'][$key]['attributes']['video_tablet'] = $this->getMedia($slide['attributes']['video_tablet']);

            $dataNew['heading_sliders'][$key]['attributes']['photo_phone'] = $this->getMedia($slide['attributes']['photo_phone']);
            $dataNew['heading_sliders'][$key]['attributes']['video_phone'] = $this->getMedia($slide['attributes']['video_phone']);
        }
        unset($key, $slide);


        foreach ($dataNew['categories'] as $keyCategories => $categories) {
            foreach ($categories['attributes']['photos'] as $keyCategory => $category) {
                $dataNew['categories'][$keyCategories]['attributes']['photos'][$keyCategory]['attributes']['main_photo'] = $this->getMedia($category['attributes']['main_photo']);
                $dataNew['categories'][$keyCategories]['attributes']['photos'][$keyCategory]['attributes']['additional_photo'] = $this->getMedia($category['attributes']['additional_photo']);
            }
        }
        unset($keyCategories, $categories);


        foreach ($dataNew['collections_desktop'] as $keyCollec => $collec) {
            $dataNew['collections_desktop'][$keyCollec]['attributes']['main_photo'] = $this->getMedia($collec['attributes']['main_photo']);
            $dataNew['collections_desktop'][$keyCollec]['attributes']['additional_photo'] = $this->getMedia($collec['attributes']['additional_photo']);
        }
        unset($keyCollec, $collec);


        foreach ($dataNew['last_blocks'] as $keyLast => $last) {
            $dataNew['last_blocks'][$keyLast]['attributes']['photo'] = $this->getMedia($last['attributes']['photo']);
        }
        unset($keyLast, $last);


        foreach ($dataNew['collections_mobile'] as $keyCollecMob => $collecMob) {
            $dataNew['collections_mobile'][$keyCollecMob]['attributes']['main_photo'] = $this->getMedia($collecMob['attributes']['main_photo']);
        }
        unset($keyCollecMob, $collecMob);


        foreach ($dataNew['banners'] as $key => $slide) {
            $dataNew['banners'][$key]['attributes']['photo_comp'] = $this->getMedia($slide['attributes']['photo_comp']);
            //$dataNew['banners'][$key]['attributes']['video_comp'] = $this->getMedia($slide['attributes']['video_comp']);

            $dataNew['banners'][$key]['attributes']['photo_notebook'] = $this->getMedia($slide['attributes']['photo_notebook']);
            //$dataNew['banners'][$key]['attributes']['video_notebook'] = $this->getMedia($slide['attributes']['video_notebook']);

            $dataNew['banners'][$key]['attributes']['photo_tablet'] = $this->getMedia($slide['attributes']['photo_tablet']);
            //$dataNew['banners'][$key]['attributes']['video_tablet'] = $this->getMedia($slide['attributes']['video_tablet']);

            $dataNew['banners'][$key]['attributes']['photo_phone'] = $this->getMedia($slide['attributes']['photo_phone']);
            //$dataNew['banners'][$key]['attributes']['video_phone'] = $this->getMedia($slide['attributes']['video_phone']);
        }
        unset($key, $slide);

        return ResponseService::successWithHeaderFooter($dataNew);
    }

}
