<?php


namespace App\Services;


class OptionService
{
    public static function getProductOptionForSelect()
    {
        $product = \App\Models\Product::query()->get();

        $category = \App\Models\Category::query()->get();
        $nameproduct = \App\Models\NameProduct::query()->get();
        $color = \App\Models\Color::query()->get();

        $options = [];
        foreach ($product as $value) {

            $cat = $category->where('id', $value['category_id'])->first();

            $cat = $cat ? $cat->category_name  : '';

            /*
            // Если flexible поле то писать так

                        if($value['second_category_id']){
                            $additionalCategory = json_decode($value['second_category_id'], true);
                            foreach ($additionalCategory as $key => $categoryItem){
                                $currentCategory = \App\Models\Category::query()->find($categoryItem['attributes']['category_id']);
                                $currentCategoryName = $currentCategory->category_name;
                                $cat = $cat . ', ' . $currentCategoryName;
                            }
                        }*/

            if($value['second_category_id']){
                $currentCategory = \App\Models\Category::query()->find($value['second_category_id']);
                $currentCategoryName = $currentCategory->category_name;
                $cat = $cat . ', ' . $currentCategoryName;
            }

            $namep = $nameproduct->where('id', $value['name_product_id'])->first();
            $namep = $namep ? ' | ' . $namep->products_name  : '';

            $col = $color->where('id', $value['color_id'])->first();
            $col = $col ? ' | ' . $col->colors_name : '';


            $options[$value['id']] = $cat.$namep.$col;
        }
        return $options;
    }

}
