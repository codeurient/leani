<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function getMedia($media_id)
    {
        if (is_string($media_id)) $media_id = json_decode($media_id);

        if (is_array($media_id)) {
            return self::getManyMedia($media_id);
        }

        return self::getOneMedia($media_id);
    }

    /**
     * Get array id if error return '/storage/No_image_available.svg'.
     *
     *
     * @param  $ids = [0,1,2]
     * @return array = [0 => url, 1 => url, 2 => url]
     *
     */
    protected static function getManyMedia(array $ids): array
    {
        $media = DB::table('nova_media_library')->whereIn('id', $ids)->pluck('name', 'id')->toArray();

        $items = [];
        foreach ($ids as $id) {
            if (array_key_exists($id, $media)) {
                $items[] = \Storage::url($media[$id]);
            }
        }

        return $items;
    }

    /**
     * Get one id if error return '/storage/No_image_available.svg'.
     *
     * @param  $id
     * @return string
     *
     */
    public static function getOneMedia($id)
    {
        $media = DB::table('nova_media_library')->select('id', 'name', 'folder')
            ->where('id', $id)
            ->first();

        if ($media) {
            $media = \Storage::url($media->name);
        }

        return $media;
    }

    /**
     *
     * переводит модель по текушей локали без id, created_at, updated_at.
     *
     * @param  $model
     * @return array
     *
     */
    public static function translateModelWithoutIdAndTime($model)
    {
        foreach ($model->getAttributes() as $key => $field) {
            if (!$model->isTranslatableAttribute($key) && $key !== 'id' && $key !== 'created_at' && $key !== 'updated_at') {
                $attributes[$key] = $field;
            }
        }
        foreach ($model->getTranslatableAttributes() as $field) {
            $attributes[$field] = $model->getTranslation($field, App::currentLocale());
        }
        return $attributes;
    }
}
